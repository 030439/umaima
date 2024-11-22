<?php

namespace App\Http\Controllers;
use App\Services\AlloteService;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
class AlloteController extends Controller
{
    protected $alloteservice;
    
    public function __construct(AlloteService $alloteservice)
    {
        $this->alloteservice = $alloteservice;
    }


    function index(){
        return view('allote.index');
    }
    public function alloteCreate(){
        return view('allote.add');
    }
    public function geAll(){
        $result = $this->alloteservice->geAll();
        return ($result);
    }
    public function getAlloties(){
        $result = $this->alloteservice->getAlloties();
        return ($result);
    }
    public function store(){

        $result = $this->alloteservice->addAllote();
        return ($result);
    }
    public function alloteePlotes($id){
        return view('allote.plotes',['pid'=>$id]);
    }
    public function plotePayments($id)
    {
        try {
            $currentMonth = Carbon::now()->startOfMonth();  // Gets the first day of the current month in Carbon instance
$currentMonthDate = $currentMonth->format('15-M-Y');// Format it as 'Y-m-d' for database comparison
           
            // Fetching payment schedule based on allocation details id (for a specific user or allocation)
            $paymentSchedules = DB::table('payment_schedule')
                ->where('allocation_details_id', $id)
                // ->where('pay_date', '>=', $currentMonthDate) // Compare with first day of current month
                ->get();
            
    
            // Initialize variables for total calculations
            $totalDueAmount = 0;
            $totalAmountPaid = 0;
            $totalOutstanding = 0;
            $totalReceipts = 0;
            $surchargeRate = 0.15; // Example surcharge rate (15%)
    
            // Starting with no outstanding balance
            $previousOutstanding = 0;
    
            $formattedSchedules = [];
    
            // Loop through all payment schedules
            foreach ($paymentSchedules as $schedule) {
                // Calculate the outstanding amount for the current schedule
                $outstanding = $schedule->amount - $schedule->amount_paid;
    
                // Apply surcharge if payment is missed (Amount Paid = 0)
                $surcharge = 0;
                if ($schedule->amount_paid == 0) {
                    // Calculate surcharge based on missed payment duration
                    $surcharge = $this->calculateSurcharge($outstanding, $surchargeRate);
                    $outstanding += $surcharge; // Add surcharge to outstanding balance
                }
    
                // Add the previous outstanding balance to the current one (accumulating outstanding)
                $outstanding += $previousOutstanding;
    
                // Format the schedule data for the display
                $formattedSchedules[] = [
                    'payment_type' => $schedule->payment,//$this->getPaymentType($schedule->pay_date), // Determine payment type
                    'due_amount' => number_format($schedule->amount),              // Format due amount
                    'due_date' => Carbon::parse($schedule->pay_date)->format('d-M-Y'), // Format due date
                    'amount_paid' => number_format($schedule->amount_paid),        // Format amount paid
                    'paid_on' => $schedule->paid_on ? Carbon::parse($schedule->paid_on)->format('d-M-Y') : 'Not Paid', // Handle paid date
                    'outstanding' => number_format($outstanding),                  // Format outstanding balance
                    'surcharge' => number_format($surcharge),                      // Format surcharge amount
                ];
    
                // Calculate totals for all schedules
                $totalDueAmount += $schedule->amount;
                $totalAmountPaid += $schedule->amount_paid;
                $totalOutstanding += $outstanding;
                $totalReceipts += $surcharge;
    
                // Set the current outstanding as the previous outstanding for the next month
                $previousOutstanding = $outstanding;
            }
    
            // Return the view with the necessary data
            return view('payment_schedule', compact('formattedSchedules', 'totalDueAmount', 'totalAmountPaid', 'totalOutstanding', 'totalReceipts'));
    
        } catch (Exception $e) {
            // Handle errors if any occur
            return $e->getMessage();
        }
    }
    
    private function calculateSurcharge($outstanding, $rate)
    {
        // Example: Apply surcharge for each month missed
        return $outstanding * $rate; // Simple surcharge calculation, can be adjusted based on your business logic
    }
    
    private function getPaymentType($payDate)
    {
        // Example logic to categorize payments by the date or type
        $date = Carbon::parse($payDate);
    
        if ($date->month == 2 && $date->day == 15) {
            return 'Booking';
        } elseif ($date->month == 4 && $date->day == 15) {
            return 'Half Yearly';
        }
    
        return 'Instalment No.' . $date->month;
    }
    

    //     return view('allote.plot-payments',['pid'=>$id]);
    // }
    public function plotPaymet($id){
        $result = $this->alloteservice->plotPaymet($id);
        return ($result);
    }
}
