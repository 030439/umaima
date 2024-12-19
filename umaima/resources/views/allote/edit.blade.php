
@extends('layout.app')
<?php $breadCrumb='Allote / <span class="text-primary">Add</span></i>'?>
@section('title', 'Home Page')
@section('content')
      <div class="content-wrapper">

        <!-- Content -->
        
          <div class="container-xxl flex-grow-1 container-p-y">
            
            
<!-- Default -->
<div class="row card">


  <!-- Validation Wizard -->
  <div class="col-12 mb-6">
    <div id="wizard-" class="bs- mt-2">
   
      <div class="bs-stepper-">
      <form id="wizard-validation-form" onSubmit="return false" method="post" action="{{route('allote.create')}}">
          @csrf
          <input type="hidden" name="id" value="{{$allote->id}}">
          <!-- Personal Info -->
          <div id="personal-info-validation" class="content">
            <div class="content-header mb-4">
              <h6 class="mb-0">Personal Info</h6>
              <small>Enter  Personal Info.</small>
            </div>
            <div class="row g-6">
              <div class="col-sm-6">
                <label class="form-label" for="formValidationFirstName">Full Name</label>
                <input type="text" id="formValidationFirstName" value="{{$allote->fullname}}" name="formValidationFirstName" class="form-control" placeholder="John" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="formValidationLastName">CNIC </label>
                <input type="text" id="formValidationLastName" value="{{$allote->cnic}}" name="formValidationLastName" class="form-control" placeholder="Doe" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="formValidationFirstName">Father's/Husband Name</label>
                <input type="text" id="formValidationFirstName" value="{{$allote->father}}" name="father" class="form-control" placeholder="John" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="formValidationLastName">CNIC </label>
                <input type="text" id="formValidationLastName" value="{{$allote->fcnic}}" name="fcnic" class="form-control" placeholder="Doe" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="formValidation">Guardian Name</label>
                <input type="text" id="formValidation" value="{{$allote->guardian}}" name="guardian" class="form-control" placeholder="John" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="formValidation">CNIC </label>
                <input type="text" id="formValidation" value="{{$allote->gcnic}}" name="gcnic" class="form-control" placeholder="Doe" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="formValidationOccupation">Occupation </label>
                <input type="text" id="formValidationOccupation" value="{{$allote->occupation}}" name="occupation" class="form-control" placeholder="Doe" />
              </div>
              <div class="col-md-6">
                <label class="form-label" for="multicol-">Birth Date</label>
                <input type="date" name="dob" value="{{$allote->dob}}" id="-birthdate" class="form-control dob- -input " placeholder="YYYY-MM-DD">
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
                <input type="text" id="formValidationGoogle" value="{{$allote->nationality}}" name="nationality" class="form-control" placeholder="Doe" />
              </div>
              <!-- <div class="col-sm-6">
                <label class="form-label" for="formValidationLastName">Occupation </label>
                <input type="text" id="formValidationLastName" name="formValidationLastName" class="form-control" placeholder="Doe" />
              </div> -->
              <div class="col-sm-6">
                <label class="form-label" for="formValidationLastName">Residence No </label>
                <input type="text" id="formValidationLastName"value="{{$allote->residence_no}}" name="residence" class="form-control" placeholder="Doe" />
              </div>
              <div class="mb-6">
                <label class="form-label" for="bs-validation-bio">Address</label>
                <textarea class="form-control" id="bs-validation-bio" name="address" rows="3" required="">
                       {{$allote->address}}
                </textarea>
              </div>
              <div class="col-12 d-flex justify-content-between">
                <button class="btn btn-label- btn-prev"> 
                  <span class="align-middle d-sm-inline-block d-none"></span>
                </button>
                <button class="btn btn-success btn-next btn-submit" onclick="submitdata();">Submit</button>
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
   function submitdata(event) {

Swal.fire({
    title: "Processing...",
    text: "Please wait",
    icon: "info",
    showConfirmButton: false,
    allowOutsideClick: false,
    allowEscapeKey: false,
    willOpen: () => {
        Swal.showLoading();
    },
});

// Wait for 1 second before submitting the form
setTimeout(function () {
    var form = document.getElementById('wizard-validation-form');
    var formData = new FormData(form);

    // Debugging: Log form data to console
    for (var pair of formData.entries()) {
        console.log(pair[0] + ": " + pair[1]);
    }

    fetch("{{ route('allote.edit') }}", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
    })
    .then(response => response.json()) // Parse JSON response
    .then(data => {
        Swal.close();

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                showConfirmButton: false,
                timer: 2000
            });

            // Redirect after success
            setTimeout(function() {
                window.location.href = "/allote-listing";
            }, 2000);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: data.message.replace(/\n/g, '<br>'), // Display validation errors
            });
        }
    })
    .catch(error => {
        Swal.close();
        console.error("Error:", error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An unexpected error occurred. Please try again later.',
        });
    });
}, 1000);
}



</script>
@endsection