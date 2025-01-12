<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlotService;
use App\Services\SchemeService;

class TransferController extends Controller
{

    protected $schemeservice;

    protected $plotservice;
    public function __construct(PlotService $plotservice,SchemeService $schemeservice)
    {
        $this->plotservice = $plotservice;
        $this->schemeservice = $schemeservice; 
    }

    public function plotTransfer(){
        return view('transfer.plots');
    }

    public function transerList(){
        $all = $this->plotservice->transerList();
        return response()->json($all);
    }

    
    public function createTransfer(){
        $schemes = $this->schemeservice->getSchemes();
        return view('transfer.create');
    }
    public function getAlloteByPlot(){
        return $this->plotservice->getAlloteByPlot();
    }

    public function getplotByScheme(){
        $result = $this->plotservice->getplotBySchemes();
        return ($result);
    }

    public function transferPlot(){
        return $this->plotservice->transferPlot();
    }

}
