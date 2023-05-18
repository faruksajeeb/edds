<?php $__env->startPush('styles'); ?>
    <style>
        .nav-link {
            font-size: 20px;
            font-weight: bold;
        }

        .themed-grid-col {
            min-height: 250px;
            padding-top: 1rem;
            padding-bottom: 1rem;
            background-color: #e88923;
            border: 5px solid rgba(255, 255, 255, 1);

            color: #FFFFFF;
        }

        .themed-container {
            padding: .75rem;
            margin-bottom: 1.5rem;
            background-color: rgba(0, 123, 255, .15);
            border: 5px solid rgba(255, 255, 255, 1);
        }

        .primary_text_color {
            color: #e88923;
        }

        .primary_bg_color {
            background-color: #e88923 !important;
        }
        .big_number{
            font-size: 50px;
            font-weight:bold;
        }
    </style>
<?php $__env->stopPush(); ?>
<div class="container-fluid mx-0 px-0">
    <div class="container-fluid header-section py-3">
        <div class="container">
            <!-- navigation -->
            <header class="navigation">
                <nav class="navbar navbar-expand-xl navbar-light text-center py-3">
                    <div class="container">
                        <a class="navbar-brand" href="<?php echo e(route('/')); ?>">
                            <img loading="prelaod" decoding="async" class="img-fluid" width="160"
                                src="<?php echo e(asset('/public/logo.png')); ?>" alt="icddr,b">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation"> <span
                                class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-3">
                                <li class="nav-item"> <a class="nav-link" href="<?php echo e(route('/')); ?>">Home</a>
                                </li>
                                <li class="nav-item "> <a class="nav-link" href="<?php echo e(route('/')); ?>">About</a>
                                </li>
                                <li class="nav-item "> <a class="nav-link" href="<?php echo e(route('/')); ?>">Services</a>
                                </li>
                                <li class="nav-item "> <a class="nav-link" href="<?php echo e(route('/')); ?>">Contact</a>
                                </li>
                                
                            </ul>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary">Log In</a>
                            <a href="<?php echo e(route('login')); ?>" class="btn primary_bg_color text-white ms-2">বাংলা</a>

                        </div>
                    </div>
                </nav>
            </header>
            <!-- /navigation -->
        </div>
    </div>
    <div class="container-fluid slider-section h-100 mx-0 px-0 py-5 " style="background-color: #CCC">

        <div class="container my-3">
            <div class="row align-items-md-stretch">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 my-3">
                        <div class="h-100 p-5 text-dark bg-white rounded-3 text-center">
                            <div class="iconBox">
                                
                                <span class="big_number">55</span>
                            </div>
                            <h2 class="fw-bold my-5 primary_text_color"><?php echo e($category->option_value); ?></h2>
                            

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
        </div>

    </div>

    <div class="container-fluid mx-0 px-0 py-5">
        <div class="container my-5 table-responsive-sm">
            <table class="table  table-hover ">
                <thead>
                    <tr class="primary_bg_color">
                        <th colspan="4" class="text-center py-3 primary_bg_color text-white display-6">Division Wise
                            Last 7 Days Statistices</th>
                    </tr>
                    <tr class="table-dark">
                        <th class="">Location</th>
                        <th class="">Poultry</th>
                        <th class="">Wild Bird</th>
                        <th class="">LBM Worker</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-warning">
                        <td class="">Dhaka</td>
                        <td class="">50</td>
                        <td class="">30</td>
                        <td class="">20</td>
                    </tr>
                    <tr class="table-warning">
                        <td class="">Chittagong</td>
                        <td class="">50</td>
                        <td class="">30</td>
                        <td class="">20</td>
                    </tr>
                    <tr class="table-warning">
                        <td class="">Rajshahi</td>
                        <td class="">50</td>
                        <td class="">30</td>
                        <td class="">20</td>
                    </tr>
                    <tr class="table-warning">
                        <td class="">Khulna</td>
                        <td class="">50</td>
                        <td class="">30</td>
                        <td class="">20</td>
                    </tr>
                    <tr class="table-warning">
                        <td class="">Sylhet</td>
                        <td class="">50</td>
                        <td class="">30</td>
                        <td class="">20</td>
                    </tr>
                    <tr class="table-warning">
                        <td class="">Barisal</td>
                        <td class="">50</td>
                        <td class="">30</td>
                        <td class="">20</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="container-fluid py-3  primary_bg_color ">
        <div class="container text-center text-white">
            @ All right reserved by icddr,b
        </div>
    </div>
</div>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/livewire/frontend/home.blade.php ENDPATH**/ ?>