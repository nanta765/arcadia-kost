<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected ?string $heading = 'Revenue Bulanan';

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 1; $i <= 12; $i++) {
            $revenue = \App\Models\MonthlyRevenue::where('year', date('Y'))
                ->where('month', $i)
                ->value('total_revenue') ?? 0;
            
            $data[] = $revenue;
            $labels[] = \Carbon\Carbon::create()->month($i)->translatedFormat('M');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $data,
                ],
            ],

            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}