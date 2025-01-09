
    









<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template" data-style="light">
<head>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?php echo $__env->yieldContent('title', 'Default Title'); ?></title>
    <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <body>
<div class="layout-wrapper layout-content-navbar  ">
  <div class="layout-container">

  <div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer" style="color:#fff !important"></div>
    
     <?php echo $__env->make('partials.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
     <div class="layout-page">
      <?php echo $__env->make('partials.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo $__env->yieldContent('content'); ?>
      <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo $__env->yieldContent('files'); ?> 
  </body>
</html>


<?php /**PATH C:\xampp\htdocs\umaima\umaima\resources\views/layout/app.blade.php ENDPATH**/ ?>