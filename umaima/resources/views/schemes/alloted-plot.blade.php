@extends('layout.app')
<?php $breadCrumb='Scheme / '.$scheme->scheme.' / <span class="text-primary">Alloted Plots</span></i>'?>
@section('title', 'Scheme Plot')
@section('content')
<div class="content-wrapper">

<!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-3">
        <!-- Cards with few info -->
        <div class="col-lg-3 col-sm-6">
            <div class="card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">
                <h5 class="mb-1 me-2">{{$scheme->no_of_plots}}</h5>
                <p class="mb-0">Total Plots</p>
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
                <a href="/alloted-plots/scheme/{{$sid}}">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                        <h5 class="mb-1 me-2">{{$scheme->vacant}}</h5>
                        <p class="mb-0">Alloted plots</p>
                        </div>
                        <div class="card-icon">
                        <span class="badge bg-label-success rounded p-2">
                            <i class='ti ti-server ti-26px'></i>
                        </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">
                <h5 class="mb-1 me-2">{{$scheme->allotted}}</h5>
                <p class="mb-0">Vacant Plots</p>
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
    </div>
      <div class="card">
        <div class="card-datatable table-responsive">
                <table class="datatables-users table dataTable no-footer collapsed">
                 
                </table>
              </div>
            </div>
      </div>
  </div>
  <span id="sid" title="{{$sid}}"></span>
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
    <script src="../../assets/js/scheme-wise-alloted-plots.js"></script>
@endsection
          