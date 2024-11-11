<?php

namespace App\Http\Controllers;
use App\Services\AlloteService;
use Illuminate\Http\Request;

class AlloteController extends Controller
{
    protected $alloteservice;
    
    public function __construct(AlloteService $alloteservice)
    {
        $this->alloteservice = $alloteservice;
    }


    function index(){
        return view('allote.index');
    }
    public function alloteCreate(){
        return view('allote.add');
    }
    public function store(){

        $result = $this->alloteservice->addAllote();
        return ($result);
    }
}
