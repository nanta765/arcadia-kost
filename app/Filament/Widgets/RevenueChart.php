<?php

namespace App\Filament\Widgets;

use App\Models\MonthlyRevenue;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected int|string|array $columnSpan = 'full';
    protected ?string $heading = 'Monthly Revenue';
    protected ?string $description = 'Total booking revenue per month in Indonesian Rupiah.';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $revenues = MonthlyRevenue::orderBy('year')
            ->orderBy('month')
            ->get();

        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $revenues->pluck('total_revenue')->map(fn($v) => (int) $v)->values()->toArray(),
                    'fill' => true,
                    'backgroundColor' => 'rgba(245,158,11,0.18)',
                    'borderColor' => '#f59e0b',
                    'borderWidth' => 2.5,
                    'tension' => 0.4,
                    'pointRadius' => 4,
                    'pointBackgroundColor' => '#f59e0b',
                    'pointBorderColor' => '#ffffff',
                    'pointBorderWidth' => 2,
                    'pointHoverRadius' => 8,
                    'pointHoverBackgroundColor' => '#f59e0b',
                    'pointHoverBorderColor' => '#ffffff',
                    'pointHoverBorderWidth' => 3,
                ],
            ],
            'labels' => $revenues->map(fn($r) => $months[(int) $r->month] . ' ' . $r->year)->values()->toArray(),
        ];
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'
            {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        padding: 16,
                        backgroundColor: 'rgba(17,24,39,0.92)',
                        titleColor: '#f9fafb',
                        bodyColor: '#d1d5db',
                        borderColor: 'rgba(245,158,11,0.3)',
                        borderWidth: 1,
                        cornerRadius: 12,
                        displayColors: false,
                        titleFont: { weight: '600', size: 13 },
                        bodyFont: { size: 13 },
                        callbacks: {
                            title: function(items) { return items[0].label; },
                            label: function(context) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            padding: 10,
                            color: '#9ca3af',
                            font: { size: 11 },
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID', {notation:'compact', compactDisplay:'short'}).format(value);
                            },
                        },
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0,0,0,0.05)',
                            lineWidth: 1,
                        },
                        border: { display: false },
                    },
                    x: {
                        ticks: {
                            color: '#9ca3af',
                            font: { size: 11 },
                            padding: 8,
                        },
                        grid: { display: false },
                        border: { display: false },
                    },
                },
            }
            JS);
    }

    protected function getType(): string
    {
        return 'line';
    }

    public static function canView(): bool
    {
        return auth()->user()?->role === 'owner';
    }
}
