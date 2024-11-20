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
    public function geAll(){
        $result = $this->alloteservice->geAll();
        return ($result);
    }
    public function getAlloties(){
        $result = $this->alloteservice->getAlloties();
        return ($result);
    }
    public function store(){

        $result = $this->alloteservice->addAllote();
        return ($result);
    }
    public function alloteePlotes(){
        return view('allote.plotes');
    }
    public function plotePayments(){
        return view('allote.plot-payments');
    }
    public function plotPaymet(){
        $result = $this->alloteservice->plotPaymet();
        return ($result);
    }
}
