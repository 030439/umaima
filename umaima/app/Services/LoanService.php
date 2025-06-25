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
use App\Models\Loan;
use App\Models\AllocationDetail;
use App\Models\LoanParties;
use Illuminate\Http\JsonResponse;
use Exception;
class LoanService
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

    public function getPartyBalance($id)
    {
        $paid=0;
        $returned = 0;

        $loans = Loan::where('party', $id)->get();
        if(!empty($loans)){
            foreach ($loans as $row) {
                if ($row->transaction == 2) {
                    $paid += $row->amount;
                } else {
                    $returned += $row->amount;
                }
            }
        }

        return ['paid'=>$paid,'received'=>$returned]; // or handle the case where the bank is not found
    }

    public function getAllParties()
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

        // if (!empty($searchValue)) {
        //     // Using an associative array instead of a nested array
        //     $filters['bank_name'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
        //     $filters['branch'] = '%' . $searchValue . '%';
        //     $filters['account_holder'] = '%' . $searchValue . '%';
        //     $filters['account_no'] = '%' . $searchValue . '%';
        // }

        // Fetch the records using QueryTrait's fetchRecords method
        $result = $this->fetchRecords(
            "loan_parties",
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

        $data = $result['data'];
        foreach ($data as &$row) {
                $balance= $this->getPartyBalance($row->id);
                $row->paid=$balance['paid'];
                $row->received=$balance['received'];
        }

        // Return only the data if pagination is enabled, or full response if not paginated
        return[
            'data' => $data,
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'draw' => $draw,
        ];
    }


    public function saveParty()
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'party.name' => 'required|string',
                'party.phone' => 'required',
                'party.address' => 'required'
            ]);
    
            if ($validator->fails()) {
                // Format the error messages as a single string with line breaks
                $errorMessages = implode("\n", $validator->errors()->all());
            
                return response()->json([
                    'success' => false,
                    'message' => "\n" . $errorMessages
                ], 422); // Unprocessable Entity
            }
    
            // Insert into schemes table
            $scheme = LoanParties::create([
                'name' => $this->request->input('party.name'),
                'address' => $this->request->input('party.address'),
                'phone' => $this->request->input('party.phone'),
            ]);
            // Log the action
            logAction('Created Party', $scheme->name);
    
            // Success response
            return response()->json([
                'message' => 'Scheme created successfully!',
                'success' => true
            ]);
        } catch (Exception $e) {
            // Error response
            
            return response()->json([
                'message' =>  $e->getMessage(),
                'success' => false
            ]);
        }
    }


    public function updateParty()
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'party.name' => 'required|string',
                'party.phone' => 'required',
                'party.address' => 'required'
            ]);
    
            if ($validator->fails()) {
                // Format the error messages as a single string with line breaks
                $errorMessages = implode("\n", $validator->errors()->all());
            
                return response()->json([
                    'success' => false,
                    'message' => "\n" . $errorMessages
                ], 422); // Unprocessable Entity
            }
    
            // Insert into schemes table
            $id=$this->request->input('id');
            $scheme = LoanParties::where('id',$id)->update([
                'name' => $this->request->input('party.name'),
                'address' => $this->request->input('party.address'),
                'phone' => $this->request->input('party.phone'),
            ]);
            // Log the action
            logAction('updated Party', $id);
    
            // Success response
            return response()->json([
                'message' => 'Scheme created successfully!',
                'success' => true
            ]);
        } catch (Exception $e) {
            // Error response
            
            return response()->json([
                'message' =>  $e->getMessage(),
                'success' => false
            ]);
        }
    }


    public function loanStore()
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
                'party' => 'required|string',
            ];

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
            $data=['party'=>(int)$this->request->input('party'),
             'bank'=> $this->request->input('from_account'),
             'amount'=> $this->request->input('amount'),
             'transaction'=>$this->request->input('payment_type'),
             'narration'=> $this->request->input('narration'),
             'pay_date'=>$this->request->input('paydate'),
             'receipt' => $this->request->input('receipt_id'),
            'created_at' => now(),
            'updated_at' => now(),
            ];
            $lastInsertedId = DB::table('loans')->insertGetId($data);
            logAction('Created Payment', $lastInsertedId);
            $msg = "Payment created successfully!";
            logAction('Created Payment', $lastInsertedId);
                    

            DB::commit();

            return response()->json([
                'success' => true,
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


    public function getLoansList()
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('length', 10);
        $page = $this->request->input('page', 1);
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $joins = $this->request->input('joins', []);
        $orderColumn = $this->request->input('orderColumn', 'pay_date');
        $orderDirection = $this->request->input('orderDirection', 'asc');
        $groupBy = $this->request->input('groupBy', []);
        $having = $this->request->input('having', []);
        $paginate = $this->request->input('paginate', true);
        $draw=$this->request->get('draw');
        $searchValue = $this->request->get('search')['value']; // This is the value you want to search for
        

        $columns = [
            'loans.*',
            'banks.bank_name  as bank',
            'banks.account_no  as account',
            'loan_parties.name',
            'loan_parties.phone',
        ];

        // Initialize an array for the conditions
        $filters = [];
        $conditions=[];
        $startDate = $this->request->input('startDate');
        $endDate = $this->request->input('endDate');
    
        // Add startDate and endDate to the filters if they are provided
        
        $joins = [
            [
                'table' => 'loan_parties',
                'first' => 'loans.party',
                'operator' => '=',
                'second' => 'loan_parties.id',
                'type'=>'leftJoin'
            ],
            [
                'table' => 'banks',
                'first' => 'loans.bank',
                'operator' => '=',
                'second' => 'banks.id',
                'type'=>'leftJoin'
            ],
        ];

        if (!empty($searchValue)) {
            // Using an associative array instead of a nested array
            $filters['pay_date'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
            $filters['bank'] = '%' . $searchValue . '%';
            $filters['amount'] = '%' . $searchValue . '%';
            $filters['narration'] = '%' . $searchValue . '%';
            $filters['loan_parties.name'] = '%' . $searchValue . '%';
        }
        if (!empty($startDate) && !empty($endDate)) {
            $conditions[] = ['pay_date', '>=', $startDate]; // start date condition
            $conditions[] = ['pay_date', '<=', $endDate]; // end date condition
        }
        $paymentType = $this->request->get('payment');
        $subcat = $this->request->get('subcat');
        //code for filter of payment by type and sub cat
        if (!empty($paymentType)) {
            $conditions[] = ['transaction', '=', $paymentType];
        
            if (!empty($subcat)) {
                $conditions[] = ['party', '=', $subcat];
            }
        }
        

        // Fetch the records using QueryTrait's fetchRecords method
        $result = $this->fetchRecords(
            'loans',
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

}