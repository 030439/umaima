@extends('layout.app')
<?php $breadCrumb='Allote / <span class="text-primary">Plots</span></i>'?>
@section('title', 'Scheme Plot')
@section('content')
<div class="content-wrapper">
<span id="pid" title="<?php echo $pid?>"></span>
<!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- <div class="row mb-5">
        <div class="col-lg-3 col-sm-6">
            <div class="card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">
                <h5 class="mb-1 me-2">86%</h5>
                <p class="mb-0">CPU Usage</p>
                </div>
                <div class="card-icon">
                <span class="badge bg-label-primary rounded p-2">
                    <i class='ti ti-cpu ti-26px'></i>
                </span>
                </div>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">
                <h5 class="mb-1 me-2">1.24gb</h5>
                <p class="mb-0">Memory Usage</p>
                </div>
                <div class="card-icon">
                <span class="badge bg-label-success rounded p-2">
                    <i class='ti ti-server ti-26px'></i>
                </span>
                </div>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">
                <h5 class="mb-1 me-2">0.2%</h5>
                <p class="mb-0">Downtime Ratio</p>
                </div>
                <div class="card-icon">
                <span class="badge bg-label-danger rounded p-2">
                    <i class='ti ti-chart-pie-2 ti-26px'></i>
                </span>
                </div>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">
                <h5 class="mb-1 me-2">128</h5>
                <p class="mb-0">Issues Found</p>
                </div>
                <div class="card-icon">
                <span class="badge bg-label-warning rounded p-2">
                    <i class='ti ti-alert-octagon ti-26px'></i>
                </span>
                </div>
            </div>
            </div>
        </div>
    </div> -->
   
      <div class="card">
        <div class="card-datatable table-responsive">
                <table class="datatables-users table dataTable no-footer collapsed">
                  <!-- <thead class="border-top">
                    <tr>
                      <th>Payment</th>
                      <th>Due Amount</th>
                      <th>Due Date</th>
                      <th>Amount Paid</th>
                      <th>Paid On</th>
                      <th>Outstanding</th>
                      <th>Surcharge</th>
                    </tr>
                  </thead> -->
                    <tfoot class="bg-info" id="footer-total">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
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

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>
    

    <!-- Page JS -->
    <script src="../../assets/js/allote-plot-payments.js"></script>
@endsection
          