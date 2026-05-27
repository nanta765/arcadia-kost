<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Room;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected int|string|array $columnSpan = 3;
    protected function getStats(): array
    {
        return [
            Stat::make('Total Bookings', Booking::count())
                ->description('All bookings')
                ->icon('heroicon-o-calendar-days'),

            Stat::make('Available Rooms', Room::where('status', 'available')->count())
                ->description('Ready for move-in')
                ->icon('heroicon-o-home'),

            Stat::make('Today\'s Bookings', Booking::whereDate('created_at', today())->count())
                ->icon('heroicon-o-bookmark'),
        ];
    }
}