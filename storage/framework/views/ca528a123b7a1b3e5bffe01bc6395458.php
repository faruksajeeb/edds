<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>

    <title><?php echo e(config('app.name', 'Laravel')); ?> | <?php echo e($title); ?></title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <script src="<?php echo e(asset('plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/sweetalert2/sweetalert2.min.css')); ?>">
    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <link rel="stylesheet" href="<?php echo e(asset('plugins/jquery-ui/jquery-ui.css')); ?>" />
   
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/font-awesome/css/all.min.css')); ?>">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />


    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    

    <link rel="stylesheet" href="<?php echo e(asset('plugins/datetimepicker/jquery.datetimepicker.css')); ?>" />
    <!-- year Picker -->
    <link rel="stylesheet" href="<?php echo e(asset('plugins/yearpicker/yearpicker.css')); ?>" />
    <!-- date range picker -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/daterangepicker/daterangepicker.css')); ?>" />
    <!-- Month Picker -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/monthpicker/MonthPicker.min.css')); ?>" />
    <style>
        .themed-grid-col {
            padding-top: 1rem;
            padding-bottom: 1rem;
            background-color: rgba(86, 61, 124, .15);
            border: 1px solid rgba(255, 255, 255, 1);
        }

        .themed-container {
            padding: .75rem;
            margin-bottom: 1.5rem;
            background-color: rgba(0, 123, 255, .15);
            border: 1px solid rgba(255, 255, 255, 1);
        }

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

   

    <?php echo \Livewire\Livewire::styles(); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <section id="main" class="main">
            <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="main-content p-2">
                <?php echo $__env->make('layouts.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <main>
                    <?php echo e($slot); ?>

                </main>
            </div>
        </section>
        

        <!-- Page Heading -->
        

        <!-- Page Content -->
        
    </div>
    <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery-3.6.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/jquery-ui/jquery-ui.js')); ?>"></script>
    <script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>
    

    <script src="<?php echo e(asset('plugins/datetimepicker/jquery.datetimepicker.full.min.js')); ?>"></script>
    <!-- Yearpicker -->
    <script src="<?php echo e(asset('plugins/yearpicker/yearpicker.js')); ?>"></script>
    <!-- daterange picker -->
    <script type="text/javascript" src="<?php echo e(asset('plugins/daterangepicker/moment.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('plugins/daterangepicker/daterangepicker.js')); ?>"></script>
    <!-- Month Picker -->
    <script type="text/javascript" src="<?php echo e(asset('plugins/monthpicker/MonthPicker.min.js')); ?>"></script>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')
            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })();

        $(".yearpicker").yearpicker();
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $(".datetimepicker").datetimepicker({
            format: 'Y-m-d H:i:00',
            "step": 30 //Will Change Minute Interval as 00, 05, 10 ... 55
        });
        $(".monthpicker").MonthPicker({
            ShowIcon: false
            // Button: '<button>...</button>'
        });

        $(document).ready(function() {
            $('.select2').select2();
        });

        function toggleMenu() {
            let toggle = document.querySelector(".toggle");
            let navigation = document.querySelector(".navigation");
            let main = document.querySelector(".main");
            toggle.classList.toggle('active');
            navigation.classList.toggle('active');
            main.classList.toggle('active');
        }
        $(document).on('click', ".active_inactive_btn", function() {
            // var status;
            // if ($(this).is(':checked')) {
            //     alert('checked');
            //     status = 7;                    
            // }else{
            //     status = -7;                   
            // }  

            var id = $(this).val();
            var status = $(this).attr('status');
            var field_id = $(this).attr('id');
            $.ajax({
                type: "GET",
                url: "<?php echo e(route('active.inactive')); ?>",
                dataType: "json",
                data: {
                    id: id,
                    status: $(this).attr('status'),
                    table: $(this).attr('table')
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#" + field_id).attr('status', response.changed_value);
                        if (response.changed_value == -7) {
                            $('#edit_btn_' + field_id).prop('disabled', true);
                        } else if (response.changed_value == 7) {
                            $('#edit_btn_' + field_id).prop('disabled', false);
                        }
                    } else if (response.status == 'not_success') {
                        var $checkbox = $("#" + field_id);
                        ($checkbox.prop("checked") == true) ? $checkbox.prop("checked", false):
                            $checkbox.prop("checked", true);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                        });
                        return false;
                    }
                },
                error: function(xhr, status, error) {
                    // handle error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error,
                    });
                    return false;
                }
            })

        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <?php echo \Livewire\Livewire::scripts(); ?>

    <script>
        Livewire.on('success', message => {
            $(".modal").modal('hide');
            Swal.fire(
                'Success!',
                'Data ' + message + ' successfully!',
                'success'
            )
        })
        Livewire.on('error', message => {
            Swal.fire(
                'Error!',
                message,
                'error'
            )
        })
    </script>
</body>

</html>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/layouts/app.blade.php ENDPATH**/ ?>