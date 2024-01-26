<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> 
        User Responses
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title py-1"><i class="fa fa-table"></i>
                                <?php if(request()->get('status') == 'archived'): ?>
                                Deleted
                                <?php endif; ?> User Responses
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Response</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        <?php if(request()->get('status') == 'archived'): ?>
                                        Deleted
                                        <?php endif; ?> User Responses
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <?php if(request()->get('status') != 'archived'): ?>
                            <a href="<?php echo e(url('/user_responses?status=archived')); ?>">Deleted User Responses</a>
                            <?php else: ?>
                            <a href="<?php echo e(url('/user_responses')); ?>">User Responses</a>
                            <?php endif; ?>
                            <?php if(request()->get('status') == 'archived' && $user_responses->total() > 0): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.restore')): ?>
                            <div class="float-end">
                                <a href="" class="btn btn-primary btn-sm btn-restore-all" onclick="event.preventDefault(); restoreAllConfirmation()"><i class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                <form id="restore-all-form" action="<?php echo e(route('user_responses.restore-all')); ?>" style="display:inline" method="POST">
                                    <?php echo method_field('POST'); ?>
                                    <?php echo csrf_field(); ?>
                                </form>
                            </div>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body mt-0 pt-0">
                    <div class="">
                        <form action="" method="GET">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="status" value="<?php echo e(request()->get('status') == 'archived' ? 'archived' : ''); ?>">
                            <div class="row my-2">
                                <div class="col-md-12 col-sm-12 px-0">
                                    <div class="input-group row">
                                        <div class="col-md-3 pe-0">
                                            <select class="form-select select2" id="search_area" name="search_area">
                                                <option value="">--Select Area--</option>
                                                <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($area->id); ?>" <?php echo e((request()->get('search_area')==$area->id)?'selected':''); ?>><?php echo e($area->value); ?> - <?php echo e($area->value_bangla); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mx-0 px-0">
                                            <select class="form-select select2" id="search_market" name="search_market">
                                                <option value="">--Select Area First--</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 mx-0 px-0">
                                            <select name="search_respodent" class="col-md-3 form-select" id="search_respodent">
                                                <option value="">Select respondent type</option>
                                                <option value="Customer" <?php echo e(request()->get('search_respodent') == 'Customer' ? 'selected' : ''); ?>>
                                                    Customer</option>
                                                <option value="Seller" <?php echo e(request()->get('search_respodent') == 'Seller' ? 'selected' : ''); ?>>
                                                    Seller/LBM Worker/Cleaner</option>
                                                <!-- <option value="LBW Worker"
                                                <?php echo e(request()->get('search_respodent') == 'LBW Worker' ? 'selected' : ''); ?>>
                                                LBW Worker</option> -->
                                                
                                            </select>
                                        </div>
                                        <div class="col-md-3 mx-0 px-0">
                                            <select name="search_status" class="col-md-3 form-select" id="search_status">
                                                <option value="">Select Status</option>
                                                <option value="2" <?php echo e(request()->get('search_status') == '2' ? 'selected' : ''); ?>>Verified
                                                </option>
                                                <option value="1" <?php echo e(request()->get('search_status') == '1' ? 'selected' : ''); ?>>Pending
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="input-group input-daterange my-1">
                                        <input type="number" min="0" name="search_distance" value="<?php echo e(request()->get('search_distance')); ?>" class="form-control" placeholder="Search by distance matrix (km)">
                                        <input type="text" name="search_text" value="<?php echo e(request()->get('search_text')); ?>" class="form-control" placeholder="Search by name/mobile/email/gender">
                                        <input type="text" class="form-control  map-input" id="address-input" name="address_address" placeholder="Search by response address">
                                        <input type="hidden" name="address_latitude" id="address-latitude" value="23.810332" />
                                        <input type="hidden" name="address_longitude" id="address-longitude" value="90.4125181" />

                                        <div id="address-map-container" style="width:100%;height:400px;display:none ">
                                            <div style="width: 100%; height: 100%" id="address-map"></div>
                                        </div>

                                        <input type="text" class="form-control datepicker" name="date_from" placeholder="Date From" value="<?php echo e(request()->get('date_from')); ?>" aria-label="DateFrom">
                                        <span class="input-group-text">to</span>
                                        <input type="text" class="form-control datepicker" name="date_to" placeholder="Date To" value="<?php echo e(request()->get('date_to')); ?>" aria-label="DateTo">

                                        

                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <button class="btn btn-secondary mx-1 filter_btn" name="submit_btn" type="submit" value="search">
                                        <i class="fa fa-search"></i> Filter Data
                                    </button>
                                    <a href='<?php echo e(request()->get('status') == 'archived' ? url('/user_responses?status=archived') : url('/user_responses')); ?>' class="btn btn-xs btn-primary me-1 refresh_btn"><i class="fa fa-refresh"></i> Refresh</a>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.export')): ?>
                                    
                                    

                                    <button class="btn btn-xs btn-success export_btn" name="submit_btn" value="export" type="submit">
                                        <i class="fa-solid fa-download"></i> Export
                                    </button>
                                    <?php endif; ?>
                                    
                            </div>
                            <div class="col-md-3">
                                <!-- Show entries dropdown -->
                                <div class="float-end mt-2">
                                    <form action="<?php echo e(url()->current()); ?>" method="GET">
                                        <label for="perPage">Show
                                            <select name="perPage" id="perPage" onchange="this.form.submit()">
                                                <!-- <option value="5" <?php echo e(Request::get('perPage') == 5 ? 'selected' : ''); ?>>5</option> -->
                                                <option value="10" <?php echo e(Request::get('perPage') == 10 ? 'selected' : ''); ?>>10</option>
                                                <option value="25" <?php echo e(Request::get('perPage') == 25 ? 'selected' : ''); ?>>25</option>
                                                <option value="50" <?php echo e(Request::get('perPage') == 50 ? 'selected' : ''); ?>>50</option>
                                                <!-- <option value="100" <?php echo e(Request::get('perPage') == 100 ? 'selected' : ''); ?>>100</option> -->
                                                <!-- Add more options if needed -->
                                            </select> entries</label>
                                    </form>
                                </div>
                            </div>
                    </div>


                </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped mb-0 table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Response Date</th>
                                <th>Entry Time</th>
                                <th>User Name</th>
                                <!-- <th>Email</th> -->
                                <th>Mobile</th>
                                <th>Gender</th>
                                <th>Respondent</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $user_responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-nowrap"><?php echo e($index + $user_responses->firstItem()); ?></td>
                                <td class="text-nowrap"><?php echo e($val->response_date); ?></td>
                                <td class="text-nowrap"><?php echo e($val->created_at); ?></td>
                                <td class="text-nowrap">
                                    <?php echo e(isset($val->registered_user) ? $val->registered_user->full_name : ''); ?>

                                </td>
                                <!-- <td class="text-nowrap">
                                    <?php echo e(isset($val->registered_user) ? $val->registered_user->email : ''); ?>

                                </td> -->
                                <td class="text-nowrap">
                                    <?php echo e(isset($val->registered_user) ? $val->registered_user->mobile_no : ''); ?>

                                </td>
                                <td class="text-nowrap">
                                    <?php echo e(isset($val->registered_user) ? $val->registered_user->gender : ''); ?>

                                </td>
                                
                                <td class="text-nowrap">
                                    <?php echo e(isset($val->registered_user) ? $val->registered_user->respondent_type : ''); ?>

                                </td>
                                <td class="text-nowrap">
                                    <?php if($val->status == 1): ?>
                                    <span class="badge bg-info">Pending</span>
                                    <?php elseif($val->status == 2): ?>
                                    <span class="badge bg-success">Verified</span>
                                    <?php endif; ?>
                                </td>


                                <td class="text-nowrap">
                                    <div class="btn-group">
                                        <?php if(request()->get('status') == 'archived'): ?>
                                        
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.restore')): ?>
                                        <a href="" class="btn btn-primary btn-sm btn-restore-<?php echo e($val->id); ?>" onclick="event.preventDefault(); restoreConfirmation(<?php echo e($val->id); ?>)"><i class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                        <form id="restore-form-<?php echo e($val->id); ?>" action="<?php echo e(route('user_responses.restore', Crypt::encryptString($val->id))); ?>" method="POST" style="display: none">
                                            <?php echo method_field('POST'); ?>
                                            <?php echo csrf_field(); ?>
                                        </form>
                                        <?php endif; ?>
                                        
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.force_delete')): ?>
                                        <a href="" class="btn btn-danger btn-sm btn-force-delete-<?php echo e($val->id); ?>" onclick="event.preventDefault(); forceDelete(<?php echo e($val->id); ?>)"><i class="fa-solid fa-remove"></i> Force Delete</a>
                                        <form id="force-delete-form-<?php echo e($val->id); ?>" style="display: none" action="<?php echo e(route('user_responses.force-delete', Crypt::encryptString($val->id))); ?>" method="POST">
                                            <?php echo method_field('DELETE'); ?>
                                            <?php echo csrf_field(); ?>
                                        </form>
                                        <?php endif; ?>
                                        <?php else: ?>
                                        
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.edit')): ?>
                                        <?php if($val->status == 1): ?>
                                        
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.verify')): ?>
                                        <?php if($val->status == 1): ?>
                                        <a href="" class="btn btn-outline-success btn-sm btn-verify-<?php echo e($val->id); ?>" onclick="event.preventDefault(); confirmVerify(<?php echo e($val->id); ?>)"><i class="fas fa-check"></i> Verify</a>
                                        <form id="verify-form-<?php echo e($val->id); ?>" style="display: none" action="<?php echo e(route('user_responses.verify', Crypt::encryptString($val->id))); ?>" method="POST">
                                            <?php echo method_field('PUT'); ?>
                                            <?php echo csrf_field(); ?>
                                        </form>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        <a class="btn btn-sm btn-secondary mx-1" data-bs-toggle="modal" data-bs-target="#details-modal-<?php echo e($val->id); ?>">
                                            <i class="fa-solid fa-magnifying-glass-plus"></i></a>

                                        
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.delete')): ?>
                                        <?php if($val->status == 1): ?>
                                        <a href="" class="btn btn-outline-danger btn-sm btn-delete-<?php echo e($val->id); ?>" onclick="event.preventDefault(); confirmDelete(<?php echo e($val->id); ?>)"><i class="fa-solid fa-trash"></i> Delete</a>
                                        <form id="delete-form-<?php echo e($val->id); ?>" style="display: none" action="<?php echo e(route('user_responses.destroy', Crypt::encryptString($val->id))); ?>" method="POST">
                                            <?php echo method_field('DELETE'); ?>
                                            <?php echo csrf_field(); ?>
                                        </form>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center">No records found. </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php echo e($user_responses->withQueryString()->links()); ?>

            </div>
        </div>
    </div>
    </div>
    </div>
    <?php echo $__env->make('user_response.detail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->startPush('scripts'); ?>


    <script>
        let confirmVerify = (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to cancel this again!'",
                icon: 'warning',
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, verify it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.btn-verify-' + id).addClass('disabledAnchor');
                    $('.btn-verify-' + id).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verifying...'
                    );
                    document.getElementById('verify-form-' + id).submit();
                    processing('Verifying...');
                }
            })
        }


        $(document).ready(function() {
            // if (!searchDistrict && !searchThana) {
            $("#drpDistrict, #drpUpazilla").children('option').hide();
            $("#drpDistrict, #drpUpazilla").val("");

            var searchDivision = "<?php echo e(request()->get('search_division')); ?>";
            if (searchDivision) {
                $("#drpDivision option[value=" + searchDivision + "]").attr('selected', 'selected');
            }
            var searchDistrict = "<?php echo e(request()->get('search_district')); ?>";
            if (searchDistrict) {
                $("#drpDistrict").children('option[data-link="' + searchDivision + '"]').show();
                $("#drpDistrict option[value=" + searchDistrict + "]").attr('selected', 'selected');

            }
            var searchThana = "<?php echo e(request()->get('search_thana')); ?>";
            if (searchThana) {
                $("#drpUpazilla").children('option[data-link="' + searchDistrict + '"]').show();
                $("#drpUpazilla option[value=" + searchThana + "]").attr('selected', 'selected');
            }

            $("#drpDivision").change(function() {
                $("#drpDistrict, #drpUpazilla").children('option').hide();
                $("#drpDistrict, #drpUpazilla").val("");
                if ($(this).val() && $(this).val() != "" && $(this).val() != NaN) {
                    var myValue = $(this).val();
                    $("#drpDistrict").children('option[data-link="' + myValue + '"]').show();
                }
            });
            $("#drpDistrict").change(function() {
                $("#drpUpazilla").children('option').hide();
                $("#drpUpazilla").val("");
                if ($(this).val() && $(this).val() != "" && $(this).val() != NaN) {
                    var myValue = $(this).val();
                    $("#drpUpazilla").children('option[data-link="' + myValue + '"]').show();
                }
            });






        });




        const getArea = (val) => {
            if (val) {
                // by jquery
                $.ajax({
                    url: "<?php echo e(url('api/fetch-areas')); ?>",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        upazilla: val
                    },
                    success: (response) => {
                        $('#search_area').html('<option value="">-- Select Area --</option>');
                        $.each(response.areas, (key, value) => {
                            $("#search_area").append('<option value="' + value
                                .id + '">' + value.value + '</option>');
                        });
                    },
                    error: (xhr, status, error) => {

                    }
                });
            }
        }


        $(document).ready(function() {
            var area_id = $('#search_area').val();
            // alert(area_id);
            if (area_id) {
                getMarket(area_id, 'onload');
            }

            $('#search_area').change(function() {
                var area_id = $(this).val();
                if (area_id) {
                    getMarket(area_id, 'onchange');
                }
            });
        });


        const getMarket = async (val, type) => {

            if (val) {

                // by raw/vanilla javascript api
                await fetch("<?php echo e(url('api/fetch-markets')); ?>/" + val)
                    .then(response => response.json())
                    .then(data => {
                        let marketSelect = document.querySelector('#search_market');
                        marketSelect.innerHTML = '<option value="">-- Select Market --</option>'; // Clear existing options
                        data.markets.forEach((market) => {
                            var option = document.createElement('option');
                            option.value = market.id;
                            option.text = market.value;
                            marketSelect.appendChild(option);
                        });
                        if (type == 'onload') {
                            $('#search_market').val(<?php echo request()->get('search_market'); ?>);
                        }
                    });
            }
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAPS_API_KEY')); ?>&libraries=places&callback=initialize" async defer></script>
    <script>
        function initialize() {

            $('form').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
            const locationInputs = document.getElementsByClassName("map-input");

            const autocompletes = [];
            const geocoder = new google.maps.Geocoder;
            for (let i = 0; i < locationInputs.length; i++) {

                const input = locationInputs[i];
                const fieldKey = input.id.replace("-input", "");
                const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(
                    fieldKey + "-longitude").value != '';

                const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
                const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;

                const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
                    center: {
                        lat: latitude,
                        lng: longitude
                    },
                    zoom: 13
                });
                const marker = new google.maps.Marker({
                    map: map,
                    position: {
                        lat: latitude,
                        lng: longitude
                    },
                });

                marker.setVisible(isEdit);
                var options = {
                    // types: ['(cities)'],
                    componentRestrictions: {
                        country: "bd"
                    } //Here bd for bangladesh location only
                };
                const autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.key = fieldKey;
                autocompletes.push({
                    input: input,
                    map: map,
                    marker: marker,
                    autocomplete: autocomplete
                });
            }

            for (let i = 0; i < autocompletes.length; i++) {
                const input = autocompletes[i].input;
                const autocomplete = autocompletes[i].autocomplete;
                const map = autocompletes[i].map;
                const marker = autocompletes[i].marker;

                google.maps.event.addListener(autocomplete, 'place_changed', function() {
                    marker.setVisible(false);
                    const place = autocomplete.getPlace();

                    geocoder.geocode({
                        'placeId': place.place_id
                    }, function(results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            const lat = results[0].geometry.location.lat();
                            const lng = results[0].geometry.location.lng();
                            setLocationCoordinates(autocomplete.key, lat, lng);
                        }
                    });

                    if (!place.geometry) {
                        window.alert("No details available for input: '" + place.name + "'");
                        input.value = "";
                        return;
                    }

                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }
                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);

                });
            }
        }

        function setLocationCoordinates(key, lat, lng) {
            const latitudeField = document.getElementById(key + "-" + "latitude");
            const longitudeField = document.getElementById(key + "-" + "longitude");
            latitudeField.value = lat;
            longitudeField.value = lng;
        }
    </script>

    <script type="text/javascript" src="<?php echo e(asset('plugins/zoom/js/zoom.js')); ?>"></script>

    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/zoom/css/zoom.css')); ?>">

    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\laravel\edds\resources\views/user_response/index.blade.php ENDPATH**/ ?>