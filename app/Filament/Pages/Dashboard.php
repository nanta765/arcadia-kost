<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\RecentBookings;
use App\Filament\Widgets\ReviewStats;

class Dashboard extends BaseDashboard
{
    public function getColumns(): int|array
    {
        return 5;
    }

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            ReviewStats::class,
            RecentBookings::class,
        ];
    }
}
