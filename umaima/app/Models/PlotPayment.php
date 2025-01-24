<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlotPayment extends Model
{
    use HasFactory;

    protected $table="plot_paymnets";
    
    protected $fillable = [
        'allocation_details_id',
        'paydate',
        'receipt_id',
        'amount',
        'narration'
    ];
}
