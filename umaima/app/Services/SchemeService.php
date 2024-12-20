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
        $start = $this->request->input('start', 0);
        $length = $this->request->input('length', 10);
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
    public function schemePlotsDetail($id)
    {
        // Fetch plots with related scheme details
        $plots = DB::table('schemes')
        ->leftJoin('plots', 'plots.scheme_id', '=', 'schemes.id') // Use LEFT JOIN to include schemes without plots
        ->select(
            'schemes.name as scheme',
            DB::raw('COUNT(plots.id) as no_of_plots'), // Count all plots
            'schemes.total_valuation',
            DB::raw('COALESCE(SUM(CASE WHEN plots.status = 0 THEN 1 ELSE 0 END), 0) as vacant'),   // Count of active plots or 0
            DB::raw('COALESCE(SUM(CASE WHEN plots.status = 1 THEN 1 ELSE 0 END), 0) as allotted'), // Count of allotted plots or 0
            DB::raw('COALESCE(SUM(CASE WHEN plots.status = 2 THEN 1 ELSE 0 END), 0) as fill')     // Count of vacant plots or 0
        )
        ->where('schemes.id', '=', $id) // Filter by scheme ID
        ->groupBy('schemes.id', 'schemes.name', 'schemes.no_of_plots', 'schemes.total_valuation') // Group by scheme details
        ->first();
        return $plots;
    
    }

    public function getSchemeDetails(){

        $sizes = DB::table('plot_sizes')->get();
        $locations = DB::table('plot_locations')->get();
        $schemes = DB::table('schemes')->get();
        $categories = DB::table('categories')->get();
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
        $cate=$categories->map(function ($category) {
            return [
                'value' => $category->id, // assuming 'id' is a unique identifier
                'label' => $category->name // assuming 'name' holds the display name
            ];
        });
        return response()->json([
            'success' => true,
            'plotSizes' => $size,
            'plotLocations' =>$location,
            'scheme'=>$scheme,
            'cate'=>$cate
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
    public function updateScheme()
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'scheme.schemeName' => 'required|string',
                'scheme.schemeArea' => 'required',
                'scheme.numberOfPlots' => 'required',
                'scheme.totalValuation' => 'required',
            ]);
    
            if ($validator->fails()) {
                // Format the error messages as a single string with line breaks
                $errorMessages = implode("\n", $validator->errors()->all());
            
                return response()->json([
                    'success' => false,
                    'message' => "\n" . $errorMessages
                ], 422); // Unprocessable Entity
            }
    
            $id=$this->request->input('scheme.id');
            $scheme = Scheme::find($id);
            $scheme->name = $this->request->input('scheme.schemeName');
            $scheme->area = $this->request->input('scheme.schemeArea');
            $scheme->no_of_plots =$this->request->input('scheme.numberOfPlots');
            $scheme->total_valuation = $this->request->input('scheme.totalValuation');
            $scheme->save();
           
            // Log the action
            logAction('Scheme updated', $scheme->name);
    
            // Success response
            return response()->json([
                'message' => 'Scheme updated successfully!',
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
            ->leftjoin('allocation_details', 'allocation_details.plot', '=', 'plots.plot_number')
            ->leftjoin('allotes', 'allocation_details.allote', '=', 'allotes.id')
            ->select(
                'plots.id as id',
                'plots.status as status',
                'plots.plot_number',
                'schemes.name as scheme',
                'allotes.fullname as allote',
                'allotes.id as aid'
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
                                'aid'=>$plot->aid,
                                'allote'=>$plot->allote,
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
        $results = DB::table('payment_schedule')
            ->join('allocation_details', 'payment_schedule.allocation_details_id', '=', 'allocation_details.id')
            ->join('schemes', 'allocation_details.scheme', '=', 'schemes.id')
            ->select('schemes.name as scheme_name','schemes.no_of_plots as total_plots','schemes.id as sid')
            ->selectRaw('SUM(payment_schedule.outstanding) as totalDue')
            ->selectRaw('SUM(payment_schedule.amount) as totalAmount')
            ->selectRaw('SUM(payment_schedule.amount_paid) as totalPaid')
            ->groupBy('schemes.name','schemes.no_of_plots','schemes.id')
            ->get();
        return $results;
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

    public function editScheme($id){
        return Scheme::find($id);
    }
     
    
}
