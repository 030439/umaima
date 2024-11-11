<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    protected $fillable = ['plot_number', 'scheme_id', 'plot_size_id', 'plot_location_id', 'plot_category_id'];

    public function scheme()
    {
        return $this->belongsTo(Scheme::class);
    }

    // public function size()
    // {
    //     return $this->belongsTo(PlotSize::class, 'plot_size_id');
    // }

    // public function location()
    // {
    //     return $this->belongsTo(PlotLocation::class, 'plot_location_id');
    // }

    // public function category()
    // {
    //     return $this->belongsTo(PlotCategory::class, 'plot_category_id');
    // }
}
