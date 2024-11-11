<?php

namespace App\Services;

use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Exception;
class PlotService
{
    use QueryTrait;

    protected $table;
    protected $request;

    public function __construct(Request $request)
    {
        $this->table = 'permissions'; // Define the table name for users
        $this->request = $request; // Inject Request
    }

    public function getUsers()
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
            $filters['name'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
        }

        // Fetch the records using QueryTrait's fetchRecords method
        $result = $this->fetchRecords(
            $this->table,
            $perPage,
            $page,
            $filters,
            $joins,
            $orderColumn,
            $orderDirection,
            $groupBy,
            $having,
            $paginate,
            $draw
        );

        // Return only the data if pagination is enabled, or full response if not paginated
        return[
            'data' => $result['data'],
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'draw' => $draw,
        ];
    }

   

    public function createPlotSize()
    {
        try {
            // The incoming request is already validated by StoreRoleRequest
            $validator = Validator::make($this->request->all(), [
                'size' => 'required|integer|unique:plot_sizes,size',
            ]);
        
            // If validation fails, return a response with errors
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->size,
                    'errors' => $validator->errors(),
                ], 422); // Unprocessable Entity
            }
        
            // Retrieve validated data

            $size = $this->request->input('size');

            // Step 1: Create the role
            DB::table('plot_sizes')->insert([
                'size' => $size
            ]);

            // Return success response
             $this->logAction('Created Plot size', $size);
            
            $response = [
                'message' => 'Plot size successfully !',
                 'success' => true
            ];

            // Return success response in DataTable format
            return response()->json($response);
        } catch (Exception $e) {

            // Return error response
            $response = [
                'message' => 'An unexpected error occurred while creating the Plot size.',
                 'success' => false
            ];

            // Return success response in DataTable format
            return response()->json($response);

        }
    }
    public function createPlotLocation()
    {
        try {
            // The incoming request is already validated by StoreRoleRequest
            $validator = Validator::make($this->request->all(), [
                'location_' => 'required|unique:plot_locations,location_name',
            ]);
        
            // If validation fails, return a response with errors
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422); // Unprocessable Entity
            }
        
            // Retrieve validated data
            $location_ = $this->request->input('location_');

            // Step 1: Create the role
            DB::table('plot_locations')->insert([
                'location_name' => $location_
            ]);

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




}
