
<?php $breadCrumb=' Scheme / <span class="text-primary">Plots</span></i>'?>
<?php $__env->startSection('title', 'Scheme-plots'); ?>
<?php $__env->startSection('content'); ?>
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
    <form id="schemePlotForm" class="row g-6"  onsubmit="return false">
        <div class="col-6">
            <label class="form-label" for="schemeSelection">Scheme</label>
            <select class="form-select" id="schemeSelection" name="schemeSelection" >
                <option value="">Select Scheme</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select your scheme</div>
        </div>

        <div class="col-md-6">
            <label class="form-label" for="plotNumber">Plot Number</label>
            <input type="text" id="plotNumber" class="form-control" tag="Plot number" name="plotNumber"  />
            <div class="invalid-feedback">Please enter the plot number.</div>
        </div>

        <div class="col-6">
            <label class="form-label" for="plotSize">Plot Size</label>
            <select class="form-select" id="plotSize" name="plotSize" >
                <option value="">Select Plot Size</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select the plot size.</div>
        </div>
        <div class="col-6">
            <label class="form-label" for="plotCategories">Plot Category</label>
            <select class="form-select" id="plotCategories" name="plotCategories" >
                <option value="">Select Plot Category</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select the plot Category.</div>
        </div>
        <div class="col-6">
            <label class="form-label" for="plotCat">Plot Sub Category</label>
            <select class="form-select" id="plotCat" name="plotCat" >
                <option value="">Select Plot Category</option>
                <option value="1">Residential</option>
                <option value="2">Commercial</option>
            </select>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please select the plot Category.</div>
        </div>
        <div class="col-6">
            <label class="form-label" for="plotLocation">Plot Location</label>
            <select class="form-select" id="plotLocation" name="plotLocation" >
                <option value="">Select Plot Location</option>
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
  <?php $__env->stopSection(); ?>
  <?php $__env->startSection('files'); ?>

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
<script src="../../assets/js/app-add-scheme-plot.js"></script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\umaima\umaima\resources\views/schemes/add-plot.blade.php ENDPATH**/ ?>