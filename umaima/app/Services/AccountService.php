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
            $page ,
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
            $lastInsertedId = DB::table('payments')->insertGetId($data);
            $success=true;
            if ($payment_type == 1) {
                $pay = $this->payAmount();
                switch ($pay) {
                    case 1:
                        $msg = "Payment schedule updated successfully!";
                        break;
                    case 2:
                        $success=false;
                        $msg = "Failed to update payment schedule!";
                        break;
                    case 3:
                        $success=false;
                        $msg = "No matching payment schedule found.";
                        
                        break;
                    default:
                    $success=false;
                        $msg = $pay; // Return the exception message
                }
            } else {
                $msg = "Payment created successfully!";
            }

            // Log the action
            logAction('Created Payment', $lastInsertedId);

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


    public function payAmount()
    {
        try {
            $allocationId = $this->request->input('plot');
            $amountPaid = $this->request->input('amount');
            $paidOn = $this->request->input('paydate');

            $payDate = Carbon::parse($paidOn)->format('15-M-Y');

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
            $page ,
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
            $page ,
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
            $page ,
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

    
}
