@extends('layout.app')
<?php $breadCrumb='Plots / <span class="text-primary">Allotemnt</span></i>'?>
@section('title', 'plot Allotement')
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
        <div class="card-header px-0 pt-3">
            <div class="nav-align-top">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link waves-effect active" data-bs-toggle="tab" data-bs-target="#form-tabs-personal" aria-controls="form-tabs-personal" role="tab" aria-selected="true"><span class="ti ti-user ti-lg d-sm-none"></span><span class="d-none d-sm-block">Allote Info</span></button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link waves-effect" data-bs-toggle="tab" data-bs-target="#form-tabs-account" aria-controls="form-tabs-account" role="tab" aria-selected="false" tabindex="-1"><span class="ti ti-user-cog ti-lg d-sm-none"></span><span class="d-none d-sm-block">Property Details</span></button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link waves-effect" data-bs-toggle="tab" data-bs-target="#form-tabs-social" aria-controls="form-tabs-social" role="tab" aria-selected="false" tabindex="-1"><span class="ti ti-link ti-lg d-sm-none"></span><span class="d-none d-sm-block">Payments Schedule</span></button>
                </li>
                <li class="nav-item" role="presentation">
                <button id="actionButton" type="submit"disabled  class="nav-link waves-effect" data-bs-toggle="tab" data-bs-target="#form-tabs-detail" aria-controls="form-tabs-social" role="tab" aria-selected="false" tabindex="-1"><span class="ti ti-link ti-lg d-sm-none"></span><span class="d-none d-sm-block">Payments Details</span></button>
                </li>
              </ul>
            </div>
          </div>

          <div class="card-body">
            <form id="checkSchedule" class="row g-6"  onsubmit="return false">
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
                      <input type="text" id="category" class="form-control" tag="John Doe" name="category" readonly>
                      <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                    </div>
                    <div class="col-6 fv-plugins-icon-container">
                      <label class="form-label" for="cat">Sub Category</label>
                      <input type="text" id="cat" class="form-control" tag="plot sub cat" name="cat" readonly>
                      <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                    </div>
                   
                    <div class="col-md-6 fv-plugins-icon-container">
                      <label class="form-label" for="location">Location</label>
                      <input type="text" id="location" class="form-control" tag="John Doe" name="location" readonly>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    
                    <div class="col-md-6 fv-plugins-icon-container">
                      <label class="form-label" for="plot-size">Plot Size</label>
                      <input type="text" id="plot-size" class="form-control" tag="John Doe" name="plot-size" readonly>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                  
                      
                  </div>
              
                </div>
                <!-- Paymenys Schedule -->
                <div class="tab-pane fade" id="form-tabs-social" role="tabpanel">
                
                    <div class="row g-6">
                      <div class="col-sm-6">
                        <label class="form-label" for="alignment-birthdate">Booking Date</label>
                        <input type="date" id="alignment-birthdate" class="form-control" name="bdate" placeholder="YYYY-MM-DD">
                      </div>
                      
                      <div class="col-sm-6">
                        <label class="form-label" for="onbooking">On Booking</label>
                        <input type="number" id="onbooking" name="onbooking" class="form-control" tag="10000" />
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="allocation">Allocation </label>
                        <input type="number" id="allocation" name="allocation" class="form-control" tag="10000" />
                      </div>
                    
                      <div class="col-sm-6">
                        <label class="form-label" for="confirmation">Confirmation </label>
                        <input type="number" id="confirmation" name="confirmation" class="form-control" tag="10000" />
                      </div>
                      <div class="col-6">
                        <label class="form-label" for="installment">installment</label>
                        <select id="installment" name="installment" class="form-select select2" data-allow-clear="true">
                          <option value="">Select</option>
                        </select>
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="installment_amount">Amount</label>
                        <input type="number" id="installment_amount" name="installment_amount" class="form-control" tag="John" />
                      </div>
                      <div class="col-6">
                          <label class="form-label" for="duration">Mid Pay Durations</label>
                          <select id="duration" name="duration" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                          </select>
                        </div>
                        <div class="col-sm-6">
                        <label class="form-label" for="duration_amount">Amount</label>
                        <input type="number" id="duration_amount" name="duration_amount" class="form-control" tag="John" />
                      </div>
                      <div class="col-6">
                          <label class="form-label" for="extra">Extra Charges</label>
                          <select id="extra" name="extra" class="form-select select2" data-allow-clear="true">
                            <option value="">Select</option>
                            <option value="corner">Corner</option>
                            <option value="west">West Open</option>
                            <option value="road">Road Facing</option>
                          </select>
                        </div>
                        <div class="col-sm-6">
                        <label class="form-label" for="percentage">Percentage</label>
                        <input type="number" id="percentage" name="percentage" class="form-control" tag="0.5" />
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="possession">Possession </label>
                        <input type="number" id="possession" name="possession" class="form-control" tag="10000" />
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="demargation">Demargation </label>
                        <input type="number" id="demargation" name="demargation" class="form-control" tag="10000" />
                      </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="form-tabs-detail" role="tabpanel">
                  <div class="row">
                    <div class="col-12">
                    <table class="table table-bordered mt-4" id="table-detail">
                          <thead>
                              <tr>
                                  <th>Payments</th>
                                  <th>Due Amount</th>
                                  <th>Due Date </th>
                                  <!-- Add more headers as per your data structure -->
                              </tr>
                          </thead>
                          <tbody id="paymentDetailsTableBody">
                      
                          </tbody>
                          <tfoot>
                            <tr>
                              <td  class="text-end"><strong>Total Amount:</strong></td>
                              <td id="totalPlots">0</td>
                              <td> <div class="col-12">
                              <button id="confirm-btn" class="btn btn-primary waves-effect waves-light">Confirm</button>
                            </div></td>
                            </tr>
                          </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </form>
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
<script src="../../assets/vendor/libs/moment/moment.js"></script>
<script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script src="../../assets/vendor/libs/select2/select2.js"></script>
<script src="../../assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>

<script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="../../assets/vendor/libs/tagify/tagify.js"></script>
<script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
<script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
<script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>

<script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

<!-- Main JS -->
<script src="../../assets/js/main.js"></script>


<!-- Page JS -->
<script src="../../assets/js/extended-ui-sweetalert2.js"></script>



<!-- Page JS -->
<script src="../../assets/js/form-validation.js"></script>
<script>
    $(document).ready(function(){ 
            // Initialize select2
                $("#allote").select2();
            });
</script>
@endsection

