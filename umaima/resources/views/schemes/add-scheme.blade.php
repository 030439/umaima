@extends('layout.app')

@section('title', 'Home Page')
@section('content')
 <div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">
    

<div class="row">
<!-- FormValidation -->
<div class="col-12">
<div class="card">
<h5 class="card-header">Create Scheme</h5>
<div class="card-body">

<form id="formValidationExamples" class="row g-6">

  <div class="col-md-6">
    <label class="form-label" for="formValidationName">Scheme Name</label>
    <input type="text" id="formValidationName" class="form-control" placeholder="scheme name " name="formValidationName" />
  </div>
  <div class="col-md-6">
    <label class="form-label" for="formValidationEmail">Area</label>
    <input class="form-control" type="number" id="formValidationEmail" name="formValidationEmail" placeholder="scheme area" />
  </div>

  <div class="col-md-6">
    <div class="form-password-toggle">
      <label class="form-label" for="formValidationPass">No Plot</label>
      <div class="input-group input-group-merge">
        <input class="form-control" type="number" id="formValidationPass" name="formValidationPass" placeholder="number of plots"   />
       
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-password-toggle">
      <label class="form-label" for="formValidationConfirmPass">Total Valuation</label>
      <div class="input-group input-group-merge">
        <input class="form-control" type="password" id="formValidationConfirmPass" name="formValidationConfirmPass" placeholder="total valuation" />
        
      </div>
    </div>
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
<script src="../../assets/vendor/libs/moment/moment.js"></script>
<script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="../../assets/vendor/libs/tagify/tagify.js"></script>
<script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
<script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
<script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>

<!-- Main JS -->
<script src="../../assets/js/main.js"></script>


<!-- Page JS -->
<script src="../../assets/js/form-validation.js"></script>
@endsection