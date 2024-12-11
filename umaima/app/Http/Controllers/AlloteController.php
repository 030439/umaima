<?php

namespace App\Http\Controllers;
use App\Services\AlloteService;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
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
    public function getAllotiesNames(){
        $result = $this->alloteservice->getAllotiesNames();
        return ($result);
    }
    public function store(){
        $result = $this->alloteservice->addAllote();
        return ($result);
    }
    public function alloteePlotes($id){
        return view('allote.plotes',['pid'=>$id]);
    }
    public function plotePayments($id)
    {
        return view('allote.plot-payments',['pid'=>$id]);
    }
    public function edit($id){
        return view('allote.plotes',['pid'=>$id]);
    }
    //     return view('allote.plot-payments',['pid'=>$id]);
    // }
    public function plotPaymet($id){
        $result = $this->alloteservice->plotPaymet($id);
        return ($result);
    }
}
