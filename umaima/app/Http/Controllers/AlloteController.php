<?php

namespace App\Http\Controllers;
use App\Services\AlloteService;
use Illuminate\Http\Request;
use App\Models\Allote;
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
    function inactive(){
        return view('allote.inactive');
    }
    public function alloteCreate(){
        return view('allote.add');
    }
    public function getInActiveAllotees(){
        $result = $this->alloteservice->getInActiveAllotees();
        return ($result);
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
        $allote=Allote::find($id);
        return view('allote.edit',['allote'=>$allote]);
    }
    public function editStore(){
        $result = $this->alloteservice->updateAllote();
        return ($result);
    }
    public function plotPaymet($id){
        $result = $this->alloteservice->plotPaymet($id);
        return ($result);
    }
}
