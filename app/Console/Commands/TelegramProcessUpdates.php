<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TelegramProcessUpdates extends Command
{
    protected $signature = 'telegram:process-updates';
    protected $description = 'Fetch and process pending Telegram bot updates manually';

    public function handle()
    {
        $token = config('services.telegram-bot-api.token');
        if (!$token) {
            $this->error('Telegram Bot Token is not configured.');
            return 1;
        }

        // Get updates from Telegram
        $response = Http::get("https://api.telegram.org/bot{$token}/getUpdates");
        $updates = $response->json()['result'] ?? [];

        if (empty($updates)) {
            $this->info('No pending updates found.');
            return 0;
        }

        $this->info(count($updates) . ' updates found. Processing...');

        foreach ($updates as $update) {
            // Your existing webhook logic goes here
            if (isset($update['message']['text']) && isset($update['message']['chat']['id'])) {
                $chatId = $update['message']['chat']['id'];
                $text = $update['message']['text'];

                if (Str::startsWith($text, '/start ')) {
                    $connectToken = Str::after($text, '/start ');

                    $user = User::where('telegram_connect_token', $connectToken)->first();

                    if ($user) {
                        $user->telegram_chat_id = $chatId;
                        $user->telegram_connect_token = null; // Single-use
                        $user->save();
                        $this->info("User #{$user->id} ({$user->name}) has been connected with Chat ID {$chatId}.");
                    }
                }
            }

            // Mark this update as read by using the 'offset' parameter for the next run
            $offset = $update['update_id'] + 1;
            Http::get("https://api.telegram.org/bot{$token}/getUpdates?offset={$offset}");
        }

        $this->info('All updates processed.');
        return 0;
    }
}
