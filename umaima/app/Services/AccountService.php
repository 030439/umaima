<?php

namespace App\Services;

use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;
use App\Models\PlotPayment;
use App\Models\Payment;
use Carbon\Carbon;
use App\Models\Allote;
use App\Models\AllocationDetail;
use App\Models\PaymentSchedule;
use Illuminate\Http\JsonResponse;
use Exception;

class AccountService
{
    //
    use QueryTrait;

    protected $table;
    protected $request;

    public function __construct(Request $request)
    {
        $this->table = 'banks'; // Define the table name for users
        $this->request = $request; // Inject Request
    }

    public function getAll()
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('length', 10);
        $page = $this->request->input('page', 1);
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $joins = $this->request->input('joins', []);
        $orderColumn = $this->request->input('orderColumn', 'id');
        $orderDirection = $this->request->input('orderDirection', 'asc');
        $groupBy = $this->request->input('groupBy', []);
        $having = $this->request->input('having', []);
        $paginate = $this->request->input('paginate', true);
        $draw=$this->request->get('draw');
        $searchValue = $this->request->get('search')['value']; // This is the value you want to search for
        
        // Initialize an array for the conditions
        $filters = [];

        if (!empty($searchValue)) {
            // Using an associative array instead of a nested array
            $filters['bank_name'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
            $filters['branch'] = '%' . $searchValue . '%';
            $filters['account_holder'] = '%' . $searchValue . '%';
            $filters['account_no'] = '%' . $searchValue . '%';
        }

        // Fetch the records using QueryTrait's fetchRecords method
        $result = $this->fetchRecords(
            $this->table,
            $columns = ['*'],
            $conditions = [],
            $filters,
            $joins,
            $orderColumn,
            $orderDirection,
            $groupBy ,
            $having ,
            $perPage ,
            $page = ($start / $length) + 1 ,
            $paginate = true
        );

        // Return only the data if pagination is enabled, or full response if not paginated
        return[
            'data' => $result['data'],
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'draw' => $draw,
        ];
    }

   
    public function addAccountHead()
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'name' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->size,
                    'errors' => $validator->errors(),
                ], 422); // Unprocessable Entity
            }
            $size = $this->request->input('name');
            DB::table('account_heads')->insert([
                'name' => $size,
                'created_at' => now(), // Set created_at to current timestamp
                'updated_at' => now(),
            ]);
           logAction('Created Account Head', $size);
            $response = [
                'message' => 'Account  successfully !',
                 'success' => true
            ];
            // Return success response in DataTable format
            return response()->json($response);
        } catch (Exception $e) {
            $response = [
                'message' => 'An unexpected error occurred while creating the Plot size.',
                 'success' => false
            ];
            return response()->json($response);
        }
    }

    public function fetchAccounts(){
        $banks = DB::table('banks')->where('status','1')->get();

        $bank=$banks->map(function ($bank) {
            return [
                'value' => $bank->id, // assuming 'id' is a unique identifier
                'label' => $bank->bank_name // assuming 'name' holds the display name
            ];
        });
        return response()->json([
            'success' => true,
            'acccounts' => $bank
        ]);
    }
    
    public function isAmounntPaidOnDate($date,$allocation_details_id){

    }
    public function lateapplyStanding($allocation_id)
    {
        $pdate=date('Y-m-15');
        $paymentSchedules = DB::table('payment_schedule')
            ->where('allocation_details_id', '=', $allocation_id)
            ->orderBy('id', 'desc') // Get the last two entries
            ->limit(2)
            ->get();
        $updateCount = 0;
        foreach ($paymentSchedules as $i=> $schedule) {
            if($i==1){
                $lastOut=$schedule->outstanding;
            }
            if($i==0){
                $outstanding = $schedule->amount_paid;
                $last_id=$schedule->id;
            }
        }

        $final=$lastOut-$outstanding;

        $updated = DB::table('payment_schedule')
        ->where('id', $last_id)
        ->update([
            'outstanding' => (int)$final,
            'updated_at' => now(),
        ]);
        // Return success or failure message
        if ($updateCount > 0) {
            return "records updated successfully";
        } else {
            return 'No records were updated.';
        }
    }

    public function applyStanding()
    {
        $pdate = date('Y-m-15');

        try {
            // Fetch records grouped by allocation_details_id
            $paymentSchedules = DB::table('payment_schedule')
                ->where('pay_date', '<=', $pdate)
                ->orderBy('allocation_details_id')
                ->orderBy('pay_date')
                ->get()
                ->groupBy('allocation_details_id');

            $updateCount = 0;

            foreach ($paymentSchedules as $allocation_id => $schedules) {
                $cumulativeOutstanding = 0; // Reset for each allocation group

                foreach ($schedules as $schedule) {
                    // Calculate new outstanding for this record
                    $newOutstanding = $cumulativeOutstanding + $schedule->amount + $schedule->surcharge - $schedule->amount_paid;

                    // Update cumulative outstanding
                    $cumulativeOutstanding = $newOutstanding;

                    // Update the database record
                    $updated = DB::table('payment_schedule')
                        ->where('id', $schedule->id)
                        ->update([
                            'outstanding' => $cumulativeOutstanding,
                            'updated_at' => now(),
                        ]);

                    if ($updated) {
                        $updateCount++;
                    }
                }
            }

            return $updateCount > 0
                ? "{$updateCount} records updated successfully"
                : "No records were updated.";
        } catch (\Exception $e) {
            // Log the error and return a failure message
            Log::error("Error updating payment schedule: " . $e->getMessage());
            return "An error occurred: " . $e->getMessage();
        }
    }

    public function checkIFReceiptIdExists($receiptId)
    {
        // Check if the receipt ID exists in the payments table
        $exists = DB::table('payments')->where('receipt_id', $receiptId)->exists();
        
        return response()->json([
            'exists' => $exists,
        ]);
    }

    public function storePayment()
    {
        try {
            $payment_type = $this->request->input('payment_type');

            // Validation rules
            $rules = [
                'paydate' => 'required|date',
                'payment_type' => 'required|integer',
                'from_account' => 'required|integer',
                'amount' => 'required|numeric',
                'narration' => 'required|string',
            ];

            // Conditional validation rules
            if ($payment_type == 1) {
                $rules['allotees'] = 'required|integer';
                $rules['plot'] = 'required|integer';
            } else {
                $rules['expense_heads'] = 'required|integer';
            }

            // Validate request data
            $validator = Validator::make($this->request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => implode("\n", $validator->errors()->all())
                ]);
            }

            if($this->checkIFReceiptIdExists($this->request->input('receipt_id'))->getData()->exists){
                return response()->json([
                    'success' => false,
                    'message' => "Receipt ID already exists."
                ]);
            }
            DB::beginTransaction();

            // Prepare data for insertion
            $data = [
                'paydate' => $this->request->input('paydate'),
                'receipt_id' => $this->request->input('receipt_id'),
                'payment_type' => $this->request->input('payment_type'),
                'from_account' => $this->request->input('from_account'),
                'amount' => $this->request->input('amount'),
                'narration' => $this->request->input('narration'),
                'allotees' => (int)$this->request->input('allotees', 0),
                'expense_heads' => (int)$this->request->input('expense_heads', 0),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert data and get the last inserted ID
           
            $success=true;
            $allocationId = $this->request->input('plot');

            if ($payment_type == 1) {
                $pay = $this->payAmount();
                // dd($pay);
            
                switch ($pay) {
                    case 1:
                        $std=$this->applyStanding();
                        $msg = "Payment schedule updated successfully!";
                        $lastInsertedId = DB::table('payments')->insertGetId($data);
                        logAction('Created Payment', $lastInsertedId);
                        break;
                    case 2:
                        $success=false;
                        $msg = "Failed to update payment schedule!";
                        break;
                    case 3:
                        $dd=$this->lateapplyStanding($allocationId);
                       
                        $msg = "Payment schedule updated successfully!";
                        $lastInsertedId = DB::table('payments')->insertGetId($data);
                        logAction('Created Payment', $lastInsertedId);
                        break;

                        $success=false;
                        $msg = "No matching payment schedule found.";
                        
                    case 5:
                        $success=false;
                        $msg = "Payment already Paidn on this scheduled date.";
                        
                        break;
                    default:
                    $success=false;
                        $msg = $pay; // Return the exception message
                }
            } else {
                $lastInsertedId = DB::table('payments')->insertGetId($data);
                        logAction('Created Payment', $lastInsertedId);
                $msg = "Payment created successfully!";
                logAction('Created Payment', $lastInsertedId);
            }

            // Log the action
            

            DB::commit();

            return response()->json([
                'success' => $success,
                'message' => $msg,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function deletePayment($id){
        
            $payment=$this->getPaymentById($id);
            try {
            if($payment->payment_type==1){
                $plotdata= DB::table('allocation_details')
                    ->select('allocation_details.id','plot_paymnets.id as pid')
                    ->join('plot_paymnets','allocation_details.id','=','plot_paymnets.allocation_details_id')
                    //  ->where('payment_schedule.paid_on',"$payment->pdate")
                    ->where('plot_paymnets.created_at',$payment->created_at)
                    ->where('allocation_details.allote',$payment->allote_id)
                    ->first();
                    
                    $allocationId=$plotdata->id;

             
                    $deletePlotPay=PlotPayment::where('id', $plotdata->pid)->delete(); 
                    if(!$deletePlotPay){
                        return response()->json([
                            'success' => false,
                            'message' => "Something went wrong"
                        ]);
                    }

                    $schedule=['amount_paid'=>0,'paid_on'=>0];
                    $record =  PaymentSchedule::where('allocation_details_id', $allocationId)
                    ->where('paid_on', $payment->pdate)
                    ->update($schedule);
                    
            }
            // Delete the payment record
            DB::table('payments')->where('id', $id)->delete();
            logAction('Deleted Payment', $id);

            return response()->json([
                'success' => true,
                'message' => 'Payment deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting payment: ' . $e->getMessage()
            ]);
        }
    }


     public function updatePayment()
    {
         
        $id = $this->request->input('id');
        $payment=$this->getPaymentById($id); 

        $exists = DB::table('payments')->where('receipt_id', $this->request->input('receipt_id'))->where('id', $id)->exists();
       
        if($this->checkIFReceiptIdExists($this->request->input('receipt_id'))->getData()->exists){
            if(!$exists){
                return response()->json([
                'success' => false,
                'message' => "Receipt ID already exists."
            ]);
            }
        }
        try {
            $payment_type = $this->request->input('payment_type');
            // Validation rules
            $rules = [
                'paydate' => 'required|date',
                'payment_type' => 'required|integer',
                'from_account' => 'required|integer',
                'amount' => 'required|numeric',
                'narration' => 'required|string',
            ];

            // Conditional validation rules
            if ($payment_type == 1) {
                $rules['allotees'] = 'required|integer';
                $rules['plot'] = 'required|integer';
            } else {
                $rules['expense_heads'] = 'required|integer';
            }

            // Validate request data
            $validator = Validator::make($this->request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => implode("\n", $validator->errors()->all())
                ]);
            }

            DB::beginTransaction();

            // Prepare data for insertion
            $data = [
                'paydate' => $this->request->input('paydate'),
                'receipt_id' => $this->request->input('receipt_id'),
                'payment_type' => $this->request->input('payment_type'),
                'from_account' => $this->request->input('from_account'),
                'amount' => $this->request->input('amount'),
                'narration' => $this->request->input('narration'),
                'allotees' => (int)$this->request->input('allotees', 0),
                'expense_heads' => (int)$this->request->input('expense_heads', 0),
            ];


            if($payment->payment_type==1){

                $plotdata= DB::table('allocation_details')
                    ->select('allocation_details.id','plot_paymnets.id as pid')
                    ->join('plot_paymnets','allocation_details.id','=','plot_paymnets.allocation_details_id')
                    //  ->where('payment_schedule.paid_on',"$payment->pdate")
                    ->where('plot_paymnets.receipt_id',$payment->receipt_id)
                    ->where('allocation_details.allote',$payment->allote_id)
                    ->first();
                    
                    $allocationId=$plotdata->id;

                    PlotPayment::where('id', $plotdata->pid)->delete();                    
                    $schedule=['amount_paid'=>0,'paid_on'=>0];
                    $record =  PaymentSchedule::where('allocation_details_id', $allocationId)
                    ->where('paid_on', $payment->pdate)
                    ->update($schedule);
            }

            // Insert data and get the last inserted ID
           
            $success=true;
            $allocationId = $this->request->input('plot');

            if ($payment_type == 1) {
                $pay = $this->payAmount();
                switch ($pay) {
                    case 1:
                        $std=$this->applyStanding();
                        $msg = "Payment schedule updated successfully!";
                        DB::table('payments')
                            ->where('id', $id)
                            ->update($data);
                        $lastInsertedId = $id;//DB::table('payments')->insertGetId($data);
                        logAction('Created Payment', $lastInsertedId);
                        break;
                    case 2:
                        $success=false;
                        $msg = "Failed to update payment schedule!";
                        break;
                    case 3:
                        $dd=$this->lateapplyStanding($allocationId);
                       
                        $msg = "Payment schedule updated successfully!";
                          DB::table('payments')
                            ->where('id', $id)
                            ->update($data);
                        logAction('Created Payment', $id);
                        break;

                        $success=false;
                        $msg = "No matching payment schedule found.";
                        
                    case 5:
                        $success=false;
                        $msg = "Payment already Paid on this scheduled date.";
                        
                        break;
                    default:
                    $success=false;
                        $msg = $pay; // Return the exception message
                }
            } else {
                DB::table('payments')
                ->where('id', $id)
                ->update($data);
                logAction('update Payment', $id);
                $msg = "Payment updated successfully!";
                logAction('update Payment', $id);
            }

            // Log the action
            

            DB::commit();

            return response()->json([
                'success' => $success,
                'message' => $msg,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function payAmount_()
    {
        try {
            $allocationId = $this->request->input('plot');
            $amountPaid = $this->request->input('amount');
            $paidOn = $this->request->input('paydate');

            // Validate inputs
            if (!$allocationId || !$amountPaid || !$paidOn) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid input provided.',
                ], 400);
            }

            $payDate = Carbon::parse($paidOn)->format('Y-m-15');
            $currentMonth = Carbon::now()->startOfMonth();

            // Apply surcharge to overdue payment schedules with zero surcharge
            $overdueSchedules = PaymentSchedule::where('allocation_details_id', $allocationId)
                ->where('pay_date', '<', $currentMonth)
                ->where('surcharge', 0)
                ->get();

            $surchargeRate = 15; // Define surcharge rate
            foreach ($overdueSchedules as $schedule) {
                $outstanding = $schedule->amount - $schedule->amount_paid;

                // Calculate surcharge
                $surcharge = $this->calculateSurcharge($outstanding, $surchargeRate);

                // Update surcharge and outstanding for overdue schedules
                $schedule->update([
                    'surcharge' => $surcharge,
                    // 'outstanding' => $schedule->outstanding + $surcharge,
                    'updated_at' => now(),
                ]);
            }

            // Fetch payment schedule for the specified date
            $record = PaymentSchedule::where('allocation_details_id', $allocationId)
                ->where('pay_date', $payDate)
                ->first();

            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment schedule not found for the given date.',
                ], 404);
            }

            // Check if the amount is already paid
            if ($record->amount_paid > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment has already been recorded for this date.',
                ], 409);
            }

            // Update payment schedule with the new payment details
            $updated = $record->update([
                'amount_paid' => $amountPaid,
                'paid_on' => $paidOn,
                'updated_at' => now(),
            ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment successfully recorded, and surcharge applied for overdue schedules.',
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to update the payment schedule.',
            ], 500);
        } catch (Exception $e) {
            // Log the error
            Log::error('Payment processing failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function addSurcharge($allocationId,$payDate){
        $paymentSchedules = PaymentSchedule::where('allocation_details_id', $allocationId)
                    ->where('pay_date', '=', $payDate)
                    ->where('surcharge', 0)
                    ->where('amount_paid', 0)
                    ->get();
                $surchargeRate = 15;
                $previousOutstanding = 0;

                foreach ($paymentSchedules as $schedule) {
                    $outstanding = $schedule->amount - $schedule->amount_paid;

                    // Calculate surcharge if payment is not made
                    $surcharge = 0;
                    if ($schedule->amount_paid == 0) {
                        $surcharge = $this->calculateSurcharge($outstanding, $surchargeRate);
                        $outstanding += $surcharge; // Add surcharge to outstanding balance
                    }
                    $outstanding += $previousOutstanding;
                    // Update the database with surcharge and outstanding
                    $updated = PaymentSchedule::where('id', $schedule->id)->update([
                        'surcharge' => $surcharge, 
                        // 'outstanding' => $outstanding,
                        'updated_at' => now(),
                    ]);
                }
                $this->applyStanding();

    }

    public function lateSurcharge($allocationId,$payDate){
        $paymentSchedules = PaymentSchedule::where('allocation_details_id', $allocationId)
                    ->get();
                $surchargeRate = 15;
                $previousOutstanding = 0;

                foreach ($paymentSchedules as $schedule) {
                    $outstanding = $schedule->amount - $schedule->amount_paid;

                    // Calculate surcharge if payment is not made
                    $surcharge = 0;
                    if ($schedule->amount_paid == 0) {
                        $surcharge = $this->calculateSurcharge($outstanding, $surchargeRate);
                        $outstanding += $surcharge; // Add surcharge to outstanding balance
                    }
                    $outstanding += $previousOutstanding;
                    // Update the database with surcharge and outstanding
                    $updated = PaymentSchedule::where('id', $schedule->id)->update([
                        'surcharge' => $surcharge, 
                        'outstanding' => $outstanding,
                        'updated_at' => now(),
                    ]);
                }
                $this->applyStanding();

    }

    public function payAmount()
    {
        try {
            $allocationId = $this->request->input('plot');
            $amountPaid = $this->request->input('amount');
            $receipt_id = $this->request->input('receipt_id');
            $paidOn = $this->request->input('paydate');
            $narration=$this->request->input('narration');
            $payD=Carbon::parse($paidOn)->format('Y-m-d');
            $payDate = Carbon::parse($paidOn)->format('Y-m-15');
            $dm=Carbon::parse($paidOn)->format('Y-m');
            $pD = Carbon::parse($paidOn)->format('Y-m');
            $amount=$amountPaid;

            $paymentSchedule = DB::table('payment_schedule')
            ->where('allocation_details_id', $allocationId)
            ->whereRaw("pay_date = ?", [$payDate])
            ->first();
            $late=false;
            if (!$paymentSchedule) {
                $late=true; 
            }

            if($payD>$payDate && $dm!=$pD){
                $this->addSurcharge($allocationId,$payDate);
            }
            
            $record =  PaymentSchedule::where('allocation_details_id', $allocationId)
                ->where('pay_date', $payDate)
                ->first();
               

            if ($record || $late) {
                //check if amount is already paid on this date 
                if($record){
                    if($record->amount_paid){
                        $amountPaid+=$record->amount_paid;
                      }
                }
                
                $overdueSchedules = PaymentSchedule::where('allocation_details_id', $allocationId)
                ->where('pay_date', '<', $payDate)
                ->where('surcharge', 0)
                ->where('amount_paid', 0)
                ->get();
                $surchargeRate = 15; // Define surcharge rate
                $out_standing=0;
                foreach ($overdueSchedules as $schedule) {
                    $outstanding = $schedule->amount - $schedule->amount_paid;
                    
                    // print_r($outstanding);
                    // Calculate surcharge
                    $surcharge = $this->calculateSurcharge($outstanding, $surchargeRate);
        
                    // Update surcharge and outstanding for overdue schedules
                    $outStd= (int)($outstanding + $surcharge);//change outstanding value to decimal two points
                    
                    $outStd = (int)round($outstanding + $surcharge);
                    $out_standing=$out_standing+$outStd;
                    $updation=[
                        'surcharge' => $surcharge,
                        // 'outstanding' =>$out_standing,
                        'updated_at' => now(),
                    ];
                    $schedule->update($updation);
                }
                if($late) {
                    $latePayment=[
                        "allocation_details_id"=>$allocationId,
                        "payment"=>"Late Payment",
                        "amount"=>0,
                        "amount_paid"=>$amountPaid,
                        "paid_on"=>$paidOn,
                        "surcharge"=>0,
                        "outstanding"=>0,
                        "pay_date"=>0,
                    ];
                    $plotPayments= [
                        'allocation_details_id'=>$allocationId,
                        'receipt_id'=>$receipt_id,
                        'paydate'=>$paidOn,
                        'amount'=>$amount,
                        'narration'=>$narration
                    ];
    
                    PlotPayment::create($plotPayments);
                    PaymentSchedule::create($latePayment);  
                    return 3;
                }
                $updated =$record->update([
                    'amount_paid' => $amountPaid,
                    'paid_on' => $paidOn,
                    // 'outstanding' =>$out_standing-$amountPaid,
                    'updated_at' => now(),
                ]);

                $plotPayments= [
                    'allocation_details_id'=>$allocationId,
                    'paydate'=>$paidOn,
                    'amount'=>$amount,
                    'narration'=>$narration,
                    'receipt_id'=>$receipt_id,
                ];

                PlotPayment::create($plotPayments);
            }


            return $updated ? 1 : 2;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function alloteData(){
        $id = $this->request->get('subcat');
        $plot = $this->request->get('plot');
        $startDate = $this->request->input('startDate');
        $endDate = $this->request->input('endDate');

          if(!($endDate)){
            $endDate=$startDate;
        }

        // Initialize conditions array
        $conditions = [];

        if (!empty($startDate) && !empty($endDate)) {
            $conditions[] = ['paydate', '>=', $startDate]; // start date condition
            $conditions[] = ['paydate', '<=', $endDate]; // end date condition
        }

        // Get allote information
        $allote = Allote::select('fullname', 'father')
            ->where('id', '=', $id)
            ->first();

        // Build allocation query
        $allocationQuery = AllocationDetail::select(
                'allocation_details.bdate',
                'plots.plot_number',
                'schemes.name as scheme',
                'plot_categories.category_name',
                'plot_sizes.size'
            )
            ->join('plots', 'plots.id', 'allocation_details.plot')
            ->join('plot_categories', 'plot_categories.id', 'plots.plot_category_id')
            ->join('plot_sizes', 'plot_sizes.id', 'plots.plot_size_id')
            ->join('schemes', 'schemes.id', 'plots.scheme_id')
            ->where('allocation_details.allote', '=', $id);

        if ($plot && $plot > 0) {
            $allocationQuery->where('allocation_details.plot', '=', $plot);
        }

        // Apply date conditions if they exist
        if (!empty($conditions)) {
            $allocationQuery->where($conditions);
        }

        // Execute the query and get results
        $allocation = $allocationQuery->get();

        $html="";

        $html.='<div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                <div class="info-container">
                    <ul class="list-unstyled mb-6">
                        <li class="mb-2">
                        <span class="h6 me-1">Allote:</span>
                        <span id="allote-name">'.$allote->fullname.'</span>
                        </li>
                        <li class="mb-2">
                        <span class="h6 me-1">Father:</span>
                        <span id="father_">'.$allote->father.'</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-9">
            <table class="table">
                <thead>
                    <tr>
                        <th>Scheme</th>
                        <th>Plot</th>
                        <th>Category</th>
                        <th>Sq.Fts</th>
                        <th>Booking Date</th>
                    </tr>
                </thead>
                <tbody>';
                if($allocation){
                    foreach($allocation as $alloted){
                        $html.="<tr>";
                        $html.="<td>";
                        $html.=$alloted->scheme;
                        $html.="</td>";
                        $html.="<td>";
                        $html.=$alloted->plot_number;
                        $html.="</td>";
                        $html.="<td>";
                        $html.=$alloted->category_name;
                        $html.="</td>";
                        $html.="<td>";
                        $html.=$alloted->size;
                        $html.="</td>";
                        $html.="<td>";
                        $html.=$alloted->bdate;
                        $html.="</td>";
                        $html.="</tr>";
                    }
                }
                $html.='</tbody>
            </table>
        </div>';
        echo $html;
    }


    public function alloteDataForPrint(){

        $id = $this->request->get('allote');
        $plot = $this->request->get('plot');
        $startDate = $this->request->input('startDate');
        $endDate = $this->request->input('endDate');
          if(!($endDate)){
            $endDate=$startDate;
        }

        // Initialize conditions array
        $conditions = [];

        if (!empty($startDate) && !empty($endDate)) {
            $conditions[] = ['paydate', '>=', $startDate]; // start date condition
            $conditions[] = ['paydate', '<=', $endDate]; // end date condition
        }

        // Get allote information
        $allote = Allote::select('fullname', 'father')
            ->where('id', '=', $id)
            ->first();

        // Build allocation query
        $allocationQuery = AllocationDetail::select(
                'allocation_details.bdate',
                'plots.plot_number',
                'schemes.name as scheme',
                'plot_categories.category_name',
                'plot_sizes.size'
            )
            ->join('plots', 'plots.id', 'allocation_details.plot')
            ->join('plot_categories', 'plot_categories.id', 'plots.plot_category_id')
            ->join('plot_sizes', 'plot_sizes.id', 'plots.plot_size_id')
            ->join('schemes', 'schemes.id', 'plots.scheme_id')
            ->where('allocation_details.allote', '=', $id);

        if ($plot && $plot > 0) {
            $allocationQuery->where('allocation_details.plot', '=', $plot);
        }

        // Apply date conditions if they exist
        if (!empty($conditions)) {
            $allocationQuery->where($conditions);
        }

        // Execute the query and get results
        $allocation = $allocationQuery->get();

        return ['allote'=>$allote,'allocation'=>$allocation];
    }

    public function getLedger()
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('length', 10);
        $page = $this->request->input('page', 1);
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $joins = $this->request->input('joins', []);
        $orderColumn = $this->request->input('orderColumn', 'id');
        $orderDirection = $this->request->input('orderDirection', 'asc');
        $groupBy = $this->request->input('groupBy', []);
        $having = $this->request->input('having', []);
        $paginate = $this->request->input('paginate', true);
        $draw=$this->request->get('draw');
        $searchValue = $this->request->get('search')['value']; // This is the value you want to search for
        

        $columns = [
            'plot_paymnets.*',
        ];

        // Initialize an array for the conditions
        $filters = [];
        $conditions=[];
        $startDate = $this->request->input('startDate');
        $endDate = $this->request->input('endDate');
        if(!($endDate)){
            $endDate=$startDate;
        }
        $plot = $this->request->input('plot');
    
        // Add startDate and endDate to the filters if they are provided
        
        $joins = [
            [
                'table' => 'allocation_details',
                'first' => 'plot_paymnets.allocation_details_id',
                'operator' => '=',
                'second' => 'allocation_details.id',
                'type'=>'leftJoin'
            ],
            // [
            //     'table' => 'banks',
            //     'first' => 'payments.from_account',
            //     'operator' => '=',
            //     'second' => 'banks.id',
            //     'type'=>'leftJoin'
            // ],
        ];

        if (!empty($searchValue)) {
            // Using an associative array instead of a nested array
            $filters['paydate'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
            $filters['from_account'] = '%' . $searchValue . '%';
            $filters['amount'] = '%' . $searchValue . '%';
            $filters['narration'] = '%' . $searchValue . '%';
            $filters['account_heads.name'] = '%' . $searchValue . '%';
            $filters['allotes.fullname'] = '%' . $searchValue . '%';
        }
        if (!empty($startDate) && !empty($endDate)) {
            $conditions[] = ['paydate', '>=', $startDate]; // start date condition
            $conditions[] = ['paydate', '<=', $endDate]; // end date condition
        }
        $paymentType = $this->request->get('payment');
        $subcat = $this->request->get('subcat');
        //code for filter of payment by type and sub cat
        if(!empty($plot) && $plot>0){
            $conditions[] = ['allocation_details.plot', '=', $plot];
        }
        $conditions[] = ['allocation_details.allote', '=', $subcat];


        // Fetch the records using QueryTrait's fetchRecords method
        $result = $this->fetchRecords(
            'plot_paymnets',
            $columns,
            $conditions,
            $filters,
            $joins,
            $orderColumn,
            $orderDirection,
            $groupBy ,
            $having ,
            $perPage ,
            $page = ($start / $length) + 1 ,
            $paginate = true
        );

        // Return only the data if pagination is enabled, or full response if not paginated
        return[
            'data' => $result['data'],
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'draw' => $draw,
        ];
    }

    public function getLedgerforPrint()
    {
        $startDate = $this->request->input('startDate');
        $endDate = $this->request->input('endDate');
          if(!($endDate)){
            $endDate=$startDate;
        }
        $subcat = $this->request->get('allote');


        $data = PlotPayment::select(
                'plot_paymnets.*',
                 'allotes.fullname',
                'allotes.phone'
            )
            ->join('allocation_details', 'allocation_details.id', '=', 'plot_paymnets.allocation_details_id')
            ->join('allotes', 'allotes.id', '=', 'allocation_details.allote')
            ->where('allocation_details.allote', $subcat);  
        // Apply date filters if provided
        if (!empty($startDate) && !empty($endDate)) {
            $data->whereBetween('plot_paymnets.paydate', [$startDate, $endDate]);
        }

        $plot = $this->request->input('plot');
        if(!empty($plot) && $plot>0){
            $data->where('allocation_details.plot', $plot);
        }
        $results = $data->get();
        return $results;
    }


 public function receivingReport()
{
    $startDate =$this->request->input('startDate');
    $endDate =$this->request->input('endDate');
        if(!($endDate)){
            $endDate=$startDate;
        }
    $subcat =$this->request->get('scheme');

    $payments = PlotPayment::select(
            'categories.id as category_id',
            'categories.name as category',
            'plot_paymnets.paydate',
            'plot_paymnets.amount',
            'plot_paymnets.receipt_id',
            'plot_paymnets.narration',
            'plots.plot_number',
            'allotes.fullname',
        )
        ->join('allocation_details', 'allocation_details.id', '=', 'plot_paymnets.allocation_details_id')
        ->join('allotes', 'allotes.id', '=', 'allocation_details.allote')
        ->join('plots', 'plots.id', '=', 'allocation_details.plot')
        // ->join('payments','payments.created_at','=','plot_paymnets.created_at')
        ->join('categories', 'categories.id', '=', 'plots.category_id')
        ->where('plots.scheme_id', $subcat)
        ->whereBetween('plot_paymnets.paydate', [$startDate, $endDate])
        ->orderBy('categories.name')
        ->orderBy('plot_paymnets.paydate')
        ->get();

    // Group by category (e.g., Block B, C, D)
    $grouped = [];
    foreach ($payments as $payment) {
        $cat = $payment->category;

        if (!isset($grouped[$cat])) {
            $grouped[$cat] = [
                'category_id' => $payment->category_id,
                'category_name' => $cat,
                'total' => 0,
                'records' => []
            ];
        }
        $new=0;
        // $res=$this->getAmount( $payment->created_at);
        // if($res){
        //     $receipt_id=$res->receipt_id;
        //     $amount=$res->amount;
        // }
        // else{
        //     $receipt_id=$payment->receipt_id;
        //     $amount=$payment->amount;
        // }
         $receipt_id=$payment->receipt_id;
        $amount=$payment->amount;
        $grouped[$cat]['records'][] = [
            'allote' => $payment->fullname,
            'plot' => $payment->plot_number,
            'paydate' => $payment->paydate,
            'receipt_id' => $receipt_id,
            'narration' => $payment->narration,
            'amount' => $amount
        ];

        $grouped[$cat]['total'] += $payment->amount;
    }

    return (array_values($grouped));
}

public function getAmount($date){
    $amount=Payment::where("created_at",$date)->first();
    return $amount;
}

    public function getPaymentsVoucher()
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('length', 10);
        $page = $this->request->input('page', 1);
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $joins = $this->request->input('joins', []);
        $orderColumn = $this->request->input('orderColumn', 'paydate');
        $orderDirection = $this->request->input('payments.paydate', 'desc');
        $groupBy = $this->request->input('groupBy', []);
        $having = $this->request->input('having', []);
        $paginate = $this->request->input('paginate', true);
        $draw=$this->request->get('draw');
        $searchValue = $this->request->get('search')['value']; // This is the value you want to search for
        

        $columns = [
            'payments.*',
            'banks.bank_name  as bank',
            'banks.account_no  as account',
            'allotes.fullname',
            'allotes.phone',
            'account_heads.name as expense'
        ];

        // Initialize an array for the conditions
        $filters = [];
        $conditions=[];
        $startDate = $this->request->input('startDate');
        $endDate = $this->request->input('endDate');

          if(!($endDate)){
            $endDate=$startDate;
        }
    
        // Add startDate and endDate to the filters if they are provided
        
        $joins = [
            [
                'table' => 'allotes',
                'first' => 'payments.allotees',
                'operator' => '=',
                'second' => 'allotes.id',
                'type'=>'leftJoin'
            ],
            [
                'table' => 'account_heads',
                'first' => 'payments.expense_heads',
                'operator' => '=',
                'second' => 'account_heads.id',
                'type'=>'leftJoin'
            ],
            [
                'table' => 'banks',
                'first' => 'payments.from_account',
                'operator' => '=',
                'second' => 'banks.id',
                'type'=>'leftJoin'
            ],
        ];

        if (!empty($searchValue)) {
            // Using an associative array instead of a nested array
            $filters['paydate'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
            $filters['from_account'] = '%' . $searchValue . '%';
            $filters['amount'] = '%' . $searchValue . '%';
            $filters['narration'] = '%' . $searchValue . '%';
            $filters['account_heads.name'] = '%' . $searchValue . '%';
            $filters['allotes.fullname'] = '%' . $searchValue . '%';
        }
        if (!empty($startDate) && !empty($endDate)) {
            $conditions[] = ['paydate', '>=', $startDate]; // start date condition
            $conditions[] = ['paydate', '<=', $endDate]; // end date condition
        }
        $paymentType = $this->request->get('payment');
        $subcat = $this->request->get('subcat');
        //code for filter of payment by type and sub cat
        if (!empty($paymentType)) {
            $conditions[] = ['payment_type', '=', $paymentType];
        
            if (!empty($subcat)) {
                $conditions[] = [$paymentType == 1 ? 'allotees' : 'expense_heads', '=', $subcat];
            }
        }
        

        // Fetch the records using QueryTrait's fetchRecords method
        $result = $this->fetchRecords(
            'payments',
            $columns,
            $conditions,
            $filters,
            $joins,
            'payments.id',
            'desc',
            $groupBy ,
            $having ,
            $perPage ,
            $page = ($start / $length) + 1 ,
            $paginate = true
        );

        // Return only the data if pagination is enabled, or full response if not paginated
        return[
            'data' => $result['data'],
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'draw' => $draw,
        ];
    }


     public function receivingReportListing()
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('length', 10);
        $page = $this->request->input('page', 1);
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $joins = $this->request->input('joins', []);
        $orderColumn = $this->request->input('orderColumn', 'paydate');
        $orderDirection = $this->request->input('payments.paydate', 'desc');
        $groupBy = $this->request->input('groupBy', []);
        $having = $this->request->input('having', []);
        $paginate = $this->request->input('paginate', true);
        $draw=$this->request->get('draw');
        $searchValue = $this->request->get('search')['value']; // This is the value you want to search for
        

        $columns = [
            'payments.*',
            'banks.bank_name  as bank',
            'banks.account_no  as account',
            'allotes.fullname',
            'allotes.phone',
            'account_heads.name as expense'
        ];

        // Initialize an array for the conditions
        $filters = [];
        $conditions=[];
        $startDate = $this->request->input('startDate');
        $endDate = $this->request->input('endDate');
          if(!($endDate)){
            $endDate=$startDate;
        }
    
        // Add startDate and endDate to the filters if they are provided
        
        $joins = [
            [
                'table' => 'allotes',
                'first' => 'payments.allotees',
                'operator' => '=',
                'second' => 'allotes.id',
                'type'=>'leftJoin'
            ],
            [
                'table' => 'account_heads',
                'first' => 'payments.expense_heads',
                'operator' => '=',
                'second' => 'account_heads.id',
                'type'=>'leftJoin'
            ],
            [
                'table' => 'banks',
                'first' => 'payments.from_account',
                'operator' => '=',
                'second' => 'banks.id',
                'type'=>'leftJoin'
            ],
        ];

        if (!empty($searchValue)) {
            // Using an associative array instead of a nested array
            $filters['paydate'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
            $filters['from_account'] = '%' . $searchValue . '%';
            $filters['amount'] = '%' . $searchValue . '%';
            $filters['narration'] = '%' . $searchValue . '%';
            $filters['account_heads.name'] = '%' . $searchValue . '%';
            $filters['allotes.fullname'] = '%' . $searchValue . '%';
        }
        if (!empty($startDate) && !empty($endDate)) {
            $conditions[] = ['paydate', '>=', $startDate]; // start date condition
            $conditions[] = ['paydate', '<=', $endDate]; // end date condition
        }
        $paymentType = $this->request->get('payment');
        $subcat = $this->request->get('subcat');
        //code for filter of payment by type and sub cat
        if (!empty($paymentType)) {
            $conditions[] = ['payment_type', '=', $paymentType];
        
            if (!empty($subcat)) {
                $conditions[] = [$paymentType == 1 ? 'allotees' : 'expense_heads', '=', $subcat];
            }
        }
        

        // Fetch the records using QueryTrait's fetchRecords method
        $result = $this->fetchRecords(
            'payments',
            $columns,
            $conditions,
            $filters,
            $joins,
            'payments.id',
            'desc',
            $groupBy ,
            $having ,
            $perPage ,
            $page = ($start / $length) + 1 ,
            $paginate = true
        );

        // Return only the data if pagination is enabled, or full response if not paginated
        return[
            'data' => $result['data'],
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'draw' => $draw,
        ];
    }

    public function getAccountHeads(){
        $banks = DB::table('account_heads')->get();

        $bank=$banks->map(function ($bank) {
            return [
                'value' => $bank->id, // assuming 'id' is a unique identifier
                'label' => $bank->name // assuming 'name' holds the display name
            ];
        });
        return response()->json([
            'success' => true,
            'expenses' => $bank
        ]);
    }
    //get all expenses
    public function getExpenses()
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('length', 10);
        $page = $this->request->input('page', 1);
        $joins = $this->request->input('joins', []);
        $orderColumn = $this->request->input('orderColumn', 'id');
        $orderDirection = $this->request->input('orderDirection', 'asc');
        $groupBy = $this->request->input('groupBy', []);
        $having = $this->request->input('having', []);
        $paginate = $this->request->input('paginate', true);
        $draw=$this->request->get('draw');
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $searchValue = $this->request->get('search')['value']; // This is the value you want to search for

        $columns = [
            'payments.*',
            'banks.bank_name  as bank',
            'banks.account_no  as account',
            'allotes.fullname',
            'allotes.phone',
            'account_heads.name as expense'
        ];

        // Initialize an array for the conditions
        $filters = [];
        $conditions=[];
        $startDate = $this->request->input('startDate');
        $endDate = $this->request->input('endDate');
          if(!($endDate)){
            $endDate=$startDate;
        }
    
        // Add startDate and endDate to the filters if they are provided
        
        $joins = [
            [
                'table' => 'allotes',
                'first' => 'payments.allotees',
                'operator' => '=',
                'second' => 'allotes.id',
                'type'=>'leftJoin'
            ],
            [
                'table' => 'account_heads',
                'first' => 'payments.expense_heads',
                'operator' => '=',
                'second' => 'account_heads.id',
                'type'=>'leftJoin'
            ],
            [
                'table' => 'banks',
                'first' => 'payments.from_account',
                'operator' => '=',
                'second' => 'banks.id',
                'type'=>'leftJoin'
            ],
        ];

        if (!empty($searchValue)) {
            // Using an associative array instead of a nested array
            $filters['paydate'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
            $filters['from_account'] = '%' . $searchValue . '%';
            $filters['amount'] = '%' . $searchValue . '%';
            $filters['narration'] = '%' . $searchValue . '%';
            $filters['account_heads.name'] = '%' . $searchValue . '%';
            $filters['allotes.fullname'] = '%' . $searchValue . '%';
        }
        //date to from range filter for date filter
        if (!empty($startDate) && !empty($endDate)) {
            $conditions[] = ['paydate', '>=', $startDate]; // start date condition
            $conditions[] = ['paydate', '<=', $endDate]; // end date condition
        }
        //expense cat
        $subcat = $this->request->get('subcat');
        if (!empty($subcat)) {
            $conditions[] = ['expense_heads', '=', $subcat];
        }
        $conditions[] = ['payment_type', '=', 2];
        
        // Fetch the records using QueryTrait's fetchRecords method
        $result = $this->fetchRecords(
            'payments',
            $columns,
            $conditions,
            $filters,
            $joins,
            $orderColumn,
            $orderDirection,
            $groupBy ,
            $having ,
            $perPage ,
            $page = ($start / $length) + 1 ,
            $paginate = true
        );

        // Return only the data if pagination is enabled, or full response if not paginated
        return[
            'data' => $result['data'],
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'draw' => $draw,
        ];
    }

    //get payment listing
    public function getPayments()
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('length', 10);
        $page = $this->request->input('page', 1);
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $joins = $this->request->input('joins', []);
        $orderColumn = $this->request->input('orderColumn', 'id');
        $orderDirection = $this->request->input('orderDirection', 'asc');
        $groupBy = $this->request->input('groupBy', []);
        $having = $this->request->input('having', []);
        $paginate = $this->request->input('paginate', true);
        $draw=$this->request->get('draw');
        $searchValue = $this->request->get('search')['value']; // This is the value you want to search for
        

        $columns = [
            'payments.*',
            'banks.bank_name  as bank',
            'banks.account_no  as account',
            'allotes.fullname',
            'allotes.phone',
            'account_heads.name as expense'
        ];

        // Initialize an array for the conditions
        $filters = [];
        $conditions=[];
        $startDate = $this->request->input('startDate');
        $endDate = $this->request->input('endDate');
          if(!($endDate)){
            $endDate=$startDate;
        }
    
        // Add startDate and endDate to the filters if they are provided
        
        $joins = [
            [
                'table' => 'allotes',
                'first' => 'payments.allotees',
                'operator' => '=',
                'second' => 'allotes.id',
                'type'=>'leftJoin'
            ],
            [
                'table' => 'account_heads',
                'first' => 'payments.expense_heads',
                'operator' => '=',
                'second' => 'account_heads.id',
                'type'=>'leftJoin'
            ],
            [
                'table' => 'banks',
                'first' => 'payments.from_account',
                'operator' => '=',
                'second' => 'banks.id',
                'type'=>'leftJoin'
            ],
        ];

        if (!empty($searchValue)) {
            // Using an associative array instead of a nested array
            $filters['paydate'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
            $filters['from_account'] = '%' . $searchValue . '%';
            $filters['amount'] = '%' . $searchValue . '%';
            $filters['narration'] = '%' . $searchValue . '%';
            $filters['account_heads.name'] = '%' . $searchValue . '%';
            $filters['allotes.fullname'] = '%' . $searchValue . '%';
        }
        if (!empty($startDate) && !empty($endDate)) {
            $conditions[] = ['paydate', '>=', $startDate]; // start date condition
            $conditions[] = ['paydate', '<=', $endDate]; // end date condition
        }
        $conditions[] = ['payment_type', '=', 1];

        // Fetch the records using QueryTrait's fetchRecords method
        $result = $this->fetchRecords(
            'payments',
            $columns,
            $conditions,
            $filters,
            $joins,
            $orderColumn,
            $orderDirection,
            $groupBy ,
            $having ,
            $perPage ,
            $page = ($start / $length) + 1 ,
            $paginate = true
        );

        // Return only the data if pagination is enabled, or full response if not paginated
        return[
            'data' => $result['data'],
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'draw' => $draw,
        ];
    }
    public function applyCharge()
    {
        try {
            DB::beginTransaction(); // Start the transaction
    
            // Fetch all payment schedules grouped by allocation_details_id
            $paymentSchedules = DB::table('payment_schedule')
                ->where('id', '>', 0)
                ->orderBy('allocation_details_id', 'asc') // Group by allocation_details_id
                ->orderBy('id', 'asc') // Ensure installments are processed in chronological order
                ->lockForUpdate() // Prevent other transactions from modifying these rows
                ->get();
    
            // Define surcharge rate
            $surchargeRate = 15;
    
            // Track the last outstanding balance for each allocation_details_id
            $lastOutstandingByAllocation = [];
    
            foreach ($paymentSchedules as $schedule) {
                $allocationId = $schedule->allocation_details_id;
    
                // Initialize last outstanding balance for the allocation_details_id if not set
                if (!isset($lastOutstandingByAllocation[$allocationId])) {
                    $lastOutstandingByAllocation[$allocationId] = 0;
                }
    
                // Calculate surcharge if payment is not made
                $surcharge = 0;
                if ($schedule->amount_paid == 0) {
                    $surcharge = $this->calculateSurcharge($schedule->amount, $surchargeRate);
                }
    
                // Calculate outstanding balance for the current installment
                $currentOutstanding = $schedule->amount + $surcharge - $schedule->amount_paid;
    
                // Add the current outstanding to the last outstanding balance for the allocation
                $outstanding = $lastOutstandingByAllocation[$allocationId] + $currentOutstanding;
    
                // Debugging: Print values for verification
                // echo "Allocation ID: {$allocationId}\n";
                // echo "Installment ID: {$schedule->id}\n";
                // echo "Amount: {$schedule->amount}\n";
                // echo "Amount Paid: {$schedule->amount_paid}\n";
                // echo "Surcharge: {$surcharge}\n";
                // echo "Current Outstanding: {$currentOutstanding}\n";
                // echo "Last Outstanding: {$lastOutstandingByAllocation[$allocationId]}\n";
                // echo "Cumulative Outstanding: {$outstanding}\n";
                // echo "-----------------------------\n";
    
                // Update the database with surcharge and outstanding
                $updated = PaymentSchedule::where('id', $schedule->id)->update([
                    'surcharge' => $surcharge,
                    'outstanding' => $outstanding,
                    'updated_at' => now(),
                ]);
    
                if ($updated === 0) { // If no rows were updated, rollback
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Failed to update record with ID {$schedule->id}",
                    ]);
                }
    
                // Update the last outstanding balance for the next iteration
                $lastOutstandingByAllocation[$allocationId] = $outstanding;
            }
    
            DB::commit(); // Commit the transaction
    
            // Log action
            logAction('Surcharge applied for all payment schedules.');
    
            return response()->json([
                'success' => true,
                'message' => "Surcharge successfully applied.",
            ]);
        } catch (Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            return response()->json([
                'success' => false,
                'message' => "Something went wrong: " . $e->getMessage(),
            ]);
        }
    }

    private function calculateSurcharge($amount, $rate)
    {
        return ($amount * $rate) / 100;
    }

    public function getPaymentById($id){
        return  DB::table('payments')
        ->leftjoin('allotes', 'payments.allotees', '=', 'allotes.id')
        ->leftjoin('banks', 'banks.id', '=', 'payments.from_account')
        ->leftjoin('account_heads', 'account_heads.id', '=', 'payments.expense_heads')
        ->select(
            'payments.id as id',
            'payments.paydate as pdate',
            'payments.created_at as created_at',
            'payments.updated_at as updated_at',
            'payments.receipt_id as receipt_id',
            'payments.payment_type as payment_type',
            'payments.amount as amount',
            'payments.narration as narration',
            'account_heads.id as expense',
            'banks.bank_name as account',
            'banks.id as bank_id',
            'account_heads.name as expense_name',
            'allotes.id as allote_id',
            'allotes.fullname as allote'
        )
        ->where('payments.id','=',$id)
        ->first();
    }
}