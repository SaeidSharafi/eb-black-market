<?php

namespace App\Filament\Dashboard\Widgets;

use App\Models\MarketListing;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class UserListingsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        return [
            Stat::make('Your Active Listings', MarketListing::where('user_id', $user->id)->where('status', 'active')->count())
                ->description('Your active listings in the market')
                ->color('success'),
        ];
    }
}
