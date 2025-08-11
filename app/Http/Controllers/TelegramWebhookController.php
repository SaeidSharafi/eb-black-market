<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $update = $request->all();

        // Check if the update is a message and contains text
        if (isset($update['message']['text']) && isset($update['message']['chat']['id'])) {
            $chatId = $update['message']['chat']['id'];
            $text = $update['message']['text'];

            // Check if the message is a /start command with a token
            if (Str::startsWith($text, '/start ')) {
                $token = Str::after($text, '/start ');

                $user = User::where('telegram_connect_token', $token)->first();

                if ($user) {
                    // Associate the chat_id with the user and clear the token
                    $user->telegram_chat_id = $chatId;
                    $user->telegram_connect_token = null; // Token is single-use
                    $user->save();

                    // (Optional) Send a confirmation message back to the user
                    $this->sendTelegramMessage($chatId, '✅ Your account has been successfully connected!');
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }

    protected function sendTelegramMessage(string $chatId, string $message)
    {
        $token = config('services.telegram-bot-api.token');
        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        try {
            \Illuminate\Support\Facades\Http::post($url, [
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send Telegram confirmation message: ' . $e->getMessage());
        }
    }
}
