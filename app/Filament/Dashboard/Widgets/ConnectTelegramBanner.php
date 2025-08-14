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
    public bool $isConnected = false;
    public function mount(): void
    {
        $user = Auth::user();
        $this->botUsername = config('services.telegram-bot-api.username');

        if ($user && $this->botUsername) {
            // For account linking, we'll use the Telegram Login Widget approach
            // The actual OAuth flow will be handled via JavaScript widget
            $this->connectUrl = route('telegram.link.callback');
        }
        $this->isConnected = !is_null($user->telegram_chat_id);
    }

    public static function canView(): bool
    {
        return Auth::check();
    }
}
