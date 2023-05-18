<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>EDDS</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('frontend-assets/imgs/theme/favicon.ico')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend-assets/css/font-awesome.min.css')); ?>">
    <script src="<?php echo e(asset('plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/sweetalert2/sweetalert2.min.css')); ?>">
    <link href="<?php echo e(asset('frontend-assets/css/tailwind.min.css')); ?>" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .pagination>li>a:focus,
        .pagination>li>a:hover,
        .pagination>li>span:focus,
        .pagination>li>span:hover {
            z-index: 3;
            color: #23527c;
            background-color: purple;
            border-color: #ddd;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo \Livewire\Livewire::styles(); ?>

</head>


<body>
    

    <main class="main">
        
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <!-- Vendor JS-->
    <!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php echo \Livewire\Livewire::scripts(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script>
        Livewire.on('added', message => {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '' + message + '',
                showConfirmButton: false,
                timer: 2500
            })
        })
        Livewire.on('error', message => {
            Swal.fire({
                position: 'top-end',
                icon: 'warning',
                title: 'SORRY',
                text: '' + message + '',
                showConfirmButton: true,
                timer: 5000
            })
        })
    </script>
</body>


</html>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/livewire/frontend/master.blade.php ENDPATH**/ ?>