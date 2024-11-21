@extends('layout.app')
<?php $breadCrumb=' <span class="text-primary"></span></i>'?>
@section('title', 'Home Page')
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-xxl-4 col-xl-6 col-lg-12">
                    <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                        <h5 class="mb-1">Monthly Installments </h5>
                        </div>
                        <div class="dropdown">
                        <button class="btn btn-secondary add-new btn-primary waves-effect waves-light"  type="button" onclick="addPlotLocation()">
                                <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                    <span class="d-none d-sm-inline-block">Add New Installment</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                        @if ($installments->isNotEmpty())
                        @foreach ($installments as $installment)
                            <li class="mb-6">
                                <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{ $installment->installment }}</h6>
                                    </div>
                                </div>
                                </div>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-6 col-lg-12">
                    <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                        <h5 class="mb-1">Mid Pay Durations</h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-secondary add-new btn-primary waves-effect waves-light"  type="button" onclick="addPlotSize()">
                                <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                    <span class="d-none d-sm-inline-block">Add New Duration</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                        @if ($durations->isNotEmpty())
                        @foreach ($durations as $duration)
                            <li class="mb-6 d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-between w-100 flex-wrap">
                                <h6 class="mb-0 ms-4 badge bg-label-info rounded">{{ $duration->durationname }}</h6>
                                <div class="d-flex">
                                    <p class="mb-0">{{ $duration->durations }}</p>
                                </div>
                                </div>
                            </li>
                        @endforeach
                        @endif
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
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
            <!-- model for ploat location create -->
            <div class="modal fade" id="addPlotLocation" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-simple">
                    <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-6">
                        <h4 class="mb-2">Add New Installment</h4>
                        </div>
                        <form id="addPermissionForm" class="row" onsubmit="return false">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="modalPermissionName">Installment </label>
                            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control" placeholder="installment">
                            <div class="fv-plugins-message-container invalid-feedbacks"></div>
                        </div>
                        <div class="col-12 text-center demo-vertical-spacing">
                            <button type="submit" class="btn btn-primary me-4">Create Installment</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Discard</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <!-- model for create of plot size -->
            <div class="modal fade" id="addPlotSize" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-simple">
                    <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-6">
                        <h4 class="mb-2">Add New Duration </h4>
                        </div>
                        <form id="addsizeForm" class="row" onsubmit="return false">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="durationname">Duration Name</label>
                            <input type="text" id="durationname" name="durationname" class="form-control" placeholder="duration">
                            <div class="fv-plugins-message-container invalid-feedbacks"></div>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label" for="modalPermissionName">Duration</label>
                            <input type="text" id="plotsizefiled" name="modalPermissionName" class="form-control" placeholder="duration">
                            <div class="fv-plugins-message-container invalid-feedbacks"></div>
                        </div>
                        <div class="col-12 text-center demo-vertical-spacing">
                            <button type="submit" class="btn btn-primary me-4">Create Duration</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Discard</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
    </div>

@endsection
@section('files')
<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

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


<script src="../../assets/vendor/libs/%40form-validation/popular.js"></script>
<script src="../../assets/vendor/libs/%40form-validation/bootstrap5.js"></script>
<script src="../../assets/vendor/libs/%40form-validation/auto-focus.js"></script>

<!-- Main JS -->
<script src="../../assets/js/main.js"></script>
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    function setError(input, message) {
        input.classList.add("is-invalid");
        const errorContainer = input.nextElementSibling;
        if (errorContainer && errorContainer.classList.contains("invalid-feedbacks")) {
            errorContainer.innerText = message;
            errorContainer.style.display = "block";
        }
    }

    function addPlotSize() {
        const addCCModal = new bootstrap.Modal(document.getElementById('addPlotSize'));
        addCCModal.show();
    }

    function addPlotLocation() {
        const addCCModal = new bootstrap.Modal(document.getElementById('addPlotLocation'));
        addCCModal.show();
    }
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
    function createLocation(location) {
        $.ajax({
            method: "POST",
            url: "/setup/installment",
            data: { location_name: location },
            headers: {
                "X-CSRF-TOKEN": csrfToken // Add CSRF token to request headers
            },
            success: function(data) {
                
                if (data.success == true) {
                    // Handle success (you could reset the form, show success message, etc.)
                    showToast(data.message, "success");
                    setTimeout(() => {
                         window.location.reload(); // Reload the page
                    }, 2000);
                } else {
                    // Handle failure
                    showToast("Error: " + data.message, "danger");
                }
            },
            error: function() {
                console.error('Could not load roles.');
            }
        });
    }

    function createSize(plotsize,durationname) {
        // Function to handle plot size creation logic
        $.ajax({
            method: "POST",
            url: "/setup/duration",
            data: { size: plotsize,durationname:durationname },
            headers: {
                "X-CSRF-TOKEN": csrfToken // Add CSRF token to request headers
            },
            success: function(data) {
                
                if (data.success == true) {
                    // Handle success (you could reset the form, show success message, etc.)
                    showToast(data.message, "success");
                    setTimeout(() => {
                         window.location.reload(); // Reload the page
                    }, 2000);
                } else {
                    // Handle failure
                    showToast("Error: " + data.message, "danger");
                }
            },
            error: function() {
                console.error('Could not load roles.');
            }
        });
    }

    // Handling Plot Size Form Submission
    document.getElementById("addPlotSize").addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent default form submission
        let isValid = true;

        // Reset all fields to remove previous error states
        const fields = document.querySelectorAll(".form-control, .form-select");
        fields.forEach(field => {
            field.classList.remove("is-invalid");
            const errorContainer = field.nextElementSibling;
            if (errorContainer && errorContainer.classList.contains("invalid-feedbacks")) {
                errorContainer.style.display = "none";
            }
        });

        // Validate Plot Size
        const plotsizefiled = document.getElementById("plotsizefiled");
        const durationname = document.getElementById("durationname");
        if (plotsizefiled.value.trim() === "") {
            setError(plotsizefiled, "duratin  is required.");
            isValid = false;
        } else if (isNaN(plotsizefiled.value) || plotsizefiled.value <= 0) {
            setError(plotsizefiled, "duration must be a valid number greater than 0.");
            isValid = false;
        }

        // Submit the form if valid
        if (isValid) {
            createSize(plotsizefiled.value,durationname.value); // Pass the valid plot size to createSize function
        }
    });

    // Handling Permission Form Submission
    document.getElementById("addPermissionForm").addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent default form submission
        let isValid = true;

        // Reset all fields to remove previous error states
        const fields = document.querySelectorAll(".form-control, .form-select");
        fields.forEach(field => {
            field.classList.remove("is-invalid");
            const errorContainer = field.nextElementSibling;
            if (errorContainer && errorContainer.classList.contains("invalid-feedbacks")) {
                errorContainer.style.display = "none";
            }
        });

        // Validate Plot Location
        const location = document.getElementById("modalPermissionName");
        if (location.value.trim() === "") {
            setError(location, "installment is required.");
            isValid = false;
        } else if (isNaN(location.value) || location.value <= 0) {
            setError(location, "installmentmust be a valid number greater than 0.");
            isValid = false;
        }


        // Submit the form if valid
        if (isValid) {
            $(".modal-backdrop").remove();
            $("#addPlotLocation").hide();
            createLocation(location.value); // Pass the valid location to createLocation function
        }
    });
</script>
    

@endsection
