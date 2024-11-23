<?php

namespace App\Http\Controllers;
use App\Services\AccountService;
use Illuminate\Http\Request;
use DB;

class AccountController extends Controller
{
    protected $accountservice;
    
    public function __construct(AccountService $accountservice)
    {
        $this->accountservice = $accountservice;
    }
    public function cashbook(){
        return view('accounts.index');
    }
    public function payment(){
        return view('accounts.add-payment');
    }
    public function payments(){
        return view('accounts.payments');
    }
    public function expenses(){
        return view('accounts.expenses');
    }
    public function accountHead(){
        $accounts = DB::table('account_heads')->get();
        return view('accounts.account-head',['accounts' => $accounts]);
    }
    public function addAccountHead(){
        $result = $this->accountservice->addAccountHead();
        return ($result);
    }
    public function fetchAccounts(){
        $result = $this->accountservice->fetchAccounts();
        return ($result);
    }
    public function storePayment(){
        $result = $this->accountservice->storePayment();
        return ($result);
    }
    public function getPaymentsVoucher(){
        $result = $this->accountservice->getPaymentsVoucher();
        return ($result);
    }
    public function getExpenses(){
        $result = $this->accountservice->getExpenses();
        return ($result);
    }
    public function getAccountHeads(){
        $result = $this->accountservice->getAccountHeads();
        return ($result);
    }
    public function getPayments(){
        $result = $this->accountservice->getPayments();
        return ($result);
    }
    public function applyCharge(){
        $result = $this->accountservice->applyCharge();
        return ($result);
    }
}
