
<?php $breadCrumb='Loan / <span class="text-primary">Add</span></i>'?>
<?php $__env->startSection('title', 'loan'); ?>
<?php $__env->startSection('content'); ?>
      <div class="content-wrapper">

        <!-- Content -->
        
          <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Multi Column with Form Separator -->
            <div class="row">
          
            <div class="col-xxl">
                <div class="card mb-6">
                <h5 class="card-header">Loans</h5>
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

                        <div class="col-6 " id="allote_section">
                            <label class="col-form-label text-sm-end" for="allotees">Party</label>
                            <select id="allotees" name="party" class="select2 form-select" data-allow-clear="true">
                            <option value="">Select Party</option>    
                            <?php if(!empty($party)): ?>
                                <?php $__currentLoopData = $party; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($part->id); ?>"><?php echo e($part->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-6">
                            <label class="col-form-label text-sm-end" for="from_account"> Account</label>
                            <select id="from_account" name="from_account" class="select2 form-select" data-allow-clear="true">
                                <option value="">Select Account</option>
                                <?php if(!empty($banks)): ?>
                                <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($bank->id); ?>"><?php echo e($bank->bank_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-6">
                            <label class="col-form-label text-sm-end" for="amount">Amount</label>
                            <input type="number" id="amount" name="amount" class="form-control" tag="Enter Amount" />
                        </div>

                        <div class="col-6">
                            <label class="col-form-label text-sm-end" for="narration">Receipt No</label>
                            <input type="text" id="receipt_id" name="receipt_id" class="form-control" tag="Enter Narration" />
                        </div>

                        <div class="col-6">
                            <label class="col-form-label text-sm-end" for="narration">Narration</label>
                            <input type="text" id="narration" name="narration" class="form-control" tag="Enter Narration" />
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

                fetch("/api/loan/store", {
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
                            window.location.href = "/loans";
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
    
    <?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\umaima\umaima\resources\views/loans/add-loan.blade.php ENDPATH**/ ?>