<?php

namespace App\Services;

use App\Enum\CallbackQueryActionEnum;
use App\Enum\TelegramConversationStepEnum;
use App\Models\Item;
use App\Models\MarketListing;
use App\Models\TelegramConversation;
use App\Models\User;
use App\Notifications\SendTelegramMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

class TelegramConversationService
{
    public function __construct(protected Api $telegram)
    {
    }

    public function processUpdate(array $update): void
    {
        $chatId = data_get($update, 'message.chat.id') ?? data_get($update, 'callback_query.message.chat.id');
        $telegramUserId = data_get($update, 'message.from.id') ?? data_get($update, 'callback_query.from.id');

        if (!$chatId || !$telegramUserId) {
            return;
        }

        $user = User::where('telegram_user_id', $telegramUserId)->orWhere('telegram_chat_id', $chatId)->first();

        if ($callbackQuery = data_get($update, 'callback_query')) {
            $this->handleCallbackQuery($callbackQuery, $user);
            return;
        }

        if ($text = data_get($update, 'message.text')) {
            if (Str::startsWith($text, '/')) {
                $this->handleCommand($text, $chatId, $user);
            } else {
                $this->handleTextMessage($text, $user);
            }
        }
    }

    private function handleCommand(string $text, string $chatId, ?User $user): void
    {
        if (Str::startsWith($text, '/start ')) {
            $token = Str::after($text, '/start ');
            if ($userToConnect = User::firstWhere('telegram_connect_token', $token)) {
                $userToConnect->update(['telegram_chat_id' => $chatId, 'telegram_connect_token' => null]);
                $this->sendDirectMessage($chatId, '✅ Your account has been successfully connected!');
            }
            return;
        }

        if ($text === '/start') {
            if ($user && $user->telegram_user_id) {
                // Using the SDK's Keyboard builder is much cleaner.
                $keyboard = Keyboard::make()
                    ->inline()
                    ->row(
                        [Keyboard::button([
                            'text'          => '🆕 Create New Listing',
                            'callback_data' => CallbackQueryActionEnum::EXECUTE_COMMAND->value.':newlisting'
                        ])]
                    );

                $this->telegram->sendMessage([
                    'chat_id'      => $chatId,
                    'text'         => "Welcome back, {$user->name}!",
                    'reply_markup' => $keyboard
                ]);

            } else {
                $this->sendLoginButton($chatId);
            }
            return;
        }

        if ($text === '/newlisting') {
            if ($user && $user->telegram_user_id) {
                $this->startNewListingConversation($user);
            } else {
                $this->sendLoginButton($chatId);
            }
        }
    }

    private function handleCallbackQuery(array $callbackQuery, ?User $user): void
    {
        //$this->telegram->answerCallbackQuery(['callback_query_id' => $callbackQuery['id']]);
        [$actionValue, $value] = array_pad(explode(':', data_get($callbackQuery, 'data'), 2), 2, null);
        $action = CallbackQueryActionEnum::tryFrom($actionValue);

        if ($action === CallbackQueryActionEnum::EXECUTE_COMMAND) {
            if ($value === 'newlisting' && $user) {
                $this->startNewListingConversation($user);
            }
            return;
        }

        $conversation = $this->getActiveConversation($user);
        if (!$conversation) {
            return;
        }

        match ($action) {
            CallbackQueryActionEnum::SET_LISTING_TYPE => $this->processListingType($conversation, $value),
            CallbackQueryActionEnum::SELECT_ITEM => $this->processItemSelected($conversation, $value),
            CallbackQueryActionEnum::SET_PRICE_CURRENCY => $this->promptForPriceAmount($conversation, $value),
            CallbackQueryActionEnum::FINALIZE_LISTING => $this->finalizeListing($conversation),
            default => null,
        };
    }

