<?php

namespace App\Http\Middleware;

use App\Filament\Pages\Auth\EditProfile;
use Closure;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class EnsureTelegramUsernameIsFilledMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && empty($user->telegram_username)) {
            Notification::make()
                ->title('Profile Incomplete')
                ->warning()
                ->body('Please fill in your Telegram username to continue.')
                ->send();

            return redirect()->to(EditProfile::getUrl());
        }

        return $next($request);
    }
}
