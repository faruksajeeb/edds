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
    <div class="row">
        <div class="col-md-12 offset-md-0">
            <form action="" method="POST" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Survey Report</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <label for="Division" class="col-sm-3 col-form-label">Division</label>
                                    <div class="col-sm-9">
                                        <select name="division" id="drpDivision" class="form-select">
                                            <option value="">--select division--</option>
                                            <option value="Dhaka">Dhaka</option>
                                            <option value="Chattogram">Chattogram</option>
                                            <option value="Barishal">Barishal</option>
                                            <option value="Khulna">Khulna</option>
                                            <option value="Mymensingh">Mymensingh</option>
                                            <option value="Rajshahi">Rajshahi</option>
                                            <option value="Rangpur">Rangpur</option>
                                            <option value="Sylhet">Sylhet</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="district" class="col-sm-3 col-form-label">District</label>
                                    <div class="col-sm-9">
                                        <select name="district" id="drpDistrict" class="form-select">
                                            <option value="">--select district--</option>
                                            <option data-link="Dhaka" value="Dhaka">Dhaka</option>
                                            <option data-link="Dhaka" value="Faridpur">Faridpur</option>
                                            <option data-link="Dhaka" value="Gazipur">Gazipur</option>
                                            <option data-link="Dhaka" value="Gopalganj">Gopalganj</option>
                                            <option data-link="Dhaka" value="Kishoreganj">Kishoreganj</option>
                                            <option data-link="Dhaka" value="Madaripur">Madaripur</option>
                                            <option data-link="Dhaka" value="Manikganj">Manikganj</option>
                                            <option data-link="Dhaka" value="Munshiganj">Munshiganj</option>
                                            <option data-link="Dhaka" value="Narayanganj">Narayanganj</option>
                                            <option data-link="Dhaka" value="Narsingdi">Narsingdi</option>
                                            <option data-link="Dhaka" value="Rajbari">Rajbari</option>
                                            <option data-link="Dhaka" value="Shariatpur">Shariatpur</option>
                                            <option data-link="Dhaka" value="Tangail">Tangail</option>
                                            <option data-link="Chattogram" value="Bandarban">Bandarban</option>
                                            <option data-link="Chattogram" value="Brahmanbaria">Brahmanbaria</option>
                                            <option data-link="Chattogram" value="Chandpur">Chandpur</option>
                                            <option data-link="Chattogram" value="Chittagong">Chittagong</option>
                                            <option data-link="Chattogram" value="Cumilla">Cumilla</option>
                                            <option data-link="Chattogram" value="Coxsbazar">Coxsbazar</option>
                                            <option data-link="Chattogram" value="Feni">Feni</option>
                                            <option data-link="Chattogram" value="Khagrachari">Khagrachari</option>
                                            <option data-link="Chattogram" value="Lakshmipur">Lakshmipur</option>
                                            <option data-link="Chattogram" value="Noakhali">Noakhali</option>
                                            <option data-link="Chattogram" value="Rangamati">Rangamati</option>
                                            <option data-link="Barishal" value="Barishal">Barishal</option>
                                            <option data-link="Barishal" value="Barguna">Barguna</option>
                                            <option data-link="Barishal" value="Bhola">Bhola</option>
                                            <option data-link="Barishal" value="Jhalakathi">Jhalakathi</option>
                                            <option data-link="Barishal" value="Patuakhali">Patuakhali</option>
                                            <option data-link="Barishal" value="Pirojpur">Pirojpur</option>
                                            <option data-link="Khulna" value="Bagerhat">Bagerhat</option>
                                            <option data-link="Khulna" value="Chuadanga">Chuadanga</option>
                                            <option data-link="Khulna" value="Jashore">Jashore</option>
                                            <option data-link="Khulna" value="Jhenaidah">Jhenaidah</option>
                                            <option data-link="Khulna" value="Khulna">Khulna</option>
                                            <option data-link="Khulna" value="Kushtia">Kushtia</option>
                                            <option data-link="Khulna" value="Magura">Magura</option>
                                            <option data-link="Khulna" value="Meherpur">Meherpur</option>
                                            <option data-link="Khulna" value="Narail">Narail</option>
                                            <option data-link="Khulna" value="Satkhira">Satkhira</option>
                                            <option data-link="Mymensingh" value="Mymensingh">Mymensingh</option>
                                            <option data-link="Mymensingh" value="Jamalpur">Jamalpur</option>
                                            <option data-link="Mymensingh" value="Sherpur">Sherpur</option>
                                            <option data-link="Mymensingh" value="Netrokona">Netrokona</option>
                                            <option data-link="Rajshahi" value="Bogura">Bogura</option>
                                            <option data-link="Rajshahi" value="Joypurhat">Joypurhat</option>
                                            <option data-link="Rajshahi" value="Naogaon">Naogaon</option>
                                            <option data-link="Rajshahi" value="Natore">Natore</option>
                                            <option data-link="Rajshahi" value="Chapainawabganj">Chapainawabganj
                                            </option>
                                            <option data-link="Rajshahi" value="Pabna">Pabna</option>
                                            <option data-link="Rajshahi" value="Rajshahi">Rajshahi</option>
                                            <option data-link="Rajshahi" value="Sirajganj">Sirajganj</option>
                                            <option data-link="Rangpur" value="Rangpur">Rangpur</option>
                                            <option data-link="Rangpur" value="Nilphamari">Nilphamari</option>
                                            <option data-link="Rangpur" value="Dinajpur">Dinajpur</option>
                                            <option data-link="Rangpur" value="Panchagarh">Panchagarh</option>
                                            <option data-link="Rangpur" value="Gaibandha">Gaibandha</option>
                                            <option data-link="Rangpur" value="Kurigram">Kurigram</option>
                                            <option data-link="Rangpur" value="Lalmonirhat">Lalmonirhat</option>
                                            <option data-link="Rangpur" value="Thakurgaon">Thakurgaon</option>
                                            <option data-link="Sylhet" value="Habiganj">Habiganj</option>
                                            <option data-link="Sylhet" value="Moulvibazar">Moulvibazar</option>
                                            <option data-link="Sylhet" value="Sunamganj">Sunamganj</option>
                                            <option data-link="Sylhet" value="Sylhet">Sylhet</option>
                                        </select>
                                    </div>
                                </div>
                                


                                <div class="row mb-2">
                                    <label for="district" class="col-sm-3 col-form-label">Location</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control  map-input" id="address-input" name="address_address" placeholder="Search by location">
                                        <input type="hidden" name="address_latitude" id="address-latitude" value="23.810332"/>
                                        <input type="hidden" name="address_longitude" id="address-longitude" value="90.4125181" />
                                    </div>
                                    <div id="address-map-container" style="width:100%;height:400px;display:none ">
                                        <div style="width: 100%; height: 100%" id="address-map"></div>
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <label for="thana" class="col-sm-3 col-form-label">Category</label>
                                    <div class="col-sm-9">
                                        <select name="category_id" id="category_id" class="form-select">
                                            <option value="">--select category--</option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($val->id); ?>"><?php echo e($val->option_value); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <label for="thana" class="col-sm-3 col-form-label">Question</label>
                                    <div class="col-sm-9">
                                        <select name="question_id" id="question_id" class="form-select">
                                            <option value="">--select question--</option>
                                            <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($val->id); ?>"><?php echo e($val->value); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label for="thana" class="col-sm-3 col-form-label">Sub Question</label>
                                    <div class="col-sm-9">
                                        <select name="sub_question_id" id="sub_question_id" class="form-select">
                                            <option value="">--select sub question--</option>
                                            <?php $__currentLoopData = $sub_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($val->id); ?>"><?php echo e($val->value); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label for="ate from" class="col-sm-3 col-form-label">Date From *</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="datepicker form-control"
                                            value="<?php echo e(date('Y-m-01')); ?>" name="date_from" required />
                                        <?php if($errors->has('date_from')): ?>
                                            <?php $__errorArgs = ['date_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="alert alert-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <?php else: ?>
                                            <div class="invalid-feedback">
                                                Please select date from.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="date to" class="col-sm-3 col-form-label">Date To *</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="datepicker form-control"
                                            value="<?php echo e(date('Y-m-t')); ?>" name="date_to" required />
                                        <?php if($errors->has('date_to')): ?>
                                            <?php $__errorArgs = ['date_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="alert alert-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <?php else: ?>
                                            <div class="invalid-feedback">
                                                Please select date to.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <input type="radio" name="report_type" value="sub_question_wise" checked> Sub
                                        Question Wise
                                    </div>
                                    <div class="col-md-6">
        
                                        <input type="radio" name="report_type" value="question_wise"> Question Wise
                                    </div>
        
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <div class="card-footer text-end">
                        
                        <button class="btn btn-md btn-danger" type="submit" name='submit_btn' value="pdf"><i
                                class="fas fa-file"></i> PDF</button>
                        <button class="btn btn-md btn-success" type="submit" name='submit_btn'
                            value="export"><i class="fas fa-file-excel"></i> Export</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          
            <?php if(isset($report_format) && $report_format=='view'): ?>
                <?php
                    //$data = (Object)$data;
                ?>
                <?php if($report_type=='sub_question_wise'): ?>
                    <?php echo $__env->make('report.survey_report_export', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif($report_type=='question_wise'): ?>
                    <?php echo $__env->make('report.question_wise_survey_report_export', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                
            <?php endif; ?>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <script>
            $(document).ready(function() {
                $("#drpDistrict, #drpUpazilla").children('option').hide();
                $("#drpDistrict, #drpUpazilla").val("");
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
        </script>


<script
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAPS_API_KEY')); ?>&libraries=places&callback=initialize"
            async defer></script>
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
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/report/survey_report.blade.php ENDPATH**/ ?>