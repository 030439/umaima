
<?php $breadCrumb='Cashbook / <span class="text-primary"> Cashbook</span></i>'?>
<?php $__env->startSection('title', 'Cashbook'); ?>
<?php $__env->startSection('content'); ?>
  
<!-- / Navbar -->
      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
          <!-- Product List Table -->
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Filter</h5>
              <div class="d-flex justify-content-between align-items-center row pt-4 gap-6 gap-md-0">
                  <div class="col-md-4">
                      <label for="flatpickr-date" class="form-label">Scheme </label>
                      <select id="paymentType" class="form-select">
                          <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($scheme->id); ?>"><?php echo e($scheme->scheme); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                  </div>
                  <div class="col-md-3">
                      <label for="flatpickr-date" class="form-label">From Date </label>
                      <input type="date" class="form-control" placeholder="YYYY-MM-DD" id="fromdate">
                  </div>
                  <div class="col-md-3">
                      <label for="flatpickr-date" class="form-label">To Date</label>
                      <input type="date" class="form-control" placeholder="YYYY-MM-DD" id="todate">
                  </div>
                  <div class="col-md-2">
                    <button class="btn btn-primary mt-4" id="ledgerPrint" onclick="ledgerPrint()">Print</button>
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
<script src="../../assets/vendor/libs/moment/moment.js"></script>
<script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="../../assets/vendor/libs/select2/select2.js"></script>


<!-- Main JS -->

<script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script> 
<script src="../../assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="../../assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<script src="../../assets/vendor/libs/jquery-timepicker/jquery-timepicker.js"></script>
<script src="../../assets/vendor/libs/pickr/pickr.js"></script>

<!-- Main JS -->

<script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script src="../../assets/js/extended-ui-sweetalert2.js"></script>

<!-- Page JS -->
<script src="../../assets/js/forms-pickers.js"></script>

<!-- Page JS -->
<script src="../../assets/js/receiving-report.js"></script>

<script src="../../assets/js/main.js"></script>

<script>
  $(document).ready(function() {
    function ledgerPrint() 
    {
      var scheme = $('#paymentType').val();
      var fromdate_ = $('#fromdate').val(); 
      var todate_ = $('#todate').val(); 

      if(!scheme){
        return   alert("Please select a Scheme", "danger");
      }
      if(!fromdate_){
        return   alert("Please select a From date", "danger");
      }
      if(!todate_){
        return   alert("Please select a to date", "danger");
      }


      $.ajax({
          method: "POST",
          url: "/api/ledgerPrintReceivingReport",
          headers: {
              "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
          },
          data: {
              startDate: fromdate_,
              endDate: todate_,
              scheme: scheme,
          },
          success: function(data) {
              if (data) {
                  var printWindow = window.open('', '_blank');
                  printWindow.document.open();
                  printWindow.document.write(data); // write the server response into the new window
                  printWindow.document.close();
                  printWindow.focus();
                  printWindow.print(); // trigger the print dialog
                  printWindow.close(); // optional: close after printing
              }
          },
          error: function(xhr, status, error) {
              console.error("AJAX Error:", status, error);
          }
      });
    }
  });
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\umaima\umaima\resources\views/accounts/receivingReport.blade.php ENDPATH**/ ?>