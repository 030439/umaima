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
<h5 class="card-header">Edit  Plot</h5>
<div class="card-body">
    <form id="schemePlotForm" class="row g-6"  onsubmit="return false">

        <div class="col-6">
            <label class="form-label" for="schemeSelection">Scheme</label>
            <select class="form-select" id="" name="schemeSelection" disabled >
                @if($schemes)
                @foreach($schemes as $scheme)
                <option <?php if($plots->scheme_id==$scheme->id){echo "Selected";} ?>>{{$scheme->name}}</option>
                @endforeach
                @endif
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label" for="plotNumber">Plot Number</label>
            <input type="text" id="plotNumber" class="form-control" value="{{$plots->plot_number}}" tag="Plot number" name="plotNumber"  />
            <div class="invalid-feedback">Please enter the plot number.</div>
        </div>
        <input type="hidden" id="pid" value="{{$plots->id}}">

        <div class="col-6">
            <label class="form-label" for="plotSize">Plot Size</label>
            <select class="form-select" id="plotSize" name="plotSize" >
            @if($sizes)
                @foreach($sizes as $size)
                <option value="{{$size->id}}" <?php if($plots->plot_size_id==$size->id){echo "Selected";} ?>>{{$size->size}}</option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="col-6">
            <label class="form-label" for="plotCategories">Plot Category</label>
            <select class="form-select" id="plotCategories" name="plotCategories" >
                 @if($plot_categories)
                @foreach($plot_categories as $ps)
                <option value="{{$ps->id}}" <?php if($plots->plot_category_id ==$ps->id){echo "Selected";} ?>>{{$ps->category_name }}</option>
                @endforeach
                @endif
           
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select the plot Category.</div>
        </div>
        <div class="col-6">
            <label class="form-label" for="plotCat">Plot Sub Category</label>
            <select class="form-select" id="plotCat" name="plotCat" >
            @if($categories)
                @foreach($categories as $cat)
                <option value="{{$cat->id}}" <?php if($plots->category_id==$cat->id){echo "Selected";} ?>>{{$cat->name}}</option>
                @endforeach
                @endif
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select the plot Category.</div>
        </div>
        <div class="col-6">
            <label class="form-label" for="plotLocation">Plot Location</label>
            <select class="form-select" id="plotLocation" name="plotLocation" >
            @if($locations)
                @foreach($locations as $location)
                <option value="{{$location->id}}" <?php if($plots->plot_location_id ==$location->id){echo "Selected";} ?>>{{$location->location_name }}</option>
                @endforeach
                @endif
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select the plot location.</div>
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
    function setError(element, message) {
    element.classList.add("is-invalid");
    const errorContainer = element.nextElementSibling;
    if (errorContainer && errorContainer.classList.contains("invalid-feedback")) {
        errorContainer.style.display = "block";
        errorContainer.innerText = message;
    }
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

    function saveSchemePlot(plot) {
   
   $.ajax({
       method: "POST",
       url: "/api/edit-scheme-plot",
       data: { plot: plot },
       headers: {
           "X-CSRF-TOKEN": csrfToken
       },
       success: function(data) {
           if (data.success==true) {
               showToast(data.message, "success");
               setTimeout(() => {
                   window.location.href = "/plots";
               }, 2000);
           } else {
               showToast("Error: " + data.message, "danger");
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
   










    

    // Validate Plot Size
    const plotSize = document.getElementById("plotSize");
    if (plotSize.value === "") {
        setError(plotSize, "Please select the plot size.");
        isValid = false;
    }
    const plotCategories = document.getElementById("plotCategories");
    if (plotCategories.value === "") {
        setError(plotCategories, "Please select the plot size.");
        isValid = false;
    }

    // Validate Plot Location
    const plotLocation = document.getElementById("plotLocation");
    if (plotLocation.value === "") {
        setError(plotLocation, "Please select the plot location.");
        isValid = false;
    }
    const plotCat = document.getElementById("plotCat");
    if (plotCat.value === "") {
        setError(plotCat, "Please select the  plot SUB Category.");
        isValid = false;
    }
    var id=$("#pid").val();

    if (isValid) {
        const scheme = {
            plotSize: plotSize.value,
            plotLocation: plotLocation.value,
            plotCat:plotCat.value,
            category:plotCategories.value,
            id:id
        };

        saveSchemePlot(scheme); // Call save function to handle form submission
    }
});
</script>

@endsection