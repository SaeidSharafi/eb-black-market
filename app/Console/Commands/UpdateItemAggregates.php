<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\MarketListing;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateItemAggregates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-item-aggregates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update items with aggregated data from market listings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating item aggregates...');

        Item::chunk(100, function ($items) {
            foreach ($items as $item) {
                $aggregates = MarketListing::where('item_id', $item->id)
                    ->select(
                        DB::raw('AVG(price_qrk) as average_price_qrk'),
                        DB::raw('AVG(price_not) as average_price_not'),
                        DB::raw('AVG(price_ton) as average_price_ton'),
                        DB::raw('AVG(price_usd) as average_price_usd'),
                        DB::raw('SUM(quantity) as total_listed'),
                        DB::raw('MAX(created_at) as last_listed_at')
                    )
                    ->first();

                $item->update([
                    'average_price_qrk' => $aggregates->average_price_qrk,
                    'average_price_not' => $aggregates->average_price_not,
                    'average_price_ton' => $aggregates->average_price_ton,
                    'average_price_usd' => $aggregates->average_price_usd,
                    'total_listed' => $aggregates->total_listed,
                    'last_listed_at' => $aggregates->last_listed_at,
                ]);
            }
        });


        $this->info('Item aggregates updated successfully.');
    }
}
