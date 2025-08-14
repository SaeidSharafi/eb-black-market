<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TelegramLinkController extends Controller
{
    public function handleCallback(Request $request)
    {
        // Check if this is a manual redirect (user clicked the manual button)
        if ($request->has('manual')) {
            return $this->showManualAuthPage();
        }

        try {
            // Get all data from the request (could be GET or POST from Telegram Login Widget)
            $authData = $request->all();

            // Security: Check for required fields
            if (!isset($authData['id'], $authData['hash'], $authData['auth_date'])) {
                Log::warning('Missing required Telegram auth fields for linking.', [
                    'ip' => $request->ip(),
                    'received_data' => array_keys($authData)
                ]);
                abort(400, 'Missing required authentication data.');
            }

            // Security: Check auth_date to prevent replay attacks (data older than 1 hour)
            if ((time() - $authData['auth_date']) > 3600) {
                Log::warning('Telegram auth data too old for linking.', [
                    'auth_date' => $authData['auth_date'],
                    'current_time' => time(),
                    'ip' => $request->ip()
                ]);
                abort(403, 'Authentication data expired.');
            }

            if (!$this->isTelegramDataValid($authData)) {
                Log::warning('Invalid Telegram link attempt.', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'telegram_user_id' => $authData['id'] ?? null,
                    'received_hash' => $authData['hash'] ?? null
                ]);
                abort(403, 'Invalid hash. Data is not from Telegram.');
            }
        } catch (\Exception $e) {
            Log::error('Telegram link auth error: ' . $e->getMessage(), [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'exception' => $e
            ]);
            abort(500, 'Authentication failed.');
        }

        try {
            $telegramUserId = $authData['id'];
            $user = Auth::user();

            if (!$user) {
                Log::warning('Attempted to link Telegram account without being authenticated.', [
                    'ip' => $request->ip(),
                    'telegram_user_id' => $telegramUserId
                ]);
                abort(401, 'You must be logged in to link your Telegram account.');
            }

            // Check if this Telegram account is already linked to another user
            $existingUser = User::where('telegram_user_id', $telegramUserId)
                ->where('id', '!=', $user->id)
                ->first();

            if ($existingUser) {
                Log::warning('Attempted to link Telegram account that is already linked to another user.', [
                    'current_user_id' => $user->id,
                    'existing_user_id' => $existingUser->id,
                    'telegram_user_id' => $telegramUserId,
                    'ip' => $request->ip()
                ]);
                return view('telegram.link-error', [
                    'error' => 'This Telegram account is already linked to another user.'
                ]);
            }

            // Update the current user's Telegram data
            $user->update([
                'telegram_user_id' => $telegramUserId,
                'telegram_chat_id' => $telegramUserId,
                'telegram_username' => isset($authData['username']) ? strtolower($authData['username']) : null,
                'telegram_avatar_url' => $authData['photo_url'] ?? null,
                'telegram_connect_token' => null, // Clear the old token as we're now using OAuth
            ]);

            Log::info('User successfully linked Telegram account via OAuth.', [
                'user_id' => $user->id,
                'telegram_user_id' => $telegramUserId,
                'ip' => request()->ip()
            ]);

            return view('telegram.link-success');
        } catch (\Exception $e) {
            Log::error('User update error during Telegram linking: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'telegram_user_id' => $authData['id'] ?? null,
                'ip' => request()->ip(),
                'exception' => $e
            ]);
            abort(500, 'Telegram account linking failed.');
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

    /**
     * Show manual authentication page with Telegram Login Widget
     */
    private function showManualAuthPage()
    {
        $user = Auth::user();
        if (!$user) {
            abort(401, 'You must be logged in to link your Telegram account.');
        }

        $botUsername = config('services.telegram-bot-api.username');
        if (!$botUsername) {
            abort(500, 'Telegram bot is not properly configured.');
        }

        return view('telegram.manual-auth', [
            'botUsername' => $botUsername,
            'callbackUrl' => route('telegram.link.callback'),
            'user' => $user
        ]);
    }
}
