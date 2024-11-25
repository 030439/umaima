@extends('layout.app')
<?php $breadCrumb='Expenses / <span class="text-primary">Expense Heads</span></i>'?>
@section('title', 'Expense-head')
@section('content')
   


<!-- / Navbar -->

      

      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        
          <div class="container-xxl flex-grow-1 container-p-y">
            
            
<!-- Product List Widget -->
<div class="card mb-6">
  <div class="card-widget-separator-wrapper">
    <div class="card-body card-widget-separator">
      <div class="row gy-4 gy-sm-1">
        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1">In-store Sales</p>
              <h4 class="mb-1">$5,345.43</h4>
              <p class="mb-0"><span class="me-2">5k orders</span><span class="badge bg-label-success">+5.7%</span></p>
            </div>
            <span class="avatar me-sm-6">
              <span class="avatar-initial rounded"><i class="ti-28px ti ti-smart-home text-heading"></i></span>
            </span>
          </div>
          <hr class="d-none d-sm-block d-lg-none me-6">
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1">Website Sales</p>
              <h4 class="mb-1">$674,347.12</h4>
              <p class="mb-0"><span class="me-2">21k orders</span><span class="badge bg-label-success">+12.4%</span></p>
            </div>
            <span class="avatar p-2 me-lg-6">
              <span class="avatar-initial rounded"><i class="ti-28px ti ti-device-laptop text-heading"></i></span>
            </span>
          </div>
          <hr class="d-none d-sm-block d-lg-none">
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
            <div>
              <p class="mb-1">Discount</p>
              <h4 class="mb-1">$14,235.12</h4>
              <p class="mb-0">6k orders</p>
            </div>
            <span class="avatar p-2 me-sm-6">
              <span class="avatar-initial rounded"><i class="ti-28px ti ti-gift text-heading"></i></span>
            </span>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="mb-1">Affiliate</p>
              <h4 class="mb-1">$8,345.23</h4>
              <p class="mb-0"><span class="me-2">150 orders</span><span class="badge bg-label-danger">-3.5%</span></p>
            </div>
            <span class="avatar p-2">
              <span class="avatar-initial rounded"><i class="ti-28px ti ti-wallet text-heading"></i></span>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Product List Table -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title">Filter</h5>
    <div class="d-flex justify-content-between align-items-center row pt-4 gap-6 gap-md-0">
        <div class="col-md-4">
            <select id="paymentType" class="form-select">
                <option value="">Filter By Payement Type</option>
                <option value="1">Received </option>
                <option value="2">Payment</option>
            </select>
        </div>
        <div class="col-md-4">
            <select id="subcat" class="form-select text-capitalize">
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control flatpickr-input" placeholder="YYYY-MM-DD to YYYY-MM-DD" id="flatpickr-range" readonly="readonly">
        </div>
    </div>
  </div>
  <div class="card-datatable table-responsive">
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer"><div class="card-header d-flex border-top rounded-0 flex-wrap py-0 flex-column flex-md-row align-items-start"><div class="me-5 ms-n4 pe-5 mb-n6 mb-md-0">
</div>
        <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
          </div></div></div>
            <table class="datatables-products table dataTable no-footer dtr-column collapsed" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 958px;">
                
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

