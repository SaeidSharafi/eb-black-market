<?php

namespace App\Filament\Dashboard\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class ConnectTelegramBanner extends Widget
{
    protected static string $view = 'filament.dashboard.widgets.connect-telegram-banner';
    protected int|string|array $columnSpan = 'full';

    public ?string $connectUrl = null;
    public ?string $botUsername = null;

    public function mount(): void
    {
        $user = Auth::user();
        $this->botUsername = config('services.telegram-bot-api.username');

        if ($user && $this->botUsername) {
            // For account linking, we'll use the Telegram Login Widget approach
            // The actual OAuth flow will be handled via JavaScript widget
            $this->connectUrl = route('telegram.link.callback');
        }
    }

    public static function canView(): bool
    {
        // Only show the widget if the user is logged in and their telegram_chat_id is not set.
        $user = Auth::user();
        return $user && is_null($user->telegram_chat_id);
    }
}
