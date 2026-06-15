<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProfitSummary extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->role === 'owner';
    }

    protected ?string $heading = 'Profit Breakdown';

    protected function getStats(): array
    {
        $rows = Booking::selectRaw("
                COALESCE(SUM(total_price), 0) as gross,
                COUNT(*) as booking_count
            ")
            ->whereIn('status', ['active', 'completed', 'review', 'pending'])
            ->first();

        $gross = (int) ($rows->gross ?? 0);
        $count = (int) ($rows->booking_count ?? 0);
        $net = $gross - ($count * 1_400_000);
        $deduction = $gross - $net;

        return [
            Stat::make('Gross Profit', 'Rp ' . number_format($gross, 0, ',', '.'))
                ->description('Total booking revenue')
                ->icon('heroicon-o-banknotes')
                ->color('warning'),

            Stat::make('Net Profit', 'Rp ' . number_format($net, 0, ',', '.'))
                ->description('After Rp 1,4M cost per booking')
                ->icon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Total Deduction', 'Rp ' . number_format($deduction, 0, ',', '.'))
                ->description($count . ' bookings × Rp 1,400,000')
                ->icon('heroicon-o-arrow-trending-down')
                ->color('danger'),
        ];
    }
}
