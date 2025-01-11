<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Payment;
use App\Models\PlotPayment;
use App\Models\AllocationDetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\Plot;
use App\Traits\QueryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Bank;
use Carbon\Carbon;
use App\Models\PaymentSchedule;
use Illuminate\Http\JsonResponse;
use Exception;


class BulkDataImport implements ToCollection
{

    
    public function collection(Collection $rows)
    {
       
        // Skip the header row
        $header = $rows->shift();

        DB::transaction(function () use ($rows, $header) {
            $processedRows = [];
            $number = 0; // Counter for rc keys
            $arr = [];  // Final result array
            $rcKey = $number; // Initial rc key
            $arr[$rcKey] = []; // Initialize the first rc array
    
            foreach ($rows as $i => $row) {
               
                if($row[0]==""){
                    break;
                }

                if ($row[0] == "end") {
                    $number++; // Increment number for the next rc key
                    $rcKey = $number; // Update rc key
                    $arr[$rcKey] = []; // Initialize a new rc array
                    continue; // Skip this iteration
                }

                if ($row[8] > 0) {
                    if (!is_numeric($row[8])) {
                        $payDate=null;
                        // echo ("Invalid date value at row {$i}: " .($row));
                        continue; // Skip invalid rows
                    }
            
                    try {
                        $payDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8]);
                        // echo "Paydate: " . $payDate->format('Y-m-d') . PHP_EOL;
                    } catch (Exception $e) {
                        echo ("Error converting date at row {$i}: " . $e->getMessage());
                    }
                }

                // if($row[8]>0){
                //     if ($row[0] != "end") {
                      
                //      $payDate =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8]);
                //     }
                // }
                // $payDate =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8]);
                // $bdate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]);
                // $paidOn=null;
                // if ($row[0] != "end") {
                // if(is_numeric($row[10])){
                //     $paidOn=$row[10];
                    // $paidOn = ($row[10]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]) : null;
                    // $paidOn ? $paidOn->format('Y-m-d') : null;
                // }
            // }

            if ($row[10] > 0) {
                if (!is_numeric($row[10])) {
                    $paidOn=null;
                    // echo ("Invalid date value at row {$i}: " .($row));
                    continue; // Skip invalid rows
                }
        
                try {
                    $paidOn = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]);
                    // echo "Paydate: " . $payDate->format('Y-m-d') . PHP_EOL;
                } catch (Exception $e) {
                    echo ("Error converting date at row {$i}: " . $e->getMessage());
                }
            }

                // $paidOn = ($ro ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]) : null;
                
                // if($row[13]=="#VALUE!"){
                // }
               
                if($row[0]>0){
                    $arr[$rcKey][] = [
                        'allote' => (int)$row[0],
                        'plot' => $row[1],
                        'scheme' => (int)$row[2],
                        'installment' => (int)$row[3],
                        'duration' => (int)$row[4],
                        'extra' => $row[5],
                        'payment' => $row[6],
                        'amount' => (int)$row[7],
                        'pay_date' =>  $payDate,
                        'amount_paid' => (int)$row[9],
                        'paid_on' => $paidOn,
                        'receipt' => $row[11],
                        'surcharge' => (int)$row[12],
                        'outstanding' => (int)$row[13],
                        'account' => $row[14],
                        // 'bdate'=>$bdate,
                    ];
                }
                
