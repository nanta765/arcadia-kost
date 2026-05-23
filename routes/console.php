<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jadwalkan perhitungan revenue sebulan sekali pada hari terakhir setiap bulan jam 23:50
// Atau bisa dijalankan setiap hari agar tabel tetap up-to-date
Schedule::command('app:calculate-monthly-revenue')->dailyAt('23:50');
