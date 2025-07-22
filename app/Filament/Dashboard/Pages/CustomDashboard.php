<?php

namespace App\Filament\Dashboard\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class CustomDashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    public function getWidgets(): array
    {
        if (auth()->user()->is_super_admin) {
            return [
                \App\Filament\Dashboard\Widgets\StatsOverview::class,
                \App\Filament\Dashboard\Widgets\UserListingsOverview::class,
                \Filament\Widgets\AccountWidget::class,
            ];
        }
        return [
            \App\Filament\Dashboard\Widgets\UserListingsOverview::class,
            \Filament\Widgets\AccountWidget::class,
        ];
    }
}
