<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlotService;
use App\Services\SchemeService;
use Illuminate\Support\Facades\DB;
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
      public function canceList(){
        $all = $this->plotservice->canceList();
        return response()->json($all);
    }
      public function adjustList(){
        $all = $this->plotservice->adjustList();
        return response()->json($all);
    }



     public function adjustStore(){
        return $this->plotservice->adjustStore();
    }
    
    public function createTransfer(){
       
        return view('transfer.create');
    }
    public function getAlloteByPlot(){
        return $this->plotservice->getAlloteByPlot();
    }

    public function getAmountByPlot(){
        return $this->plotservice->getAmountByPlot();
    }


    public function getplotByScheme(){
        $result = $this->plotservice->getplotBySchemes();
        return ($result);
    }

     public function getplotBySchemeAlloted(){
        $result = $this->plotservice->getplotBySchemeAlloted();
        return ($result);
    }


    public function transferPlot(){
        return $this->plotservice->transferPlot();
    }
    
    public function cancelStore(){
        return $this->plotservice->cancelStore();
    }

}
