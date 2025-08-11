<?php

namespace App\Notifications;

use App\Filament\Dashboard\Resources\MyListingResource;
use App\Models\MarketListing;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use NotificationChannels\Telegram\TelegramMessage;

class ListingExpiredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly MarketListing $listing)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram(object $notifiable)
    {
        $lang = DB::table('user_languages')
            ->where('model_id', $notifiable->id)
            ->where('model_type', User::class)
            ->value('lang');
        $lang = $lang ?: 'ru';
        return TelegramMessage::create()
            ->to($notifiable->telegram_chat_id)
            ->line(__('notifications.expired_listing.title',[],$lang))
            ->line(
                __('notifications.expired_listing.message', [
                    'item' => $this->listing->item->getTranslation('name', $lang),
                ], $lang)
            )
            ->button(__('notifications.expired_listing.action_text',[],$lang), route('filament.dashboard.resources.my-listings.edit', [$this->listing->id]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
