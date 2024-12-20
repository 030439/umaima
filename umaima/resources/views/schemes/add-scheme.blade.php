@extends('layout.app')
<?php $breadCrumb=' Scheme / <span class="text-primary">Create</span></i>'?>
@section('title', 'create-scheme')
@section('content')
 <div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">
    
  <style>
      /* Error messages hidden by default */
      .invalid-feedbacks {
        display: none;
        color: #ff4d4f; /* Red color for error messages */
        font-size: 0.875em;
      }

      /* Highlight invalid fields */
      .is-invalid {
        border-color: #ff4d4f;
      }
  </style>
<div class="row">
<!-- FormValidation -->
<div class="col-12">
<div class="card">
<h5 class="card-header">Create Scheme</h5>
<div class="card-body">

<form id="schemeForm" class="row g-6" onsubmit="return false">
  <div class="col-md-6">
    <label class="form-label" for="schemeName">Scheme Name</label>
    <input type="text" id="schemeName" class="form-control" tag="Scheme name" name="schemeName" />
    <div class="invalid-feedback"></div>
  </div>
  
  <div class="col-md-6">
    <label class="form-label" for="schemeArea">Area</label>
    <input class="form-control" type="number" id="schemeArea" name="schemeArea" tag="Scheme area" />
  </div>

  <div class="col-md-6">
    <label class="form-label" for="numberOfPlots">No. of Plots</label>
    <input class="form-control" type="number" id="numberOfPlots" name="numberOfPlots" tag="Number of plots" />
  </div>

  <div class="col-md-6">
    <label class="form-label" for="totalValuation">Total Valuation</label>
    <input class="form-control" type="number" id="totalValuation" name="totalValuation" tag="Total valuation" />
  </div>

  <div class="col-12">
    <button type="submit" name="submitButton" class="btn btn-primary">Submit</button>
  </div>
</form>

</div>
</div>
</div>
<!-- /FormValidation -->
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
<script src="../../assets/vendor/libs/select2/select2.js"></script>
<script src="../../assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
<script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="../../assets/vendor/libs/tagify/tagify.js"></script>
<script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
<script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
<script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>

<!-- Main JS -->
<script src="../../assets/js/main.js"></script>
<script src="../../assets/js/app-scheme-list.js"></script>


@endsection