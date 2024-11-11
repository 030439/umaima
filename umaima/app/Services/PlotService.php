<?php

namespace App\Services;

use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Models\Plot;
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

    public function geAll()
    {
        // Use request parameters with fallback defaults
        $perPage = $this->request->input('perPage', 10);
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

    public function createPlot(){
        {
            try {
                $validator = Validator::make($this->request->all(), [
                    'plot.plotNumber' => 'required|string|unique:plots,plot_number',
                    'plot.scheme' => 'required|integer',
                    'plot.plotSize' => 'required|integer',
                    'plot.plotLocation' => 'required|integer',
                    'plot.plotCat' => 'required|integer',
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
                    'plot_category_id'=>$this->request->input('plot.plotCat')
                ]);
        
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
}
