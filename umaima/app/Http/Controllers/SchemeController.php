<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SchemeService;
class SchemeController extends Controller
{
    protected $schemeservice;
    public function __construct(SchemeService $schemeservice)
    {
        $this->schemeservice = $schemeservice; 
    }

    public function index()
    {
        return view('schemes.index');
    }
    public function createScheme()
    {
        return view('schemes.add-scheme');
    }
    public function store()
    {
        $result = $this->schemeservice->createScheme();
        return ($result);
    }
    public function schemePlots()
    {
        return view('schemes.plots');
    }
    public function createSchemePlot()
    {
        return view('schemes.add-plot');
    }
    public function schemeWisePlot($id)
    {
        $plots = $this->schemeservice->schemePlotsDetail($id);
        return view('schemes.scheme-plots',['sid'=>$id,'scheme'=>$plots]);
    }
    public function allotedPlotListing(){
        $groupedPlots = $this->schemeservice->allotedPlotListing();
        return view('plots.alloted-plot', compact('groupedPlots'));
    }
    public function listing(){
        $all = $this->schemeservice->getAll();
        return response()->json($all);
    }
    public function getSchemeDetails(){
        $all = $this->schemeservice->getSchemeDetails();
        return $all;
    }
}
