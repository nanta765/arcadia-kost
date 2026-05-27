<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReviewStats extends BaseWidget
{
    protected int|string|array $columnSpan = 2;
    protected function getStats(): array
    {
        // Hitung rata-rata rating dari seluruh kamar
        $averageRating = Review::avg('rating') ?? 0;
        // Hitung total ulasan yang masuk
        $totalReviews = Review::count();

        return [
            Stat::make('Average Rating', number_format($averageRating, 1) . ' / 5.0')
                ->description('Overall tenant satisfaction')
                ->descriptionIcon('heroicon-m-star')
                ->color($averageRating >= 4 ? 'success' : 'warning'),

            Stat::make('Total Reviews', $totalReviews . ' Reviews')
                ->description('Feedback from tenants')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('info'),
        ];
    }
}