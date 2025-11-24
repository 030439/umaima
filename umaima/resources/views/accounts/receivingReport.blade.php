@extends('layout.app')
<?php $breadCrumb='Cashbook / <span class="text-primary"> Cashbook</span></i>'?>
@section('title', 'Cashbook')
@section('content')
  
<!-- / Navbar -->
      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
          <!-- Product List Table -->
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Filter</h5>
              <div class="d-flex justify-content-between align-items-center row pt-4 gap-6 gap-md-0">
                  <div class="col-md-3">
                      <label for="flatpickr-date" class="form-label">Scheme </label>
                      <select id="paymentType" class="form-select">
                          @foreach($schemes as $scheme)
                              <option value="{{ $scheme->id }}">{{ $scheme->scheme }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-md-3">
                      <label for="flatpickr-date" class="form-label">From Date </label>
                      <input type="date" class="form-control" placeholder="YYYY-MM-DD" id="fromdate">
                  </div>
                  <div class="col-md-3">
                      <label for="flatpickr-date" class="form-label">To Date</label>
                      <input type="date" class="form-control" placeholder="YYYY-MM-DD" id="todate">
                  </div>
                 
                  <div class="col-md-3 mt-1">
                    <button class="btn btn-primary mt-4" id="ledgerPrint" onclick="ledgerPrint()">View</button>
                    <button class="btn btn-primary mt-4" id="ledgerPrintBtn" onclick="ledgerPrintRes()">Print</button>
                  </div>
              </div>
               <div class="row">
                    <div class="col-10"></div>
                    <div class="col-2"></div>
                  </div>
            </div>
          <div class="card">
            <div id="result"></div>
          </div>
  
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
<script src="../../assets/vendor/libs/moment/moment.js"></script>
<script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="../../assets/vendor/libs/select2/select2.js"></script>


<!-- Main JS -->

<script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script> 
<script src="../../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="../../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<script src="../../assets/vendor/libs/jquery-timepicker/jquery-timepicker.js"></script>
<script src="../../assets/vendor/libs/pickr/pickr.js"></script>

<!-- Main JS -->

<script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script src="../../assets/js/extended-ui-sweetalert2.js"></script>

<!-- Page JS -->
<script src="../../assets/js/forms-pickers.js"></script>

<!-- Page JS -->
<script src="../../assets/js/receiving-report.js"></script>

<script src="../../assets/js/main.js"></script>

<script>
 
@endsection

