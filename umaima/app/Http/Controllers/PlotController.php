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

    public function alloteePlotes($id){
        $result = $this->plotservice->alloteePlotes($id);
        return ($result);
    }

    public function listing()
    {
        $result = $this->plotservice->geAll();
        return ($result);
    }
    public function schemePlots($id)
    {
        $result = $this->plotservice->schemePlots($id);
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
    //fetch total schemes
    public function getplotByScheme(){
        $result = $this->plotservice->getplotByScheme();
        return ($result);
    }
    //plot detail by plot id
    public function getplotDetails(){
        $result = $this->plotservice->getplotDetails();
        return ($result);
    }
    //payment isnallments and duration of payments
    public function getInstallments(){
        $result = $this->plotservice->getInstallments();
        return ($result);
    }
    public function paymentSchedule() {
        $result = $this->plotservice->paymentSchedule();
        return response()->json($result);
    }

    public function confirmSchedule(){
        $result = $this->plotservice->confirmSchedule();
        return ($result);
    }

    public function getPlotsByAllote(){
        $result = $this->plotservice->getPlotsByAllote();
        return ($result);
    }
    


}
