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
        <div class="col-4">
            <label class="form-label" for="schemeSelection">From Scheme</label>
            <select class="form-select select2" id="scheme" name="scheme" >
                <option value="">Select Scheme</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select your scheme</div>
        </div>
        <div class="col-4">
            <label class="form-label" for="schemeSelection">From Plot</label>
            <select class="form-select select2" id="plot" name="plot" >
                <option value="">Select Plot</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select your scheme</div>
        </div>

        <div class="col-4">
            <label class="form-label" for="schemeSelection">From Allote</label>
            <input class="form-control" id="alloted" name="fromallote" readonly>
            <input type="hidden"  id="from-allote" name="from" readonly>
            <input type="hidden"  id="allocation" name="allocation" readonly>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select your scheme</div>
        </div>





         <div class="col-4">
            <label class="form-label" for="schemeSelection">To Scheme</label>
            <select class="form-select select2" id="toscheme" name="toscheme" >
                <option value="">Select Scheme</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select your scheme</div>
        </div>
        <div class="col-4">
            <label class="form-label" for="schemeSelection">To Plot</label>
            <select class="form-select select2" id="toplot" name="toplot" >
                <option value="">Select Plot</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select your scheme</div>
        </div>

        <div class="col-4">
            <label class="form-label" for="schemeSelection">To Allote</label>
            <input class="form-control" id="toalloted" name="toallote" readonly>
            <input type="hidden"  id="to-allote" name="tofrom" readonly>
            <input type="hidden"  id="toallocation" name="toallocation" readonly>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select your scheme</div>
        </div>






        <!-- <div class="col-6">
            <label class="form-label" for="schemeSelection">To Allote</label>
            <select class="form-select" id="allote" name="to" >
                <option value="">Select Allote</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select your scheme</div>
        </div> -->


        <div class="col-md-4">
            <label class="form-label" for="plotNumber">Amount</label>
            <input class="form-control" id="amount" name="amount" type="number" readonly>
        </div>
         <div class="col-4">
            <label class="form-label" for="schemeSelection">Bank-Account</label>
            
            <select class="form-select select2" id="accountTo" name="bank" >
                @foreach($banks as $account)
                <option value="{{$account->id}}">{{$account->bank_name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label" for="plotNumber">Date</label>
            <input class="form-control" id="date" name="date" type="date">
        </div>
            <div class="col-md-4">
            <label class="form-label" for="plotNumber">Deduction %</label>
            <input class="form-control" id="percentage" name="percentage" type="text" value="0">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="plotNumber">Narration</label>
            <input class="form-control" id="narration" name="narration">
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
     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    document.addEventListener("DOMContentLoaded", function () {
       

        function populateDropdown(selectId, items) {
            const selectElement = document.getElementById(selectId);
            selectElement.innerHTML = "<option value=''>Select</option>";

            items.forEach(item => {
                const option = document.createElement("option");
                option.value = item.value;
                option.textContent = item.label;
                selectElement.appendChild(option);
            });

            $("#" + selectId).select2(); // jQuery Select2 integration
        }

        function fetchSchemesAndPopulate(selectId) {
            $.ajax({
                method: "POST",
                url: "/api/get-alloties",
                headers: { "X-CSRF-TOKEN": csrfToken },
                success: function (data) {
                    if (data.success) {
                        populateDropdown(selectId, data.scheme);
                    } else {
                        showToast("Error: " + data.message, "danger");
                    }
                },
                error: function (jqXHR) {
                    const errorResponse = jqXHR.responseJSON;
                    if (errorResponse && errorResponse.error) {
                        showToast("Error: " + errorResponse.message, "danger");
                    } else {
                        showToast("Failed to load scheme details.", "danger");
                    }
                }
            });
        }

        function fetchPlotsByScheme(schemeId, plotSelectId) {
            $.ajax({
                method: "POST",
                url: "/api/get-plot-by-scheme-alloted",
                headers: { "X-CSRF-TOKEN": csrfToken },
                data: { id: schemeId },
                success: function (response) {
                    if (response.success && response.plots) {
                        populateDropdown(plotSelectId, response.plots);
                    } else {
                        showToast("Failed to fetch plots", "danger");
                    }
                },
                error: function () {
                    showToast("Error fetching plots", "danger");
                }
            });
        }

        function fetchAlloteByPlot(plotId, nameInputId, idInputId, allocationInputId) {
            $.ajax({
                method: "POST",
                url: '/api/get-allote-by-plot',
                headers: { "X-CSRF-TOKEN": csrfToken },
                data: { plot: plotId },
                success: function (response) {
                    if (response) {
                        $("#" + nameInputId).val(response.name);
                        $("#" + idInputId).val(response.id);
                        $("#" + allocationInputId).val(response.allocation);
                    } else {
                        showToast("Failed to fetch allote", "danger");
                    }
                },
                error: function () {
                    showToast("Error fetching allote", "danger");
                }
            });
        }

        // Reset dropdowns or inputs
        function resetDropdown(selectId) {
            document.getElementById(selectId).innerHTML = '<option value="">Select</option>';
        }

        function resetInputs(...inputIds) {
            inputIds.forEach(id => {
                document.getElementById(id).value = '';
            });
        }

        // Initial fetch for both dropdowns
        fetchSchemesAndPopulate("scheme");
        fetchSchemesAndPopulate("toscheme");

        // From Scheme Change
         function getAmountByPlot(plotId) {
            $.ajax({
                method: "post",
                url: '/api/get-amount-by-plot',
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                }, // Your endpoint for fetching plots
                data:{plot:plotId},
                success: function (response) {
                    if (response) {
                        $("#amount").val(response.amount);
                    } else {
                        showToast("Failed to fetch plots", "danger");
                    }
                },
                error: function () {
                    showToast("Error fetching plots", "danger");
                }
            });
        }
        $("#scheme").on("change", function () {
            const schemeId = this.value;
            if (schemeId) {
                fetchPlotsByScheme(schemeId, "plot");
            } else {
                resetDropdown("plot");
            }
        });

        // To Scheme Change
        $("#toscheme").on("change", function () {
            const schemeId = this.value;
            if (schemeId) {
                fetchPlotsByScheme(schemeId, "toplot");
            } else {
                resetDropdown("toplot");
            }
        });

        // From Plot Change
        $("#plot").on("change", function () {
            const plotId = this.value;
            if (plotId) {
                getAmountByPlot(plotId);
                fetchAlloteByPlot(plotId, "alloted", "from-allote", "allocation");
            } else {
                resetInputs("alloted", "from-allote", "allocation");
            }
        });

        // To Plot Change
        $("#toplot").on("change", function () {
            const plotId = this.value;
            if (plotId) {
                fetchAlloteByPlot(plotId, "toalloted", "to-allote", "toallocation");
            } else {
                resetInputs("toalloted", "to-allote", "toallocation");
            }
        });
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


        fetch("{{ route('transfer.adjustStore') }}", {
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
                    window.location.href = "/setup/plot-adjust";
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