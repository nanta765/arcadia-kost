<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Room;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Booking', Booking::count())
                ->description('Semua booking')
                ->icon('heroicon-o-calendar-days'),

            Stat::make('Kamar Tersedia', Room::where('status', 'available')->count())
                ->description('Ready digunakan')
                ->icon('heroicon-o-home'),

            Stat::make('Booking Hari Ini', Booking::whereDate('created_at', today())->count())
                ->icon('heroicon-o-bookmark'),

            Stat::make(
                'Revenue',
                'Rp ' . number_format(
                    Booking::sum('total_price'),
                    0,
                    ',',
                    '.'
                )
            )->icon('heroicon-o-banknotes'),
        ];
    }
}