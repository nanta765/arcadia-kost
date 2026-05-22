<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReviewStats extends BaseWidget
{
    protected function getStats(): array
    {
        // Hitung rata-rata rating dari seluruh kamar
        $averageRating = Review::avg('rating') ?? 0;
        // Hitung total ulasan yang masuk
        $totalReviews = Review::count();

        return [
            Stat::make('Rata-rata Rating Kost', number_format($averageRating, 1) . ' / 5.0')
                ->description('Kepuasan keseluruhan anak kost')
                ->descriptionIcon('heroicon-m-star')
                ->color($averageRating >= 4 ? 'success' : 'warning'),

            Stat::make('Total Ulasan Masuk', $totalReviews . ' Ulasan')
                ->description('Total feedback dari penghuni')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('info'),
        ];
    }
}