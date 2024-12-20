@extends('layout.app')
<?php $breadCrumb=' Scheme / <span class="text-primary">edit</span></i>'?>
@section('title', 'edit-scheme')
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
<h5 class="card-header">Edit Scheme</h5>
<div class="card-body">

<form id="schemeForm" class="row g-6" onsubmit="return false">
  <div class="col-md-6">
    <label class="form-label" for="schemeName">Scheme Name</label>
    <input type="text" id="schemeName" class="form-control" value="{{$scheme->name}}" tag="Scheme name" name="schemeName" />
    <div class="invalid-feedback"></div>
  </div>
  
  <div class="col-md-6">
    <label class="form-label" for="schemeArea">Area</label>
    <input class="form-control" type="number" id="schemeArea" value="{{$scheme->area}}" name="schemeArea" tag="Scheme area" />
  </div>

  <div class="col-md-6">
    <label class="form-label" for="numberOfPlots">No. of Plots</label>
    <input class="form-control" type="number" id="numberOfPlots" value="{{$scheme->no_of_plots}}" name="numberOfPlots" tag="Number of plots" />
  </div>

  <div class="col-md-6">
    <label class="form-label" for="totalValuation">Total Valuation</label>
    <input class="form-control" type="number" id="totalValuation" value="{{$scheme->total_valuation}}" name="totalValuation" tag="Total valuation" />
  </div>
  <input type="hidden" id="editId" value="{{$scheme->id}}">

  <div class="col-12">
    <button type="submit" name="submitButton" class="btn btn-primary">Update</button>
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
<script>
    function showToast(message, type) {
        const toastContainer = document.getElementById("toastContainer");

        const toast = document.createElement("div");
        toast.classList.add("toast", "fade", "show", `bg-${type}`);
        toast.setAttribute("role", "alert");
        toast.setAttribute("aria-live", "assertive");
        toast.setAttribute("aria-atomic", "true");

        toast.innerHTML = `
            <div class="toast-body text-white">
                ${message}
            </div>
        `;

        // Append the toast to the container
        toastContainer.appendChild(toast);

        // Remove toast after 5 seconds
        setTimeout(() => {
            toast.classList.remove("show");
            toast.classList.add("hide");
            toast.addEventListener("transitionend", () => toast.remove());
        }, 5000);
    }
    function saveScheme(scheme) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        $.ajax({
            method: "post",
            url: "/api/update-scheme",
            data: { scheme: scheme },
            headers: {
                "X-CSRF-TOKEN": csrfToken // Add CSRF token to request headers
            },
            success: function(data) {
                if (data.success) {
                    // Handle success (reset form, show success message, etc.)
                    showToast(data.message, "success");
                    setTimeout(() => {
                        window.location.href="/scheme-listing"; // Reload the page
                    }, 2000);
                } else {
                    // Handle custom failure
                    showToast("Error: " + data.message, "danger");
                }
            },
            error: function(jqXHR) {
                // Capture server error message for unauthorized or other errors
                const errorResponse = jqXHR.responseJSON;
                if (errorResponse && errorResponse.error) {
                    showToast("Error: " + errorResponse.message, "danger");
                    setTimeout(() => {
                        window.location.reload(); // Reload the page
                    }, 2000);
                } else {
                    // Generic error message
                    showToast("An error occurred while saving the scheme.", "danger");
                }
            }
        });
    }

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("schemeForm").addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent default form submission
        let isValid = true;

        // Reset all fields to remove previous error states
        const fields = document.querySelectorAll(".form-control");
        fields.forEach(field => {
            field.classList.remove("is-invalid");
            const errorContainer = field.nextElementSibling;
            if (errorContainer && errorContainer.classList.contains("invalid-feedbacks")) {
                errorContainer.style.display = "none";
            }
        });

        // Validate Scheme Name
        const schemeName = document.getElementById("schemeName");
        if (schemeName.value.trim() === "") {
            setError(schemeName, "Please enter the scheme name.");
            isValid = false;
        }

        // Validate Area (must be a positive number)
        const schemeArea = document.getElementById("schemeArea");
        if (schemeArea.value.trim() === "" || isNaN(schemeArea.value) || parseFloat(schemeArea.value) <= 0) {
            setError(schemeArea, "Please enter a valid area.");
            isValid = false;
        }

        // Validate Number of Plots (must be a positive integer)
        const numberOfPlots = document.getElementById("numberOfPlots");
        if (numberOfPlots.value.trim() === "" || isNaN(numberOfPlots.value) || parseInt(numberOfPlots.value) <= 0) {
            setError(numberOfPlots, "Please enter a valid number of plots.");
            isValid = false;
        }

        // Validate Total Valuation (must be a positive number)
        const totalValuation = document.getElementById("totalValuation");
        if (totalValuation.value.trim() === "" || isNaN(totalValuation.value) || parseFloat(totalValuation.value) <= 0) {
            setError(totalValuation, "Please enter a valid total valuation.");
            isValid = false;
        }
        var editId=$("#editId").val();
        if (isValid) {
            const scheme = {
                schemeName: schemeName.value,
                schemeArea: schemeArea.value,
                numberOfPlots: numberOfPlots.value,
                totalValuation: totalValuation.value,
                id: editId
            };

            saveScheme(scheme);
        }
    });

    // Function to set error message
    function setError(element, message) {
        element.classList.add("is-invalid");
        const errorContainer = element.nextElementSibling;
        if (errorContainer && errorContainer.classList.contains("invalid-feedbacks")) {
            errorContainer.textContent = message;
            errorContainer.style.display = "block";
        }
    }

    // Example function to handle valid scheme data
});
</script>


@endsection