    private function startNewListingConversation(User $user): void
    {
        $conversation = TelegramConversation::updateOrCreate(
            ['user_id' => $user->id], // The attributes to find the conversation by.
            [
                'chat_id' => $user->telegram_chat_id,
                'command' => '/newlisting',
                'step' => TelegramConversationStepEnum::AWAITING_LISTING_TYPE,
                'data' => [],
            ]
        );
        $keyboard = Keyboard::make()
            ->inline()
            ->row(
                [
                    Keyboard::button([
                        'text' => '🛒 Buy', 'callback_data' => CallbackQueryActionEnum::SET_LISTING_TYPE->value.':buy'
                    ]),
                    Keyboard::button([
                        'text' => '💰 Sell', 'callback_data' => CallbackQueryActionEnum::SET_LISTING_TYPE->value.':sell'
                    ])
                ]
            );

        $this->telegram->sendMessage([
            'chat_id'      => $user->telegram_chat_id,
            'text'         => $conversation->step->description(),
            'reply_markup' => $keyboard
        ]);
    }
    private function processItemSearch(TelegramConversation $conv, string $searchTerm): void
    {
        $items = Item::whereRaw(
            "JSON_SEARCH(LOWER(JSON_EXTRACT(name, '$.*')), 'one', LOWER(?)) IS NOT NULL",
            ['%'.$searchTerm.'%'])->limit(5)->get();
        if ($items->isEmpty()) {
            $this->telegram->sendMessage(['chat_id' => $conv->chat_id, 'text' => "⚠️ No items found matching '{$searchTerm}'. Please try again."]);
            return;
        }
        $conv->update(['step' => TelegramConversationStepEnum::AWAITING_ITEM_SELECTION]);

        $keyboard = Keyboard::make()->inline();
        foreach ($items as $item) {
            $keyboard->row(
               [ Keyboard::button([
                    'text' => $item->getTranslation('name', app()->getLocale()),
                    'callback_data' => CallbackQueryActionEnum::SELECT_ITEM->value . ':' . $item->id
                ])]
            );
        }

        $this->telegram->sendMessage([
            'chat_id' => $conv->chat_id,
            'text' => $conv->step->description(),
            'reply_markup' => $keyboard
        ]);
    }
    private function sendPriceKeyboard(TelegramConversation $conv, string $text): void
    {
        $keyboard = Keyboard::make()
            ->inline()
            ->row(
                [Keyboard::button(['text' => 'TON', 'callback_data' => CallbackQueryActionEnum::SET_PRICE_CURRENCY->value . ':ton']),
                Keyboard::button(['text' => 'QRK', 'callback_data' => CallbackQueryActionEnum::SET_PRICE_CURRENCY->value . ':qrk'])]
            )
            ->row(
               [ Keyboard::button(['text' => 'NOT', 'callback_data' => CallbackQueryActionEnum::SET_PRICE_CURRENCY->value . ':not']),
                Keyboard::button(['text' => 'USD', 'callback_data' => CallbackQueryActionEnum::SET_PRICE_CURRENCY->value . ':usd'])]
            )
            ->row(
                [Keyboard::button(['text' => '✅ Done', 'callback_data' => CallbackQueryActionEnum::FINALIZE_LISTING->value])]
            );

        $this->telegram->sendMessage(['chat_id' => $conv->chat_id, 'text' => $text, 'reply_markup' => $keyboard]);
    }
    private function sendLoginButton(string $chatId): void
    {
        $loginUrl = route('telegram.auth.callback');

        // The SDK has a dedicated parameter for login_url buttons.
        $keyboard = Keyboard::make()
            ->inline()
            ->row(
                [Keyboard::button(['text' => '✅ Securely Connect Account', 'login_url' => $loginUrl])]
            );

        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => 'Welcome! To get started, please connect your account securely.',
            'reply_markup' => $keyboard
        ]);
    }
    private function handleTextMessage(string $text, ?User $user): void
    {
        $conversation = $this->getActiveConversation($user);
        if (!$conversation) { return; }

        match ($conversation->step) {
            TelegramConversationStepEnum::AWAITING_ITEM_NAME => $this->processItemSearch($conversation, $text),
            TelegramConversationStepEnum::AWAITING_PRICE_AMOUNT => $this->processPriceAmount($conversation, $text),
            default => null,
        };
    }

    private function processListingType(TelegramConversation $conv, string $type): void
    {
        $conv->update(['step' => TelegramConversationStepEnum::AWAITING_ITEM_NAME, 'data' => ['listing_type' => $type]]);
        $this->telegram->sendMessage(['chat_id' => $conv->chat_id, 'text' => $conv->step->description()]);
    }

    private function processItemSelected(TelegramConversation $conv, string $itemId): void
    {
        $data = $conv->data;
        $data['item_id'] = $itemId;
        $conv->update(['step' => TelegramConversationStepEnum::AWAITING_PRICE, 'data' => $data]);
        $this->sendPriceKeyboard($conv, "Item selected. Please set a price or press Done.");
    }

    private function promptForPriceAmount(TelegramConversation $conv, string $currency): void
    {
        $data = $conv->data;
        $data['awaiting_price_for'] = $currency;
        $conv->update(['step' => TelegramConversationStepEnum::AWAITING_PRICE_AMOUNT, 'data' => $data]);
        $this->telegram->sendMessage(['chat_id' => $conv->chat_id, 'text' => "Please enter the price in " . strtoupper($currency) . "."]);
    }

    private function processPriceAmount(TelegramConversation $conv, string $amount): void
    {
        if (!is_numeric($amount) || $amount < 0) {
            $this->telegram->sendMessage(['chat_id' => $conv->chat_id, 'text' => "⚠️ Invalid input. Please enter a positive numeric price."]);
            return;
        }
        $data = $conv->data;
        $currency = $data['awaiting_price_for'];
        data_set($data, "prices.price_{$currency}", $amount);
        unset($data['awaiting_price_for']);
        $conv->update(['step' => TelegramConversationStepEnum::AWAITING_PRICE, 'data' => $data]);
        $currentPrices = collect(data_get($conv->data, 'prices', []))->map(fn($p, $c) => strtoupper(str_replace('price_', '', $c)) . ": $p")->implode(', ');
        $this->sendPriceKeyboard($conv, "Price set. Current prices: [{$currentPrices}]. Set another or press Done.");
    }

    private function finalizeListing(TelegramConversation $conv): void
    {
        $data = $conv->data;
        MarketListing::create(array_merge(
            ['user_id' => $conv->user_id, 'quantity' => 1, 'status' => 'active'],
            $data['prices'] ?? [],
            ['item_id' => data_get($data, 'item_id')],
            ['listing_type' => data_get($data, 'listing_type')],
        ));
        $this->telegram->sendMessage(['chat_id' => $conv->chat_id, 'text' => '✅ Success! Your listing has been created.']);
        $conv->delete();
    }

    private function getActiveConversation(?User $user): ?TelegramConversation
    {
        return $user ? TelegramConversation::where('user_id', $user->id)->latest()->first() : null;
    }
}
