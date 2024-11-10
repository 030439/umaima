<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlotController extends Controller
{
    public function plotSize(){
        return view('plots.sizes');
    }
    public function plotLocation(){
        return view('plots.sizes');
    }
    public function installments(){
        return view('plots.installments');
    }
}
