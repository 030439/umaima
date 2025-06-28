
<?php $breadCrumb='Expenses / <span class="text-primary">Expense Heads</span></i>'?>
<?php $__env->startSection('title', 'Expense-head'); ?>
<?php $__env->startSection('content'); ?>
      <div class="content-wrapper">


        <div class="container-xxl flex-grow-1 container-p-y">
          <div class="card">

            <div class="card-header">
              <h5 class="card-title">Filter</h5>
            </div>

            <div class="card-datatable card-body table-responsive">
              <div class="row">
                <div class="col-md-6">
                    <select id="subcat" class="form-select text-capitalize">
                    </select>
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control flatpickr-input" placeholder="YYYY-MM-DD to YYYY-MM-DD" id="flatpickr-range" readonly="readonly">
                </div>
              </div>
              <table class="datatables-order table border-top">
          
              </table>

            </div>
          </div>
        </div>


          
<?php $__env->stopSection(); ?>
<?php $__env->startSection('files'); ?>

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

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <!-- Main JS -->
<script src="../../assets/vendor/libs/moment/moment.js"></script>
<script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script> 
<script src="../../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="../../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<script src="../../assets/vendor/libs/jquery-timepicker/jquery-timepicker.js"></script>
<script src="../../assets/vendor/libs/pickr/pickr.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>
    

    <!-- Page JS -->
    <script src="../../assets/js/forms-pickers.js"></script>
    
    <!-- Page JS -->
    <script src="../../assets/js/expenses.js"></script>
    <?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\umaima\umaima\resources\views/accounts/expenses.blade.php ENDPATH**/ ?>