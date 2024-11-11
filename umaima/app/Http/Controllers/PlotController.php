<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlotService;

class PlotController extends Controller
{
    protected $plotservice;
    public function __construct(PlotService $plotservice)
    {
        $this->plotservice = $plotservice;
       
    }

    public function plotSize(){
        return view('plots.sizes');
    }
    public function plotLocation(){
        return view('plots.sizes');
    }
    public function installments(){
        return view('plots.installments');
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
}
