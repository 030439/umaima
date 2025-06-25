<?php

namespace App\Http\Controllers;
use App\Services\LoanService;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\LoanParties;

class LoanController extends Controller
{

    protected $LoanService;
    
    public function __construct(LoanService $LoanService)
    {
        $this->LoanService = $LoanService;
    }

    public function index()
    {
        $party=LoanParties::all();
        return view('loans.index',compact('party'));
    }

    public function addLoan()
    {
         $party=LoanParties::all();
         $banks=Bank::all();
        return view('loans.add-loan',compact('party','banks'));
    }

    public function parties()
    {

        return view('loans.parties');
    }
    public function addParty()
    {
        return view('loans.add-party');
    }
    public function editParty($id)
    {
         $party=LoanParties::where('id',$id)->first();
        return view('loans.edit-party',compact('party'));
    }
    public function parties_listing()
    {
        return $this->LoanService->getAllParties();
    }

    public function saveParty()
    {
        return $this->LoanService->saveParty();
    }

    public function loanStore()
    {
        return $this->LoanService->loanStore();
    }

    public function getLoansList()
    {
        return $this->LoanService->getLoansList();
    }

    public function updateParty()
    {
        return $this->LoanService->updateParty();
    }
}
