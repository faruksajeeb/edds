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

        .big_number {
            font-size: 50px;
            font-weight: bold;
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
                                src="<?php echo e(asset('/uploads/' . $theme_settings->website_logo)); ?>" alt="icddr,b">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation"> <span
                                class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-3">
                                <li class="nav-item"> <a class="nav-link" href="<?php echo e(route('/')); ?>"><?php echo e(__('menu.home')); ?></a>
                                </li>
                                <li class="nav-item "> <a class="nav-link" href="<?php echo e(route('/')); ?>"><?php echo e(__('menu.about')); ?></a>
                                </li>
                                <li class="nav-item "> <a class="nav-link" href="<?php echo e(route('/')); ?>"><?php echo e(__('menu.services')); ?></a>
                                </li>
                                <li class="nav-item "> <a class="nav-link" href="<?php echo e(route('/')); ?>"><?php echo e(__('menu.contact')); ?></a>
                                </li>
                                
                            </ul>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary"><?php echo e(__('menu.login')); ?></a>
                            <?php if((session()->get('locale') == 'bn')): ?>
                                <button class="btn btn-danger text-white ms-2 changeLang" value="en">English</button>
                            <?php elseif(!session()->get('locale') || session()->get('locale') == 'en'): ?>
                                <button class="btn primary_bg_color text-white ms-2 changeLang" value="bn">বাংলা</button>
                            <?php endif; ?>

                        </div>
                    </div>
                </nav>
            </header>
            <!-- /navigation -->
        </div>
    </div>
    <div class="container-fluid slider-section h-100 mx-0 px-0 py-5 " style="background-color: #FFDEAD">

        <div class="container my-3">
            <div class="row align-items-md-stretch">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 my-3">
                        <div class="h-100 p-3 text-dark bg-white rounded-3 text-center">
                            <div class="iconBox">
                                
                                <span class="big_number"><?php echo e((session()->get('locale')=='bn')?$webspice->convertToBanglaNumber($category['response_data']):$category['response_data']); ?></span>
                                <p><?php echo e(__('text.today')); ?></p>
                            </div>
                            <h2 class="fw-bold my-5 primary_text_color"><?php echo e((session()->get('locale')=='bn')?$category['category_name_bangla'] : $category['category_name']); ?></h2>


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
                    <?php
                    $colSpan = count($categories);
                    ?>
                    <tr class="primary_bg_color">
                        <th colspan="<?php echo e($colSpan + 1); ?>"
                            class="text-center py-3 primary_bg_color text-white display-6"><?php echo e(__('text.tabular_statistic_title')); ?></th>
                    </tr>
                    <tr class="table-dark">
                        <th class=""><?php echo e(__('text.location')); ?></th>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="text-center"><?php echo e((session()->get('locale')=='bn')?$category['category_name_bangla'] : $category['category_name']); ?></th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $division): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="table-warning">
                            <td class=""><?php echo e((session()->get('locale')=='bn')?$webspice->convertToBanglaDivision($division['division_name']):$division['division_name']); ?></td>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="text-center"><?php echo e((session()->get('locale')=='bn')?$webspice->convertToBanglaNumber($division[$key]) : $division[$key]); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="container-fluid py-3  primary_bg_color ">
        <div class="container text-center text-white">
            <?php echo e(__('text.copyright')); ?>

        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        var url = "<?php echo e(route('changeLang')); ?>";

        $(".changeLang").on('click',function() {
            $('.changeLang').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Language Changing...'
                    );
            var lang = $(this).attr('value');
            //alert(lang);
            window.location.href = url + "?lang=" + lang;
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/livewire/frontend/home.blade.php ENDPATH**/ ?>