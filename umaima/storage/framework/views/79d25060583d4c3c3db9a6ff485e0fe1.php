<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Tax Invoice</title>
    <link rel="shortcut icon" type="image/png" href="./favicon.png" />
    <style>
      * {
        box-sizing: border-box;
      }

      .table-bordered td,
      .table-bordered th {
        border: 1px solid #ddd;
        padding: 10px;
        word-break: break-all;
      }

      body {
        font-family: Arial, Helvetica, sans-serif;
        margin: 0;
        padding: 0;
        font-size: 16px;
      }
      .h4-14 h4 {
        font-size: 12px;
        margin-top: 0;
        margin-bottom: 5px;
      }
      .img {
        margin-left: "auto";
        margin-top: "auto";
        height: 30px;
      }
      pre,
      p {
        /* width: 99%; */
        /* overflow: auto; */
        /* bpicklist: 1px solid #aaa; */
        padding: 0;
        margin: 0;
      }
      table {
        font-family: arial, sans-serif;
        width: 100%;
        border-collapse: collapse;
        padding: 1px;
      }
      .hm-p p {
        text-align: left;
        padding: 1px;
        padding: 5px 4px;
      }
      td,
      th {
        text-align: left;
        padding: 8px 6px;
      }
      .table-b td,
      .table-b th {
        border: 1px solid #ddd;
      }
      th {
        /* background-color: #ddd; */
      }
      .hm-p td,
      .hm-p th {
        padding: 3px 0px;
      }
      .cropped {
        float: right;
        margin-bottom: 20px;
        height: 100px; /* height of container */
        overflow: hidden;
      }
      .cropped img {
        width: 400px;
        margin: 8px 0px 0px 80px;
      }
      .main-pd-wrapper {
        box-shadow: 0 0 10px #ddd;
        background-color: #fff;
        border-radius: 10px;
        padding: 15px;
      }
      .table-bordered td,
      .table-bordered th {
        border: 1px solid #ddd;
        padding: 10px;
        font-size: 14px;
      }

         .header {
      text-align: center;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .sub-header {
      text-align: center;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }
    table, th, td {
      border: 1px solid #000;
    }
    th, td {
      padding: 5px;
      text-align: left;
    }
    .category-title {
      background: #eee;
      font-weight: bold;
      padding: 8px;
      margin-top: 20px;
    }
    .total-row {
      font-weight: bold;
      text-align: right;
    }
    .report-meta {
      font-size: 12px;
      margin-bottom: 10px;
      text-align: right;
    }
    .page-title {
      text-align: center;
      font-size: 16px;
      font-weight: bold;
      text-decoration: underline;
    }
    </style>
  </head>
  <body>

  
    <section class="main-pd-wrapper" style="margin:10px 20px">
      <div style="">
          <div class="report-meta">
    Report Print: <?php date_default_timezone_set('Asia/Karachi');
                    echo strtoupper(date('d-M-y h:i A'));
                    ?>
  </div>

  <div class="header">
    CLIENT RECOVERY SUMMARY ALL PROJECTS
  </div>
  <div class="sub-header">
    <?php echo e($scheme); ?><br>
    FROM: <?php echo e($startDate); ?> TO <?php echo e($endDate); ?>

  </div>

    <!-- Repeat for each block -->
    <?php $total=0;?>
    <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
        <div class="category-title">Voucher Type: CRV &nbsp;&nbsp;&nbsp;&nbsp; Block <?php echo e($report['category_name']); ?></div>
        <table>
            <thead>
            <tr>
                <th>Date</th>
                <th>Allote</th>
                <th>Plot</th>
                <th>Receipt No</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $report['records']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                
                <td><?php echo e($record['paydate']); ?></td>
                <td><?php echo e($record['allote']); ?></td>
                <td><?php echo e($record['plot']); ?></td>
                <td><?php echo e($record['receipt_id']); ?></td>
                <td><?php echo e($record['narration']); ?></td>
                <td><?php echo e($record['amount']); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php $total+=$report['total'];?>
            <tr class="total-row">
                <td colspan="5">TOTAL &gt;&gt;&gt;&nbsp;&nbsp;&nbsp;&nbsp; Block B</td>
                <td><?php echo e($report['total']); ?></td>
            </tr>
            
            </tbody>
        </table>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <p class="category-title" style="text-align:right">OVERALL TOTAL&nbsp;&nbsp;:&nbsp;&nbsp; <?php echo e($total); ?></p>

     
    </section>
  </body>
</html>



<?php /**PATH C:\xampp\htdocs\umaima\umaima\resources\views/reports/print-receiving.blade.php ENDPATH**/ ?>