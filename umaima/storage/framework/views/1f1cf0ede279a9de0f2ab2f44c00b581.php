<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Import</title>
</head>
<body>
    <h1>Import Excel Data</h1>
    <?php if(session('success')): ?>
        <div style="color:green"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div style="color:red;"><?php echo e(session('error')); ?></div>
    <?php endif; ?>


    <form action="<?php echo e(route('import.upload')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="file" name="file" required>
        <button type="submit">Import</button>
    </form>
</body>
</html><?php /**PATH C:\xampp\htdocs\umaima\umaima\resources\views/import/form.blade.php ENDPATH**/ ?>