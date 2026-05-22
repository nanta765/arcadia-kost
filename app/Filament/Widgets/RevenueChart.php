<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected ?string $heading = 'Revenue Bulanan';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => [10, 20, 30, 40],
                ],
            ],

            'labels' => ['Jan', 'Feb', 'Mar', 'Apr'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}