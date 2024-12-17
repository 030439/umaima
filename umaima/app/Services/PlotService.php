<?php

namespace App\Services;

use App\Traits\QueryTrait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Models\Plot;
use App\Models\AllocationDetail;
use Carbon\Carbon;
use Exception;
class PlotService
{
    use QueryTrait;

    protected $table;
    protected $request;

    public function __construct(Request $request)
    {
        $this->table = 'plots'; // Define the table name for users
        $this->request = $request; // Inject Request
    }
    //fetch all the plots
    public function geAll()
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('length', 10);
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $page = $this->request->input('page', 1);
        $orderColumn = $this->request->input('orderColumn', 'plots.id');
        $orderDirection = $this->request->input('orderDirection', 'asc');
        $groupBy = $this->request->input('groupBy', []);
        $having = $this->request->input('having', []);
        $paginate = $this->request->input('paginate', true);
        $draw=$this->request->get('draw');
        $searchValue = $this->request->get('search')['value']; // This is the value you want to search for

        // Initialize an array for the conditions
        $columns = [
            'plots.id as id',
            'plots.status as status',
            'plots.plot_number',
            'schemes.name  as scheme',
            'plot_locations.location_name as location',
            'plot_sizes.size as size'
        ];

        $filters = [];
        $joins = [
            [
                'table' => 'schemes',
                'first' => 'plots.scheme_id',
                'operator' => '=',
                'second' => 'schemes.id',
                'type'=>'join'
            ],
            [
                'table' => 'plot_locations',
                'first' => 'plots.plot_location_id',
                'operator' => '=',
                'second' => 'plot_locations.id',
                'type'=>'join'
            ],
            [
                'table' => 'plot_sizes',
                'first' => 'plots.plot_size_id',
                'operator' => '=',
                'second' => 'plot_sizes.id',
                'type'=>'join'
            ],
        ];
        if (!empty($searchValue)) {
            // Using an associative array instead of a nested array
            $filters['name'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
        }

        // Fetch the records using QueryTrait's fetchRecords method
    
        $result = $this->fetchRecords(
            $this->table,
            $columns,
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
    //fetch plots shceme wise
    public function schemePlots($id)
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('length', 10);
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $page = $this->request->input('page', 1);
        $orderColumn = $this->request->input('orderColumn', 'plots.id');
        $orderDirection = $this->request->input('orderDirection', 'asc');
        $groupBy = $this->request->input('groupBy', []);
        $having = $this->request->input('having', []);
        $paginate = $this->request->input('paginate', true);
        $draw=$this->request->get('draw');
        $searchValue = $this->request->get('search')['value']; // This is the value you want to search for

        // Initialize an array for the conditions
        $columns = [
            'plots.id as id',
            'plots.status as status',
            'plots.plot_number',
            'schemes.name  as scheme',
            'plot_locations.location_name as location',
            'plot_sizes.size as size'
        ];

        $filters = [];
        $joins = [
            [
                'table' => 'schemes',
                'first' => 'plots.scheme_id',
                'operator' => '=',
                'second' => 'schemes.id',
                'type'=>'join'
            ],
            [
                'table' => 'plot_locations',
                'first' => 'plots.plot_location_id',
                'operator' => '=',
                'second' => 'plot_locations.id',
                'type'=>'join'
            ],
            [
                'table' => 'plot_sizes',
                'first' => 'plots.plot_size_id',
                'operator' => '=',
                'second' => 'plot_sizes.id',
                'type'=>'join'
            ],
        ];
        $conditions[] = ['plots.scheme_id', '=', $id];
        if (!empty($searchValue)) {
            // Using an associative array instead of a nested array
            $filters['name'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
        }

        // Fetch the records using QueryTrait's fetchRecords method
    
        $result = $this->fetchRecords(
            $this->table,
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
    //fetch alloted plots
    public function schemeAllotedPlots($id)
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('length', 10);
        $page = $this->request->input('page', 1);
        $orderColumn = $this->request->input('orderColumn', 'plots.id');
        $orderDirection = $this->request->input('orderDirection', 'asc');
        $groupBy = $this->request->input('groupBy', []);
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
        $having = $this->request->input('having', []);
        $paginate = $this->request->input('paginate', true);
        $draw=$this->request->get('draw');
        $searchValue = $this->request->get('search')['value']; // This is the value you want to search for

        // Initialize an array for the conditions
        $columns = [
            'plots.id as id',
            'plots.status as status',
            'plots.plot_number',
            'schemes.name  as scheme',
            'plot_locations.location_name as location',
            'plot_sizes.size as size'
        ];

        $filters = [];
        $joins = [
            [
                'table' => 'schemes',
                'first' => 'plots.scheme_id',
                'operator' => '=',
                'second' => 'schemes.id',
                'type'=>'join'
            ],
            [
                'table' => 'plot_locations',
                'first' => 'plots.plot_location_id',
                'operator' => '=',
                'second' => 'plot_locations.id',
                'type'=>'join'
            ],
            [
                'table' => 'plot_sizes',
                'first' => 'plots.plot_size_id',
                'operator' => '=',
                'second' => 'plot_sizes.id',
                'type'=>'join'
            ],
        ];
        $conditions[] = ['plots.scheme_id', '=', $id];
        $conditions[] = ['plots.status', '=', 1];
        if (!empty($searchValue)) {
            // Using an associative array instead of a nested array
            $filters['name'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
        }

        // Fetch the records using QueryTrait's fetchRecords method
    
        $result = $this->fetchRecords(
            $this->table,
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
    public function alloteePlotes($id)
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
    
        // Initialize the query

$query = DB::table('allocation_details')
    ->select(
        'allocation_details.id as id',
        'plots.status as status',
        'plots.plot_number',
        'schemes.name as scheme',
        DB::raw('(SELECT ps.outstanding 
                  FROM payment_schedule ps 
                  WHERE ps.allocation_details_id = allocation_details.id 
                  ORDER BY ps.id DESC 
                  LIMIT 1) as totalDue'),
        DB::raw('SUM(payment_schedule.outstanding) as due'),
        DB::raw('SUM(payment_schedule.amount) as amount'),
        DB::raw('SUM(payment_schedule.amount_paid) as paid'),
        'plot_sizes.size as size',
        'allocation_details.installment',
        'allocation_details.bdate'
    )
    ->leftJoin('plots', 'allocation_details.plot', '=', 'plots.id')
    ->leftJoin('schemes', 'allocation_details.scheme', '=', 'schemes.id')
    ->leftJoin('payment_schedule', 'allocation_details.id', '=', 'payment_schedule.allocation_details_id')
    ->leftJoin('plot_sizes', 'plots.plot_size_id', '=', 'plot_sizes.id')
    ->where('allocation_details.allote', '=', $id);
    
        // Apply search filter
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->orWhere('plots.plot_number', 'LIKE', '%' . $searchValue . '%')
                    ->orWhere('schemes.name', 'LIKE', '%' . $searchValue . '%')
                    ->orWhere('plot_sizes.size', 'LIKE', '%' . $searchValue . '%');
            });
        }
    
        // Group by necessary columns
        $query->groupBy(
            'allocation_details.id',
            'plots.status',
            'plots.plot_number',
            'schemes.name',
            'plot_sizes.size',
            'allocation_details.installment',
            'allocation_details.bdate'
        );
    
        // Apply order by
        $query->orderBy($orderColumn, $orderDirection);
        
    
        // Get the total records count
        $totalRecords = $query->count();
        
    
        // Get the filtered records count
        $filteredQuery = clone $query; // Clone the query for counting filtered results
        $filteredRecords = $filteredQuery->count();
    
        // Apply pagination
        $query->offset($start)->limit($length);
    
        // Fetch the data
        $data = $query->get();
        $totalRecords=count($data);
        $filteredRecords=count($data);
        // Return the result (formatted for DataTables)
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }
    

        // Return only the data if pagination is enabled, or full response if not paginated
    //     dd($result);
    //     return[
    //         'data' => $result['data'],
    //         'recordsTotal' => $result['recordsTotal'],
    //         'recordsFiltered' => $result['recordsFiltered'],
    //         'draw' => $draw,
    //     ];
    // }
    public function createPlot()
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'plot.plotNumber' => 'required|string|unique:plots,plot_number',
                'plot.scheme' => 'required|integer',
                'plot.plotSize' => 'required|integer',
                'plot.plotLocation' => 'required|integer',
                'plot.plotCat' => 'required|integer',
                'plot.category' => 'required|integer',
                
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
            $scheme = Plot::create([
                'plot_number' => $this->request->input('plot.plotNumber'),
                'scheme_id' => $this->request->input('plot.scheme'),
                'plot_size_id' => $this->request->input('plot.plotSize'),
                'plot_location_id' => $this->request->input('plot.plotLocation'),
                'plot_category_id'=>$this->request->input('plot.plotCat'),
                'category_id'=>$this->request->input('plot.category'),
                'created_at' => now(), // Set created_at to current timestamp
                'updated_at' => now(),
            ]);
            dd($scheme);

            // Log the action
            logAction('Created Plot', $scheme->plot_numer.','.$scheme->scheme_id);

            // Success response
            return response()->json([
                'message' => 'Scheme Plot created successfully!',
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
                'size' => $size,
                'created_at' => now(), // Set created_at to current timestamp
                'updated_at' => now(),
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
                'location_name' => $location_,
                'created_at' => now(), // Set created_at to current timestamp
                'updated_at' => now(),
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

    public function createPlotCategory()
    {
        try {
            // The incoming request is already validated by StoreRoleRequest
            $validator = Validator::make($this->request->all(), [
                'name' => 'required|unique:categories,name',
            ]);
        
            // If validation fails, return a response with errors
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->name,
                ], 422); // Unprocessable Entity
            }
        
            // Retrieve validated data
            $location_ = $this->request->input('name');

            // Step 1: Create the role
            DB::table('categories')->insert([
                'name' => $location_,
                'created_at' => now(), // Set created_at to current timestamp
                'updated_at' => now(),
            ]);
            logAction('Created Plot Category', $location_);

            // Return success response
            
            $response = [
                'message' => 'Plot Category created succesfully!',
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
                'durationname' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->durations,
                    'errors' => $validator->errors(),
                ], 422); // Unprocessable Entity
            }
            $size = $this->request->input('size');
            $durationname = $this->request->input('durationname');
            DB::table('mid_pays_durations')->insert([
                'durationname'=>$durationname,
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

    public function getplotByScheme(){
        $id=$this->request->input('id');
        $allotes = DB::table('plots')->select('plot_number', 'id')->where('scheme_id', $id)->where('status', 1)->get();
        $allote=$allotes->map(function ($allote) {
            return [
                'value' => $allote->plot_number, // assuming 'id' is a unique identifier
                'label' => $allote->plot_number // assuming 'name' holds the display name
            ];
        });
        return response()->json([
            'success' => true,
            'plots' => $allote
        ]);
    }
    public function getInstallments(){
        $installments = DB::table('installments')->get();
        $durations = DB::table('mid_pays_durations')->get();

        $installment=$installments->map(function ($installment) {
            return [
                'value' => $installment->installment, // assuming 'id' is a unique identifier
                'label' => $installment->installment // assuming 'name' holds the display name
            ];
        });
        $duration=$durations->map(function ($duration) {
            return [
                'value' => $duration->id, // assuming 'id' is a unique identifier
                'label' => $duration->durationname . ' - ' . $duration->durations." Months"// assuming 'name' holds the display name
            ];
        });
        return response()->json([
            'success' => true,
            'duration' => $duration,
            'installment'=>$installment
        ]);
    }
    public function  getplotDetails(){
        $id=$this->request->input('id');
            $allotes = DB::table('plots')
            ->select('plot_categories.category_name','categories.name as cat','plot_sizes.size','plot_locations.location_name')
            ->join('plot_sizes', 'plots.plot_size_id', '=', 'plot_sizes.id')
            ->join('plot_locations', 'plots.plot_location_id', '=', 'plot_locations.id')
            ->join('plot_categories', 'plots.plot_category_id', '=', 'plot_categories.id')
            ->join('categories', 'plots.category_id', '=', 'categories.id')
            ->where('plots.id', $id)
            ->where('plots.status', 1)
            ->get();

            $allote=$allotes->map(function ($allote) {
            return [
                'cat'=>$allote->cat,
                'location' => $allote->location_name, // assuming 'id' is a unique identifier
                'size' => $allote->size, // assuming 'name' holds the display name
                'category' => $allote->category_name // assuming 'name' holds the display name
            ];
        });
        $staus=!empty($allote)?true:false;
        return response()->json([
            'success' => $staus,
            'detail' => $allote
        ]);
    }

    //show payment schedule
    public function paymentSchedule() {
        $installmentCount = (int) $this->request->input('installment');
        $durationAmount = $this->request->input('duration_amount');
        $installmentAmount = $this->request->input('installment_amount');
        $bdate = $this->request->input('bdate');
        $onBooking = $this->request->input('onbooking');
        $allocation = $this->request->input('allocation');
        $confirmation = $this->request->input('confirmation');
        $demarcation = $this->request->input('demargation');
        $possession = $this->request->input('possession');
        
        // Format and parse dates
        $bookingDate = Carbon::createFromFormat('Y-m-d', $bdate);
        $startDate = $bookingDate->copy()->day(15); // Start on the 15th of the month
    
        $durationId = (int) $this->request->input('duration');
        $durationDetails = DB::table('mid_pays_durations')
            ->select('*')
            ->where('id', $durationId)
            ->first();
    
        $duration = $durationDetails->durations ?? 1; // Fallback if duration not found
    
        $response = [
            [
                "payment" => "Booking",
                "amount" => $onBooking,
                "date" => $startDate->format('d-M-Y')
            ]
        ];
    
        // Add Allocation Payment
        if ($allocation > 0) {
            $allocationDate = $startDate->copy()->addMonth();
            $response[] = [
                "payment" => "Allocation",
                "amount" => $allocation,
                "date" => $allocationDate->format('d-M-Y')
            ];
        }
    
        // Add Confirmation Payment
        if ($confirmation > 0) {
            $confirmationDate = isset($allocationDate) 
                ? $allocationDate->copy()->addMonth()
                : $startDate->copy()->addMonth();
            $response[] = [
                "payment" => "Confirmation",
                "amount" => $confirmation,
                "date" => $confirmationDate->format('d-M-Y')
            ];
        } else {
            $confirmationDate = $startDate;
        }
        if($allocation>0 && $confirmation<=0 ){
            $confirmationDate = $allocationDate;
        }
    
        // Add Installments and Durations
        $lastDate = $confirmationDate->copy();
        $counter = 0;
        for ($i = 1; $i <= $installmentCount; $i++) {
            $lastDate->addMonth();
            $response[] = [
                "payment" => "Installment " . $i,
                "amount" => $installmentAmount,
                "date" => $lastDate->format('d-M-Y')
            ];
    
            $counter++;
            if ($counter == $duration) {
                $response[] = [
                    "payment" => "Duration " . ceil($i / $duration),
                    "amount" => $durationAmount,
                    "date" => $lastDate->format('d-M-Y')
                ];
                $counter = 0;
            }
        }
    
        // Add Demarcation Payment
        if ($demarcation > 0) {
            $response[] = [
                "payment" => "Demarcation",
                "amount" => $demarcation,
                "date" => $lastDate->copy()->addMonth()->format('d-M-Y')
            ];
        }
    
        // Add Possession Payment
        if ($possession > 0) {
            $date3_ = $startDate->copy()->addMonths($this->request->input('demargation') > 0 ? 2 : 1);
            $pdate = $date3_->format('d-M-Y');
            $response[] = [
                "payment" => "Possession",
                "amount" => $possession,
                "date" => $pdate
            ];
        }
    
        return $response;
    }
    
    //store scheule on confirmation
    public function confirmSchedule(){
        $schedule=$this->paymentSchedule();
       
        try {

            $validator = Validator::make($this->request->all(), [
                'plot' => 'required|unique:allocation_details,plot',
                'allote' => 'required|integer',
                'scheme' => 'required|integer',
                'bdate' => 'required|date',
                'onbooking' => 'required|integer',
                'allocation' => 'required|integer',
                'confirmation' => 'required|integer',
                'installment' => 'required|integer',
                'duration' => 'required|integer',
                'extra' => 'required|string',
                'percentage' => 'required|numeric',
                'possession' => 'required|integer',
                'demargation' => 'required|integer',
            ]);
            
            if ($validator->fails()) {
                // Join all the error messages with a new line break
                $errors = $validator->errors()->all(); // Get all errors as an array
                $errorMessages = implode("\n", $errors); // Convert array to string with line breaks
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $errorMessages, // Return the errors as a string with new lines
                ]); // Unprocessable Entity
            }
                $plot = $this->request->input('plot');
                $scheme = $this->request->input('scheme');
                $allote = $this->request->input('allote');
                $data = [
                    'allote' => $this->request->input('allote'),
                    'scheme' => $this->request->input('scheme'),
                    'status' => '1', // Default status or get it from input if needed
                    'plot' => $this->request->input('plot'),
                    'bdate' => $this->request->input('bdate'),
                    'onbooking' => $this->request->input('onbooking'),
                    'allocation' => $this->request->input('allocation'),
                    'confirmation' => $this->request->input('confirmation'),
                    'installment' => $this->request->input('installment'),
                    'duration' => $this->request->input('duration'),
                    'extra' => $this->request->input('extra'),
                    'percentage' => $this->request->input('percentage'),
                    'possession' => $this->request->input('possession'),
                    'demargation' => $this->request->input('demargation'),
                    'created_at' => now(), // Set created_at to current timestamp
                    'updated_at' => now(),
                ];
            
                // Begin transaction to handle rollbacks on error
                DB::beginTransaction();
                $allocationDetail = AllocationDetail::create($data);
                $status=['status'=>0];
                Plot::where('plot_number', $plot)->where('scheme_id', $scheme)->update($status);     
                if ($allocationDetail) {
                    $aid = $allocationDetail->id;
                    foreach ($schedule as $pay) {
                        $inputDate = $pay['date']; // e.g., '1-Jun-2024'

                        // Convert the date to 'Y-m-d' format for insertion into the database
                        $formattedDate = Carbon::createFromFormat('d-M-Y', $inputDate)->format('Y-m-d');
                        if($pay['amount']>0){
                            $Q = DB::table('payment_schedule')->insert([
                                'allocation_details_id' => $aid,
                                'payment' => $pay['payment'],
                                'amount' => $pay['amount'],
                                'pay_date' => $formattedDate,
                                'created_at' => now(), // Set created_at to current timestamp
                                'updated_at' => now(),
                            ]);
                        }
                        
            
                        // Check if the insertion failed
                        if (!$Q) {
                            throw new Exception('Failed to insert payment schedule data.');
                        }
                    }
            
                    // If all inserts succeed, commit the transaction and return success response
                    DB::commit();
                    logAction('Plot Allocation Created', "Plot no ". $plot ." to Allote".$allote);
                    $response = [
                        'message' => 'Plot Allocated successfully!',
                        'success' => true,
                    ];
                } else {
                    // If AllocationDetail creation fails
                    DB::rollBack();
                    $response = [
                        'errors' => 'Failed to create Plot Location.',
                        'success' => false
                    ];
                }
            
                return response()->json($response);
            } catch (Exception $e) {
                DB::rollBack();
            
                $response = [
                    'errors' => $e->getMessage(),
                    'success' => false
                ];
                return response()->json($response);
            }
            
    }
    public function getPlotsByAllote(){
        $id=$this->request->input('allote');
        $allotes = DB::table('allocation_details')->select('plot', 'id')->where('allote', $id)->where('status', 1)->get();
        $allote=$allotes->map(function ($allote) {
            return [
                'value' => $allote->id, // assuming 'id' is a unique identifier
                'label' => $allote->plot // assuming 'name' holds the display name
            ];
        });
        return response()->json([
            'success' => true,
            'plots' => $allote
        ]);
    }

}
