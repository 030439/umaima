@extends('layout.app')
<?php $breadCrumb=' <span class="text-primary"></span></i>'?>
@section('title', 'plots sizes & locations')
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-xxl-4 col-xl-4 col-lg-12">
                    <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                        <h5 class="mb-1">Plots Locations </h5>
                        </div>
                        <div class="dropdown">
                        <button class="btn btn-secondary add-new btn-primary waves-effect waves-light"  type="button" onclick="addPlotLocation()">
                                <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                    <span class="d-none d-sm-inline-block">Add New </span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                        @if ($locations->isNotEmpty())
                        @foreach ($locations as $location)
                            <li class="mb-6">
                                <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{ $location->location_name }}</h6>
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
                <div class="col-xxl-4 col-xl-4 col-lg-12">
                    <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                        <h5 class="mb-1">Plots Sizes </h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-secondary add-new btn-primary waves-effect waves-light"  type="button" onclick="addPlotSize()">
                                <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                    <span class="d-none d-sm-inline-block">Add New  </span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                        @if ($sizes->isNotEmpty())
                        @foreach ($sizes as $size)
                            <li class="mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                        <div class="me-2">
                                        <h6 class="mb-0">{{ $size->size }}</h6>
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
                <div class="col-xxl-4 col-xl-4 col-lg-12">
                    <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                        <h5 class="mb-1">Plots Category </h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-secondary add-new btn-primary waves-effect waves-light"  type="button" onclick="addPlotCat()">
                                <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                    <span class="d-none d-sm-inline-block">Add New  </span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                        @if ($categories->isNotEmpty())
                        @foreach ($categories as $category)
                            <li class="mb-6">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                        <div class="me-2">
                                        <h6 class="mb-0">{{ $category->name }}</h6>
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
                        <h4 class="mb-2">Add New Location</h4>
                        </div>
                        <form id="addPermissionForm" class="row" onsubmit="return false">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="modalPermissionName">Location Name</label>
                            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control" placeholder="location Name">
                            <div class="fv-plugins-message-container invalid-feedbacks"></div>
                        </div>
                        <div class="col-12 text-center demo-vertical-spacing">
                            <button type="submit" class="btn btn-primary me-4">Create Location</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Discard</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addPlotCat" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-simple">
                    <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-6">
                        <h4 class="mb-2">Add New Category</h4>
                        </div>
                        <form id="addCatForm" class="row" onsubmit="return false">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="modalcategoryName">Category Name</label>
                            <input type="text" id="modalcategoryName" name="category" class="form-control" placeholder="category Name">
                            <div class="fv-plugins-message-container invalid-feedbacks"></div>
                        </div>
                        <div class="col-12 text-center demo-vertical-spacing">
                            <button type="submit" class="btn btn-primary me-4">Create Category</button>
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
                        <h4 class="mb-2">Add New Plot Size</h4>
                        </div>
                        <form id="addsizeForm" class="row" onsubmit="return false">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="modalPermissionName">Plot  Size</label>
                            <input type="text" id="plotsizefiled" name="modalPermissionName" class="form-control" placeholder="plot size Name">
                            <div class="fv-plugins-message-container invalid-feedbacks"></div>
                        </div>
                        <div class="col-12 text-center demo-vertical-spacing">
                            <button type="submit" class="btn btn-primary me-4">Create Plot Size</button>
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
    function addPlotCat() {
        const addCCModal = new bootstrap.Modal(document.getElementById('addPlotCat'));
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
            url: "/setup/create-plot-location",
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
    function createCategory(location) {
        $.ajax({
            method: "POST",
            url: "/setup/create-plot-category",
            data: { name: location },
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

    function createSize(plotsize) {
        // Function to handle plot size creation logic
        $.ajax({
            method: "POST",
            url: "/setup/create-plot-size",
            data: { size: plotsize },
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
        if (plotsizefiled.value.trim() === "") {
            setError(plotsizefiled, "Plot size is required.");
            isValid = false;
        } else if (isNaN(plotsizefiled.value) || plotsizefiled.value <= 0) {
            setError(plotsizefiled, "Plot size must be a valid number greater than 0.");
            isValid = false;
        }

        // Submit the form if valid
        if (isValid) {
            createSize(plotsizefiled.value); // Pass the valid plot size to createSize function
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
            setError(location, "Plot location is required.");
            isValid = false;
        }

        // Submit the form if valid
        if (isValid) {
            $(".modal-backdrop").remove();
            $("#addPlotLocation").hide();
            createLocation(location.value); // Pass the valid location to createLocation function
        }
    });
    document.getElementById("addCatForm").addEventListener("submit", function (e) {
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
        const location = document.getElementById("modalcategoryName");
        if (location.value.trim() === "") {
            setError(location, "Category Name is required.");
            isValid = false;
        }

        // Submit the form if valid
        if (isValid) {
            $(".modal-backdrop").remove();
            $("#addPlotLocation").hide();
            createCategory(location.value); // Pass the valid location to createLocation function
        }
    });
</script>
    

@endsection
