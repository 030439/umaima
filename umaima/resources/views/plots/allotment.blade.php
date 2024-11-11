@extends('layout.app')

@section('title', 'Home Page')
@section('content')

      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        
          <div class="container-xxl flex-grow-1 container-p-y">
            
            

<div class="row">
  <!-- FormValidation -->
  <div class="col-12">
    <div class="card">
      <h5 class="card-header">FormValidation</h5>
      <div class="card-body">

        <form id="formValidationExamples" class="row g-6">

          <!-- Account Details -->
          <div class="col-12">
            <h6>1. Account Details</h6>
            <hr class="mt-0">
          </div>

          <div class="col-md-12">
            <label class="form-label" for="allote">Allote</label>
            <select id="allote" name="allote" class="form-select select2" data-allow-clear="true">
              <option value="">Select</option>
            </select>
          </div>


          <!-- Personal Info -->

          <div class="col-12">
            <h6 class="mt-2">2. Personal Info</h6>
            <hr class="mt-0" />
          </div>

          

          <div class="col-md-6">
            <label class="form-label" for="scheme">Scheme</label>
            <select id="scheme" name="scheme" class="form-select select2" data-allow-clear="true">
              <option value="">Select</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="plot">Plot</label>
            <select id="plot" name="plot" class="form-select select2" data-allow-clear="true">
              <option value="">Select</option>
            </select>
          </div>

          <div class="col-md-6 fv-plugins-icon-container">
            <label class="form-label" for="category">Category</label>
            <input type="text" id="category" class="form-control" placeholder="John Doe" name="category">
          <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
          <div class="col-md-6 fv-plugins-icon-container">
            <label class="form-label" for="location">Location</label>
            <input type="text" id="location" class="form-control" placeholder="John Doe" name="location">
          <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
          <div class="col-md-6 fv-plugins-icon-container">
            <label class="form-label" for="plot-size">Plot Size</label>
            <input type="text" id="plot-size" class="form-control" placeholder="John Doe" name="plot-size">
          <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
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

