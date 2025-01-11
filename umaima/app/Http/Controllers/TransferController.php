<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlotService;

class TransferController extends Controller
{

    protected $plotservice;
    
    public function __construct(PlotService $plotservice)
    {
        $this->plotservice = $plotservice;
    }

    public function plotTransfer(){
        return view('transfer.plots');
    }
}
