<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchemeController extends Controller
{
    public function index()
    {
        return view('schemes.index');
    }
    public function createScheme()
    {
        return view('schemes.add-scheme');
    }
    public function schemePlots()
    {
        return view('schemes.plots');
    }
    public function createSchemePlot()
    {
        return view('schemes.add-plot');
    }
}
