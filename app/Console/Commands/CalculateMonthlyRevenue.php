<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CalculateMonthlyRevenue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-monthly-revenue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and store total revenue for the current and previous month';

    public function handle()
    {
        $monthsToCalculate = [now(), now()->subMonth()];

        foreach ($monthsToCalculate as $date) {
            $year = $date->year;
            $month = $date->month;

            $totalRevenue = \App\Models\Booking::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('total_price');

            \App\Models\MonthlyRevenue::updateOrCreate(
                ['year' => $year, 'month' => $month],
                ['total_revenue' => $totalRevenue]
            );

            $this->info("Monthly revenue for {$year}-{$month} calculated and saved: Rp {$totalRevenue}");
        }
    }
}
