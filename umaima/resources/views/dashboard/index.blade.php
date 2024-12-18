@extends('layout.app')
<?php $breadCrumb=' <span class="text-primary"></span></i>'?>
@section('title', 'Home Page')
@section('content')
 <!-- Content wrapper -->
 <div class="content-wrapper">

<!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    
    <div class="card">
      <div class="card-body">
        <div class="card-title">Schemes</div>
          <div class="row mb-5">
            @if($totalPlotsSchemeWise)
            @foreach($totalPlotsSchemeWise as $sp)
              <div class="col-lg-6 col-sm-6">
                <a href="scheme-plots/{{$sp->sid}}">
                  <div class="card h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                      <div class="card-title mb-0">
                        <h5 class="mb-1 me-2">{{$sp->total_plots}}</h5>
                        <p class="mb-0">{{$sp->scheme}}</p>
                      </div>
                      <div class="card-icon">
                        <span class="badge bg-label-warning rounded p-2">
                          <i class='ti ti-alert-octagon ti-26px'></i>
                        </span>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
            @endif
          </div>
        </div>
     </div>
    <div class="row mt-3 mb-3">
     
      <div class="col-xxl-6 col-md-6">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between badge bg-success mb-3">
            <div class="card-title mb-0">
              <h6 class="mb-1 text-white">Received Payments</h6>
              <!-- <p class="card-subtitle">Monthly Sales Overview</p> -->
            </div>
            <i class="menu-icon tf-icons ti ti-checkbox"></i>
          </div>
          <div class="card-body">
            <ul class="p-0 m-0">
              @if($totalPaymentsByAllote)
              @foreach($totalPaymentsByAllote as $ap)
                <li class="d-flex align-items-center mb-4">
                
                  <div class="d-flex w-100 flex-wrap align-items-center badge bg-label-gray justify-content-between gap-2">
                    <div class="me-2">
                      <div class="d-flex align-items-center">
                        <h6 class="mb-0 me-1">{{$ap->allote}}</h6>
                      </div>
                    </div>
                    <div class="user-progress">
                      <p class="text-info fw-medium mb-0 d-flex align-items-center gap-1">
                        {{$ap->total_amount}}
                      </p>
                    </div>
                  </div>
                </li>
              @endforeach
              @endif
            </ul>
          </div>
        </div>
      </div>
      <div class="col-xxl-6 col-md-6">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between badge bg-info mb-3">
            <div class="card-title mb-0">
              <h6 class="mb-1 text-white">Expense By Expense Heads</h6>
              <!-- <p class="card-subtitle">Monthly Sales Overview</p> -->
            </div>
            <i class="menu-icon tf-icons ti ti-file-description"></i>
          </div>
          <div class="card-body">
            <ul class="p-0 m-0">
              @if($totalPaymentsByAllote)
              @foreach($totalPaymentsByAllote as $ap)
                <li class="d-flex align-items-center mb-4">
                
                  <div class="d-flex w-100 badge bg-label-gray flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <div class="d-flex align-items-center">
                        <h6 class="mb-0 me-1">{{$ap->allote}}</h6>
                      </div>
                    </div>
                    <div class="user-progress">
                      <p class="text-info fw-medium mb-0 d-flex align-items-center gap-1">
                        {{$ap->total_amount}}
                      </p>
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

<div class="row">
            <div class="col">
                <h6 class="mt-6">Scheme-Wise-Plots</h6>
                <div class="card mb-6">
                <div class="card-header px-0 pt-0">
                    <div class="nav-align-top">
                      
                    <ul class="nav nav-tabs" role="tablist">
                        @if(!empty($groupedPlots))
                        
                        @foreach($groupedPlots as $schemeName => $plots)
                        <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link waves-effect <?php if($schemeName==0){echo 'active';}?>" data-bs-toggle="tab" data-bs-target="#t{{$schemeName}}" aria-controls="form-tabs-personal" role="tab" aria-selected="true"><span class="ti ti-user ti-lg d-sm-none"></span><span class="d-none d-sm-block">{{$plots['scheme']}}</span></button>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                    </div>
                </div>

                <div class="card-body">
                    <div class="tab-content p-0">
                    <!-- Personal Info -->
                    @if(!empty($groupedPlots))
                    @foreach($groupedPlots as $schemeName => $plots)

                    <div class="tab-pane fade <?php if($schemeName==0){echo 'active';}?> show" id="t{{$schemeName}}" role="tabpanel">
                        <div class="row" style="margin-left:20px">    
                    @if(!empty($plots))
                    @foreach ($plots['plots'] as $plot) 
                             <?php if($plot['aid']){?>
                              <a href="allote-plotes/{{$plot['aid']}}" class="col-3 col-md-2 col-lg-1 text-white  bg-info text-center p-4" 
                            style="margin:1px"  data-bs-toggle="tooltip" 
                            data-bs-placement="top" 
                            data-bs-custom-class="tooltip-info"
                            data-bs-original-title="{{$plot['allote']}}">
                                    {{$plot['plot_number']}}
                            </a>
                            <?php }else{?>
                              <a href="#" class="col-3 col-md-2 col-lg-1 text-white  bg-primary text-center p-4" 
                                style="margin:1px"  data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                data-bs-custom-class="tooltip-primary"
                                data-bs-original-title="{{$plot['allote']}}">
                                    {{$plot['plot_number']}}
                             </a>
                              <?php
                            }?>
                    @endforeach
                     @endif
                     </div>
                    </div>
                    @endforeach
                    @endif
                 </div>
                </div>
                </div>
            </div>
            </div>


          </div>

</div>
  <!-- / Content -->

  
  
  <div class="modal fade " id="addNewCCModal" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="mb-2">Add New Card</h4>
          <p>Add new card to complete payment</p>
        </div>
        
        <form action="{{ route('bulk.store') }}" method="POST" class="dropzone"  id="dropzone-basic">
          @csrf
            <div class="dz-message">
                Drop files here or click to upload.
            </div>
        </form>

      </div>
    </div>
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
    <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

<!-- Main JS -->
<script src="../../assets/js/main.js"></script>


<!-- Page JS -->
<script src="../../assets/js/extended-ui-sweetalert2.js"></script>
    

    <!-- Page JS -->
    <script src="../../assets/js/dashboards-crm.js"></script>
    <script>
      function addPlotSize() {
        const addCCModal = new bootstrap.Modal(document.getElementById('addNewCCModal'));
        addCCModal.show();
    }
    </script>
 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
 <script src="../../assets/js/forms-file-upload.js"></script>

 <script>
       

        function applySurcharge() {
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

                fetch("/api/apply/surcharge", {
                    method: "POST",
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
                            //window.location.href = "/cashbook";
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
        applySurcharge();
    </script>

@endsection
