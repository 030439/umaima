@extends('layout.app')
<?php $breadCrumb='Banks / <span class="text-primary">List</span></i>'?>
@section('title', 'Banks list')
@section('content')
<div class="content-wrapper">

<!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    
    

      <!-- Users List Table -->
      <div class="card">
        
        <div class="card-datatable table-responsive">
                <table class="datatables-users table dataTable no-footer collapsed">
                  <thead class="border-top">
                    <tr>
                      <th> Bank</th>
                      <th>Branch</th>
                      <th>Account-Holder</th>
                      <th>Account-No</th>
                      <th>Initial-Balance</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

      </div>


  </div>
          
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
  <script src="../../assets/vendor/libs/moment/moment.js"></script>
  <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
  <script src="../../assets/vendor/libs/select2/select2.js"></script>
  <script src="../../assets/vendor/libs/%40form-validation/popular.js"></script>
  <script src="../../assets/vendor/libs/%40form-validation/bootstrap5.js"></script>
  <script src="../../assets/vendor/libs/%40form-validation/auto-focus.js"></script>
  <script src="../../assets/vendor/libs/cleavejs/cleave.js"></script>
  <script src="../../assets/vendor/libs/cleavejs/cleave-phone.js"></script>
   <script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>
    <!-- Page JS -->
    <script src="../../assets/js/extended-ui-sweetalert2.js"></script>
    <script src="../../assets/js/app-bank-list.js"></script>
    <script src="../../assets/js/custom.js"></script>
@endsection
          