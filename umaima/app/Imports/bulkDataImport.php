<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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

                if ($row[0] == "end") {
                    $number++; // Increment number for the next rc key
                    $rcKey = $number; // Update rc key
                    $arr[$rcKey] = []; // Initialize a new rc array
                    continue; // Skip this iteration
                }

                $payDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8]);
                $paidOn = !empty($row[10]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]) : null;
                if($row[13]=="#VALUE!"){
                }
                $arr[$rcKey][] = [
                    'allote' => $row[0],
                    'plot' => $row[1],
                    'scheme' => $row[2],
                    'installment' => $row[6],
                    'amount' => $row[7],
                    'pay_date' => $payDate->format('Y-m-d'),
                    'amount_paid' => $row[9],
                    'paid_on' => $paidOn ? $paidOn->format('Y-m-d') : null,
                    'receipt' => $row[11],
                    'surcharge' => $row[12],
                    'outstanding' => $row[13],
                    'account' => $row[14],
                ];
               
            }
            $this->storePayment($arr);
            dd($arr);
        });
    }



    public function allotment()
    {
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
        }
    }


    public function storePayment($records)
    {

        try {
            DB::beginTransaction();
            foreach($records as $rec){
                dd($rec);
            }
            $data = [
                'paydate' => $rec('paid_on'),
                'payment_type' => 1,
                'from_account' => 1,
                'amount' => $rec('amount_paid'),
                'narration' => "Plot Payment",
                'allotees' => (int)$rec('allote'),
                'expense_heads' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
           
                $success=true;
                $pay = $this->payAmount();

                $lastInsertedId = DB::table('payments')->insertGetId($data);
                logAction('Created Payment', $lastInsertedId);

            DB::commit();

            return response()->json([
                'success' => $success,
                'message' => $msg,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function payAmount()
    {
        try {
            $allocationId = $rec('plot');
            $amountPaid = $rec('amount_paid');
            $paidOn = $rec('paid_on');
            $payD=Carbon::parse($paidOn)->format('Y-m-d');
            $payDate = Carbon::parse($paidOn)->format('Y-m-15');
            $dm=Carbon::parse($paidOn)->format('Y-m');
            $pD = Carbon::parse($paidOn)->format('Y-m');
            

            $paymentSchedule = DB::table('payment_schedule')
            ->where('allocation_details_id', $allocationId)
            ->whereRaw("pay_date = ?", [$payDate])
            ->first();
            
            if (!$paymentSchedule) {
                return 3;
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

                $updated =$record->update([
                    'amount_paid' => $amountPaid,
                    'paid_on' => $paidOn,
                    'updated_at' => now(),
                ]);
            }

            return $updated ? 1 : 2;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}