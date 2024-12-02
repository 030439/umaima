@extends('layout.app')
<?php $breadCrumb='Expenses / <span class="text-primary">Expense Heads</span></i>'?>
@section('title', 'Expense-head')
@section('content')
      <div class="content-wrapper">

        <!-- Content -->
        
          <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Multi Column with Form Separator -->
            <div class="row">
          
            <div class="col-xxl">
                <div class="card mb-6">
                <h5 class="card-header">Form Label Alignment</h5>
                <form class="card-body" id="pay-form" onsubmit="return false">
                    <hr class="my-6 mx-n4" />
                    <div class="row mb-6">

                        <div class="col-6">
                            <label class="col-form-label text-sm-end" for="birthdate">Payment Date</label>
                            <input type="text" id="paydate" name="paydate" class="form-control dob-picker" placeholder="YYYY-MM-DD" />
                        </div>

                        <div class="col-6">
                            <label class="col-form-label text-sm-end" for="payment_type">Payment Type</label>
                            <select id="payment_type" name="payment_type" class="select2 form-select" data-allow-clear="true">
                                <option value="">Select Payment Type</option>
                                <option value="1">Receive</option>
                                <option value="2">Payment</option>
                            </select>
                        </div>

                        <div class="col-6 d-none" id="allote_section">
                            <label class="col-form-label text-sm-end" for="allotees">Allotees</label>
                            <select id="allotees" name="allotees" class="select2 form-select" data-allow-clear="true">
                                <option value="">Select Allotee</option>
                            </select>
                        </div>

                        <div class="col-6 d-none" id="plot_section">
                            <label class="col-form-label text-sm-end" for="allotees">Plots</label>
                            <select id="plot" name="plot" class="select2 form-select" data-allow-clear="true">
                                <option value="">Select Plot</option>
                            </select>
                        </div>

                        <div class="col-6 d-none" id="expense_section">
                            <label class="col-form-label text-sm-end" for="expense_heads">Expense Heads</label>
                            <select id="expense_heads" name="expense_heads" class="select2 form-select" data-allow-clear="true">
                                <option value="">Select Expense Head</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <label class="col-form-label text-sm-end" for="from_account"> Account</label>
                            <select id="from_account" name="from_account" class="select2 form-select" data-allow-clear="true">
                                <option value="">Select Account</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <label class="col-form-label text-sm-end" for="amount">Amount</label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter Amount" />
                        </div>

                        <div class="col-6">
                            <label class="col-form-label text-sm-end" for="narration">Narration</label>
                            <input type="text" id="narration" name="narration" class="form-control" placeholder="Enter Narration" />
                        </div>
                    </div>

                    <div class="pt-6">
                        <div class="row justify-content-end">
                            <div class="col-sm-12">
                                <button type="submit" id="add-btn" class="btn btn-primary me-4">Submit</button>
                                <button type="reset" class="btn btn-label-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>

                </div>

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
    <script src="../../assets/vendor/libs/cleavejs/cleave.js"></script>
<script src="../../assets/vendor/libs/cleavejs/cleave-phone.js"></script>
<script src="../../assets/vendor/libs/moment/moment.js"></script>
<script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script src="../../assets/vendor/libs/select2/select2.js"></script>

<!-- Main JS -->
<script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

<!-- Main JS -->
<script src="../../assets/js/main.js"></script>


<!-- Page JS -->
<script src="../../assets/js/extended-ui-sweetalert2.js"></script>


    <!-- Page JS -->
    <script src="../../assets/js/form-layouts.js"></script>
    <script>
        
        $(document).ready(function(){
            function populateDropdown(selectId, items) {
                const selectElement = document.getElementById(selectId);
                selectElement.innerHTML = "<option value=''>Select</option>"; // Reset options

                items.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item.value;
                    option.textContent = item.label;
                    selectElement.appendChild(option);
                });
            }
            function fetchAccounts() {
                $.ajax({
                    method: "POST",
                    url: "/api/fetch-accounts",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    success: function(data) {
                        if (data.success) {
                            populateDropdown("from_account", data.acccounts);
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
            fetchAccounts();

            function fetchExpenseHeads() {
                $.ajax({
                    method: "POST",
                    url: "/get-account-heads",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    success: function(data) {
                        if (data.success) {
                            populateDropdown("expense_heads", data.expenses);
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
            function fetchalloties() {
                $.ajax({
                    method: "POST",
                    url: "/api/get-alloties",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    success: function(data) {
                        if (data.success) {
                            populateDropdown("allotees", data.allotes);
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
            function fetchPlots(allote) {
                $.ajax({
                    method: "POST",
                    url: "/api/get-plots",
                    data:{allote:allote},
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    success: function(data) {
                        if (data.success) {
                            populateDropdown("plot", data.plots);
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
            $('#allotees').on('change', function () {
                const selectedOption_ = $(this).val();
                fetchPlots(selectedOption_);
            });
            $('#payment_type').on('change', function () {
                const selectedOption = $(this).val();
                if (selectedOption == 1) {
                    $("#expense_section").addClass('d-none');
                    fetchalloties();
                    $("#plot_section").removeClass('d-none');
                    $("#allote_section").removeClass('d-none');
                } else if (selectedOption == 2) {
                    $("#plot_section").addClass('d-none');
                    $("#allote_section").addClass('d-none');
                    fetchExpenseHeads();
                    $("#expense_section").removeClass('d-none');
                }
            });

        });
    </script>
    <script>
        const formButton = document.getElementById("add-btn");
            formButton.addEventListener("click", function () {
            confirmForm();
        });

        function confirmForm(event) {
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
                const formData = new FormData(document.getElementById("pay-form"));

                fetch("/api/cash/store", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
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
                            window.location.href = "/cashbook";
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
                    
                    console.error("Error:", error);
                    Swal.fire({
                        icon: 'error',
                        text: error,
                    });
                });
            }, 100); // Delay of 1 second (1000 milliseconds)
        }
    </script>
    
    @endsection

