<?php

namespace App\Filament\Dashboard\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class ConnectTelegramBanner extends Widget
{
    protected static string $view = 'filament.dashboard.widgets.connect-telegram-banner';
    protected int|string|array $columnSpan = 'full';

    public ?string $connectUrl = null;

    public function mount(): void
    {
        $user = Auth::user();
        $botUsername = config('services.telegram-bot-api.bot_username'); // Add your bot username to config/services.php

        if ($user && $user->telegram_connect_token && $botUsername) {
            $this->connectUrl = 'https://t.me/' . $botUsername . '?start=' . $user->telegram_connect_token;
        }
    }

    public static function canView(): bool
    {
        // Only show the widget if the user is logged in and their telegram_chat_id is not set.
        $user = Auth::user();
        return $user && is_null($user->telegram_chat_id);
    }
}
