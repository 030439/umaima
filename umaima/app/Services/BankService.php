<?php

namespace App\Services;

use App\Traits\QueryTrait;
use App\Traits\BalanceTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;
use Illuminate\Http\JsonResponse;
use Exception;
class BankService
{
    //
    use QueryTrait,BalanceTrait;

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

    //bank store with validation
    public function storeBank(){
        {
            try {
                $validator = Validator::make($this->request->all(), [
                    'bank' => 'required|string',
                    'branch' => 'required|string',
                    'account_holder' => 'required|string',
                    'account_no' => 'required|unique:banks,account_no',
                    'initial_balance' => 'required|integer',
                ]);
        
                if ($validator->fails()) {
                    // Format the error messages as a single string with line breaks
                    $errorMessages = implode("\n", $validator->errors()->all());
                    return response()->json([
                        'success' => false,
                        'message' => "\n" . $errorMessages
                    ]); // Unprocessable Entity
                }
        
                // Insert into schemes table
                $arr = [
                        'bank_name' => $this->request->input('bank'),
                        'branch' => $this->request->input('branch'),
                        'account_holder' => $this->request->input('account_holder'),
                        'account_no' => $this->request->input('account_no'),
                        'initial_balance' => $this->request->input('initial_balance')
                    ];
                
                $bank = Bank::create($arr);
        
                // Log the action
                logAction('Bank Created ', $bank->bank.','.$bank->account_no);
        
                // Success response
                return response()->json([
                    'message' => 'Bank created successfully!',
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
    }

    public function destroy()
    {
        $id = $this->request->id;

        // Validate the ID
        if (!$id) {
            return response()->json(['error' => 'ID is required'], 400);
        }

        // Find and delete the record
     
        $bank = Bank::find($id);
        if ($bank) {
            $bank->status = 0;
            $bank->save();
            
            logAction('Bank Deleted ',$id);
            return response()->json(['success' => 'Record deleted successfully'], 200);
        }

        return response()->json(['error' => 'Record not found'], 404);
    }

    public function ledger($id)
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
        // if (!empty($paymentType)) {
        //     $conditions[] = ['payment_type', '=', $paymentType];
        
        //     if (!empty($subcat)) {
        //         $conditions[] = [$paymentType == 1 ? 'allotees' : 'expense_heads', '=', $subcat];
        //     }
        // }
        $conditions[] = ['banks.id', '=', $id];
        

        // Fetch the records using QueryTrait's fetchRecords method
        $result = $this->fetchRecordsBank(
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

    
}
