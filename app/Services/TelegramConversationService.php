<?php

namespace App\Services;

use App\Enum\CallbackQueryActionEnum;
use App\Enum\ListingStatusEnum;
use App\Enum\TelegramConversationStepEnum;
use App\Models\Item;
use App\Models\MarketListing;
use App\Models\TelegramConversation;
use App\Models\User;
use App\Notifications\SendTelegramMessage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Throwable;

class TelegramConversationService
{
    protected array $supportedLanguages
        = [
            'en' => '🇺🇸 English',
            'ru' => '🇷🇺 Русский',
        ];

    public function __construct(protected Api $telegram)
    {
    }

    public function processUpdate(array $update): void
    {
        try {
            $chatId = data_get($update, 'message.chat.id') ?? data_get($update, 'callback_query.message.chat.id');
            $telegramUserId = data_get($update, 'message.from.id') ?? data_get($update, 'callback_query.from.id');

            if (!$chatId || !$telegramUserId) {
                Log::warning('Missing chat_id or telegram_user_id in update', ['update' => $update]);
                return;
            }

            $user = User::where('telegram_user_id', $telegramUserId)
                ->orWhere('telegram_chat_id', $chatId)
                ->first();

            // Set user's locale if they exist
            if ($user && $user->locale) {
                App::setLocale($user->locale);
            }

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
        } catch (Throwable $e) {
            Log::error('Error processing Telegram update: '.$e->getMessage(), [
                'update'    => $update,
                'exception' => $e,
                'trace'     => $e->getTraceAsString()
            ]);

            // Try emergency fallback if we have chat_id
            if (isset($chatId)) {
                $this->emergencyFallback($chatId, $user ?? null);
            }
        }
    }

    private function handleCommand(string $text, string $chatId, ?User $user): void
    {
        try {
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
                    // Check if user needs language selection
                    if (!$user->locale || !in_array($user->locale, array_keys($this->supportedLanguages))) {
                        $this->startLanguageSelection($user, $chatId);
                        return;
                    }

                    // User has a language set, show main menu
                    $this->showMainMenu($user, $chatId);
                } else {
                    $this->sendLoginButton($chatId);
                }
                return;
            }

            if ($text === '/language') {
                if ($user && $user->telegram_user_id) {
                    $this->startLanguageSelection($user, $chatId);
                } else {
                    $this->sendLoginButton($chatId);
                }
                return;
            }

