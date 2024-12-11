@extends('layout.app')
<?php $breadCrumb='Allote / <span class="text-primary">Add</span></i>'?>
@section('title', 'Home Page')
@section('content')
{{dd($allote)}}
      <div class="content-wrapper">

        <!-- Content -->
        
          <div class="container-xxl flex-grow-1 container-p-y">
            
            
<!-- Default -->
<div class="row">


  <!-- Validation Wizard -->
  <div class="col-12 mb-6">
    <div id="wizard-validation" class="bs-stepper mt-2">
      <div class="bs-stepper-header">
        <div class="step" data-target="#account-details-validation">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">1</span>
            <span class="bs-stepper-label mt-1">
              <span class="bs-stepper-title">Account Details</span>
              <span class="bs-stepper-subtitle">Setup Account Details</span>
            </span>
          </button>
        </div>
        <div class="line">
          <i class="ti ti-chevron-right"></i>
        </div>
        <div class="step" data-target="#personal-info-validation">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">2</span>
            <span class="bs-stepper-label">
              <span class="bs-stepper-title">Personal Info</span>
              <span class="bs-stepper-subtitle">Add personal info</span>
            </span>
          </button>
        </div>
        <div class="line">
          <i class="ti ti-chevron-right"></i>
        </div>
        <div class="step" data-target="#social-links-validation">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-circle">3</span>
            <span class="bs-stepper-label">
              <span class="bs-stepper-title">Social Links</span>
              <span class="bs-stepper-subtitle">Add social links</span>
            </span>
          </button>
        </div>
      </div>
      <div class="bs-stepper-content">
        <form id="wizard-validation-form" onSubmit="return false" method="post" action="{{route('allote.create')}}">
          @csrf
          <!-- Account Details -->
          <div id="account-details-validation" class="content">
            <div class="content-header mb-4">
              <h6 class="mb-0">Account Details</h6>
              <small>Enter  Account Details.</small>
            </div>
            <div class="row g-6">
              <div class="col-sm-6">
                <label class="form-label" for="formValidationUsername">Username</label>
                <input type="text" name="formValidationUsername" id="formValidationUsername" class="form-control" placeholder="johndoe" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="formValidationEmail">Email</label>
                <input type="email" name="formValidationEmail" id="formValidationEmail" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
              </div>
              <div class="col-sm-6 form-password-toggle">
                <label class="form-label" for="formValidationcell">Cell No</label>
                <div class="input-group input-group-merge">
                  <input type="number" id="formValidationcell" name="formValidationcell" class="form-control" aria-describedby="formValidationPass2" />
                </div>
              </div>
              <div class="col-sm-6 form-password-toggle">
                <label class="form-label" for="formValidationoffice">Phone No:Office </label>
                <div class="input-group input-group-merge">
                  <input type="number" id="" name="formValidationoffice" class="form-control"   />
                 
                </div>
              </div>
              <div class="col-12 d-flex justify-content-between">
                <button class="btn btn-label-secondary btn-prev" disabled> <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                  <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button>
                <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span> <i class="ti ti-arrow-right ti-xs"></i></button>
              </div>
            </div>
          </div>
          <!-- Personal Info -->
          <div id="personal-info-validation" class="content">
            <div class="content-header mb-4">
              <h6 class="mb-0">Personal Info</h6>
              <small>Enter  Personal Info.</small>
            </div>
            <div class="row g-6">
              <div class="col-sm-6">
                <label class="form-label" for="formValidationFirstName">Full Name</label>
                <input type="text" id="formValidationFirstName" name="formValidationFirstName" class="form-control" placeholder="John" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="formValidationLastName">CNIC </label>
                <input type="text" id="formValidationLastName" name="formValidationLastName" class="form-control" placeholder="Doe" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="formValidationFirstName">Father's/Husband Name</label>
                <input type="text" id="formValidationFirstName" name="father" class="form-control" placeholder="John" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="formValidationLastName">CNIC </label>
                <input type="text" id="formValidationLastName" name="fcnic" class="form-control" placeholder="Doe" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="formValidation">Guardian Name</label>
                <input type="text" id="formValidation" name="guardian" class="form-control" placeholder="John" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="formValidation">CNIC </label>
                <input type="text" id="formValidation" name="gcnic" class="form-control" placeholder="Doe" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="formValidationOccupation">Occupation </label>
                <input type="text" id="formValidationOccupation" name="occupation" class="form-control" placeholder="Doe" />
              </div>
              <div class="col-md-6">
                <label class="form-label" for="multicol-birthdate">Birth Date</label>
                <input type="text" name="dob" id="multicol-birthdate" class="form-control dob-picker flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">
              </div>
              
              
              <div class="col-12 d-flex justify-content-between">
                <button class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                  <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button>
                <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span> <i class="ti ti-arrow-right ti-xs"></i></button>
              </div>
            </div>
          </div>
          <!-- Social Links -->
          <div id="social-links-validation" class="content">
            <div class="content-header mb-4">
              <h6 class="mb-0">Residentail Details </h6>
            </div>
            <div class="row g-6">
             
             
            
            <div class="col-sm-6">
                <label class="form-label" for="formValidationLastName">Nationality </label>
                <input type="text" id="formValidationGoogle" name="nationality" class="form-control" placeholder="Doe" />
              </div>
              <!-- <div class="col-sm-6">
                <label class="form-label" for="formValidationLastName">Occupation </label>
                <input type="text" id="formValidationLastName" name="formValidationLastName" class="form-control" placeholder="Doe" />
              </div> -->
              <div class="col-sm-6">
                <label class="form-label" for="formValidationLastName">Residence No </label>
                <input type="text" id="formValidationLastName" name="residence" class="form-control" placeholder="Doe" />
              </div>
              <div class="mb-6">
                <label class="form-label" for="bs-validation-bio">Address</label>
                <textarea class="form-control" id="bs-validation-bio" name="address" rows="3" required=""></textarea>
              </div>
              <div class="col-12 d-flex justify-content-between">
                <button class="btn btn-label-secondary btn-prev"> <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                  <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button>
                <button class="btn btn-success btn-next btn-submit">Submit</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<hr class="container-m-nx mb-12">
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
<script src="../../assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
<script src="../../assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
<script src="../../assets/vendor/libs/select2/select2.js"></script>
<script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
<script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
<script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>
<script src="../../assets/vendor/libs/moment/moment.js"></script>
<script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script src="../../assets/vendor/libs/select2/select2.js"></script>

