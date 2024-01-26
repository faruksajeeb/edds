<?php if($message = Session::get('success')): ?>
<!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><i class="fa-solid fa-circle-check"></i> <?php echo $message; ?></strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> -->
<script>
    Swal.fire({
        title: "Success!",
        text: "<?php echo $message; ?>",
        icon: "success"
    });
</script>
<?php echo e(session()->forget('success')); ?>

<?php endif; ?>

<?php if($message = Session::get('error')): ?>
<!-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong><i class="fa-solid fa-circle-exclamation"></i> <?php echo $message; ?></strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> -->
<script>
    Swal.fire({
        title: "Error!",
        text: "<?php echo $message; ?>",
        icon: "error"
    });
</script>
<?php echo e(session()->forget('error')); ?>

<?php endif; ?>

<?php if($message = Session::get('warning')): ?>
<!-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong> <i class="fa-solid fa-circle-exclamation"></i> <?php echo $message; ?></strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> -->
<script>
    Swal.fire({
        title: "Warning!",
        text: "<?php echo $message; ?>",
        icon: "warning"
    });
</script>
<?php echo e(session()->forget('warning')); ?>

<?php endif; ?>

<?php if($message = Session::get('info')): ?>
<!-- <div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong><i class="fa-solid fa-circle-info"></i> <?php echo $message; ?></strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> -->
<script>
    Swal.fire({
        title: "Info!",
        text: "<?php echo $message; ?>",
        icon: "info"
    });
</script>
<?php echo e(session()->forget('info')); ?>

<?php endif; ?>

<?php if($errors->any()): ?>
<!-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fa-solid fa-circle-exclamation"></i>
    Please check the form below for errors<br />
    <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> -->
<script>
    Swal.fire({
        title: "Validation Error!",
        text: "",
        icon: "error"
    });
</script>
<?php endif; ?><?php /**PATH D:\laragon\www\laravel\edds\resources\views/layouts/flash-message.blade.php ENDPATH**/ ?>