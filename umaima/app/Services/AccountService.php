<?php

namespace App\Services;

use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;
use Carbon\Carbon;
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
                'label' => $bank->bank_name.'('.$bank->account_no.')' // assuming 'name' holds the display name
            ];
        });
        return response()->json([
            'success' => true,
            'acccounts' => $bank
        ]);
    }
    
    public function isAmounntPaidOnDate($date,$allocation_details_id){

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

            DB::beginTransaction();

            // Prepare data for insertion
            $data = [
                'paydate' => $this->request->input('paydate'),
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
            if ($payment_type == 1) {
                $pay = $this->payAmount();
                switch ($pay) {
                    case 1:
                        $msg = "Payment schedule updated successfully!";
                        $lastInsertedId = DB::table('payments')->insertGetId($data);
                        logAction('Created Payment', $lastInsertedId);
                        break;
                    case 2:
                        $success=false;
                        $msg = "Failed to update payment schedule!";
                        break;
                    case 3:
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
                'outstanding' => $schedule->outstanding + $surcharge,
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


    public function payAmount()
    {
        try {
            $allocationId = $this->request->input('plot');
            $amountPaid = $this->request->input('amount');
            $paidOn = $this->request->input('paydate');

            $payDate = Carbon::parse($paidOn)->format('Y-m-15');

            $paymentSchedule = DB::table('payment_schedule')
            ->where('allocation_details_id', $allocationId)
            ->whereRaw("pay_date = ?", [$payDate])
            ->first();
            
            if (!$paymentSchedule) {
                return 3;
            }
            $record =  PaymentSchedule::where('allocation_details_id', $allocationId)
                ->where('pay_date', $payDate)
                ->first();
               

            if ($record) {
                //check if amount is already paid on this date 
                if($record->amount_paid){
                    return 5;
                }
                $overdueSchedules = PaymentSchedule::where('allocation_details_id', $allocationId)
                ->where('pay_date', '<', $payDate)
                ->where('surcharge', 0)
                ->where('amount_paid', 0)
                ->get();
                $surchargeRate = 15; // Define surcharge rate
                foreach ($overdueSchedules as $schedule) {
                    $outstanding = $schedule->amount - $schedule->amount_paid;
                    // print_r($outstanding);
                    // Calculate surcharge
                    $surcharge = $this->calculateSurcharge($outstanding, $surchargeRate);
        
                    // Update surcharge and outstanding for overdue schedules
                    $outStd= (int)($outstanding + $surcharge);//change outstanding value to decimal two points
                    
                    $outStd = (int)round($outstanding + $surcharge);
                    $updation=[
                        'surcharge' => $outStd,
                        'outstanding' =>$surcharge,
                        'updated_at' => now(),
                    ];
                    $schedule->update($updation);
                }
                $updated =$record->update([
                    'amount_paid' => $amountPaid,
                    'paid_on' => $paidOn,
                    'updated_at' => now(),
                ]);
            }

            // $updated = DB::table('payment_schedule')
            //     ->where('allocation_details_id', $allocationId)
            //     ->where('pay_date', $payDate)
            //     ->update([
            //         'amount_paid' => $amountPaid,
            //         'paid_on' => $paidOn,
            //         'updated_at' => now(),
            //     ]);

            return $updated ? 1 : 2;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }



    public function getPaymentsVoucher()
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

            $currentMonth = Carbon::now()->startOfMonth(); // First day of the current month
            $currentMonthDate = $currentMonth->format('Y-m-15'); // Use the 15th of the current month
            $currentMonthLastDate = $currentMonth->endOfMonth()->format('Y-m-d'); // Dynamically get the last day

            // Fetch payment schedules where no payment is made and due within the current month
            $paymentSchedules = DB::table('payment_schedule')
                ->where('amount_paid', '=', 0)
                ->where('pay_date', '>=', $currentMonthDate)
                ->where('pay_date', '<=', $currentMonthLastDate)
                ->lockForUpdate() // Prevent other transactions from modifying these rows
                ->get();

            // Define surcharge rate
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

                if ($updated === 0) { // If no rows were updated, rollback
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Failed to update record with ID {$schedule->id}",
                    ]);
                }
            }

            DB::commit(); // Commit the transaction

            // Log action
            logAction('Surcharge applied for payment month ' . $currentMonthDate);

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
    private function calculateSurcharge($outstanding, $rate)
    {

        // Example: Apply surcharge for each month missed
        return ($outstanding*$rate)/100; // Simple surcharge calculation, can be adjusted based on your business logic
    }
    public function getPaymentById($id){
        return  DB::table('payments')
        ->leftjoin('allotes', 'payments.allotees', '=', 'allotes.id')
        ->leftjoin('banks', 'banks.id', '=', 'payments.from_account')
        ->select(
            'payments.paydate as pdate',
            'payments.payment_type as payment_type',
            'payments.amount as amount',
            'payments.narration as narration',
            'banks.bank_name as account',
            'allotes.fullname as allote'
        )
        ->where('payments.id','=',$id)
        ->first();
    }

}