                // echo " paydate ";
                // echo($row[8]);
                // echo " paidon ";
                // echo($row[10]);
                // echo "<br>";
               
            }
             return $this->storePayment($arr);
           
        });
    }

    public function getPlotId($plot_number,$scheme){
        $plot=Plot::where('plot_number',$plot_number)->where('scheme_id',$scheme)->first();
        if($plot->id>0){
            return $plot->id;
        }else{
            return 0;
        }
    }

    public function getAllocation($plot_number,$allote){
        $plot=AllocationDetail::where('plot',$plot_number)->where('allote',$allote)->first();
    
        if($plot->id>0){
            return $plot->id;
        }else{
            return 0;
        }
    }

    public function allotment($data)
    {
        
        // $rec=$records[0];
        $scheme=$data['scheme'];
        $plot=$data['plot'];
        $allote=$data['allote'];
        $plot_id=$this->getPlotId($plot,$scheme);
        // echo $plot_id;
        // return $plot_id;
        if($plot==0){
            return 0;
        }
        $data = [
            'allote' => $data['allote'],
            'scheme' => $scheme,
            'status' => '1', // Default status or get it from input if needed
            'plot' => $plot_id,
            'pay_date' => $data['pay_date'],
            'bdate' => $data['pay_date'],
            'onbooking' => $data['amount'],
            'allocation' => 0,
            'confirmation' => 0,
            'installment' => $data['installment'],
            'duration' => $data['duration'],
            'extra' => $data['extra'],
            'percentage' => 1,
            'possession' => 0,
            'demargation' =>0,
            'created_at' => now(), // Set created_at to current timestamp
            'updated_at' => now(),
        ];
        
        $plot=$data['plot'];
        $scheme=$data['scheme'];
        DB::beginTransaction();
        
        $allocationDetail = AllocationDetail::create($data);
       
        if ($allocationDetail) {
                // $status=['status'=>0];
                // $updatedRows = DB::table('plots')
                // ->where('plot_number', '"'.$plot.'"')
                // ->where('scheme_id', $scheme)
                // ->update($status);
                $aid = $allocationDetail->id;
               
            // foreach ($records as $pay) {
                
            //     $inputDate = $pay['pay_date']; // e.g., '1-Jun-2024'

            //     // $formattedDate = Carbon::createFromFormat('d-M-Y', $inputDate)->format('Y-m-d');
               
            //     // if($pay['amount']>0){
            //         $Q = DB::table('payment_schedule')->insert([
            //             'allocation_details_id' => $aid,
            //             'payment' => $pay['payment'],
            //             'amount' => $pay['amount'],
            //             'pay_date' => $pay['pay_date'],
            //             'created_at' => now(), // Set created_at to current timestamp
            //             'updated_at' => now(),
            //         ]);
            //     // }
               
                
            // }
    
            // If all inserts succeed, commit the transaction and return success response
            DB::commit();
            logAction('Plot Allocation Created', "Plot no ". $plot ." to Allote".$allote);
            return $aid;
        }else{
            return 0;
        }
    }


    public function storePayment($records)
    {
         $ok=false;
            foreach($records as $index=> $record){
                 if(!empty($record)){
                    $alloted =$this->allotment($record[0]);
                 
                    if($alloted>0){
                    $this->confirmSchedule($record,$alloted);
                    }
                 }
            }



            // foreach($records as $index=> $record){
            //     if(!empty($record)){
            //        $scheme=$record[0]['scheme'];
            //        $plot=$record[0]['plot'];
            //        $allote=$record[0]['allote'];

            //        $plot_id=$this->getPlotId($plot,$scheme);
           
            //        $alloted_=$this->getAllocation($plot_id,$allote);
             
            //        if($alloted_>0){
            //             foreach($record as $rec){
                      
            //                 if(!empty($rec['paid_on'])){
    
            //                     $data = [
            //                         'paid_on' => $rec['paid_on'],
            //                         'paydate' => $rec['paid_on'],
            //                         'payment_type' => 1,
            //                         'from_account' => 1,
            //                         'amount' => $rec['amount_paid'],
            //                         'amount_paid'=>$rec['amount_paid'],
            //                         'narration' => "Plot Payment",
            //                         'allotees' => (int)$rec['allote'],
            //                         'expense_heads' => 0,
            //                         'created_at' => now(),
            //                         'updated_at' => now(),
            //                     ];

            //                     $pay = [
            //                         'paydate' => $rec['paid_on'],
            //                         'payment_type' => 1,
            //                         'from_account' => 1,
            //                         'amount' => $rec['amount_paid'],
            //                         'narration' => "Plot Payment",
            //                         'allotees' => (int)$rec['allote'],
            //                         'expense_heads' => 0,
            //                         'created_at' => now(),
            //                         'updated_at' => now(),
            //                     ];
            //                     $success=true;
                              
            //                     $this->payAmount($data,$alloted_);
            //                     $lastInsertedId=Payment::create($pay);
            //                     // AllocationDetail::create($data);
            //                     // $lastInsertedId = DB::table('payments')->insertGetId($pay);
            //                     logAction('Created Payment', 1);
            //                 }
            //             }
            //        }
            //     }
            // }

             return $ok?true:false;

           
    }

    // public function payAmount($red)
    // {
    //     try {
    //         $allocationId = $rec['plot'];
    //         $amountPaid = $rec['amount_paid'];
    //         $paidOn = $rec['paid_on'];
    //         $payD=Carbon::parse($paidOn)->format('Y-m-d');
    //         $payDate = Carbon::parse($paidOn)->format('Y-m-15');
    //         $dm=Carbon::parse($paidOn)->format('Y-m');
    //         $pD = Carbon::parse($paidOn)->format('Y-m');
            

    //         $paymentSchedule = DB::table('payment_schedule')
    //         ->where('allocation_details_id', $allocationId)
    //         ->whereRaw("pay_date = ?", [$payDate])
    //         ->first();
            
    //         if (!$paymentSchedule) {
    //             return 3;
    //         }

    //         $record =  PaymentSchedule::where('allocation_details_id', $allocationId)
    //             ->where('pay_date', $payDate)
    //             ->first();
               

    //         if ($record) {
    //             //check if amount is already paid on this date 
    //             if($record->amount_paid){
    //                 return 5;
    //             }

    //             $overdueSchedules = PaymentSchedule::where('allocation_details_id', $allocationId)
    //             ->where('pay_date', '<', $payDate)
    //             ->where('surcharge', 0)
    //             ->where('amount_paid', 0)
    //             ->get();

    //             $updated =$record->update([
    //                 'amount_paid' => $amountPaid,
    //                 'paid_on' => $paidOn,
    //                 'updated_at' => now(),
    //             ]);
    //         }

    //         return $updated ? 1 : 2;
    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }
    private function calculateSurcharge($outstanding, $rate)
    {

        // Example: Apply surcharge for each month missed
        return ($outstanding*$rate)/100; // Simple surcharge calculation, can be adjusted based on your business logic
    }
    public function addSurcharge($allocationId,$payDate){
    $paymentSchedules = PaymentSchedule::where('allocation_details_id', $allocationId)
                ->where('pay_date', '=', $payDate)
                ->where('surcharge', 0)
                ->where('amount_paid', 0)
                ->get();
            $surchargeRate = 15;
            $previousOutstanding = 0;

            foreach ($paymentSchedules as $schedule) {
                $outstanding = $schedule->amount - $schedule->amount_paid;

                // Calculate surcharge if payment is not made
                $surcharge = 0;
                if ($schedule->amount_paid == 0) {
                    $surcharge = $this->calculateSurcharge($outstanding, $surchargeRate);
                    $outstanding += $surcharge; // Add surcharge to outstanding balance
                }
                $outstanding += $previousOutstanding;
                // Update the database with surcharge and outstanding
                $updated = PaymentSchedule::where('id', $schedule->id)->update([
                    'surcharge' => $surcharge, 
                    // 'outstanding' => $outstanding,
                    'updated_at' => now(),
                ]);
            }
            $this->applyStanding();

    }
    
    public function payAmount($data,$allocationId)
    {
       
        // try {
            // $allocationId = $data['plot'];
            $amountPaid = $data['amount_paid'];
            $paidOn = $data['paid_on'];
            
            
            $payD=Carbon::parse($paidOn)->format('Y-m-d');
            $payDate = Carbon::parse($paidOn)->format('Y-m-15');
            $dm=Carbon::parse($paidOn)->format('Y-m');
            $pD = Carbon::parse($paidOn)->format('Y-m');
            // dd($payDate,$allocationId);
            
            $paymentSchedule = DB::table('payment_schedule')
            ->where('allocation_details_id', $allocationId)
            ->whereRaw("pay_date = ?", [$payDate])
            ->first();
            // dd($allocationId,$payDate);
            if (!$paymentSchedule) {
                return 3;
            }
            if($payD>$payDate && $dm!=$pD){
                $this->addSurcharge($allocationId,$payDate);
            }
            $record =  PaymentSchedule::where('allocation_details_id', $allocationId)
                ->where('pay_date', $payDate)
                ->first();
                

            if ($record) {
                //check if amount is already paid on this date 
                if($record->amount_paid){
                    return 5;
                }
                $overdueSchedules = PaymentSchedule::where('allocation_details_id', $allocationId)
                ->where('pay_date', '<', $payDate)
                ->where('surcharge', 0)
                ->where('amount_paid', 0)
                ->get();
                $surchargeRate = 15; // Define surcharge rate
                $out_standing=0;
                foreach ($overdueSchedules as $schedule) {
                    $outstanding = $schedule->amount - $schedule->amount_paid;
                    
                    // print_r($outstanding);
                    // Calculate surcharge
                    $surcharge = $this->calculateSurcharge($outstanding, $surchargeRate);
        
                    // Update surcharge and outstanding for overdue schedules
                    $outStd= (int)($outstanding + $surcharge);//change outstanding value to decimal two points
                    
                    $outStd = (int)round($outstanding + $surcharge);
                    $out_standing=$out_standing+$outStd;
                    $updation=[
                        'surcharge' => $surcharge,
                        // 'outstanding' =>$out_standing,
                        'updated_at' => now(),
                    ];
                    $schedule->update($updation);
                }
                $updated =$record->update([
                    'amount_paid' => $amountPaid,
                    'paid_on' => $paidOn,
                    // 'outstanding' =>$out_standing-$amountPaid,
                    'updated_at' => now(),
                ]);
                $plotPayments= [
                    'allocation_details_id'=>$allocationId,
                    'paydate'=>$paidOn,
                    'amount'=>$amountPaid,
                    'narration'=>"Payment Paid",
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                PlotPayment::create($plotPayments);
            }

            // $updated = DB::table('payment_schedule')
            //     ->where('allocation_details_id', $allocationId)
            //     ->where('pay_date', $payDate)
            //     ->update([
            //         'amount_paid' => $amountPaid,
            //         'paid_on' => $paidOn,
            //         'updated_at' => now(),
            //     ]);

            return $updated ? 1 : 2;
        // } catch (Exception $e) {
        //     return $e->getMessage();
        // }
    }


    public function paymentSchedule($data) {

        // dd($data);
        $response=[];
        foreach($data as $i=> $d){
           $bdate= $d['pay_date'];
            $bookingDate = \Carbon\Carbon::createFromFormat('Y-m-d', $bdate->format('Y-m-d'));
            $startDate = $bookingDate->copy()->day(15); // Start on the 15th of the month
    
            $response[$i]= [
                "payment" => $d['payment'],
                "amount" => $d['amount'],
                "date" =>  $startDate->format('d-M-Y')
            ];
        }
        return $response; 
        dd($response);
        $installmentCount =  (int)$data[0]['installment'];
        
        // $durationAmount = $data['duration_amount'];
        // $installmentAmount = $data['installment_amount'];
         $bdate = $data[0]['pay_date'];
         $onBooking = $data[0]['amount'];
        // $allocation = $data['allocation'];
        // $confirmation = $data['confirmation'];
        // $demarcation = $data['demargation'];
        // $possession = $data['possession'];

        $allocation=0;
        $confirmation=0;
        $demarcation=0;
        $possession=0;
        $installmentAmount=0;
        $durationAmount=0;
       
        foreach($data as $d){
            if($d['payment']=="Half Yearly No.1"){
                $durationAmount = $d['amount'];
            }
            if($d['payment']=="Instalment No.1"){
                $installmentAmount = $d['amount'];
            }
            if($d['payment']=="Allocation"){
                $allocation = $d['amount'];
            }
            if($d['payment']=="Confirmation"){
                $confirmation = $d['amount'];
            }
            if($d['payment']=="Demagration"){
                $demarcation = $d['amount'];
            }
            if($d['payment']=="Passession"){
                $possession = $d['amount'];
            }
        }
        // Format and parse dates
     
        // $bookingDate = Carbon::createFromFormat('Y-m-d', $bdate);
        $bookingDate = \Carbon\Carbon::createFromFormat('Y-m-d', $bdate->format('Y-m-d'));

        $startDate = $bookingDate->copy()->day(15); // Start on the 15th of the month
    
        $durationId =  $data[0]['duration'];
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
                "payment" => "Demagration",
                "amount" => $demarcation,
                "date" => $lastDate->copy()->addMonth()->format('d-M-Y')
            ];
        }
    
        // Add Possession Payment
        if ($possession > 0) {
            $date3_ = $lastDate->copy()->addMonths($demarcation > 0 ? 2 : 1);
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
    public function confirmSchedule($data,$aid){
     
         $schedule=$this->paymentSchedule($data);
        


        $plot = $data[0]['plot'];
        $scheme =$data[0]['scheme'];
        $allote = $data[0]['allote'];
        $ok=false;
        // dd($schedule);
        foreach ($schedule as $pay) {
            // $inputDate = $pay['date']; 
            $formattedDate = Carbon::createFromFormat('d-M-Y', $pay['date'])->format('Y-m-d');
            // dd($formattedDate);
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
                $ok=false;
                throw new Exception('Failed to insert payment schedule data.');
            }else{
                $ok=true;
            }
        }
        return $ok;
            
                    
            
            
    }

}