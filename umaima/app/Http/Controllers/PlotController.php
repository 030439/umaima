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
    public function paymentSchedule(Request $req) {
        $installmentCount = (int) $req->input('installment');  
        $durationAmount = $req->input('duration_amount'); 
        $installment_amount = $req->input('installment_amount');

        $bdate = $req->input('bdate');
        $convertedDate = Carbon::createFromFormat('Y-m-d', $bdate)->format('d-M-Y'); // String here

        // Create new Carbon instance to format further
        $carbonDate = Carbon::createFromFormat('d-M-Y', $convertedDate);
        $month = $carbonDate->format('M');
        $year = $carbonDate->format('Y');
        $dateString = "15-{$month}-{$year}";
        $startDate = Carbon::createFromFormat('d-M-Y', $dateString); 
    
        $did = (int) $req->input('duration'); 
        $allotes = DB::table('mid_pays_durations')
                    ->select('*')
                    ->where('id', $did)
                    ->first();
        $duration = $allotes->durations;
    
        $bookingDate = $carbonDate->format('d-M-Y');
        $date2 = $startDate->copy()->addMonths(1);
        $allocationDate = $date2->format('d-M-Y');
        $date3 = $startDate->copy()->addMonths(2);
        $confirmationDate = $date3->format('d-M-Y');
    
        $response = [
            [
                "payment" => "Booking",
                "amount" => $req->input('onbooking'),
                "date" => $bookingDate
            ],
            [
                "payment" => "Allocation",
                "amount" => $req->input('allocation'),
                "date" => $allocationDate
            ],
            [
                "payment" => "Confirmation",
                "amount" => $req->input('confirmation'),
                "date" => $confirmationDate
            ],
        ];
    
        $durationCount = 0;
        $counter = 0;
        $installmentStartDate = Carbon::createFromFormat('d-M-Y', $confirmationDate); 
    
        for ($i = 1; $i <= $installmentCount; $i++) {
            $counter++;
            $installmentDate = $installmentStartDate->copy()->addMonths($i); 
            $response[] = [
                "payment" => "Installment " . $i,
                "amount" => $installment_amount,
                "date" => $installmentDate->format('d-M-Y')
            ];
    
            if ($counter == $duration) {
                $durationCount++;
                $response[] = [
                    "payment" => "Duration " . $durationCount,
                    "amount" => $durationAmount,
                    "date" => $installmentDate->format('d-M-Y')
                ];
                $counter = 0;
            }
    
            $last_date = $installmentDate;
        }
    
        $response[] = [
            "payment" => "Demargation",
            "amount" => $req->input('demargation'),
            "date" => $last_date->copy()->addMonths(1)->format('d-M-Y')
        ];
        $response[] = [
            "payment" => "Possession",
            "amount" => $req->input('possession'),
            "date" => $last_date->copy()->addMonths(2)->format('d-M-Y')
        ];
    
        return response()->json($response);
    }
    


}
