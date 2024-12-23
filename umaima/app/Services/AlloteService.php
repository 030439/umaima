<?php

namespace App\Services;

use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Models\Allote;
use Exception;
class AlloteService
{
    use QueryTrait;

    protected $table;
    protected $request;

    public function __construct(Request $request)
    {
        $this->table = 'plots'; // Define the table name for users
        $this->request = $request; // Inject Request
    }

    public function geAll()
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('length', 10);
        $page = $this->request->input('page', 1);
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $orderColumn = $this->request->input('orderColumn', 'id');
        $orderDirection = $this->request->input('orderDirection', 'asc');
        $groupBy = $this->request->input('groupBy', []);
        $having = $this->request->input('having', []);
        $paginate = $this->request->input('paginate', true);
        $draw=$this->request->get('draw');
        $searchValue = $this->request->get('search')['value']; // This is the value you want to search for

        // Initialize an array for the conditions
        
        $columns = [
            'allotes.id as id',
            'allotes.fullname',
            'allotes.cellno',
            'allotes.email',
            'allotes.cnic',
            'allotes.status'
        ];

        $filters = [];
        $joins = [];
        if (!empty($searchValue)) {
            // Using an associative array instead of a nested array
            $filters['fullname'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
            $filters['cellno'] = '%' . $searchValue . '%'; 
            $filters['email'] = '%' . $searchValue . '%'; 
            $filters['cnic'] = '%' . $searchValue . '%'; 
            $filters['address'] = '%' . $searchValue . '%'; 
        }

        // Fetch the records using QueryTrait's fetchRecords method
    
        $result = $this->fetchRecords(
            "allotes",
            $columns,
            $conditions=[],
            $filters,
            $joins=[],
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
    public function getInActiveAllotees()
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('length', 10);
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $page = ($start / $length) + 1;
        $orderColumn = $this->request->input('orderColumn', 'plots.id');
        $orderDirection = $this->request->input('orderDirection', 'asc');
        $draw = $this->request->get('draw');
        $searchValue = $this->request->input('search')['value'] ?? null;

        $allocationDetailsQuery = DB::table('allocation_details')
    ->select(
        'allocation_details.allote',
        'allocation_details.id',
        'allotes.fullname as allote_name',
        'plots.plot_number as plot'
    )
    ->leftJoin(
        DB::raw('(SELECT allocation_details_id, MAX(updated_at) AS last_payment_date 
                  FROM payment_schedule 
                  GROUP BY allocation_details_id) as ps'),
        'allocation_details.id', '=', 'ps.allocation_details_id'
    )
    ->leftJoin('allotes', 'allocation_details.allote', '=', 'allotes.id')
    ->leftJoin('plots', 'allocation_details.plot', '=', 'plots.plot_number')
    ->where(function ($query) {
        $query->whereNull('ps.last_payment_date')
              ->orWhere('ps.last_payment_date', '<', DB::raw('DATE_SUB(CURDATE(), INTERVAL 1 MONTH)'));
    });
       
    if (!empty($searchValue)) {
        $allocationDetailsQuery->where(function ($query) use ($searchValue) {
            $query->where('allocation_details.allote', 'LIKE', "%{$searchValue}%")
                  ->orWhere('allotes.fullname', 'LIKE', "%{$searchValue}%")
                  ->orWhere('plots.plot_number', 'LIKE', "%{$searchValue}%");
        });
    }
    
    // Apply sorting
    $allocationDetailsQuery->orderBy($orderColumn, $orderDirection);
    
    // Apply pagination
    $allocationDetails = $allocationDetailsQuery
        ->offset($start)
        ->limit($length)
        ->get();
    
  
    
        // Step 2: Initialize an empty array for results
        $results = [];
        
        // Step 3: Loop through each allocation_detail
        foreach ($allocationDetails as $detail) {
            // Fetch the latest outstanding amount from payment_schedule
            $latestDue = DB::table('payment_schedule')
                ->where('allocation_details_id', $detail->id)
                ->orderByDesc('id')
                ->value('outstanding');
        
            // Fetch the latest plot status from plots table
            $latestStatus = DB::table('plots')
                ->where('plot_number', $detail->plot)
                ->orderByDesc('id')
                ->value('status');
        
            // Fetch the latest plot number from plots table
            $latestPlotNumber = DB::table('plots')
                ->where('plot_number', $detail->plot)
                ->orderByDesc('id')
                ->value('plot_number');
        
            // Aggregate payment_schedule data for this allocation_detail
            $paymentSummary = DB::table('payment_schedule')
                ->selectRaw('SUM(outstanding) as totalDue, SUM(amount) as totalAmount, SUM(amount_paid) as totalPaid')
                ->where('allocation_details_id', $detail->id)
                ->first();
        
            // Construct the result for this allocation_detail
            $results[] = [
                // 'scheme' => $detail->scheme,
                'id' => $detail->id,
                'plot' => $detail->plot,
                'allote' => $detail->allote_name,
                'status' => $latestStatus,
                'plot_number' => $latestPlotNumber,
                'totalDue' => $paymentSummary->totalDue ?? 0,
                'amount' => $paymentSummary->totalAmount ?? 0,
                'paid' => $paymentSummary->totalPaid ?? 0,
            ];
        }
        // Step 4: Get the total records count
        $totalRecords = count($results);
        
        
            $data = $results;
            $totalRecords=count($results);
            $filteredRecords=count($results);
            // Return the result (formatted for DataTables)
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);
    }
    public function plotPaymet($id)
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('length', 10);
        $page = $this->request->input('page', 1);
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $orderColumn = $this->request->input('orderColumn', 'payment_schedule.id');
        $orderDirection = $this->request->input('orderDirection', 'asc');
        $groupBy = $this->request->input('groupBy', []);
        $having = $this->request->input('having', []);
        $paginate = $this->request->input('paginate', true);
        $draw=$this->request->get('draw');
        $searchValue = $this->request->get('search')['value']; // This is the value you want to search for

