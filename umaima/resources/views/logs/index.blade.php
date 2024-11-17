@extends('layout.app')
<?php $breadCrumb='  <span class="text-primary">Logs</span></i>'?>
@section('title', 'Home Page')
@section('content')
      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        
          <div class="container-xxl flex-grow-1 container-p-y">
            
  
<!-- Order List Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <!-- <table class="datatables-order table border-top"> -->
    <table class=" table border-top">
      <thead>
        <tr>
          <th>Log id</th>
          <th>User</th>
          <th>Action</th>
          <th>Detail</th>
          <th>Ip</th>
          <th>Created at</th>
        </tr>
      </thead>
      <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->user_id ?? 'System' }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->details }}</td>
                    <td>{{ $log->ip_address }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
    <script src="../../assets/js/main.js"></script>
    

    <!-- Page JS -->
    <script src="../../assets/js/app-ecommerce-order-list.js"></script>
    
    @endsection