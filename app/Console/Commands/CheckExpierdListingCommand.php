<?php

namespace App\Console\Commands;

use App\Enum\ListingStatusEnum;
use App\Models\MarketListing;
use Carbon\CarbonInterface;
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
        MarketListing::query()->each(function ($item) {
            echo $item->updated_at->format('Y-m-d H:i:s').PHP_EOL;
        });
        MarketListing::query()
            ->with('user')
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

                    if ($listing->user->telegram_chat_id) {
                        $listing->user->notify(new \App\Notifications\ListingExpiredNotification($listing));
                    }
                    DB::commit();
                }
            });
        $counterAbout = 0;
        MarketListing::query()
            ->withWhereHas('user', function ($query) {
                $query->whereNotNull('telegram_chat_id');
            })
            ->where('status', ListingStatusEnum::ACTIVE)
            ->where('updated_at', '<', now()->subDays(2)->subHours(13)->format('Y-m-d H:i:s'))
            ->chunk(100, function ($listings) use (&$counterAbout) {
                foreach ($listings as $listing) {

                    $alreadySent = cache()->get("listing_about_to_expire_{$listing->id}", false);
                    if ($alreadySent) {
                        continue; // Skip if notification was already sent in the last 3 hours
                    }
                    $counterAbout++;
                    $listing->user->notify(new \App\Notifications\ListingAboutToExpireNotification($listing));
                    cache()->put("listing_about_to_expire_{$listing->id}", true, now()->addHours(3));
                }
            });
        $this->info("{$counter} expired listings found and notifications sent.");
        $this->info("{$counterAbout} listings about to expire notifications sent.");

        // You can return an exit code if needed
        return 0; // 0 indicates success
    }
}
