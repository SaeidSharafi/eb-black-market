<?php

namespace App\Console\Commands;

use App\Enum\ListingStatusEnum;
use App\Models\MarketListing;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckExpierdListingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:expierd-listing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired listings that need notification...');
        $counter = 0;
        MarketListing::query()
            ->withWhereHas('user', function ($query) {
                $query->whereNotNull('telegram_chat_id');
            })
            ->where('status', ListingStatusEnum::ACTIVE)
            ->where('updated_at', '<', now()->subDays(3)->format('Y-m-d H:i:s'))
            ->whereNull('expired_notification_sent_at')
            ->chunk(100, function ($listings) use (&$counter) {
                foreach ($listings as $listing) {
                    DB::beginTransaction();
                    $counter++;

                    $listing->status = ListingStatusEnum::EXPIRED;
                    $listing->expired_notification_sent_at = now();
                    $listing->timestamps = false;
                    $listing->save(['timestamps' => false]);

                    // Send the notification
                    $listing->user->notify(new \App\Notifications\ListingExpiredNotification($listing));
                    DB::commit();
                }
            });

        $this->info("{$counter} expired listings found and notifications sent.");

        // You can return an exit code if needed
        return 0; // 0 indicates success
    }
}
