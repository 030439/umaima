@extends('layout.app')
<?php $breadCrumb=' <span class="text-primary"></span></i>'?>
@section('title', 'Home Page')
@section('content')
 <!-- Content wrapper -->
 <div class="content-wrapper">

<!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    
  
  <div class="row">
  <div class="col">
    <h6 class="mt-6">Scheme-Wise-Plots</h6>
    <div class="card mb-6">
        <div class="card-header px-0 pt-0">
            <div class="nav-align-top">
                <ul class="nav nav-tabs" role="tablist">
                    <?php if (!empty($groupedPlots)): ?>
                        <?php $isActive = true; $counter=0;?>
                        <?php foreach ($groupedPlots as $schemeName => $plots):  ?>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link waves-effect <?php echo  $isActive ? 'active' : '' ?>" 
                                    data-bs-toggle="tab" 
                                    data-bs-target="#tab-0-<?php echo  $counter; ?>" 
                                    aria-controls="form-tabs-personal" 
                                    role="tab" 
                                    aria-selected="<?php echo  $isActive ? 'true' : 'false' ?>">
                                    <span class="ti ti-user ti-lg d-sm-none"></span>
                                    <span class="d-none d-sm-block"><?php echo  htmlspecialchars($plots['scheme']) ?></span>
                                </button>
                            </li>
                            <?php $isActive = false; $counter++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="card-body">
            <div class="tab-content p-0">
                <?php if (!empty($groupedPlots)): ?>
                    <?php $isActive = true; $counter=0; ?>
                    <?php foreach ($groupedPlots as $schemeName => $plotsGroup): ?>
                        <div class="tab-pane fade <?php echo  $isActive ? 'active show' : '' ?>" 
                            id="tab-0-<?php echo $counter;?>" 
                            role="tabpanel">
                            <div class="row" style="margin-left:20px">
                                <?php if (!empty($plotsGroup)): ?>
                                    <?php foreach ($plotsGroup['plots'] as $k=> $plot): ?>
                                        <?php if (($plot['allote_id'])): ?>
                                            <a href="allote-plotes/{{($plot['allote_id'])}}" 
                                                class="col-3 col-md-2 col-lg-1 text-white bg-info text-center p-4" 
                                                style="margin:1px" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                data-bs-custom-class="tooltip-info" 
                                                data-bs-original-title="<?php echo  htmlspecialchars($plot['allote']) ?>">
                                                <?php echo  htmlspecialchars($plot['plot_number']) ?>
                                            </a>
                                        <?php else: ?>
                                            <a href="#" 
                                                class="col-3 col-md-2 col-lg-1 text-white bg-primary text-center p-4" 
                                                style="margin:1px" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                data-bs-custom-class="tooltip-primary" 
                                                data-bs-original-title="Unallocated">
                                                <?php echo  htmlspecialchars($plot['plot_number']) ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php $isActive = false;$counter++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
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


@endsection
