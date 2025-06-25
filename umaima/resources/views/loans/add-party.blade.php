@extends('layout.app')
<?php $breadCrumb=' Loan-Party / <span class="text-primary">Add</span></i>'?>
@section('title', 'Loan-party')
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
<h5 class="card-header">Create Loan Party</h5>
<div class="card-body">
    <form id="schemePlotForm" class="row g-6"  onsubmit="return false">
        <div class="col-6">
        <label class="form-label" for="plotNumber">Name</label>
            <input type="text" id="name" class="form-control" tag="name" name="name"  />
            <div class="invalid-feedback">Please enter Name.</div>
        </div>

        <div class="col-md-6">
            <label class="form-label" for="plotNumber">Phone Number</label>
            <input type="text" id="phone" class="form-control" tag="phone" name="phone"  />
            <div class="invalid-feedback">Please enter the Phone number.</div>
        </div>

        <div class="col-6">
            <label class="form-label" for="plotNumber">Address</label>
            <input type="text" id="address" class="form-control" tag="address" name="address"  />
            <div class="invalid-feedback">Please enter address.</div>
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
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    function saveSchemePlot(plot) {
   
   $.ajax({
       method: "POST",
       url: "/api/save-party",
       data: { party: plot },
       headers: {
           "X-CSRF-TOKEN": csrfToken
       },
       success: function(data) {
           if (data.success==true) {
               setTimeout(() => {
                   window.location.href = "/loan/parties";
               }, 1000);
           } else {
               alert("Error: " + data.message, "danger");
           }
       },
       error: function(jqXHR) {
           const errorResponse = jqXHR.responseJSON;
           if (errorResponse && errorResponse.error) {
               showToast("Error: " + errorResponse.message, "danger");
               setTimeout(() => {
                   window.location.reload();
               }, 2000);
           } else {
               showToast("An error occurred while saving the scheme.", "danger");
           }
       }
   });
}



document.getElementById("schemePlotForm").addEventListener("submit", function (e) {
   e.preventDefault(); // Prevent default form submission
   let isValid = true;

   // Reset all fields to remove previous error states
   const fields = document.querySelectorAll(".form-control, .form-select");
   fields.forEach(field => {
       field.classList.remove("is-invalid");
       const errorContainer = field.nextElementSibling;
       if (errorContainer && errorContainer.classList.contains("invalid-feedback")) {
           errorContainer.style.display = "none";
       }
   });

   // Validate Scheme Selection
   const name = document.getElementById("name");
   if (name.value === "") {
       setError(name, "Please Enter Name.");
       isValid = false;
   }

   // Validate Plot Number
   const phone = document.getElementById("phone");
   if (phone.value.trim() === "") {
       setError(phone, "Please enter phone number.");
       isValid = false;
   }

   // Validate Plot Size
   const address = document.getElementById("address");
   if (address.value === "") {
       setError(address, "Please Enter address.");
       isValid = false;
   }


   if (isValid) {
       const scheme = {
           name: name.value,
           phone: phone.value,
           address: address.value
       };

       saveSchemePlot(scheme); // Call save function to handle form submission
   }
});
</script>


@endsection