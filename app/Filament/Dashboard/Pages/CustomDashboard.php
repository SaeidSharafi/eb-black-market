<?php

namespace App\Filament\Dashboard\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class CustomDashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    public function getWidgets(): array
    {
        $topWidget = [
            \App\Filament\Dashboard\Widgets\ConnectTelegramBanner::class,
        ];
        if (auth()->user()->is_super_admin) {
            $adminWidgets =  [
                \App\Filament\Dashboard\Widgets\StatsOverview::class,
                \App\Filament\Dashboard\Widgets\UserListingsOverview::class,
            ];
        }
        return array_merge(
            $topWidget,
                $adminWidgets ?? [],
            [
                \Filament\Widgets\AccountWidget::class,
            ]
        );
    }
}
