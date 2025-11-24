<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Print</title>
    <link rel="shortcut icon" type="image/png" href="./favicon.png" />
    <style>
      * {
        box-sizing: border-box;
      }

      .table-bordered td,
      .table-bordered th {
        border: 1px solid #ddd;
        padding: 10px;
        word-break: break-all;
      }

      body {
        font-family: Arial, Helvetica, sans-serif;
        margin: 0;
        padding: 0;
        font-size: 16px;
      }
      .h4-14 h4 {
        font-size: 12px;
        margin-top: 0;
        margin-bottom: 5px;
      }
      .img {
        margin-left: "auto";
        margin-top: "auto";
        height: 30px;
      }
      pre,
      p {
        /* width: 99%; */
        /* overflow: auto; */
        /* bpicklist: 1px solid #aaa; */
        padding: 0;
        margin: 0;
      }
      table {
        font-family: arial, sans-serif;
        width: 100%;
        border-collapse: collapse;
        padding: 1px;
      }
      .hm-p p {
        text-align: left;
        padding: 1px;
        padding: 5px 4px;
      }
      td,
      th {
        text-align: left;
        padding: 8px 6px;
      }
      .table-b td,
      .table-b th {
        border: 1px solid #ddd;
      }
      th {
        /* background-color: #ddd; */
      }
      .hm-p td,
      .hm-p th {
        padding: 3px 0px;
      }
      .cropped {
        float: right;
        margin-bottom: 20px;
        height: 100px; /* height of container */
        overflow: hidden;
      }
      .cropped img {
        width: 400px;
        margin: 8px 0px 0px 80px;
      }
      .main-pd-wrapper {
        box-shadow: 0 0 10px #ddd;
        background-color: #fff;
        border-radius: 10px;
        padding: 15px;
      }
      .table-bordered td,
      .table-bordered th {
        border: 1px solid #ddd;
        padding: 10px;
        font-size: 14px;
      }
    </style>
  </head>
  <body>
    <section class="main-pd-wrapper" style="width: 1000px; margin: auto">
      <div style="display: table-header-group">
        <!-- <h4 style="text-align: center; margin: 0">
          <b>Tax Invoice</b>
        </h4> -->

      <h4 style="margin-top: 5px; margin-bottom: 5px">
                  {{$allote->fullname}}
                </h4>
                 <p style="font-size: 14px">
                 {{$allote->address}}<br />
                  Tel:
                  <a href="tel:01241234568" style="color: #00bb07"
                    >{{$allote->phone}}</a
                  >
                </p>

            @php
            use Illuminate\Support\Facades\DB;

           $Totalplots = DB::table('allocation_details')
          ->select('allocation_details.id', 'plots.plot_number','plots.deleted_at')
          ->join('plots', 'plots.id', '=', 'allocation_details.plot')
          ->where('allocation_details.allote', $allote->id)
          ->where('allocation_details.deleted_at', NULL)
          
          ->get();

            @endphp
        <table style="width: 100%; table-layout: fixed" border="1">
          <tr>
            <th>Plot</th>
            <th>Amount</th>
            <th>Surcharge</th>
            <th>Total</th>
            <th>Paid</th>
            <th>Remaining</th>
          </tr>
          <?php 
            foreach($Totalplots as $plot_){
              $data = DB::table('payment_schedule')
              ->selectRaw('SUM(amount) as payable, SUM(amount_paid) as paid, SUM(surcharge) as surcharge')
              ->where('allocation_details_id', $plot_->id)
              ->first();
              $total_pay=$data->payable+$data->surcharge;
              $remaining=$total_pay-$data->paid;
              ?>
              <tr>
                <th>{{$plot_->plot_number}}</th>
                <th>{{$data->payable}}</th>
                <th>{{$data->surcharge}}</th>
                <th>{{$total_pay}}</th>
                <th>{{$data->paid}}</th>
                <th>{{$remaining}}</th>
              </tr>
            <?php }?>
         
          
        </table>
      <table
        class="table table-bordered h4-14"
        style="width: 100%; -fs-table-paginate: paginate; margin-top: 15px"
      >
        <thead style="display: table-header-group">
          <tr
            style="
              margin: 0;
              background: #fcbd021f;
              padding: 15px;
              padding-left: 20px;
              -webkit-print-color-adjust: exact;
            "
          >
            <td colspan="4">
            <p>Scheme</p>
              </h3>
            </td>
            <td colspan="2">
              <p>Category</p>
            </td>
            <td colspan="2">
              <p>
                Plot-No |  SQFT 
              </p>
            </td>
            <td colspan="4">
              <p>Booking Date</p>
            </td>
          </tr>
          @if(!empty($allocation))
          @foreach($allocation as $key => $allo)
          <tr>
            <td colspan="4">{{$allo->scheme}}</td>
            <td colspan="2">{{$allo->category_name}}</td>
            <td colspan="2">{{$allo->plot_number}} | {{$allo->size}}</td>
            <td colspan="4">{{$allo->bdate}}</td>
          </tr>
          @endforeach
          @endif
    </table>
    <table border id="data-table" class="table table-bordered h4-14" style="width: 100%; margin-top: 15px">
          <tr>
            <th style="widt:200px">#</th>
            <th style="">Date</th>
            <th style=""> Receipt No</th>
            <th style=""> Amount </th>
            <!-- <th style=""> Narration</th> -->
          </tr>
        </thead>
        <tbody>
          @if(!empty($ledgers))
          @foreach($ledgers as $key => $ledger)
          <tr>

             <td>{{++$key}}</td>
            <td>{{$ledger->paydate}}</td>
            <td>{{$ledger->receipt_id}}</td>
            <td>{{$ledger->amount}}</td>
            <!-- <td>{{$ledger->narration}}</td> -->
          </tr>
          @endforeach
          @endif
        </tbody>
        <tfoot></tfoot>
      </table>

    
      <!-- <table class="hm-p table-bordered" style="width: 100%; margin-top: 30px">
        <tr>
          <th style="width: 400px">
            <p>Payment Mode:</p>
            <p>COD:</p>
            <p>Deerika Cashback:</p>
          </th>
          <td style="width: 100px; border-right: none">
            <p>&nbsp;</p>
            <p style="text-align: right"><b>1199</b></p>
            <p style="text-align: right"><b>90</b></p>
          </td>
          <td colspan="5" style="border-left: none"></td>
        </tr>
        <tr style="background: #fcbd02">
          <th>Total Order Value</th>
          <td style="width: 70px; text-align: right; border-right: none">
            <b>1289</b>
          </td>
          <td colspan="5" style="border-left: none"></td>
        </tr>
      </table> -->

     
    </section>
  </body>


  <script>
        function printReceipt() {
            window.print();
        }
    
        window.onload = function() {
            printReceipt();
        };
    
        window.onafterprint = function() {
            window.location.href = "{{ route('allote.ledger') }}";
        };
    </script>
</html>



