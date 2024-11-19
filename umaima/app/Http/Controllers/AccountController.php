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
        $result = $this->accountservice->addAccountHead();
        return ($result);
    }
}
