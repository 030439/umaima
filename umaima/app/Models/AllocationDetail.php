<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AllocationDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'allocation_details';

    // Fields that can be mass-assigned
    protected $fillable = [
        'allote',
        'scheme',
        'status',
        'plot',
        'bdate',
        'onbooking',
        'allocation',
        'confirmation',
        'installment',
        'duration',
        'extra',
        'percentage',
        'possession',
        'demargation'
    ];

    // Define date attributes to ensure proper date handling
    protected $dates = ['bdate', 'deleted_at'];
}
