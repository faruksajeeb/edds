<?php $__env->startPush('styles'); ?>
    <style>

    </style>
<?php $__env->stopPush(); ?>
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
        Create Market
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Import Market</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo e(url('markets')); ?>">Markets</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Import</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="import-form" action="<?php echo e(route('markets.import')); ?>" method="POST"
                        class="needs-validation" enctype="multipart/form-data" novalidate>
                        <?php echo csrf_field(); ?>

                        <div class="form-group mb-3">
                            <label for="import_file" class="<?php if($errors->has('import_file')): ?> has-error <?php endif; ?> fw-bold">
                                Import File <span class="text-danger">*</span></label><br />
                            <input type="file" name='import_file' id='import_file'
                                class="form-control <?php $__errorArgs = ['import_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Enter import_file" value="<?php echo e(old('import_file')); ?>" required>
                            <?php if($errors->has('import_file')): ?>
                                <?php $__errorArgs = ['import_file'];
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
                                    Please select a valid file.
                                </div>
                                <div class="text-info">
                                    Please must be select a file of type: xls, xlsx, csv.
                                </div>
                            <?php endif; ?>
                        </div>

                        Upload File Format Sample:
                        <table style="font-size:10px" class="table table-sm table-bordered my-0">
                            <tr>
                                <td class=""></td>
                                <td>A</td>
                                <td>B</td>
                                <td>C</td>
                                <td>D</td>
                                <td>E</td>
                                <td>F</td>
                            </tr>
                            <tr style="background-color: #C5DFF8; color:black;font-weight:bold">
                                <td class="" style="background-color: #FFF;font-weight:normal">1</td>
                                <td class="text-danger">Area</td>
                                <td class="text-danger">Market_Name_Eng</td>
                                <td>Market_Name_Ban</td>
                                <td>Market_Address</td>
                                <td class="text-danger">Latitude</td>
                                <td class="text-danger">Longitude</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>DNCC</td>
                                <td>Panir Tanki Bazar</td>
                                <td>পানির ট্যাংকি বাজার</td>
                                <td>11C, Avenue-5, Mirpur-11</td>
                                <td>23.81464</td>
                                <td>90.37478</td>
                            </tr>
                        </table>
                        [* Red text color fields are required.]
                        <a class="float-end my-0 fst-italic"
                            href="<?php echo e(asset('uploads/upload_file_format/upload_markets_format.xlsx')); ?>">Download The
                            Format</a>
                        <br />
                        <br />

                        <div class="form-group">
                            <button type="submit" name="submit_btn" class="btn btn-lg btn-success btn-import"
                                onclick="startClock()">Import</button>
                            <p id="clock" class="float-end d-none">00:00:00</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <script>
            function startClock() {
                var clockElement = document.getElementById('clock');
                var file = $('#import_file').val();
                if (file) {
                    $('#clock').show();
                    var startTime = new Date().getTime();
                    var intervalId = setInterval(function() {
                        var currentTime = new Date().getTime();
                        var elapsedTime = currentTime - startTime;

                        var hours = Math.floor(elapsedTime / (1000 * 60 * 60));
                        var minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);

                        var timeString = formatTime(hours) + ':' + formatTime(minutes) + ':' + formatTime(seconds);

                        clockElement.textContent = timeString;
                    }, 1000);
                }

            }

            function formatTime(time) {
                return time < 10 ? '0' + time : time;
            }
        </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/market/import.blade.php ENDPATH**/ ?>