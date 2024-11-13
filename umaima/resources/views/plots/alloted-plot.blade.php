@extends('layout.app')

@section('title', 'Home Page')
@section('content')

      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        
          <div class="container-xxl flex-grow-1 container-p-y">
            
          <div class="row">
            <div class="col">
                <h6 class="mt-6"> Form with Tabs </h6>
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
                        <div class="row">    
                    @if(!empty($plots))
                    @foreach ($plots['plots'] as $plot) 
                    
                    <?php $status = $plot['status'] == 0 ? "success" : ($plot['status'] == 1 ? "primary" : "warning");?>
                            <div class="col-3 col-md-2 col-lg-1 text-white mb-1">
                                <div class="bg-{{$status}} text-center p-2"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-{{$status}}" data-bs-original-title="Success tooltip">
                                    {{$plot['plot_number']}}
                                </div>
                                
                            </div>
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
          <!-- / Content -->

          
          
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
    <script src="../../assets/js/main.js"></script>
    

    <!-- Page JS -->
    <script src="../../assets/js/charts-apex.js"></script>
    
    @endsection


