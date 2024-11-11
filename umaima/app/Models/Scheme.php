<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    protected $fillable = ['name', 'no_of_plots', 'area', 'total_valuation'];

    public function plots()
    {
        return $this->hasMany(Plot::class);
    }
}
