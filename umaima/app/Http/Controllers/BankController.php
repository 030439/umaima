<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Services\BankService;
use Illuminate\Http\Request;

class BankController extends Controller
{
    protected $bankservice;
    public function __construct(BankService $bankservice)
    {
        $this->bankservice = $bankservice;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('banks.index');
    }

    public function listing(){
        $result = $this->bankservice->getAll();
        return ($result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('banks.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = $this->bankservice->storeBank();
        return ($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        //
    }
}
