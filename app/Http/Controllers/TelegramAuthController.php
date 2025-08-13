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
        try {
            $authData = $request->all();

            // Security: Check for required fields
            if (!isset($authData['id'], $authData['hash'], $authData['auth_date'])) {
                Log::warning('Missing required Telegram auth fields.', ['ip' => $request->ip()]);
                abort(400, 'Missing required authentication data.');
            }

            // Security: Check auth_date to prevent replay attacks (data older than 1 hour)
            if ((time() - $authData['auth_date']) > 3600) {
                Log::warning('Telegram auth data too old.', ['auth_date' => $authData['auth_date'], 'ip' => $request->ip()]);
                abort(403, 'Authentication data expired.');
            }

            if (!$this->isTelegramDataValid($authData)) {
                Log::warning('Invalid Telegram login attempt.', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'telegram_user_id' => $authData['id'] ?? null
                ]);
                abort(403, 'Invalid hash. Data is not from Telegram.');
            }
        } catch (\Exception $e) {
            Log::error('Telegram auth error: ' . $e->getMessage(), [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'exception' => $e
            ]);
            abort(500, 'Authentication failed.');
        }

        try {
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
                    'name' => trim(($authData['first_name'] ?? '') . ' ' . ($authData['last_name'] ?? '')),
                    'telegram_user_id' => $telegramUserId,
                    'telegram_chat_id' => $telegramUserId,
                    'telegram_username' => isset($authData['username']) ? strtolower($authData['username']) : null,
                    'telegram_avatar_url' => $authData['photo_url'] ?? null,

                    // We must create placeholder values for required fields not provided by Telegram.
                    // Create a fake, unique, and clearly identifiable email.
                    'email' => $telegramUserId . '@telegram.placeholder.local',

                    // Create a secure, random password that the user will never need to know.
                    // They can use a "Forgot Password" flow on your site later if they want to set one.
                    'password' => Hash::make(Str::random(32)), // Increased from 24 to 32 chars

                    // Set default locale if not already set
                    'locale' => app()->getLocale(),
                ]);

                Log::info('New user created via Telegram OAuth.', [
                    'user_id' => $user->id,
                    'telegram_user_id' => $telegramUserId,
                    'ip' => request()->ip()
                ]);

            } else {
                // This is an existing user. We just ensure their Telegram data is up-to-date.
                $user->update([
                    'telegram_user_id' => $telegramUserId,
                    'telegram_chat_id' => $telegramUserId,
                    'telegram_username' => isset($authData['username']) ? strtolower($authData['username']) : null,
                    'telegram_avatar_url' => $authData['photo_url'] ?? null,
                ]);

                Log::info('Existing user updated via Telegram OAuth.', [
                    'user_id' => $user->id,
                    'telegram_user_id' => $telegramUserId,
                    'ip' => request()->ip()
                ]);
            }

            // Log the user in to the web session for a seamless experience.
            Auth::login($user);

            return view('telegram.auth-success');
        } catch (\Exception $e) {
            Log::error('User creation/update error during Telegram auth: ' . $e->getMessage(), [
                'telegram_user_id' => $authData['id'] ?? null,
                'ip' => request()->ip(),
                'exception' => $e
            ]);
            abort(500, 'User authentication failed.');
        }
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
            // Security: Validate and sanitize the data
            if (!is_string($key) || !is_scalar($value)) {
                return false;
            }
            $dataCheckArr[] = $key . '=' . $value;
        }
        sort($dataCheckArr);
        $dataCheckString = implode("\n", $dataCheckArr);

        $secretKey = hash('sha256', config('services.telegram-bot-api.token'), true);
        $hash = hash_hmac('sha256', $dataCheckString, $secretKey);

        return hash_equals($hash, $checkHash); // Use hash_equals to prevent timing attacks
    }
}
