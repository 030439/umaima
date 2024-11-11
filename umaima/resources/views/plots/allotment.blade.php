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
    <div class="">
      <div class="">
      <div class="col">
    <div class="card mb-6">


      <div class="card-body">
        <div class="tab-content p-0">
          <!-- Personal Info -->
          <div class="tab-pane fade active show" id="form-tabs-personal" role="tabpanel">
     
              <div class="row g-6">
                <div class="col-md-12">
                    <label class="form-label" for="allote">Allote</label>
                    <select id="allote" name="allote" class="form-select select2" data-allow-clear="true">
                    <option value="">Select</option>
                    </select>
                </div>
              </div>
         
          </div>
          <!-- Account Details -->
          <div class="tab-pane fade" id="form-tabs-account" role="tabpanel">
         
          <div class="row">
          <div class="col-6">
            <label class="form-label" for="scheme">Scheme</label>
            <select id="scheme" name="scheme" class="form-select select2" data-allow-clear="true">
              <option value="">Select</option>
            </select>
          </div>
          <div class="col-6">
            <label class="form-label" for="plot">Plot</label>
            <select id="plot" name="plot" class="form-select select2" data-allow-clear="true">
              <option value="">Select</option>
            </select>
          </div>

          <div class="col-6 fv-plugins-icon-container">
            <label class="form-label" for="category">Category</label>
            <input type="text" id="category" class="form-control" placeholder="John Doe" name="category" readonly>
          <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
          <div class="col-md-6 fv-plugins-icon-container">
            <label class="form-label" for="location">Location</label>
            <input type="text" id="location" class="form-control" placeholder="John Doe" name="location" readonly>
          <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
          <div class="col-md-6 fv-plugins-icon-container">
            <label class="form-label" for="plot-size">Plot Size</label>
            <input type="text" id="plot-size" class="form-control" placeholder="John Doe" name="plot-size" readonly>
          <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
          
              
          </div>
        
          </div>
          <!-- Social Links -->
          <div class="tab-pane fade" id="form-tabs-social" role="tabpanel">
          
              <div class="row g-6">
                <div class="col-md-6">
                  <div class="row">
                    <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-twitter">Twitter</label>
                    <div class="col-sm-9">
                      <input type="text" id="formtabs-twitter" class="form-control" placeholder="https://twitter.com/abc">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-facebook">Facebook</label>
                    <div class="col-sm-9">
                      <input type="text" id="formtabs-facebook" class="form-control" placeholder="https://facebook.com/abc">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-google">Google+</label>
                    <div class="col-sm-9">
                      <input type="text" id="formtabs-google" class="form-control" placeholder="https://plus.google.com/abc">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-linkedin">Linkedin</label>
                    <div class="col-sm-9">
                      <input type="text" id="formtabs-linkedin" class="form-control" placeholder="https://linkedin.com/abc">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-instagram">Instagram</label>
                    <div class="col-sm-9">
                      <input type="text" id="formtabs-instagram" class="form-control" placeholder="https://instagram.com/abc">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-quora">Quora</label>
                    <div class="col-sm-9">
                      <input type="text" id="formtabs-quora" class="form-control" placeholder="https://quora.com/abc">
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="card-header px-0 pt-0">
        <div class="nav-align-top">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button type="button" class="nav-link waves-effect active" data-bs-toggle="tab" data-bs-target="#form-tabs-personal" aria-controls="form-tabs-personal" role="tab" aria-selected="true"><span class="ti ti-user ti-lg d-sm-none"></span><span class="d-none d-sm-block">Personal Info</span></button>
            </li>
            <li class="nav-item" role="presentation">
              <button type="button" class="nav-link waves-effect" data-bs-toggle="tab" data-bs-target="#form-tabs-account" aria-controls="form-tabs-account" role="tab" aria-selected="false" tabindex="-1"><span class="ti ti-user-cog ti-lg d-sm-none"></span><span class="d-none d-sm-block">Account Details</span></button>
            </li>
            <li class="nav-item" role="presentation">
              <button type="button" class="nav-link waves-effect" data-bs-toggle="tab" data-bs-target="#form-tabs-social" aria-controls="form-tabs-social" role="tab" aria-selected="false" tabindex="-1"><span class="ti ti-link ti-lg d-sm-none"></span><span class="d-none d-sm-block">Social Links</span></button>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
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

