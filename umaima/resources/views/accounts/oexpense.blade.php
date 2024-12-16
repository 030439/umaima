@extends('layout.app')
<?php $breadCrumb='Expenses / <span class="text-primary">Expense Heads</span></i>'?>
@section('title', 'Expense-head')
@section('content')
   


<!-- / Navbar -->

      

      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        
          <div class="container-xxl flex-grow-1 container-p-y">
            


<!-- Product List Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
        <div class="card-header d-flex border-top rounded-0 flex-wrap py-0 flex-column flex-md-row align-items-start">
        <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
          </div></div></div>
          <table class="table table-borderless border-top">
          <thead class="border-bottom">
            <tr>
              <th>Payment Date</th>
              <th>Allote</th>
              <th>Account</th>
              <th>Amount</th>
              <th>Narration</th>
            </tr>
          </thead>
          <tbody>

            <tr>
              <td>
                <p class="mb-0 text-heading">{{$payment->pdate}}</p>
              </td>
              <td>
                <p class="mb-0 text-heading">{{$payment->allote}}</p>
              </td>
              <td>
                <p class="mb-0 text-heading">{{$payment->account}}</p>
              </td>
              <td>
                <p class="mb-0 text-heading">{{$payment->amount}}</p>
              </td>
              <td>
                <p class="mb-0 text-heading">{{$payment->narration}}</p>
              </td>
            </tr>
          </tbody>
        </table>
        </div>
  </div>
</div>


          </div>
          <!-- / Content -->

          @endsection 
  

    
@section('files')

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

<script src="../../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../../assets/vendor/libs/popper/popper.js"></script>
<script src="../../assets/vendor/js/bootstrap.js"></script>
  <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../../assets/vendor/libs/hammer/hammer.js"></script>
<script src="../../assets/vendor/libs/i18n/i18n.js"></script>
<script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="../../assets/vendor/js/menu.js"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

<!-- Main JS -->
<script src="../../assets/vendor/libs/moment/moment.js"></script>
<script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script> 
<script src="../../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="../../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<script src="../../assets/vendor/libs/jquery-timepicker/jquery-timepicker.js"></script>
<script src="../../assets/vendor/libs/pickr/pickr.js"></script>

<!-- Main JS -->
<script src="../../assets/js/main.js"></script>


<!-- Page JS -->
<script src="../../assets/js/forms-pickers.js"></script>

<!-- Page JS -->
<script src="../../assets/js/app-ecommerce-product-list.js"></script>
@endsection

