<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TelegramAuthController extends Controller
{
    public function handleCallback(Request $request)
    {
        $authData = $request->all();

        if (!$this->isTelegramDataValid($authData)) {
            Log::warning('Invalid Telegram login attempt.', $authData);
            abort(403, 'Invalid hash. Data is not from Telegram.');
        }

        $telegramUserId = $authData['id'];

        // Find an existing user by their old chat_id to migrate them,
        // or find them by their new telegram_user_id if they've logged in before.
        $user = User::where('telegram_user_id', $telegramUserId)
            ->orWhere('telegram_chat_id', $telegramUserId) // For migrating users
            ->first();

        if (!$user) {
            // This is a new user. We create a new account for them.
            $user = User::create([
                // We get what we can from Telegram
                'name' => ($authData['first_name'] ?? '') . ' ' . ($authData['last_name'] ?? 'User'),
                'telegram_user_id' => $telegramUserId,
                'telegram_chat_id' => $telegramUserId,
                'telegram_username' => $authData['username'] ?? null,
                'telegram_avatar_url' => $authData['photo_url'] ?? null,

                // We must create placeholder values for required fields not provided by Telegram.
                // Create a fake, unique, and clearly identifiable email.
                'email' => $telegramUserId . '@telegram.placeholder.local',

                // Create a secure, random password that the user will never need to know.
                // They can use a "Forgot Password" flow on your site later if they want to set one.
                'password' => Hash::make(Str::random(24)),
            ]);

            Log::info('New user created via Telegram OAuth.', ['user_id' => $user->id, 'telegram_user_id' => $telegramUserId]);

        } else {
            // This is an existing user. We just ensure their Telegram data is up-to-date.
            $user->update([
                'telegram_user_id' => $telegramUserId,
                'telegram_chat_id' => $telegramUserId,
                'telegram_username' => $authData['username'] ?? null,
                'telegram_avatar_url' => $authData['photo_url'] ?? null,
            ]);
        }

        // Log the user in to the web session for a seamless experience.
        Auth::login($user);

        return view('telegram.auth-success');
    }

    /**
     * Verify that the data is genuinely from Telegram.
     */
    private function isTelegramDataValid(array $authData): bool
    {
        if (!isset($authData['hash'])) {
            return false;
        }

        $checkHash = $authData['hash'];
        unset($authData['hash']);

        $dataCheckArr = [];
        foreach ($authData as $key => $value) {
            $dataCheckArr[] = $key . '=' . $value;
        }
        sort($dataCheckArr);
        $dataCheckString = implode("\n", $dataCheckArr);

        $secretKey = hash('sha256', config('services.telegram-bot-api.token'), true);
        $hash = hash_hmac('sha256', $dataCheckString, $secretKey);

        return $hash === $checkHash;
    }
}
