<?php

namespace App\Filament\Dashboard\Widgets;

use App\Models\MarketListing;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Total users in the system')
                ->color('success'),
            Stat::make('Total Listings', MarketListing::count())
                ->description('Total listings in the market')
                ->color('primary'),
            Stat::make('Active Listings', MarketListing::where('status', 'active')->count())
                ->description('Active listings available for purchase')
                ->color('info'),
        ];
    }
}
