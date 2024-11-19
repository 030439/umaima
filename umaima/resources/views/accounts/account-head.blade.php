@extends('layout.app')
<?php $breadCrumb='Expenses / <span class="text-primary">Expense Heads</span></i>'?>
@section('title', 'Expense-head')
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-xxl-4 col-xl-12 col-lg-12">
                    <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                        <h5 class="mb-1">Expense Heads </h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-secondary add-new btn-primary waves-effect waves-light"  type="button" onclick="addPlotLocation()">
                                <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                    <span class="d-none d-sm-inline-block">Add New Expense Head</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                        @if ($accounts)
                        @foreach ($accounts as $Expense)
                            <li class="mb-6">
                                <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{ $Expense->name }}</h6>
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
                        <h4 class="mb-2">Add New Expense Head</h4>
                        </div>
                        <form id="addPermissionForm" class="row" onsubmit="return false">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="modalPermissionName">Expense Head </label>
                            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control" placeholder="installment">
                            <div class="fv-plugins-message-container invalid-feedbacks"></div>
                        </div>
                        <div class="col-12 text-center demo-vertical-spacing">
                            <button type="submit" class="btn btn-primary me-4">Submit</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Discard</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <!-- model for create of plot size -->
           
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
            url: "/api/account-heads",
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
            setError(location, "Expense Head  is required.");
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
