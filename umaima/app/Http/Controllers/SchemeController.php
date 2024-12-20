<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SchemeService;
use DB;
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
    public function updateScheme()
    {
        $result = $this->schemeservice->updateScheme();
        return ($result);
    }
    public function editScheme($id){
        $scheme = $this->schemeservice->editScheme($id);
        return view('schemes.edit',compact('scheme'));
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
    public function editPlot($id)
    {
        $plots = $this->schemeservice->editPlot($id);
        $schemes = $this->schemeservice->getSchemes();
        $sizes = DB::table('plot_sizes')->get();
        $locations = DB::table('plot_locations')->get();
        $plot_categories = DB::table('plot_categories')->get();
        $categories = DB::table('categories')->get();
        return view('schemes.edit-plots',compact('plots','schemes','sizes','locations','plot_categories','categories'));
    }
    public function allotePlotByScheme($id)
    {
        $plots = $this->schemeservice->schemePlotsDetail($id);
        return view('schemes.alloted-plot',['sid'=>$id,'scheme'=>$plots]);
    }
    public function allotedPlotListing(){
        $groupedPlots = $this->schemeservice->allotedPlotListing();
        $totalPlotsSchemeWise = $this->schemeservice->totalPlotsSchemeWise();
        $expensesByHeads = $this->schemeservice->totalExpenseHeadWise();
        $totalPaymentsByAllote = $this->schemeservice->totalPaymentsByAllote();
        return view('plots.alloted-plot', compact('groupedPlots','totalPlotsSchemeWise','expensesByHeads','totalPaymentsByAllote'));
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
