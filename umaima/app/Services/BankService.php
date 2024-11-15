<?php

namespace App\Services;

use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;
use Illuminate\Http\JsonResponse;
use Exception;
class BankService
{
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
        $perPage = $this->request->input('perPage', 10);
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

    
}
