<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSchedule extends Model
{
    use HasFactory;

    protected $table="payment_schedule";
    protected $fillable = [
        'allocation_details_id',
        'payment',
        'amount',
        'outstanding',
        'amount_paid',
        'paid_on',
        'surcharge',
        'pay_date'
    ];
}
