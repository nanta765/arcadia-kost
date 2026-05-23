<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyRevenue extends Model
{
    protected $fillable = ['year', 'month', 'total_revenue'];
}
