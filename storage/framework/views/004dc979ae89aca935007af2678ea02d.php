<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> 
        Survey Report
     <?php $__env->endSlot(); ?>
    <?php $__env->startPush('styles'); ?>
        <style>

        </style>
    <?php $__env->stopPush(); ?>
    <div class="row">
        <div class="col-md-12 text-center">
            <h3 class="text-center">Division Wise Counting Report</h3>
            <div class="row">
                <div class="col-md-12">
                    <div id="mapPanel" style="height:800px; width:100%; position:relative">
                        <div id="map" style="height:100%; width:100%;"></div>
                        <div
                            style="position:absolute; top:50px; right:50px; padding:3px; height:18px; background:#fe6223; border-radius:3px;">
                            Poultry</div>
                        <div
                            style="position:absolute; top:75px; right:50px; padding:3px; height:18px; background:#f6cb2b; border-radius:3px;">
                            Wild Bird</div>
                        <div
                            style="position:absolute; top:100px; right:50px; padding:3px; height:18px; background:#17d27c; border-radius:3px;">
                            LBM Worker</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC08AOyEIZxUheEbBU8-BXrW_4M42oF8JQ&callback=initMap"
            defer></script>
        <script>
            // For latitude and longitude addition/subtraction do:
            var meters = 10000;

            // number of km per degree = ~111km (111.32 in google maps, but range varies
            // between 110.567km at the equator and 111.699km at the poles)
            //
            // 111.32km = 111320.0m (".0" is used to make sure the result of division is
            // double even if the "meters" variable can't be explicitly declared as double)
            var coef = meters / 111320.0;

            let map;
            // global array to store the marker object 
            let markersArray = [];

            function initMap() {
                const Bangladesh = {
                    lat: 23.684994,
                    lng: 90.356331
                };
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 7,
                    center: Bangladesh,
                    gestureHandling: "none",
                    zoomControl: false,
                });

                // create marker

                <?php if($googleMapResult): ?>
                    <?php $__currentLoopData = $googleMapResult; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $poultry = $row->TOTAL_POULTRY;
                            $wildBird = $row->TOTAL_WILD_BIRD;
                            $lblWorker = $row->TOTAL_LBM_WORKER;
                            // $webspice = new \App\Lib\Webspice();
                            $location = $webspice->getGeoData($row->division, 'location');
                        ?>
                        <?php if(!$location): ?>
                            continue;
                        <?php endif; ?> ;

                        // add poultry marker
                        var newMarker = {
                            lat: <?php echo e(isset($location->lat) ? $location->lat : ''); ?>,
                            lng: <?php echo e(isset($location->lng) ? $location->lng : ''); ?>

                        };
                        addMarker(newMarker, '<?php echo e($poultry); ?>', title = 'Poultry', icon = 'icon-marker-ir.png');

                        // add wild bird marker
                        var new_lat = <?php echo e(isset($location->lat) ? $location->lat : ''); ?> + coef;
                        var new_long = <?php echo e(isset($location->lng) ? $location->lng : ''); ?> + coef / Math.cos(
                            <?php echo e(isset($location->lat) ? $location->lat : ''); ?> * 0.01745);
                        var newMarker = {
                            lat: new_lat,
                            lng: new_long
                        };
                        addMarker(newMarker, '<?php echo e($wildBird); ?>', title = 'Wild Bird', icon = 'icon-marker-y.png');

                        // add LBM Worker marker
                        var new_lat = <?php echo e(isset($location->lat) ? $location->lat : ''); ?> + coef;
                        var new_long = <?php echo e(isset($location->lng) ? $location->lng : ''); ?> - coef / Math.cos(
                            <?php echo isset($location->lat) ? $location->lat : ''; ?> *
                            0.01745);
                        var newMarker = {
                            lat: new_lat,
                            lng: new_long
                        };
                        addMarker(newMarker, '<?php echo e($lblWorker); ?>', title = 'LBM Worker', icon = 'icon-marker-g.png');
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> ;
                <?php endif; ?> ;
            }

            function addMarker(latLng, label = "", title = '', icon = 'icon-marker-r.png') {
                let icon_url = "<?php echo e(asset('public/icons')); ?>/" + icon;

                let marker = new google.maps.Marker({
                    map: map,
                    position: latLng,
                    label: label,
                    title: title,
                    icon: {
                        url: icon_url,
                        scaledSize: new google.maps.Size(40, 40)
                    }
                });

                //store the marker object drawn in global array
                markersArray.push(marker);
            }

            window.initMap = initMap;
        </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/report/division_wise_counting_report.blade.php ENDPATH**/ ?>