@extends('layout.app')
<?php $breadCrumb=' <span class="text-primary"></span></i>'?>
@section('title', 'Home Page')
@section('content')
 <!-- Content wrapper -->
 <div class="content-wrapper">

<!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    
    
<div class="row g-6">

<!-- Sales last year -->
<div class="col-xxl-2 col-md-4 col-sm-6">
<div class="card h-100">
<div class="card-header pb-3">
<h5 class="card-title mb-1">Order</h5>
<p class="card-subtitle">Last week</p>
</div>
<div class="card-body">
<div id="ordersLastWeek"></div>
<div class="d-flex justify-content-between align-items-center gap-3">
  <h4 class="mb-0">124k</h4>
  <small class="text-success">+12.6%</small>
</div>
</div>
</div>
</div>

<!-- Sessions Last month -->
<div class="col-xxl-2 col-md-4 col-sm-6">
<div class="card h-100">
<div class="card-header pb-0">
<h5 class="card-title mb-1">Sales</h5>
<p class="card-subtitle">Last Year</p>
</div>
<div id="salesLastYear"></div>
<div class="card-body pt-0">
<div class="d-flex justify-content-between align-items-center mt-3 gap-3">
  <h4 class="mb-0">175k</h4>
  <small class="text-danger">-16.2%</small>
</div>
</div>
</div>
</div>

<!-- Total Profit -->
<div class="col-xxl-2 col-md-4 col-6">
<div class="card h-100">
<div class="card-body">
<div class="badge p-2 bg-label-danger mb-3 rounded"><i class="ti ti-credit-card ti-28px"></i></div>
<h5 class="card-title mb-1">Total Profit</h5>
<p class="card-subtitle ">Last week</p>
<p class="text-heading mb-3 mt-1">1.28k</p>
<div>
  <span class="badge bg-label-danger">-12.2%</span>
</div>
</div>
</div>
</div>

<!-- Total Sales -->


<!-- Revenue Growth -->






<!-- Sales By Country -->




<!--/ Activity Timeline -->
</div>

  </div>
  <!-- / Content -->

  
  

@endsection
@section('files')
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
    <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>
    

    <!-- Page JS -->
    <script src="../../assets/js/dashboards-crm.js"></script>

@endsection
