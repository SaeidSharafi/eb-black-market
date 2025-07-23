<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\MarketListing;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\MarketListingFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MarketListing::truncate();
        Item::truncate();
        User::query()
            ->where('is_super_admin', 0)
            ->orWhereNull('is_super_admin')
            ->delete();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call(ItemSeeder::class);
        MarketListing::factory(100)->create();
    }
}
