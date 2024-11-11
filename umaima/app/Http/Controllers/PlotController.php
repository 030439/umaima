<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlotService;
use Illuminate\Support\Facades\DB;

class PlotController extends Controller
{
    protected $plotservice;
    
    public function __construct(PlotService $plotservice)
    {
        $this->plotservice = $plotservice;
    }

    public function plotAllotment(){
        return view('plots.allotment');
    }

    public function listing()
    {
        $result = $this->plotservice->geAll();
        return ($result);
    }

    public function store()
    {
        $result = $this->plotservice->createPlot();
        return ($result);
    }

    public function plotSize(){
        $sizes = DB::table('plot_sizes')->get();
        $locations = DB::table('plot_locations')->get();
        return view('plots.sizes',compact('sizes','locations'));
    }

    public function installments(){
        $durations = DB::table('mid_pays_durations')->get();
        $installments = DB::table('installments')->get();
        return view('plots.installments',compact('durations','installments'));
    }
    public function createPlotSize()
    {
        $result = $this->plotservice->createPlotSize();
        return ($result);
    }
    public function createPlotLocation()
    {
        $result = $this->plotservice->createPlotLocation();
        return ($result);
    }

    public function duration()
    {
        $result = $this->plotservice->duration();
        return ($result);
    }

    public function installment()
    {
        $result = $this->plotservice->installment();
        return ($result);
    }
    public function getplotByScheme(){
        $result = $this->plotservice->getplotByScheme();
        return ($result);
    }

}