<!-- Main JS -->
<script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

<!-- Main JS -->
<script src="../../assets/js/main.js"></script>


<!-- Page JS -->
<script src="../../assets/js/extended-ui-sweetalert2.js"></script>
<script>
  function submitdata() {
    // Prevent form from submitting the traditional way
    event.preventDefault();

    // Get the form element
    var form = document.getElementById('wizard-validation-form');

    // Collect the form data
    var formData = new FormData(form);

    // Send the data via AJAX
    $.ajax({
        url: "{{ route('allote.create') }}",  // URL where the form data should be submitted
        type: "POST",  // HTTP method
        data: formData,  // Form data
        processData: false,  // Disable processing the data (required for FormData)
        contentType: false,  // Disable setting the content type (required for FormData)
        success: function(response) {
            // Handle the success response
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Form data submitted successfully!',
                    showConfirmButton: false,
                    timer: 2000
                });
                // Optionally, you can redirect or reset the form here
                window.location.href="allote-listing";
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'There was an error submitting the form.',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },
        error: function(xhr, status, error) {
            // Handle the error response
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'There was an error with the AJAX request.',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}

</script>
<script src="../../assets/js/form-wizard-numbered.js"></script>
<script src="../../assets/js/form-wizard-validation.js"></script>
<script src="../../assets/js/form-layouts.js"></script>
@endsection