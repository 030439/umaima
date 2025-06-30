<?php

namespace App\Http\Controllers;
use App\Services\AccountService;
use Illuminate\Http\Request;
use App\Models\Scheme;
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
     public function deletePayment($id){
        $result = $this->accountservice->deletePayment($id);
        return ($result);
    }
    public function updatePayment(){
        $result = $this->accountservice->updatePayment();
        return ($result);
    }
    public function getPaymentsVoucher(){
        $result = $this->accountservice->getPaymentsVoucher();
        return ($result);
    }
    public function receivingReportListing(){
        $result = $this->accountservice->receivingReportListing();
        return ($result);
    }
    public function getLedger(){
        $result = $this->accountservice->getLedger();
        return ($result);
    }
    public function alloteData(){
        $result = $this->accountservice->alloteData();
        return ($result);
    }

    public function ledgerPrint(){
        $ledgers=$this->accountservice->getLedgerforPrint();
        $alloteDetail=$this->accountservice->alloteDataForPrint();
        $allote=$alloteDetail['allote'];
        $allocation=$alloteDetail['allocation'];

        return view('reports.print-ledger',compact('ledgers','allote','allocation'));

    }

    public function ledgerPrintReceivingReport(Request $request){
        $startDate =$request->input('startDate');
        $endDate =$request->input('endDate');
        $scheme =Scheme::where('id',$request->input('scheme'))->first()->name;
        $reports=$this->accountservice->receivingReport();

        return view('reports.print-receiving',compact('reports','startDate','endDate','scheme'));

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
    public function paymentDetail($id)
    {
        $payment = $this->accountservice->getPaymentById($id);
        $page=$payment->payment_type==1?"pay":"expense";
        return view('accounts.'.$page,['payment' => $payment]);
    }

     public function paymentEdit($id)
    {
        $payment = $this->accountservice->getPaymentById($id);
        // dd($payment);
        if($payment->payment_type==1){
            $plots= DB::table('allocation_details')
                    ->select('allocation_details.plot','plots.plot_number')
                    ->join('plot_paymnets','allocation_details.id','=','plot_paymnets.allocation_details_id')
                       ->join('plots','plots.id','=','allocation_details.plot')
                    //  ->where('payment_schedule.paid_on',"$payment->pdate")
                     ->where('plot_paymnets.created_at',$payment->updated_at)
                      ->where('allocation_details.allote',$payment->allote_id)
                    ->first();
                    $plot=['plot_number' => $plots->plot_number, 'plot' => $plots->plot];
        }else{
            $plot = [];
        }
        // dd($plot);
         $accounts =  DB::table('banks')->where('status','1')->get();
        return view('accounts.editpay',['payment' => $payment,'accounts' => $accounts,'plot' => $plot]);
    }

    public function applyCharge(){
        $result = $this->accountservice->applyCharge();
        return ($result);
    }

     public function receivingReport(){
         $schemes = DB::table('schemes')
        ->select(
            'schemes.name as scheme',
            'schemes.id as id'
        )
        ->orderBy('schemes.id') // Sort descending by plot ID
        ->get();
        return view('accounts.receivingReport',['schemes' => $schemes]);
    }
}
