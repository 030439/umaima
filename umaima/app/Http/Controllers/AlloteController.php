<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlloteController extends Controller
{
    function index(){
        return view('allote.index');
    }
}
