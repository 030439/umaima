@extends('layout.app')
<?php $breadCrumb=' Scheme / <span class="text-primary">Plots</span></i>'?>
@section('title', 'Scheme-plots')
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
<h5 class="card-header">Create Scheme Plot</h5>
<div class="card-body">
    <form id="formdata" class="row g-6"  onsubmit="return false">
        <div class="col-6">
            <label class="form-label" for="schemeSelection">Scheme</label>
            <select class="form-select select2" id="scheme" name="scheme" >
                <option value="">Select Scheme</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select your scheme</div>
        </div>
        <div class="col-6">
            <label class="form-label" for="schemeSelection">Plot</label>
            <select class="form-select select2" id="plot" name="plot" >
                <option value="">Select Plot</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select your scheme</div>
        </div>

        <div class="col-6">
            <label class="form-label" for="schemeSelection">From Allote</label>
            <input class="form-control" id="alloted" name="fromallote" readonly>
            <input type="hidden"  id="from-allote" name="from" readonly>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select your scheme</div>
        </div>

        <div class="col-6">
            <label class="form-label" for="schemeSelection">To Allote</label>
            <select class="form-select" id="allote" name="to" >
                <option value="">Select Allote</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select your scheme</div>
        </div>


        <div class="col-md-6">
            <label class="form-label" for="plotNumber">Amount</label>
            <input class="form-control" id="amount" name="amount" type="number">
        </div>

        <div class="col-md-6">
            <label class="form-label" for="plotNumber">Date</label>
            <input class="form-control" id="date" name="date" type="date">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="plotNumber">Narration</label>
            <input class="form-control" id="narration" name="narration">
        </div>

        <div class="col-md-6">
            <label class="form-label" for="plotNumber">Document</label>
            <input class="form-control" id="document" name="document" type="file">
        </div>
        <div class="col-12">
        <button class="btn btn-success btn-next btn-submit" onclick="submitdata();">Submit</button>
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

<!-- Main JS -->
<script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

>


<!-- Page JS -->
<script src="../../assets/js/extended-ui-sweetalert2.js"></script>

<script>
    const csrfToken=document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    
    function populateDropdown(selectId, items) {
        const selectElement = document.getElementById(selectId);
        selectElement.innerHTML = "<option value=''>Select</option>"; // Reset options

        items.forEach(item => {
            const option = document.createElement("option");
            option.value = item.value;
            option.textContent = item.label;
            selectElement.appendChild(option);
        });
        $("#"+selectId).select2();
        
    }
    function fetchSchemeDetails() {
        $.ajax({
            method: "POST",
            url: "/api/get-alloties",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            success: function(data) {
                if (data.success) {
                    populateDropdown("allote", data.allotes);
                    populateDropdown("scheme", data.scheme);
                } else {
                    showToast("Error: " + data.message, "danger");
                }
            },
            error: function(jqXHR) {
                const errorResponse = jqXHR.responseJSON;
                if (errorResponse && errorResponse.error) {
                    showToast("Error: " + errorResponse.message, "danger");
                } else {
                    showToast("Failed to load scheme details.", "danger");
                }
            }
        });
    }
   fetchSchemeDetails();

    function fetchPlots(plotId) {
        $.ajax({
            method: "post",
            url: `/api/get-plot-by-scheme`,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            data:{id:plotId}, // Your endpoint for fetching plots
            success: function (response) {
                if (response.success && response.plots) {
                    populateDropdown('plot',response.plots);
                    
                } else {
                    showToast("Failed to fetch plots", "danger");
                }
            },
            error: function () {
                showToast("Error fetching plots", "danger");
            }
        });
    }

    function fetchAllote(plotId) {
        $.ajax({
            method: "post",
            url: '/api/get-allote-by-plot',
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }, // Your endpoint for fetching plots
            data:{plot:plotId},
            success: function (response) {
                if (response) {
                    $("#alloted").val(response.name);
                    $("#from-allote").val(response.id);
                } else {
                    showToast("Failed to fetch plots", "danger");
                }
            },
            error: function () {
                showToast("Error fetching plots", "danger");
            }
        });
    }

    const selectScheme = document.getElementById("scheme");
    const alloted = document.getElementById("alloted");
    const selectPlot = document.getElementById("plot");

    function resetPlots() {
        selectPlot.innerHTML = '<option value="">Select</option>';
    }
    function resetAllote() {
        alloted.innerHTML = '<option value="">Select</option>';
    }
   

    $("#scheme").on("change", function () {
        const schemeId = selectScheme.value;
        if (schemeId) {
            fetchPlots(schemeId);
        } else {
            resetPlots();
        }
    });

    $("#plot").on("change", function () {
        const plotId = selectPlot.value;
        if (plotId) {
            fetchAllote(plotId);
        } else {
            resetAllote();
        }
    });

</script>

<script>




function submitdata(event) {
    // Show loading dialog for 1 second before submitting the form
    Swal.fire({
        title: "Processing...",
        text: "Please wait",
        icon: "info",
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        willOpen: () => {
            Swal.showLoading(); // Show the loading spinner
        },
    });

    // Wait for 1 second before submitting the form
    setTimeout(function () {
        // Create a new FormData object from the form
        const formData = new FormData(document.getElementById("formdata"));

        // const supplier = document.getElementById("supplier-name").value;
        // const tcharges = document.getElementById("tcharges").value;
        // const currency = document.getElementById("currency").value;
        // const crate = document.getElementById("conversion-rate").value;
        // const cdate = document.getElementById("cdate").value;
        // const saleType = document.getElementById("sale-type").value;
        // const invType = document.getElementById("inv-type-0").value;

        // // Append them to the FormData object
        // formData.append("supplier", supplier);
        // formData.append("crate", crate);
        // formData.append("currency", currency);
        // formData.append("cdate", cdate);
        // formData.append("tcharges", tcharges);
        // formData.append("invType",invType);
        // formData.append("saleType",saleType);

        fetch("{{ route('transfer.create') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": csrfToken // Add CSRF token to request headers
            },
        })
        .then(response => {
            if (!response.ok) {
                Swal.close(); // Close the loading dialog
            
                Swal.fire({
                    icon: 'error',
                    text: response,
                });
            }
            return response.json(); // Assuming JSON response
        })
        .then(data => {
            Swal.close(); // Close the loading dialog
            
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
                    window.location.href = "/sale/list";
                }, 2000); 
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                });
            }
        })
        .catch(error => {
            Swal.close(); // Close the loading dialog
            
            Swal.fire({
                icon: 'error',
                text: error,
            });
        });
    }, 1000); // Delay of 1 second (1000 milliseconds)
}



    function submitdata__(event) {
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


        var form = document.getElementById('formdata');
        var formData = new FormData(form);

        // Debugging: Log form data to console
        for (var pair of formData.entries()) {
            console.log(pair[0] + ": " + pair[1]);
        }

        fetch("{{ route('transfer.create') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
        })
        .then(response => {
            if (!response.ok) {
           return response.json().then(errorData => {
               throw new Error(errorData.message || 'Network response was not ok');
           });
        }
        return response.json();
        })
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
                    window.location.href = "allote-listing";
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
}
</script>
@endsection