@extends('layout.app')
<?php $breadCrumb=' <span class="text-primary"></span></i>'?>
@section('title', 'Home Page')
@section('content')
 <!-- Content wrapper -->
 <div class="content-wrapper">

<!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
  <div class="col-xl-12 mb-6">
        <div class="card h-100">
          <div class="card-body d-flex justify-content-between" style="position: relative;">
            <div class="d-flex flex-column">
              <div class="card-title mb-auto">
                <h5 class="mb-0 text-nowrap">Generated Leads</h5>
                <p class="mb-0">Monthly Report</p>
              </div>
              <div class="chart-statistics">
                <h3 class="card-title mb-0">4,350</h3>
                <p class="text-success text-nowrap mb-0"><i class="ti ti-chevron-up me-1"></i> 15.8%</p>
              </div>
            </div>
            <div id="generatedLeadsChart" style="min-height: 131.8px;"><div id="apexcharts5vw0in9j" class="apexcharts-canvas apexcharts5vw0in9j apexcharts-theme-light" style="width: 120px; height: 131.8px;"><svg id="SvgjsSvg1702" width="120" height="131.8" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1704" class="apexcharts-inner apexcharts-graphical" transform="translate(-22.5, 15)"><defs id="SvgjsDefs1703"><clipPath id="gridRectMask5vw0in9j"><rect id="SvgjsRect1706" width="169" height="110" x="-2" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMask5vw0in9j"></clipPath><clipPath id="nonForecastMask5vw0in9j"></clipPath><clipPath id="gridRectMarkerMask5vw0in9j"><rect id="SvgjsRect1707" width="169" height="114" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG1708" class="apexcharts-pie"><g id="SvgjsG1709" transform="translate(0, 0) scale(1)"><circle id="SvgjsCircle1710" r="34.7609756097561" cx="82.5" cy="55" fill="transparent"></circle><g id="SvgjsG1711" class="apexcharts-slices"><g id="SvgjsG1712" class="apexcharts-series apexcharts-pie-series" seriesName="Electronic" rel="1" data:realIndex="0"><path id="SvgjsPath1713" d="M 82.5 5.341463414634141 A 49.65853658536586 49.65853658536586 0 0 1 132.14207316729613 53.72139628776691 L 117.24945121710729 54.104977401436834 A 34.7609756097561 34.7609756097561 0 0 0 82.5 20.239024390243898 L 82.5 5.341463414634141 z" fill="rgba(36,179,100,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-0" index="0" j="0" data:angle="88.52459016393442" data:startAngle="0" data:strokeWidth="0" data:value="45" data:pathOrig="M 82.5 5.341463414634141 A 49.65853658536586 49.65853658536586 0 0 1 132.14207316729613 53.72139628776691 L 117.24945121710729 54.104977401436834 A 34.7609756097561 34.7609756097561 0 0 0 82.5 20.239024390243898 L 82.5 5.341463414634141 z"></path></g><g id="SvgjsG1714" class="apexcharts-series apexcharts-pie-series" seriesName="Sports" rel="2" data:realIndex="1"><path id="SvgjsPath1715" d="M 132.14207316729613 53.72139628776691 A 49.65853658536586 49.65853658536586 0 0 1 63.39809407308648 100.8376204199069 L 69.12866585116053 87.08633429393483 A 34.7609756097561 34.7609756097561 0 0 0 117.24945121710729 54.104977401436834 L 132.14207316729613 53.72139628776691 z" fill="rgba(83,210,140,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-1" index="0" j="1" data:angle="114.09836065573771" data:startAngle="88.52459016393442" data:strokeWidth="0" data:value="58" data:pathOrig="M 132.14207316729613 53.72139628776691 A 49.65853658536586 49.65853658536586 0 0 1 63.39809407308648 100.8376204199069 L 69.12866585116053 87.08633429393483 A 34.7609756097561 34.7609756097561 0 0 0 117.24945121710729 54.104977401436834 L 132.14207316729613 53.72139628776691 z"></path></g><g id="SvgjsG1716" class="apexcharts-series apexcharts-pie-series" seriesName="Decor" rel="3" data:realIndex="2"><path id="SvgjsPath1717" d="M 63.39809407308648 100.8376204199069 A 49.65853658536586 49.65853658536586 0 0 1 33.36921383151037 62.220533655227136 L 48.10844968205726 60.054373558658995 A 34.7609756097561 34.7609756097561 0 0 0 69.12866585116053 87.08633429393483 L 63.39809407308648 100.8376204199069 z" fill="rgba(126,221,169,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-2" index="0" j="2" data:angle="59.016393442622956" data:startAngle="202.62295081967213" data:strokeWidth="0" data:value="30" data:pathOrig="M 63.39809407308648 100.8376204199069 A 49.65853658536586 49.65853658536586 0 0 1 33.36921383151037 62.220533655227136 L 48.10844968205726 60.054373558658995 A 34.7609756097561 34.7609756097561 0 0 0 69.12866585116053 87.08633429393483 L 63.39809407308648 100.8376204199069 z"></path></g><g id="SvgjsG1718" class="apexcharts-series apexcharts-pie-series" seriesName="Fashion" rel="4" data:realIndex="3"><path id="SvgjsPath1719" d="M 33.36921383151037 62.220533655227136 A 49.65853658536586 49.65853658536586 0 0 1 82.49133295039263 5.341464170976899 L 82.49393306527485 20.23902491968383 A 34.7609756097561 34.7609756097561 0 0 0 48.10844968205726 60.054373558658995 L 33.36921383151037 62.220533655227136 z" fill="rgba(169,233,197,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-pie-area apexcharts-donut-slice-3" index="0" j="3" data:angle="98.36065573770492" data:startAngle="261.6393442622951" data:strokeWidth="0" data:value="50" data:pathOrig="M 33.36921383151037 62.220533655227136 A 49.65853658536586 49.65853658536586 0 0 1 82.49133295039263 5.341464170976899 L 82.49393306527485 20.23902491968383 A 34.7609756097561 34.7609756097561 0 0 0 48.10844968205726 60.054373558658995 L 33.36921383151037 62.220533655227136 z"></path></g></g></g><g id="SvgjsG1720" class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)"><text id="SvgjsText1721" font-family="Public Sans" x="82.5" y="75" text-anchor="middle" dominant-baseline="auto" font-size=".8125rem" font-weight="400" fill="#28c76f" class="apexcharts-text apexcharts-datalabel-label" style="font-family: &quot;Public Sans&quot;;">Total</text><text id="SvgjsText1722" font-family="Public Sans" x="82.5" y="56" text-anchor="middle" dominant-baseline="auto" font-size="1.5rem" font-weight="500" fill="#444050" class="apexcharts-text apexcharts-datalabel-value" style="font-family: &quot;Public Sans&quot;;">184</text></g></g><line id="SvgjsLine1723" x1="0" y1="0" x2="165" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1724" x1="0" y1="0" x2="165" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line></g><g id="SvgjsG1705" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend"></div><div class="apexcharts-tooltip apexcharts-theme-false"><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(36, 179, 100);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 2;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(83, 210, 140);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 3;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(126, 221, 169);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="order: 4;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(169, 233, 197);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div></div></div>
          <div class="resize-triggers"><div class="expand-trigger"><div style="width: 956px; height: 181px;"></div></div><div class="contract-trigger"></div></div></div>
        </div>
      </div>
    
<div class="row g-6">

<!-- Sales last year -->
<div class="col-xxl-2 col-md-4 col-sm-6">
<div class="card h-100">
<div class="card-header pb-3">
  <div class="row">
    <div class="col-6">
      <h5 class="card-title mb-1">Order</h5>
      <p class="card-subtitle">Last week</p>
    </div>
    <div class="col-6">
    <button class="btn btn-secondary add-new btn-primary waves-effect waves-light"  type="button" onclick="addPlotSize()">
      Add New Ploat Size
    </button>
    </div>
  </div>
</div>
<div class="card-body">
<div id="ordersLastWeek"></div>
<div class="d-flex justify-content-between align-items-center gap-3">
  <h4 class="mb-0">124k</h4>
  <small class="text-success">+12.6%</small>
</div>
</div>
</div>
</div>

<!-- Sessions Last month -->
<div class="col-xxl-2 col-md-4 col-sm-6">
<div class="card h-100">
<div class="card-header pb-0">
<h5 class="card-title mb-1">Sales</h5>
<p class="card-subtitle">Last Year</p>
</div>
<div id="salesLastYear"></div>
<div class="card-body pt-0">
<div class="d-flex justify-content-between align-items-center mt-3 gap-3">
  <h4 class="mb-0">175k</h4>
  <small class="text-danger">-16.2%</small>
</div>
</div>
</div>
</div>

<!-- Total Profit -->
<div class="col-xxl-2 col-md-4 col-6">
<div class="card h-100">
<div class="card-body">
<div class="badge p-2 bg-label-danger mb-3 rounded"><i class="ti ti-credit-card ti-28px"></i></div>
<h5 class="card-title mb-1">Total Profit</h5>
<p class="card-subtitle ">Last week</p>
<p class="text-heading mb-3 mt-1">1.28k</p>
<div>
  <span class="badge bg-label-danger">-12.2%</span>
</div>
</div>
</div>
</div>

<!-- Total Sales -->


<!-- Revenue Growth -->






<!-- Sales By Country -->




<!--/ Activity Timeline -->
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
        
        <form action="{{ route('bulk.store') }}" method="POST" class="dropzone" id="dropzone-multi">
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
    <script src="../../assets/js/main.js"></script>
    

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
