<?php

namespace Database\Factories;

use App\Enum\ListinStatusEnum;
use App\Models\Item;
use App\Models\MarketListing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MarketListingFactory extends Factory
{
    protected $model = MarketListing::class;

    public function definition(): array
    {
        $bundle = random_int(0, 1);
        return [
            'user_id'             => User::factory(),
            'quantity'            => $bundle ? random_int(50, 500) : random_int(1, 3),
            'quintity_per_bundle' => $bundle ? $this->faker->randomElement([
                10, 20, 50, 100, 200, 500, 1000
            ]) : 1,
            'status'              => $this->faker->randomElement(ListinStatusEnum::getAllValues()),
            'price_ton'           => $this->faker->randomFloat(2, 0, 10),
            'price_qrk'           => $this->faker->randomFloat(2, 0, 500),
            'price_not'           => $this->faker->randomFloat(2, 0, 1000),
            'price_usd'           => $this->faker->randomFloat(2, 0, 30),

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'item_id' => Item::inRandomOrder()->first(),
        ];
    }
}
