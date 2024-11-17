<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Bank extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'bank_name',
        'branch',
        'account_holder',
        'account_no',
        'initial_balance',
        'status',
    ];
}