        // Initialize an array for the conditions
        // $columns = [
        //     'allocation_details.id as id',
        //     'plots.status as status',
        //     'plots.plot_number',
        //     'schemes.name  as scheme',
        //     'plot_locations.location_name as location',
        //     'plot_sizes.size as size',
        //     'allocation_details.installment'
        // ];

        $filters = [];
        // $joins = [
        //     [
        //         'table' => 'plots',
        //         'first' => 'allocation_details.plot',
        //         'operator' => '=',
        //         'second' => 'plots.id',
        //         'type'=>'leftjoin'
        //     ],
        //     [
        //         'table' => 'schemes',
        //         'first' => 'allocation_details.scheme',
        //         'operator' => '=',
        //         'second' => 'schemes.id',
        //         'type'=>'leftjoin'
        //     ],
        //     [
        //         'table' => 'plot_locations',
        //         'first' => 'plots.plot_location_id',
        //         'operator' => '=',
        //         'second' => 'plot_locations.id',
        //         'type'=>'leftjoin'
        //     ],
        //     [
        //         'table' => 'plot_sizes',
        //         'first' => 'plots.plot_size_id',
        //         'operator' => '=',
        //         'second' => 'plot_sizes.id',
        //         'type'=>'leftjoin'
        //     ],
        // ];
        if (!empty($searchValue)) {
            // Using an associative array instead of a nested array
            $filters['allocation_details.allote'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
        }

        $conditions[] = ['payment_schedule.allocation_details_id', '=', $id];

        // Fetch the records using QueryTrait's fetchRecords method
    
        $result = $this->fetchRecords(
            "payment_schedule",
            $columns=['*'],
            $conditions,
            $filters,
            $joins=[],
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

    public function addAllote()
    {
        try {
            $validator = Validator::make($this->request->all(), [
                // 'formValidationUsername' => 'required',
                // 'formValidationEmail' => 'required',
                // 'formValidationcell' => 'required',
                'formValidationFirstName' => 'required',
                'formValidationLastName' => 'required',
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
            $arr = [
                    // 'username' => $this->request->input('formValidationUsername'),
                    // 'email' => $this->request->input('formValidationEmail'),
                    // 'cellno' => $this->request->input('formValidationcell'),
                    // 'phone' => $this->request->input('formValidationoffice'),
                    'fullname' => $this->request->input('formValidationFirstName'),
                    'cnic' => $this->request->input('formValidationLastName'),
                    'guardian'=> $this->request->input('guardian'),
                    'gcnic' => $this->request->input('gcnic'),
                    'father' => $this->request->input('father'),
                    'fcnic' => $this->request->input('fcnic'),
                    'occupation' => $this->request->input('occupation'),
                    'dob' => $this->request->input('dob'),
                    'nationality' => $this->request->input('nationality'),
                    'residence_no' => $this->request->input('residence'),
                    'address' => $this->request->input('address')
                ];
            
            $scheme = Allote::create($arr);
    
            // Log the action
            logAction('Created Allote', $scheme->fullname.','.$scheme->username);
    
            // Success response
            return response()->json([
                'message' => 'Allote created successfully!',
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

    public function updateAllote()
    {
        $id=$this->request->input("id");
        try {
            // Validate the request inputs
            $validator = Validator::make($this->request->all(), [
        
                'formValidationFirstName' => 'required',
                'formValidationLastName' => 'required',
            ]);

            if ($validator->fails()) {
                // Format the error messages as a single string with line breaks
                $errorMessages = implode("\n", $validator->errors()->all());

                return response()->json([
                    'success' => false,
                    'message' => "\n" . $errorMessages
                ], 422); // Unprocessable Entity
            }

            // Find the existing Allote record by its ID
            $allote = Allote::find($id);

            if (!$allote) {
                return response()->json([
                    'success' => false,
                    'message' => 'Allote record not found.'
                ], 404); // Not Found
            }

            // Prepare the data for updating
            $arr = [
                'username' => $this->request->input('formValidationUsername'),
                'email' => $this->request->input('formValidationEmail'),
                'cellno' => $this->request->input('formValidationcell'),
                'phone' => $this->request->input('formValidationoffice'),
                'fullname' => $this->request->input('formValidationFirstName'),
                'cnic' => $this->request->input('formValidationLastName'),
                'guardian' => $this->request->input('guardian'),
                'gcnic' => $this->request->input('gcnic'),
                'father' => $this->request->input('father'),
                'fcnic' => $this->request->input('fcnic'),
                'occupation' => $this->request->input('occupation'),
                'dob' => $this->request->input('dob'),
                'nationality' => $this->request->input('nationality'),
                'residence_no' => $this->request->input('residence'),
                'address' => $this->request->input('address')
            ];

            // Update the Allote record
            $allote->update($arr);

            // Log the action
            logAction('Updated Allote', $allote->fullname . ',' . $allote->username);

            // Success response
            return response()->json([
                'message' => 'Allote updated successfully!',
                'success' => true
            ]);
        } catch (Exception $e) {
            // Error response
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false
            ]);
        }
    }

    

    public function createPlotSize()
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'size' => 'required|integer|unique:plot_sizes,size',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->size,
                    'errors' => $validator->errors(),
                ], 422); // Unprocessable Entity
            }
            $size = $this->request->input('size');
            DB::table('plot_sizes')->insert([
                'size' => $size
            ]);
           logAction('Created Plot size', $size);
            $response = [
                'message' => 'Plot size successfully !',
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

    public function createPlotLocation()
    {
        try {
            // The incoming request is already validated by StoreRoleRequest
            $validator = Validator::make($this->request->all(), [
                'location_name' => 'required|unique:plot_locations,location_name',
            ]);
        
            // If validation fails, return a response with errors
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->location_name,
                ], 422); // Unprocessable Entity
            }
        
            // Retrieve validated data
            $location_ = $this->request->input('location_name');

            // Step 1: Create the role
            DB::table('plot_locations')->insert([
                'location_name' => $location_
            ]);
            logAction('Created Plot location', $location_);

            // Return success response
            
            $response = [
                'message' => 'Plot Location created succesfully!',
                 'success' => true
            ];
            // Return success response in DataTable format
            return response()->json($response);
        } catch (Exception $e) {
            // Rollback transaction in case of error
            

            // Return error response
            $response = [
                'message' => $e->getMessage(),
                 'success' => false
            ];

            // Return success response in DataTable format
            return response()->json($response);

        }
    }

    public function duration()
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'size' => 'required|integer|unique:mid_pays_durations,durations',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->durations,
                    'errors' => $validator->errors(),
                ], 422); // Unprocessable Entity
            }
            $size = $this->request->input('size');
            DB::table('mid_pays_durations')->insert([
                'durations' => $size
            ]);
           logAction('created pay Duration', $size);
            $response = [
                'message' => 'mid pays durations created successfully !',
                 'success' => true
            ];
            // Return success response in DataTable format
            return response()->json($response);
        } catch (Exception $e) {
            $response = [
                'message' => 'An unexpected error occurred while creating the pay duration.',
                 'success' => false
            ];
            return response()->json($response);
        }
    }

    public function installment()
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'location_name' => 'required|integer|unique:installments,installment',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->installment,
                    'errors' => $validator->errors(),
                ], 422); // Unprocessable Entity
            }
            $size = $this->request->input('location_name');
            DB::table('installments')->insert([
                'installment' => $size
            ]);
           logAction('created payment installment', $size);
            $response = [
                'message' => 'installments successfully !',
                 'success' => true
            ];
            // Return success response in DataTable format
            return response()->json($response);
        } catch (Exception $e) {
            $response = [
                'message' => 'An unexpected error occurred while creating installment name.',
                 'success' => false
            ];
            return response()->json($response);
        }
    }
    public function  getAllotiesNames(){
        $allotes = DB::table('allotes')->get();
        $allote=$allotes->map(function ($allote) {
            return [
                'value' => $allote->id, // assuming 'id' is a unique identifier
                'label' => $allote->fullname.':'.$allote->cnic // assuming 'name' holds the display name
            ];
        });
        return response()->json([
            'success' => true,
            'alloties' => $allote,
        ]);
    }
    public function  getAlloties(){
        $allotes = DB::table('allotes')->get();
        $allote=$allotes->map(function ($allote) {
            return [
                'value' => $allote->id, // assuming 'id' is a unique identifier
                'label' => $allote->fullname.':'.$allote->cnic // assuming 'name' holds the display name
            ];
        });
        $schemes = DB::table('schemes')->get();
        $scheme=$schemes->map(function ($scheme) {
            return [
                'value' => $scheme->id, // assuming 'id' is a unique identifier
                'label' => $scheme->name // assuming 'name' holds the display name
            ];
        });
        return response()->json([
            'success' => true,
            'allotes' => $allote,
            'scheme'=>$scheme
        ]);
    }
    
}