            if ($text === '/help' || $text === '/menu') {
                if ($user && $user->telegram_user_id) {
                    // Send help message with natural language examples
                    $helpMessage = __('telegram.help_message')."\n\n".__('telegram.listing_format_example');
                    $this->telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text'    => $helpMessage,
                        'parse_mode' => 'Markdown'
                    ]);
                    $this->showMainMenu($user, $chatId);
                } else {
                    $this->sendLoginButton($chatId);
                }
                return;
            }

            if ($text === '/cancel' || $text === '/stop') {
                if ($user) {
                    // Clear any active conversation
                    TelegramConversation::query()->where('user_id', $user->id)->delete();
                    $this->telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text'    => __('telegram.conversation_cancelled')
                    ]);
                    $this->showMainMenu($user, $chatId);
                } else {
                    $this->sendLoginButton($chatId);
                }
                return;
            }

            if ($text === '/newlisting') {
                if ($user && $user->telegram_user_id) {
                    // Check if user needs language selection first
                    if (!$user->locale || !in_array($user->locale, array_keys($this->supportedLanguages))) {
                        $this->startLanguageSelection($user, $chatId);
                        return;
                    }
                    $this->startNewListingConversation($user);
                } else {
                    $this->sendLoginButton($chatId);
                }
                return;
            }

            // Handle unknown commands - fallback system
            $this->handleUnknownCommand($text, $chatId, $user);
        } catch (Throwable $e) {
            Log::error('Error handling command: '.$e->getMessage(), [
                'command'   => $text,
                'chat_id'   => $chatId,
                'user_id'   => $user?->id,
                'exception' => $e
            ]);
            $this->sendErrorMessage($chatId, 'Command failed. Please try again.');
        }
    }

    private function handleCallbackQuery(array $callbackQuery, ?User $user): void
    {
        try {
            [$actionValue, $value] = array_pad(explode(':', data_get($callbackQuery, 'data'), 2), 2, null);
            $action = CallbackQueryActionEnum::tryFrom($actionValue);

            if ($action === CallbackQueryActionEnum::EXECUTE_COMMAND) {
                if ($value === 'newlisting' && $user) {
                    // Check if user needs language selection first
                    if (!$user->locale || !in_array($user->locale, array_keys($this->supportedLanguages))) {
                        $this->startLanguageSelection($user, $user->telegram_chat_id);
                        return;
                    }
                    $this->startNewListingConversation($user);
                } elseif ($value === 'mylisting' && $user) {
                    $this->startMyListingConversation($user);
                } elseif ($value === 'language' && $user) {
                    $this->startLanguageSelection($user, $user->telegram_chat_id);
                } elseif ($value === 'cancel' && $user) {
                    // Clear any cached natural listings
                    $sessionKey = 'natural_listings_'.$user->id;
                    cache()->forget($sessionKey);

                    $this->telegram->sendMessage([
                        'chat_id' => $user->telegram_chat_id,
                        'text'    => __('telegram.conversation_cancelled')
                    ]);
                    $this->showMainMenu($user, $user->telegram_chat_id);
                }
                return;
            }

            if ($action === CallbackQueryActionEnum::SET_LANGUAGE) {
                $this->processLanguageSelection($user, $value);
                return;
            }

            if ($action === CallbackQueryActionEnum::CONFIRM_NATURAL_LISTINGS) {
                $this->confirmNaturalListings($user);
                return;
            }

            if ($action === CallbackQueryActionEnum::RETRY_NATURAL_LISTINGS) {
                $this->retryNaturalListings($user);
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
        } catch (Throwable $e) {
            Log::error('Error handling callback query: '.$e->getMessage(), [
                'callback_query' => $callbackQuery,
                'user_id'        => $user?->id,
                'exception'      => $e
            ]);

            if ($user && $user->telegram_chat_id) {
                $this->sendErrorMessage($user->telegram_chat_id, 'Action failed. Please try again.');
            }
        }
    }

    private function startLanguageSelection(User $user, string $chatId): void
    {
        try {
            TelegramConversation::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'chat_id' => $chatId,
                    'command' => '/language',
                    'step'    => TelegramConversationStepEnum::AWAITING_LANGUAGE_SELECTION,
                    'data'    => [],
                ]
            );

            $keyboard = Keyboard::make()->inline();
            foreach ($this->supportedLanguages as $code => $name) {
                $keyboard->row([
                    Keyboard::button([
                        'text'          => $name,
                        'callback_data' => CallbackQueryActionEnum::SET_LANGUAGE->value.':'.$code
                    ])
                ]);
            }

            $this->telegram->sendMessage([
                'chat_id'      => $chatId,
                'text'         => 'Please select your preferred language / Пожалуйста, выберите предпочитаемый язык:',
                'reply_markup' => $keyboard
            ]);
        } catch (Throwable $e) {
            Log::error('Error starting language selection: '.$e->getMessage(), [
                'user_id'   => $user->id,
                'chat_id'   => $chatId,
                'exception' => $e
            ]);
            $this->sendErrorMessage($chatId, 'Language selection failed. Please try again.');
        }
    }

    private function processLanguageSelection(?User $user, ?string $languageCode): void
    {
        try {
            if (!$user || !$languageCode || !isset($this->supportedLanguages[$languageCode])) {
                Log::warning('Invalid language selection', [
                    'user_id'       => $user?->id,
                    'language_code' => $languageCode
                ]);
                return;
            }

            // Update user's locale
            $user->update(['locale' => $languageCode]);
            App::setLocale($languageCode);

            // Delete language selection conversation
            TelegramConversation::query()->where('user_id', $user->id)
                ->where('command', '/language')
                ->delete();

            $this->telegram->sendMessage([
                'chat_id' => $user->telegram_chat_id,
                'text'    => __('telegram.language_updated').' / Язык успешно обновлен!'
            ]);

            // Show main menu after language selection
            $this->showMainMenu($user, $user->telegram_chat_id);
        } catch (Throwable $e) {
            Log::error('Error processing language selection: '.$e->getMessage(), [
                'user_id'       => $user?->id,
                'language_code' => $languageCode,
                'exception'     => $e
            ]);

            if ($user && $user->telegram_chat_id) {
                $this->sendErrorMessage($user->telegram_chat_id, 'Language update failed. Please try again.');
            }
        }
    }

    private function showMainMenu(User $user, string $chatId): void
    {
        try {
            $keyboard = Keyboard::make()
                ->inline()
                ->row([
                    Keyboard::button([
                        'text'          => '🆕 '.__('telegram.create_new_listing'),
                        'callback_data' => CallbackQueryActionEnum::EXECUTE_COMMAND->value.':newlisting'
                    ])
                ])
                ->row([
                    Keyboard::button([
                        'text'          => '🆕 '.__('telegram.show_my_listing'),
                        'callback_data' => CallbackQueryActionEnum::EXECUTE_COMMAND->value.':mylisting'
                    ])
                ])
                ->row([
                    Keyboard::button([
                        'text'          => '🌐 '.__('telegram.change_language'),
                        'callback_data' => CallbackQueryActionEnum::EXECUTE_COMMAND->value.':language'
                    ])
                ]);

            $this->telegram->sendMessage([
                'chat_id'      => $chatId,
                'text'         => __('telegram.welcome_back', ['name' => $user->name]),
                'reply_markup' => $keyboard
            ]);
        } catch (Throwable $e) {
            Log::error('Error showing main menu: '.$e->getMessage(), [
                'user_id'   => $user->id,
                'chat_id'   => $chatId,
                'exception' => $e
            ]);
            $this->sendErrorMessage($chatId, 'Menu display failed. Please try again.');
        }
    }

    private function startNewListingConversation(User $user): void
    {
        try {
            $conversation = TelegramConversation::updateOrCreate(
                ['user_id' => $user->id], // The attributes to find the conversation by.
                [
                    'chat_id' => $user->telegram_chat_id,
                    'command' => '/newlisting',
                    'step'    => TelegramConversationStepEnum::AWAITING_LISTING_TYPE,
                    'data'    => [],
                ]
            );

            $keyboard = Keyboard::make()
                ->inline()
                ->row([
                    Keyboard::button([
                        'text'          => '🛒 '.__('telegram.buy'),
                        'callback_data' => CallbackQueryActionEnum::SET_LISTING_TYPE->value.':buy'
                    ]),
                    Keyboard::button([
                        'text'          => '💰 '.__('telegram.sell'),
                        'callback_data' => CallbackQueryActionEnum::SET_LISTING_TYPE->value.':sell'
                    ])
                ]);

            $this->telegram->sendMessage([
                'chat_id'      => $user->telegram_chat_id,
                'text'         => $conversation->step->description(),
                'reply_markup' => $keyboard
            ]);
        } catch (Throwable $e) {
            Log::error('Error starting new listing conversation: '.$e->getMessage(), [
                'user_id'   => $user->id,
                'exception' => $e
            ]);
            $this->sendErrorMessage($user->telegram_chat_id, 'Failed to start listing creation. Please try again.');
        }
    }

    private function startMyListingConversation(User $user): void
    {
        try {
            $keyboard = Keyboard::make()
                ->inline()
                ->row([
                    Keyboard::button([
                        'text' => '🆕 '.__('telegram.manage_listing'),
                        'url'  => route('filament.dashboard.resources.my-listings.index')
                    ])
                ])
                ->row([
                    Keyboard::button([
                        'text'          => '🆕 '.__('telegram.create_new_listing'),
                        'callback_data' => CallbackQueryActionEnum::EXECUTE_COMMAND->value.':newlisting'
                    ])
                ])
                ->row([
                    Keyboard::button([
                        'text'          => '🌐 '.__('telegram.change_language'),
                        'callback_data' => CallbackQueryActionEnum::EXECUTE_COMMAND->value.':language'
                    ])
                ]);
            $user->load([
                'marketListings' => function ($query) {
                    $query
                        ->with('item')
                        ->where('status', ListingStatusEnum::ACTIVE)
                        ->orWhere('status', ListingStatusEnum::EXPIRED)
                        ->orderBy('updated_at', 'desc');
                }
            ]);
            $myLisitngsText = __('telegram.my_listings', [
                'count'    => $user->marketListings->count(),
                'listings' => $user->marketListings->map(function ($listing) {
                    return "- {$listing->item->getTranslation('name', app()->getLocale())} ({$listing->quantity}) - "
                        .ListingStatusEnum::tryFrom($listing->status)->translate();
                })->implode(PHP_EOL)
            ]);
            $this->telegram->sendMessage([
                'chat_id'      => $user->telegram_chat_id,
                'text'         => $myLisitngsText,
                'reply_markup' => $keyboard
            ]);
        } catch (Throwable $e) {
            Log::error('Error starting new listing conversation: '.$e->getMessage(), [
                'user_id'   => $user->id,
                'exception' => $e
            ]);
            $this->sendErrorMessage($user->telegram_chat_id, 'Failed to start listing creation. Please try again.');
        }
    }

    private function processItemSearch(TelegramConversation $conv, string $searchTerm, User $user): void
    {
        try {
            $items = Item::whereRaw(
                "JSON_SEARCH(LOWER(JSON_EXTRACT(name, '$.*')), 'one', LOWER(?)) IS NOT NULL",
                ['%'.$searchTerm.'%']
            )->limit(5)->get();

            if ($items->isEmpty()) {
                $this->telegram->sendMessage([
                    'chat_id' => $conv->chat_id,
                    'text'    => __('telegram.no_items_found', ['search' => $searchTerm])
                ]);
                return;
            }

            // Store search results in conversation data for potential restart
            $data = $conv->data;
            $data['search_term'] = $searchTerm;
            $data['found_items'] = $items->map(function ($item) {
                return [
                    'id'   => $item->id,
                    'name' => $item->getTranslation('name', app()->getLocale())
                ];
            })->toArray();

            $conv->update([
                'step' => TelegramConversationStepEnum::AWAITING_ITEM_SELECTION,
                'data' => $data
            ]);

            $keyboard = Keyboard::make()->inline();
            foreach ($items as $item) {
                $keyboard->row([
                    Keyboard::button([
                        'text'          => $item->getTranslation('name', app()->getLocale()),
                        'callback_data' => CallbackQueryActionEnum::SELECT_ITEM->value.':'.$item->id
                    ])
                ]);
            }

            $this->telegram->sendMessage([
                'chat_id'      => $conv->chat_id,
                'text'         => $conv->step->description(),
                'reply_markup' => $keyboard
            ]);
        } catch (Throwable $e) {
            Log::error('Error processing item search: '.$e->getMessage(), [
                'conversation_id' => $conv->id,
                'search_term'     => $searchTerm,
                'exception'       => $e
            ]);
            $this->sendErrorMessage($conv->chat_id, 'Item search failed. Please try again.');
        }
    }

    /**
     * Recreate item selection buttons from stored conversation data
     */
    private function recreateItemSelectionButtons(TelegramConversation $conversation): void
    {
        try {
            $foundItems = data_get($conversation->data, 'found_items', []);

            if (empty($foundItems)) {
                // No stored items, ask user to search again
                $conversation->update(['step' => TelegramConversationStepEnum::AWAITING_ITEM_NAME]);
                $this->telegram->sendMessage([
                    'chat_id' => $conversation->chat_id,
                    'text'    => __('telegram.please_search_again')
                ]);
                return;
            }

            $keyboard = Keyboard::make()->inline();
            foreach ($foundItems as $item) {
                $keyboard->row([
                    Keyboard::button([
                        'text'          => $item['name'],
                        'callback_data' => CallbackQueryActionEnum::SELECT_ITEM->value.':'.$item['id']
                    ])
                ]);
            }

            $this->telegram->sendMessage([
                'chat_id'      => $conversation->chat_id,
                'text'         => $conversation->step->description(),
                'reply_markup' => $keyboard
            ]);
        } catch (Throwable $e) {
            Log::error('Error recreating item selection buttons: '.$e->getMessage(), [
                'conversation_id' => $conversation->id,
                'exception'       => $e
            ]);

            // Fallback to asking for search again
            $conversation->update(['step' => TelegramConversationStepEnum::AWAITING_ITEM_NAME]);
            $this->telegram->sendMessage([
                'chat_id' => $conversation->chat_id,
                'text'    => __('telegram.please_search_again')
            ]);
        }
    }

    private function sendPriceKeyboard(TelegramConversation $conv, string $text): void
    {
        try {
            $keyboard = Keyboard::make()
                ->inline()
                ->row([
                    Keyboard::button([
                        'text' => 'TON', 'callback_data' => CallbackQueryActionEnum::SET_PRICE_CURRENCY->value.':ton'
                    ]),
                    Keyboard::button([
                        'text' => 'QRK', 'callback_data' => CallbackQueryActionEnum::SET_PRICE_CURRENCY->value.':qrk'
                    ])
                ])
                ->row([
                    Keyboard::button([
                        'text' => 'NOT', 'callback_data' => CallbackQueryActionEnum::SET_PRICE_CURRENCY->value.':not'
                    ]),
                    Keyboard::button([
                        'text' => 'USD', 'callback_data' => CallbackQueryActionEnum::SET_PRICE_CURRENCY->value.':usd'
                    ])
                ])
                ->row([
                    Keyboard::button([
                        'text'          => '✅ '.__('telegram.done'),
                        'callback_data' => CallbackQueryActionEnum::FINALIZE_LISTING->value
                    ])
                ]);

            $this->telegram->sendMessage([
                'chat_id'      => $conv->chat_id,
                'text'         => $text,
                'reply_markup' => $keyboard
            ]);
        } catch (Throwable $e) {
            Log::error('Error sending price keyboard: '.$e->getMessage(), [
                'conversation_id' => $conv->id,
                'exception'       => $e
            ]);
            $this->sendErrorMessage($conv->chat_id, 'Price selection failed. Please try again.');
        }
    }

    private function sendLoginButton(string $chatId): void
    {
        try {
            $loginUrl = route('telegram.auth.callback');

            // The SDK has a dedicated parameter for login_url buttons.
            $keyboard = Keyboard::make()
                ->inline()
                ->row([
                    Keyboard::button([
                        'text'      => '✅ '.__('telegram.securely_connect_account'),
                        'login_url' => $loginUrl
                    ])
                ]);

            $this->telegram->sendMessage([
                'chat_id'      => $chatId,
                'text'         => __('telegram.welcome_connect_account'),
                'reply_markup' => $keyboard
            ]);
        } catch (Throwable $e) {
            Log::error('Error sending login button: '.$e->getMessage(), [
                'chat_id'   => $chatId,
                'exception' => $e
            ]);
            // Fallback - send simple message without button
            $this->sendDirectMessage($chatId, 'Welcome! Please visit our website to connect your account.');
        }
    }

    private function handleTextMessage(string $text, ?User $user): void
    {
        try {
            $conversation = $this->getActiveConversation($user);
            if (!$conversation) {
                // Check if this might be a natural language listing
                if ($user && $this->isNaturalLanguageListing($text)) {
                    $this->processNaturalLanguageListing($text, $user);
                    return;
                }
                // No active conversation - provide helpful guidance
                $this->provideHelpfulGuidance($text, $user);
                return;
            }

            match ($conversation->step) {
                TelegramConversationStepEnum::AWAITING_ITEM_NAME => $this->processItemSearch($conversation, $text,
                    $user),
                TelegramConversationStepEnum::AWAITING_QUANTITY => $this->processQuantity($conversation, $text),
                TelegramConversationStepEnum::AWAITING_PRICE_AMOUNT => $this->processPriceAmount($conversation, $text),
                default => $this->handleUnexpectedInput($conversation, $text),
            };
        } catch (Throwable $e) {
            Log::error('Error handling text message: '.$e->getMessage(), [
                'text'      => $text,
                'user_id'   => $user?->id,
                'exception' => $e
            ]);

            if ($user && $user->telegram_chat_id) {
                $this->sendErrorMessage($user->telegram_chat_id, 'Message processing failed. Please try again.');
                $this->showMainMenu($user, $user->telegram_chat_id);
            }
        }
    }

    private function processListingType(TelegramConversation $conv, string $type): void
    {
        try {
            $conv->update([
                'step' => TelegramConversationStepEnum::AWAITING_ITEM_NAME,
                'data' => ['listing_type' => $type]
            ]);

            $this->telegram->sendMessage([
                'chat_id' => $conv->chat_id,
                'text'    => $conv->step->description()
            ]);
        } catch (Throwable $e) {
            Log::error('Error processing listing type: '.$e->getMessage(), [
                'conversation_id' => $conv->id,
                'type'            => $type,
                'exception'       => $e
            ]);
            $this->sendErrorMessage($conv->chat_id, 'Failed to set listing type. Please try again.');
        }
    }

    private function processItemSelected(TelegramConversation $conv, string $itemId): void
    {
        try {
            $data = $conv->data;
            $data['item_id'] = $itemId;
            $conv->update([
                'step' => TelegramConversationStepEnum::AWAITING_QUANTITY,
                'data' => $data
            ]);

            $this->telegram->sendMessage([
                'chat_id' => $conv->chat_id,
                'text'    => $conv->step->description()
            ]);
        } catch (Throwable $e) {
            Log::error('Error processing item selection: '.$e->getMessage(), [
                'conversation_id' => $conv->id,
                'item_id'         => $itemId,
                'exception'       => $e
            ]);
            $this->sendErrorMessage($conv->chat_id, 'Failed to select item. Please try again.');
        }
    }

    private function promptForPriceAmount(TelegramConversation $conv, string $currency): void
    {
        try {
            $data = $conv->data;
            $data['awaiting_price_for'] = $currency;
            $conv->update([
                'step' => TelegramConversationStepEnum::AWAITING_PRICE_AMOUNT,
                'data' => $data
            ]);

            $this->telegram->sendMessage([
                'chat_id' => $conv->chat_id,
                'text'    => __('telegram.enter_price_in_currency', ['currency' => strtoupper($currency)])
            ]);
        } catch (Throwable $e) {
            Log::error('Error prompting for price amount: '.$e->getMessage(), [
                'conversation_id' => $conv->id,
                'currency'        => $currency,
                'exception'       => $e
            ]);
            $this->sendErrorMessage($conv->chat_id, 'Failed to set currency. Please try again.');
        }
    }

    private function processQuantity(TelegramConversation $conv, string $quantity): void
    {
        try {
            if (!is_numeric($quantity) || $quantity <= 0 || !ctype_digit($quantity)) {
                $this->telegram->sendMessage([
                    'chat_id' => $conv->chat_id,
                    'text'    => __('telegram.invalid_quantity_input')
                ]);
                return;
            }

            $data = $conv->data;
            $data['quantity'] = (int) $quantity;
            $conv->update([
                'step' => TelegramConversationStepEnum::AWAITING_PRICE,
                'data' => $data
            ]);

            $this->sendPriceKeyboard($conv, __('telegram.quantity_set_now_price', ['quantity' => $quantity]));
        } catch (Throwable $e) {
            Log::error('Error processing quantity: '.$e->getMessage(), [
                'conversation_id' => $conv->id,
                'quantity'        => $quantity,
                'exception'       => $e
            ]);
            $this->sendErrorMessage($conv->chat_id, 'Failed to process quantity. Please try again.');
        }
    }

    private function processPriceAmount(TelegramConversation $conv, string $amount): void
    {
        try {
            if (!is_numeric($amount) || $amount < 0) {
                $this->telegram->sendMessage([
                    'chat_id' => $conv->chat_id,
                    'text'    => __('telegram.invalid_price_input')
                ]);
                return;
            }

            $data = $conv->data;
            $currency = $data['awaiting_price_for'];
            data_set($data, "prices.price_{$currency}", $amount);
            unset($data['awaiting_price_for']);
            $conv->update([
                'step' => TelegramConversationStepEnum::AWAITING_PRICE,
                'data' => $data
            ]);

            $currentPrices = collect(data_get($conv->data, 'prices', []))
                ->map(fn($p, $c) => strtoupper(str_replace('price_', '', $c)).": $p")
                ->implode(', ');

            $this->sendPriceKeyboard($conv, __('telegram.price_set_current_prices', ['prices' => $currentPrices]));
        } catch (Throwable $e) {
            Log::error('Error processing price amount: '.$e->getMessage(), [
                'conversation_id' => $conv->id,
                'amount'          => $amount,
                'exception'       => $e
            ]);
            $this->sendErrorMessage($conv->chat_id, 'Failed to process price. Please try again.');
        }
    }

    private function finalizeListing(TelegramConversation $conv): void
    {
        try {
            $data = $conv->data;
            MarketListing::create(array_merge(
                [
                    'user_id'  => $conv->user_id,
                    'quantity' => data_get($data, 'quantity', 1), // Use the quantity from conversation or default to 1
                    'status'   => 'active'
                ],
                $data['prices'] ?? [],
                ['item_id' => data_get($data, 'item_id')],
                ['listing_type' => data_get($data, 'listing_type')],
            ));

            $this->telegram->sendMessage([
                'chat_id' => $conv->chat_id,
                'text'    => __('telegram.listing_created_success')
            ]);

            $conv->delete();
        } catch (Throwable $e) {
            Log::error('Error finalizing listing: '.$e->getMessage(), [
                'conversation_id' => $conv->id,
                'exception'       => $e
            ]);
            $this->sendErrorMessage($conv->chat_id, 'Failed to create listing. Please try again.');
        }
    }

    /**
     * Check if the text appears to be a natural language listing
     */
    private function isNaturalLanguageListing(string $text): bool
    {
        $text = strtolower(trim($text));

        // Check for listing type keywords at the beginning or with colon
        $buyKeywords = ['buy', 'buying', 'wtb', 'want to buy', 'looking for', 'need', 'покупаю', 'куплю', 'ищу'];
        $sellKeywords = ['sell', 'selling', 'wts', 'want to sell', 'have', 'продаю', 'продам', 'есть'];

        $hasListingKeyword = false;
        foreach (array_merge($buyKeywords, $sellKeywords) as $keyword) {
            if (str_starts_with($text, $keyword)) {
                $hasListingKeyword = true;
                break;
            }
        }

        if (!$hasListingKeyword) {
            return false;
        }

        // Check for price patterns (number followed by currency)
        $currencyPattern = '/(\d+(?:\.\d+)?)\s*(ton|qrk|not|usdt|usd)/i';

        // Check for quantity patterns (number before dash or x)
        $quantityPattern = '/\b(\d+)\s*[x×\-]/i';

        return preg_match($currencyPattern, $text) || preg_match($quantityPattern, $text);
    }

    /**
     * Process natural language listing input
     */
    private function processNaturalLanguageListing(string $text, User $user): void
    {
        try {
            $parsedListings = $this->parseNaturalLanguageListings($text);

            if (empty($parsedListings)) {
                $this->telegram->sendMessage([
                    'chat_id' => $user->telegram_chat_id,
                    'text'    => __('telegram.could_not_parse_listing')."\n\n".
                        __('telegram.listing_format_example')
                ]);
                return;
            }

            $this->showNaturalListingsConfirmation($parsedListings, $user);

        } catch (Throwable $e) {
            Log::error('Error processing natural language listing: '.$e->getMessage(), [
                'text'      => $text,
                'user_id'   => $user->id,
                'exception' => $e
            ]);
            $this->sendErrorMessage($user->telegram_chat_id,
                'Failed to process listing. Please try the wizard mode with /newlisting');
        }
    }

    /**
     * Parse natural language listings from text
     */
    private function parseNaturalLanguageListings(string $text): array
    {
        $lines = array_filter(array_map('trim', explode("\n", $text)));
        $listings = [];

        // Check if this is a colon-separated list format
        $firstLine = $lines[0] ?? '';
        $isColonList = false;
        $defaultListingType = null;

        if (str_ends_with(strtolower(trim($firstLine)), ':')) {
            $isColonList = true;
            // Extract the listing type from the first line
            $firstLineLower = strtolower(trim($firstLine));
            $buyKeywords = ['buy', 'buying', 'wtb', 'want to buy', 'looking for', 'need', 'покупаю', 'куплю', 'ищу'];
            $sellKeywords = ['sell', 'selling', 'wts', 'want to sell', 'have', 'продаю', 'продам', 'есть'];

            foreach ($sellKeywords as $keyword) {
                if (str_starts_with($firstLineLower, $keyword)) {
                    $defaultListingType = 'sell';
                    break;
                }
            }

            if (!$defaultListingType) {
                foreach ($buyKeywords as $keyword) {
                    if (str_starts_with($firstLineLower, $keyword)) {
                        $defaultListingType = 'buy';
                        break;
                    }
                }
            }

            // Remove the first line since it's just the header
            array_shift($lines);
        }

        foreach ($lines as $line) {
            if ($isColonList && $defaultListingType) {
                // For colon lists, create a pseudo-line with the action
                $pseudoLine = $defaultListingType.' '.$line;
                $listing = $this->parseSingleListing($pseudoLine);
                // Fix the item name to remove the action prefix that got added
                if ($listing && str_starts_with($listing['item_name'], $defaultListingType.' ')) {
                    $listing['item_name'] = trim(substr($listing['item_name'], strlen($defaultListingType) + 1));
                }
            } else {
                $listing = $this->parseSingleListing($line);
            }

            if ($listing) {
                $listings[] = $listing;
            }
        }

        return $listings;
    }

    /**
     * Parse a single listing line
     */
    private function parseSingleListing(string $line): ?array
    {
        $originalLine = $line;
        $line = strtolower(trim($line));

        // Determine listing type
        $buyKeywords = [
            'buy', 'buying', 'wtb', 'want to buy', 'looking for', 'need', 'покупаю', 'куплю', 'ищу', 'нужен', 'нужна',
            'нужно'
        ];
        $sellKeywords = ['sell', 'selling', 'wts', 'want to sell', 'have', 'продаю', 'продам', 'есть', 'имею'];

        $listingType = null;
        $keywordLength = 0;

        // Check sell keywords first (longer matches have priority)
        foreach ($sellKeywords as $keyword) {
            if (str_starts_with($line, $keyword) && strlen($keyword) > $keywordLength) {
                $listingType = 'sell';
                $keywordLength = strlen($keyword);
            }
        }

        // Check buy keywords
        foreach ($buyKeywords as $keyword) {
            if (str_starts_with($line, $keyword) && strlen($keyword) > $keywordLength) {
                $listingType = 'buy';
                $keywordLength = strlen($keyword);
            }
        }

        if (!$listingType) {
            return null;
        }

        // Remove the keyword from the beginning
        $line = trim(substr($line, $keywordLength));

        // Parse prices with currency - support multiple currencies
        $prices = [];
        $pricePatterns = [
            '/(\d+(?:\.\d+)?)\s*(ton|tonc|toncoin)/i',  // TON variations
            '/(\d+(?:\.\d+)?)\s*(qrk|quark)/i',         // QRK variations
            '/(\d+(?:\.\d+)?)\s*(not|notcoin)/i',       // NOT variations
            '/(\d+(?:\.\d+)?)\s*(usdt|usd|dollar)/i',   // USD variations
        ];

        foreach ($pricePatterns as $pattern) {
            if (preg_match_all($pattern, $line, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $amount = floatval($match[1]);
                    $currency = strtolower($match[2]);

                    // Normalize currency names
                    if (in_array($currency, ['ton', 'tonc', 'toncoin'])) {
                        $currency = 'ton';
                    } elseif (in_array($currency, ['qrk', 'quark'])) {
                        $currency = 'qrk';
                    } elseif (in_array($currency, ['not', 'notcoin'])) {
                        $currency = 'not';
                    } elseif (in_array($currency, ['usdt', 'usd', 'dollar'])) {
                        $currency = 'usd';
                    }

                    $prices['price_'.$currency] = $amount;
                    // Remove the price from the line for item name extraction
                    $line = str_replace($match[0], '', $line);
                }
            }
        }

        if (empty($prices)) {
            return null; // No valid price found
        }

        // Parse quantity - multiple patterns with priority
        $quantity = 1; // Default to 1
        // add -5, –5, —5 pattern for quantity
        $quantityPatterns = [
            '/(\d+)\s*[x×]/iu',          // 5x, 5×
            '/[x×]\s*(\d+)/iu',          // x5, ×5
            '/(\d+)\s*шт\.?/iu',         // 5шт, 5шт.
            '/(\d+)\s*pcs?\.?/iu',       // 5pc, 5pcs
            '/(\d+)\s*[-–—]/iu',         // 5-, 5–, 5—
        ];

        // First try explicit quantity patterns
        foreach ($quantityPatterns as $pattern) {
            if (preg_match($pattern, $line, $matches)) {
                $quantity = intval($matches[1]);
                if ($quantity > 0) {
                    $line = preg_replace($pattern, '', $line, 1);
                    break;
                }
            }
        }

        // If no explicit quantity found, check for pattern like "item3 5 300qrk"
        // where 5 might be quantity and 300qrk is price
        if ($quantity === 1) {
            // Look for pattern: [text] [number] [bigger_number][currency]
            // The smaller number is likely quantity, bigger is price
            $quantityBeforePricePattern = '/^(.+?)\s+(\d+)\s+(\d+(?:\.\d+)?)\s*(?:ton|qrk|not|usdt|usd)/i';
            if (preg_match($quantityBeforePricePattern, trim($originalLine), $matches)) {
                $itemPart = trim($matches[1]);
                $firstNumber = intval($matches[2]);
                $secondNumber = floatval($matches[3]);

                // Only auto-detect quantity if it's small and price is much larger
                // This avoids misinterpreting item names that end in numbers
                if ($firstNumber > 1 && $firstNumber <= 100 && $secondNumber >= ($firstNumber * 2)) {
                    $quantity = $firstNumber;
                    // Rebuild the line without the quantity for further processing
                    $line = strtolower($itemPart.' '.$secondNumber.substr($matches[0],
                            strpos($matches[0], $matches[3]) + strlen($matches[3])));
                }
            }
        }

        // If still no quantity, check for number at the beginning
        if ($quantity === 1) {
            if (preg_match('/^(\d+)\s+/i', $line, $matches)) {
                $potentialQuantity = intval($matches[1]);
                if ($potentialQuantity > 1 && $potentialQuantity <= 10000) {
                    $quantity = $potentialQuantity;
                    $line = preg_replace('/^(\d+)\s+/i', '', $line, 1);
                }
            }
        }

        // Clean up the remaining text as item name
        // Remove common separators and clean whitespace
        $itemName = trim(preg_replace('/[-–—]+/', '', $line));
        $itemName = trim(preg_replace('/[|\/\\\\]+/', '', $itemName));
        $itemName = trim(preg_replace('/\s+/', ' ', $itemName));

        // Remove any remaining price indicators
        $itemName = preg_replace('/\b\d+(?:\.\d+)?\s*(ton|qrk|not|usdt|usd)/i', '', $itemName);

        // Remove any remaining listing type keywords that might have leaked through
        foreach (array_merge($buyKeywords, $sellKeywords) as $keyword) {
            if (str_starts_with(strtolower($itemName), $keyword.' ')) {
                $itemName = trim(substr($itemName, strlen($keyword) + 1));
                break;
            }
        }

        $itemName = trim($itemName);

        if (empty($itemName) || strlen($itemName) < 2) {
            return null;
        }

        return [
            'item_name'     => $itemName,
            'quantity'      => $quantity,
            'listing_type'  => $listingType,
            'prices'        => $prices,
            'original_line' => $originalLine
        ];
    }

    /**
     * Show confirmation for natural language listings before creating them
     */
    private function showNaturalListingsConfirmation(array $parsedListings, User $user): void
    {
        try {
            // Store parsed listings in user session/cache for later confirmation
            $sessionKey = 'natural_listings_'.$user->id;
            $enrichedListings = [];

            $confirmationText = __('telegram.natural_listings_preview')."\n\n";
            $validCount = 0;
            $invalidCount = 0;

            foreach ($parsedListings as $index => $listing) {
                // Try to find matching item
                $item = $this->findBestMatchingItem($listing['item_name']);
                $isValid = $item !== null;

                if ($isValid) {
                    $validCount++;
                    $confirmationText .= "✅ ";
                    $enrichedListings[] = array_merge($listing, [
                        'item_fullname' => $item->getTranslation('name', app()->getLocale()),
                        'item_id'       => $item->id, 'item_found' => true
                    ]);
                } else {
                    $invalidCount++;
                    $confirmationText .= "❌ ";
                    $enrichedListings[] = array_merge($listing, ['item_found' => false]);
                }

                $confirmationText .= sprintf(
                    "%d. %s %s (%s) (x%d) - %s",
                    $index + 1,
                    ucfirst($listing['listing_type']),
                    $item ? $item->getTranslation('name', app()->getLocale()) : '',
                    $listing['item_name'],
                    $listing['quantity'],
                    $this->formatPrices($listing['prices'])
                );

                if (!$isValid) {
                    $confirmationText .= " ".__('telegram.item_not_found');
                }

                $confirmationText .= "\n";
            }

            // Store enriched listings for confirmation
            cache()->put($sessionKey, base64_encode(serialize($enrichedListings)), now()->addMinutes(30));

            $confirmationText .= "\n".__('telegram.natural_listings_summary', [
                    'valid'   => $validCount,
                    'invalid' => $invalidCount,
                    'total'   => count($parsedListings)
                ]);
            Log::info($confirmationText);
            // Create confirmation keyboard
            $keyboard = Keyboard::make()->inline();

            if ($validCount > 0) {
                $keyboard->row([
                    Keyboard::button([
                        'text'          => '✅ '.__('telegram.confirm_create_listings', ['count' => $validCount]),
                        'callback_data' => CallbackQueryActionEnum::CONFIRM_NATURAL_LISTINGS->value
                    ])
                ]);
            }

            $keyboard->row([
                Keyboard::button([
                    'text'          => '🔄 '.__('telegram.try_again'),
                    'callback_data' => CallbackQueryActionEnum::RETRY_NATURAL_LISTINGS->value
                ])
            ]);

            $keyboard->row([
                Keyboard::button([
                    'text'          => '❌ '.__('telegram.cancel'),
                    'callback_data' => CallbackQueryActionEnum::EXECUTE_COMMAND->value.':cancel'
                ])
            ]);

            $this->telegram->sendMessage([
                'chat_id'      => $user->telegram_chat_id,
                'text'         => mb_convert_encoding($confirmationText, 'UTF-8', 'UTF-8'),
                'reply_markup' => $keyboard
            ]);

        } catch (Throwable $e) {
            Log::error('Error showing natural listings confirmation: '.$e->getMessage(), [
                'user_id'   => $user->id,
                'exception' => $e
            ]);
            $this->sendErrorMessage($user->telegram_chat_id, 'Failed to process listings. Please try again.');
        }
    }

    /**
     * Create confirmed natural language listings
     */
    private function createConfirmedListings(array $parsedListings, User $user): void
    {
        try {
            $confirmationText = __('telegram.parsed_listings_confirmation')."\n\n";
            $createdCount = 0;
            $failedCount = 0;
            $failedItems = [];

            foreach ($parsedListings as $index => $listing) {
                $confirmationText .= sprintf(
                    "%d. %s %s %s (x%d) - %s\n",
                    $index + 1,
                    ucfirst($listing['listing_type']),
                    $listing['item_fullname'],
                    $listing['item_name'],
                    $listing['quantity'],
                    $this->formatPrices($listing['prices'])
                );

                // Try to find matching item
                $item = $this->findBestMatchingItem($listing['item_name']);

                if ($item) {
                    // Create the listing
                    try {
                        MarketListing::create([
                            'user_id'      => $user->id,
                            'item_id'      => $item->id,
                            'quantity'     => $listing['quantity'],
                            'listing_type' => $listing['listing_type'],
                            'status'       => 'active',
                            ...$listing['prices']
                        ]);
                        $createdCount++;
                    } catch (Throwable $e) {
                        $failedCount++;
                        $failedItems[] = $listing['item_name'];
                        Log::error('Failed to create listing', [
                            'listing'   => $listing,
                            'exception' => $e
                        ]);
                    }
                } else {
                    $failedCount++;
                    $failedItems[] = $listing['item_name'].' (item not found)';
                }
            }

            $confirmationText .= "\n".__('telegram.listings_creation_summary', [
                    'created' => $createdCount,
                    'failed'  => $failedCount
                ]);

            if (!empty($failedItems)) {
                $confirmationText .= "\n\n".__('telegram.failed_items').":\n• ".implode("\n• ", $failedItems);
            }

            $this->telegram->sendMessage([
                'chat_id' => $user->telegram_chat_id,
                'text'    => mb_convert_encoding($confirmationText, 'UTF-8', 'UTF-8'),
            ]);

        } catch (Throwable $e) {
            Log::error('Error confirming and creating listings: '.$e->getMessage(), [
                'user_id'   => $user->id,
                'exception' => $e
            ]);
            $this->sendErrorMessage($user->telegram_chat_id, 'Failed to create listings. Please try again.');
        }
    }

    /**
     * Handle confirmation of natural language listings
     */
    private function confirmNaturalListings(User $user): void
    {
        try {
            $sessionKey = 'natural_listings_'.$user->id;
            $enrichedListings = cache()->get($sessionKey);
            $enrichedListings = $enrichedListings ? unserialize(base64_decode($enrichedListings)) : null;
            info("lsit:",$enrichedListings);
            if (!$enrichedListings) {
                $this->sendErrorMessage($user->telegram_chat_id, __('telegram.session_expired_retry'));
                return;
            }

            // Filter only valid listings
            $validListings = array_filter($enrichedListings, fn($listing) => $listing['item_found']);

            if (empty($validListings)) {
                $this->sendErrorMessage($user->telegram_chat_id, __('telegram.no_valid_listings'));
                return;
            }

            // Create the listings
            $this->createConfirmedListings($validListings, $user);

            // Clear cache
            cache()->forget($sessionKey);

        } catch (Throwable $e) {
            Log::error('Error confirming natural listings: '.$e->getMessage(), [
                'user_id'   => $user->id,
                'exception' => $e
            ]);
            $this->sendErrorMessage($user->telegram_chat_id, 'Failed to create listings. Please try again.');
        }
    }

    /**
     * Handle retry of natural language listings
     */
    private function retryNaturalListings(User $user): void
    {
        try {
            $sessionKey = 'natural_listings_'.$user->id;
            cache()->forget($sessionKey);

            $this->telegram->sendMessage([
                'chat_id' => $user->telegram_chat_id,
                'text'    => __('telegram.retry_natural_listings_help'),
                'parse_mode' => 'MarkdownV2'
            ]);

        } catch (Throwable $e) {
            Log::error('Error retrying natural listings: '.$e->getMessage(), [
                'user_id'   => $user->id,
                'exception' => $e
            ]);
            $this->sendErrorMessage($user->telegram_chat_id, 'Please try again.');
        }
    }

    /**
     * Find the best matching item for a search term
     */
    private function findBestMatchingItem(string $searchTerm): ?Item
    {
        // First try exact match
        $item = Item::whereRaw(
            "JSON_SEARCH(LOWER(JSON_EXTRACT(name, '$.*')), 'one', LOWER(?)) IS NOT NULL",
            [$searchTerm]
        )->first();

        if ($item) {
            return $item;
        }

        // Try partial match
        $item = Item::whereRaw(
            "JSON_SEARCH(LOWER(JSON_EXTRACT(name, '$.*')), 'one', LOWER(?)) IS NOT NULL",
            ['%'.$searchTerm.'%']
        )->first();

        return $item;
    }

    /**
     * Format prices for display
     */
    private function formatPrices(array $prices): string
    {
        return collect($prices)
            ->map(fn($amount, $key) => strtoupper(str_replace('price_', '', $key)).': '.$amount)
            ->implode(', ');
    }

    private function getActiveConversation(?User $user): ?TelegramConversation
    {
        return $user ? TelegramConversation::query()->where('user_id', $user->id)->latest()->first() : null;
    }

    private function sendErrorMessage(string $chatId, string $message): void
    {
        try {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text'    => '⚠️ '.$message
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to send error message: '.$e->getMessage(), [
                'chat_id'          => $chatId,
                'original_message' => $message,
                'exception'        => $e
            ]);
        }
    }

    private function sendDirectMessage(string $chatId, string $message): void
    {
        try {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text'    => $message
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to send direct message: '.$e->getMessage(), [
                'chat_id'   => $chatId,
                'message'   => $message,
                'exception' => $e
            ]);
        }
    }

    /**
     * Handle unknown commands with helpful suggestions
     */
    private function handleUnknownCommand(string $command, string $chatId, ?User $user): void
    {
        try {
            Log::info('Unknown command received', [
                'command' => $command,
                'chat_id' => $chatId,
                'user_id' => $user?->id
            ]);

            if ($user && $user->telegram_user_id) {
                // User is logged in but used unknown command
                $this->telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text'    => __('telegram.unknown_command', ['command' => $command])
                ]);

                // Show main menu as fallback
                $this->showMainMenu($user, $chatId);
            } else {
                // User not logged in
                $this->telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text'    => __('telegram.unknown_command_login_required')
                ]);
                $this->sendLoginButton($chatId);
            }
        } catch (Throwable $e) {
            Log::error('Error handling unknown command: '.$e->getMessage(), [
                'command'   => $command,
                'chat_id'   => $chatId,
                'exception' => $e
            ]);
            // Ultimate fallback - just send a simple help message
            $this->sendDirectMessage($chatId, '❓ Type /start to begin');
        }
    }

    /**
     * Provide helpful guidance when user sends text without active conversation
     */
    private function provideHelpfulGuidance(string $text, ?User $user): void
    {
        try {
            if (!$user || !$user->telegram_user_id) {
                $this->sendLoginButton($user?->telegram_chat_id ?? null);
                return;
            }

            // Check if user needs language selection
            if (!$user->locale || !in_array($user->locale, array_keys($this->supportedLanguages))) {
                $this->startLanguageSelection($user, $user->telegram_chat_id);
                return;
            }

            // User is logged in but sent text without active conversation
            $this->telegram->sendMessage([
                'chat_id' => $user->telegram_chat_id,
                'text'    => __('telegram.no_active_conversation', ['message' => $text])."\n\n".
                    __('telegram.natural_listing_tip')
            ]);

            // Show main menu as guidance
            $this->showMainMenu($user, $user->telegram_chat_id);
        } catch (Throwable $e) {
            Log::error('Error providing helpful guidance: '.$e->getMessage(), [
                'text'      => $text,
                'user_id'   => $user?->id,
                'exception' => $e
            ]);

            if ($user && $user->telegram_chat_id) {
                $this->sendDirectMessage($user->telegram_chat_id, '❓ Type /start to see available options');
            }
        }
    }

    /**
     * Handle unexpected input during conversations
     */
    private function handleUnexpectedInput(TelegramConversation $conversation, string $text): void
    {
        try {
            Log::info('Unexpected input in conversation', [
                'conversation_id' => $conversation->id,
                'step'            => $conversation->step->value,
                'input'           => $text
            ]);

            $helpText = match ($conversation->step) {
                TelegramConversationStepEnum::AWAITING_LANGUAGE_SELECTION => __('telegram.help_language_selection'),
                TelegramConversationStepEnum::AWAITING_LISTING_TYPE => __('telegram.help_listing_type'),
                TelegramConversationStepEnum::AWAITING_ITEM_SELECTION => __('telegram.help_item_selection'),
                TelegramConversationStepEnum::AWAITING_QUANTITY => __('telegram.help_quantity'),
                TelegramConversationStepEnum::AWAITING_PRICE => __('telegram.help_price_selection'),
                default => __('telegram.help_general')
            };

            $this->telegram->sendMessage([
                'chat_id' => $conversation->chat_id,
                'text'    => __('telegram.unexpected_input')."\n\n".$helpText
            ]);

            // Restart the current step with buttons
            $this->restartCurrentStep($conversation);
        } catch (Throwable $e) {
            Log::error('Error handling unexpected input: '.$e->getMessage(), [
                'conversation_id' => $conversation->id,
                'text'            => $text,
                'exception'       => $e
            ]);

            // Fallback - delete conversation and show main menu
            $user = $conversation->user;
            $conversation->delete();
            if ($user) {
                $this->showMainMenu($user, $user->telegram_chat_id);
            }
        }
    }

    /**
     * Restart the current conversation step
     */
    private function restartCurrentStep(TelegramConversation $conversation): void
    {
        try {
            match ($conversation->step) {
                TelegramConversationStepEnum::AWAITING_LANGUAGE_SELECTION => $this->startLanguageSelection($conversation->user,
                    $conversation->chat_id),
                TelegramConversationStepEnum::AWAITING_LISTING_TYPE => $this->startNewListingConversation($conversation->user),
                TelegramConversationStepEnum::AWAITING_ITEM_NAME => $this->telegram->sendMessage([
                    'chat_id' => $conversation->chat_id,
                    'text'    => $conversation->step->description()
                ]),
                TelegramConversationStepEnum::AWAITING_ITEM_SELECTION => $this->recreateItemSelectionButtons($conversation),
                TelegramConversationStepEnum::AWAITING_QUANTITY => $this->telegram->sendMessage([
                    'chat_id' => $conversation->chat_id,
                    'text'    => $conversation->step->description()
                ]),
                TelegramConversationStepEnum::AWAITING_PRICE => $this->sendPriceKeyboard($conversation,
                    $conversation->step->description()),
                TelegramConversationStepEnum::AWAITING_PRICE_AMOUNT => $this->telegram->sendMessage([
                    'chat_id' => $conversation->chat_id,
                    'text'    => $conversation->step->description()
                ]),
                default => null
            };
        } catch (Throwable $e) {
            Log::error('Error restarting current step: '.$e->getMessage(), [
                'conversation_id' => $conversation->id,
                'step'            => $conversation->step->value,
                'exception'       => $e
            ]);
        }
    }

    /**
     * Emergency fallback when everything fails
     */
    private function emergencyFallback(string $chatId, ?User $user = null): void
    {
        try {
            // Clear any existing conversations
            if ($user) {
                TelegramConversation::query()->where('user_id', $user->id)->delete();
            }

            $this->sendDirectMessage($chatId, '🔄 '.__('telegram.emergency_reset'));

            if ($user && $user->telegram_user_id) {
                $this->showMainMenu($user, $chatId);
            } else {
                $this->sendLoginButton($chatId);
            }
        } catch (Throwable $e) {
            Log::critical('Emergency fallback failed: '.$e->getMessage(), [
                'chat_id'   => $chatId,
                'user_id'   => $user?->id,
                'exception' => $e
            ]);
            // Last resort - send simple message
            try {
                $this->telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text'    => '🆘 Service temporarily unavailable. Please try /start'
                ]);
            } catch (Throwable $finalError) {
                Log::critical('Final fallback failed: '.$finalError->getMessage());
            }
        }
    }
}
