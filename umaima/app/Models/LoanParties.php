<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanParties extends Model
{
    use HasFactory;
    protected $table = 'loan_parties';
    protected $fillable = ['name', 'address','phone'];
}
