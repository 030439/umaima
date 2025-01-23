<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    
    protected $table="transfers";
    protected $fillable = [
        'allocation_details_id',
        'from',
        'to',
        'tdate',
        'amount', 
        'narration'
    ];
}
