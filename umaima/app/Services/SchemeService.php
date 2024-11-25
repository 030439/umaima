<?php

namespace App\Services;

use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Scheme;
use Illuminate\Http\JsonResponse;
use Exception;
class SchemeService
{
    use QueryTrait;

    protected $table;
    protected $request;

    public function __construct(Request $request)
    {
        $this->table = 'schemes'; // Define the table name for users
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
            $filters['name'] = '%' . $searchValue . '%'; // This will be like 'name' => '%searchValue%'
            $filters['no_of_plots'] = '%' . $searchValue . '%';
            $filters['total_valuation'] = '%' . $searchValue . '%';
            $filters['area'] = '%' . $searchValue . '%';
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

    public function getSchemeDetails(){

        $sizes = DB::table('plot_sizes')->get();
        $locations = DB::table('plot_locations')->get();
        $schemes = DB::table('schemes')->get();
        $scheme=$schemes->map(function ($scheme) {
            return [
                'value' => $scheme->id, // assuming 'id' is a unique identifier
                'label' => $scheme->name // assuming 'name' holds the display name
            ];
        });
        $size=$sizes->map(function ($size) {
            return [
                'value' => $size->id, // assuming 'id' is a unique identifier
                'label' => $size->size // assuming 'name' holds the display name
            ];
        });
        $location=$locations->map(function ($location) {
            return [
                'value' => $location->id, // assuming 'id' is a unique identifier
                'label' => $location->location_name // assuming 'name' holds the display name
            ];
        });
        return response()->json([
            'success' => true,
            'plotSizes' => $size,
            'plotLocations' =>$location,
            'scheme'=>$scheme
        ]);
        
    }

    public function createScheme()
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'scheme.schemeName' => 'required|string|unique:schemes,name',
                'scheme.schemeArea' => 'required|integer',
                'scheme.numberOfPlots' => 'required|integer',
                'scheme.totalValuation' => 'required|integer',
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
            $scheme = Scheme::create([
                'name' => $this->request->input('scheme.schemeName'),
                'area' => $this->request->input('scheme.schemeArea'),
                'no_of_plots' => $this->request->input('scheme.numberOfPlots'),
                'total_valuation' => $this->request->input('scheme.totalValuation'),
            ]);
    
            // Log the action
            logAction('Created Scheme', $scheme->name);
    
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

     public function allotedPlotListing()
    {
        // Fetch plots with related scheme details
            // Query to fetch plots and related scheme information
            $plots = DB::table('plots')
            ->join('schemes', 'plots.scheme_id', '=', 'schemes.id')
            ->select(
                'plots.id as id',
                'plots.status as status',
                'plots.plot_number',
                'schemes.name as scheme'
            )
            ->get();

            // Group plots by scheme name
            $groupedPlots = $plots->groupBy('scheme');

            // Format the response as desired
            $response = [];
            foreach ($groupedPlots as $schemeName => $plots) {
                $response[] = [
                    'scheme' => $schemeName,
                    'plots' => $plots->mapWithKeys(function ($plot) {
                        return [
                            $plot->id => [
                                'status' => $plot->status,
                                'plot_number' => $plot->plot_number,
                            ],
                        ];
                    })->all(),
                ];
            }

            // Output the response
            return ($response);

    }

    public function totalPlotsSchemeWise()
    {
            $plotsCountByScheme = DB::table('schemes')
            ->select(
                'schemes.name as scheme','schemes.no_of_plots as total_plots',
            )
            ->get();
            return $plotsCountByScheme;
    }
    public function totalExpenseHeadWise()
    {
        // Fetch plots with related scheme details
            // Query to fetch plots and related scheme information
            $expensesByHead = DB::table('payments')
            ->join('account_heads', 'payments.expense_heads', '=', 'account_heads.id')
            ->select(
                'account_heads.name as expense', // Expense head name
                DB::raw('SUM(payments.amount) as total_amount') // Total amount per expense head
            )
            ->where('payments.payment_type', '=', 2) // Filter by payment type
            ->groupBy('payments.expense_heads', 'account_heads.name') // Group by expense head ID and name
            ->get();
        
            return $expensesByHead;
    }
    public function totalPaymentsByAllote()
    {
        // Fetch plots with related scheme details
            // Query to fetch plots and related scheme information
            $expensesByHead = DB::table('payments')
            ->join('allotes', 'payments.allotees', '=', 'allotes.id')
            ->select(
                'allotes.fullname as allote', // Expense head name
                DB::raw('SUM(payments.amount) as total_amount') // Total amount per expense head
            )
            ->where('payments.payment_type', '=', 1) // Filter by payment type
            ->groupBy('payments.allotees', 'allotes.fullname') // Group by expense head ID and name
            ->get();
        
            return $expensesByHead;
    }
     
    
}
