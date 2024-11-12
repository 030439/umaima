<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlotService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PlotController extends Controller
{
    protected $plotservice;
    
    public function __construct(PlotService $plotservice)
    {
        $this->plotservice = $plotservice;
    }

    public function plotAllotment(){
        return view('plots.allotment');
    }

    public function listing()
    {
        $result = $this->plotservice->geAll();
        return ($result);
    }

    public function store()
    {
        $result = $this->plotservice->createPlot();
        return ($result);
    }

    public function plotSize(){
        $sizes = DB::table('plot_sizes')->get();
        $locations = DB::table('plot_locations')->get();
        return view('plots.sizes',compact('sizes','locations'));
    }

    public function installments(){
        $durations = DB::table('mid_pays_durations')->get();
        $installments = DB::table('installments')->get();
        return view('plots.installments',compact('durations','installments'));
    }
    public function createPlotSize()
    {
        $result = $this->plotservice->createPlotSize();
        return ($result);
    }
    public function createPlotLocation()
    {
        $result = $this->plotservice->createPlotLocation();
        return ($result);
    }

    public function duration()
    {
        $result = $this->plotservice->duration();
        return ($result);
    }

    public function installment()
    {
        $result = $this->plotservice->installment();
        return ($result);
    }
    //fetch total schemes
    public function getplotByScheme(){
        $result = $this->plotservice->getplotByScheme();
        return ($result);
    }
    //plot detail by plot id
    public function getplotDetails(){
        $result = $this->plotservice->getplotDetails();
        return ($result);
    }
    //payment isnallments and duration of payments
    public function getInstallments(){
        $result = $this->plotservice->getInstallments();
        return ($result);
    }
    public function paymentSchedule(Request $req){
    // Initialize response with initial payments
    $response = [
        [
            "payment" => "Booking",
            "amount" => $req->input('onbooking'),
            "date" => "15-feb-2022"
        ],
        [
            "payment" => "Allocation",
            "amount" => $req->input('allocation'),
            "date" => "15-feb-2022"
        ],
        [
            "payment" => "Confirmation",
            "amount" => $req->input('confirmation'),
            "date" => "15-feb-2022"
        ],
    ];

    // Retrieve installment count and duration amount
    $duration = (int) $req->input('duration'); 
    $installmentCount = (int) $req->input('installment');  // Number of installments
    $durationAmount = $req->input('duration_amount'); 
    $installment_amount=$req->input('installment_amount');       // Amount for each duration, assumed as input
    $dateString = '15-feb-2022'; // This is just an example, replace with dynamic data
    $startDate = Carbon::createFromFormat('d-M-Y', $dateString);// Base date for first installment

    // Generate installment payments
    $durationCount=0;
    $counter=0;
    for ($i = 1; $i <= $installmentCount; $i++) {
       
        $counter++;
        $installmentDate = $startDate->copy()->addMonths($i); // Increment by duration
        $response[] = [
            "payment" => "Installment " . $i,
            "amount" => $installment_amount,
            "date" => $installmentDate->format('d-M-Y')
        ];
        if($counter==$duration){
            $response[] = [
                "payment" => "Duration " . ++$durationCount,
                "amount" => $durationAmount,
                "date" => $installmentDate->format('d-M-Y')
            ];
            $counter=0;
        }

    }

    $response []= 
        [
            "payment" => "Demargation",
            "amount" => $req->input('demargation'),
            "date" => "15-feb-2022"
        ];
        $response []= [
            "payment" => "Possession",
            "amount" => $req->input('possession'),
            "date" => "15-feb-2022"
        ];
    
    // Return the response
    return response()->json($response);
}


}
