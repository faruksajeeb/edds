<?php $__env->startPush('styles'); ?>
    <style>
        .nav-link {
            font-size: 20px;
            font-weight: bold;
        }

        .themed-grid-col {
            min-height: 350px;
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

        .category-item p {
            font-size: 25px;
        }

        .category-item h2 {
            /* font-size: 50px; */
        }

        .division-wise-table {
            font-size: 25px;
        }

        .map-section {
            min-height: 200px;
            /* background-color: #F5F0BB; */
            background-color: #FBFFDC;
        }

        .distict-div:hover {
            fill: #FAFF00 !important;
            /* transform: scale(1.1,1.1); */
            /* transition: 0.3s; */
        }

        .slider-section {
            background-image: url("<?php echo e(asset('/uploads/')); ?>/edds_bg.png");
            /* opacity: 0.75; */
            /* style="background-color: #F5F0BB;" */
            /* background-color: rgba(255, 0, 0, 0.5); */
        }
    </style>
    <style>
        #map {
            height: 100%;
        }

        /*
         * Optional: Makes the sample page fill the window.
         */
        .map-section {
            height: 500px;
            margin: 0;
            padding: 0;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php if(session()->get('locale') == 'bn'): ?>
    <?php $__env->startPush('styles'); ?>
        <style>
            * {

                font-family: solaimanLipiBanglaFont;
            }
        </style>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php
    //dd(\App\Lib\Webspice::appUrl());
?>
<div class="container-fluid mx-0 px-0 ">
    <div class="container-fluid header-section py-3">
        <div class="container">
            <!-- navigation -->
            <header class="navigation">
                <nav class="navbar sticky-top navbar-expand-xl navbar-light text-center py-3">
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
                                <li class="nav-item"> <a class="nav-link"
                                        href="<?php echo e(route('/')); ?>"><?php echo e(__('menu.home')); ?></a>
                                </li>
                                <li class="nav-item "> <a class="nav-link"
                                        href="<?php echo e(route('/')); ?>"><?php echo e(__('menu.about')); ?></a>
                                </li>
                                <li class="nav-item "> <a class="nav-link"
                                        href="<?php echo e(route('/')); ?>"><?php echo e(__('menu.services')); ?></a>
                                </li>
                                <li class="nav-item "> <a class="nav-link"
                                        href="<?php echo e(route('/')); ?>"><?php echo e(__('menu.contact')); ?></a>
                                </li>
                                
                            </ul>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary"><?php echo e(__('menu.login')); ?></a>
                            <?php if(session()->get('locale') == 'bn'): ?>
                                <button class="btn btn-danger text-white ms-2 changeLang"
                                    value="en">English</button>
                            <?php elseif(!session()->get('locale') || session()->get('locale') == 'en'): ?>
                                <button class="btn primary_bg_color text-white ms-2 changeLang"
                                    value="bn">বাংলা</button>
                            <?php endif; ?>

                        </div>
                    </div>
                </nav>
            </header>
            <!-- /navigation -->
        </div>
    </div>
    <div class="container-fluid slider-section h-100 mx-0 px-0 py-5 ">

        <div class="container my-3">
            <div class="row align-items-md-stretch">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 my-3 ">
                        <div class="h-100 p-4 text-dark bg-white rounded-1 text-center category-item">
                            <div class="iconBox">
                                
                                <span
                                    class="big_number"><?php echo e(session()->get('locale') == 'bn' ? $webspice->convertToBanglaNumber($category['response_data']) : $category['response_data']); ?></span>
                                <p><?php echo e(__('text.today')); ?></p>
                            </div>
                            <h2 class="fw-bold my-5 primary_text_color">
                                <?php echo e(session()->get('locale') == 'bn' ? $category['category_name_bangla'] : $category['category_name']); ?>

                            </h2>


                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
        </div>

    </div>

    <div class="container-fluid mx-0 px-0 py-5">
        <div class="container my-5 table-responsive-sm">
            <table class="table  table-hover division-wise-table">
                <thead>
                    <?php
                    $colSpan = count($categories);
                    ?>
                    <tr class="primary_bg_color">
                        <th colspan="<?php echo e($colSpan + 1); ?>"
                            class="text-center py-3 primary_bg_color text-white display-6">
                            <?php echo e(__('text.tabular_statistic_title')); ?></th>
                    </tr>
                    <tr class="table-dark">
                        <th class=""><?php echo e(__('text.location')); ?></th>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="text-center">
                                <?php echo e(session()->get('locale') == 'bn' ? $category['category_name_bangla'] : $category['category_name']); ?>

                            </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody>

                    <?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $division): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="table-warning">
                            <td class="">
                                <?php echo e(session()->get('locale') == 'bn' ? $webspice->convertToBanglaDivision($division['division_name']) : $division['division_name']); ?>

                            </td>

                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="text-center">
                                    <?php echo e(session()->get('locale') == 'bn' ? $webspice->convertToBanglaNumber($division[$key]) : $division[$key]); ?>

                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </tbody>
            </table>
        </div>
    </div>

    <div class="container-fluid  mx-0 px-2 py-5 " style="background-color: #EEEEEE">
        <div class="container">
            <div class="row m-0 p-0">
                <div class="col-md-12 py-4">
                    <h3 class="text-center"><?php echo e(__('text.map_section_title')); ?></h3>
                </div>
            </div>
            <div class="row m-0 p-0" id="gallery-section">
                
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 text-center mt-3">
                        <div class="card border-0 rounded-0">
                            <div class="card-header fw-bold " style="background-color: #F2CD5C">
                                <?php echo e(session()->get('locale') == 'bn' ? $category['category_name_bangla'] : $category['category_name']); ?>

                            </div>
                            <div class="card-body">
                                <div class="col-md-12 map-section">
                                    <div id="map<?php echo e($category['category_id']); ?>" style="height: 500px"></div>
                                </div>
                            </div>
                            <div class="card-footer m-0 p-0">
                                <div class="row m-0 p-0">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                

                <!-- partial -->
            </div>

            <div class="row m-0 p-0 ">

            </div>
        </div>
    </div>
    <div class="container-fluid py-3  primary_bg_color ">
        <div class="container text-center text-white">
            <?php echo e(__('text.copyright')); ?>

        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        function initMap() {
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                let map<?php echo e($category['category_id']); ?>, heatmap<?php echo e($category['category_id']); ?>;
                map<?php echo e($category['category_id']); ?> = new google.maps.Map(document.getElementById(
                    "map<?php echo e($category['category_id']); ?>"), {
                    zoom: 7,
                    center: {
                        lat: 23.6850,
                        lng: 90.3563
                    },
                    // mapTypeId: "satellite",
                    // mapTypeId: "roadmap",
                    mapTypeId: "hybrid",
                    // mapTypeId: "terrain",
                });
                heatmap<?php echo e($category['category_id']); ?> = new google.maps.visualization.HeatmapLayer({
                    data: [
                        <?php $__currentLoopData = $category['response_locations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($val['latitude']!='' && $val['longitude']!=''): ?>                                
                                new google.maps.LatLng(<?php echo e($val['latitude']); ?>,<?php echo e($val['longitude']); ?>),
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ],
                    map: map<?php echo e($category['category_id']); ?>,
                });
                heatmap<?php echo e($category['category_id']); ?>.set("radius", heatmap<?php echo e($category['category_id']); ?>.get("radius") ?
                    null : 20);
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        }
        // Heatmap data: 500 Points
        function getPoints() {
            return [
                new google.maps.LatLng(23.8103, 90.4125),
                new google.maps.LatLng(23.9999, 90.4203),
            ];
        }
    </script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC08AOyEIZxUheEbBU8-BXrW_4M42oF8JQ&callback=initMap&libraries=visualization&v=weekly"
        defer></script>
    <script type="text/javascript">
        var url = "<?php echo e(route('changeLang')); ?>";
        $(".changeLang").on('click', function() {
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