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
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Create Market</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo e(url('markets')); ?>">Markets</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Create</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('markets.store')); ?>" method="POST" class="needs-validation" novalidate>
                        <?php echo csrf_field(); ?>
                        <div class="form-group my-1">
                            <label for=""
                                class="<?php if($errors->has('value_bangla')): ?> has-error <?php endif; ?> fw-bold">Market Area <span
                                    class="text-danger">*</span></label>
                            <select name="area_id" id="area_id" class="form-select select2" required>
                                <option value="">--select area--</option>
                                <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->id); ?>" <?php echo e($val->id == old('area_id') ? 'selected' : ''); ?>>
                                        <?php echo e($val->value); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('area_id')): ?>
                                <?php $__errorArgs = ['area_id'];
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
                                    Please select area.
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for=""
                                class="<?php if($errors->has('value')): ?> has-error <?php endif; ?> fw-bold">Market Name in
                                English <span class="text-danger">*</span></label><br />
                            <input type="text" name='value' id='value'
                                class="form-control <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Enter market name in english" value="<?php echo e(old('value')); ?>" required>
                            <?php if($errors->has('value')): ?>
                                <?php $__errorArgs = ['value'];
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
                                    Please enter a market name in english.
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for=""
                                class="<?php if($errors->has('value_bangla')): ?> has-error <?php endif; ?> fw-bold">Market Name in
                                Bangla</label><br />
                            <input type="text" name='value_bangla' id='value_bangla'
                                class="form-control <?php $__errorArgs = ['value_bangla'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Enter market name in bangla" value="<?php echo e(old('value_bangla')); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-6">

                                    <label for="latitude"
                                        class="<?php if($errors->has('latitude')): ?> has-error <?php endif; ?> fw-bold">
                                        Latitude <span class="text-danger">*</span></label><br />
                                    <input type="number"  pattern="[0-9.-]"  name='latitude' id='latitude'
                                        class="form-control <?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Enter Latitude" value="<?php echo e(old('latitude')); ?>" min="-90" max="90" required>
                                    <?php if($errors->has('latitude')): ?>
                                        <?php $__errorArgs = ['latitude'];
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
                                            Please enter a valid latitude.
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="longitude"
                                        class="<?php if($errors->has('longitude')): ?> has-error <?php endif; ?> fw-bold">
                                        Longitude <span class="text-danger">*</span></label><br />
                                    <input type="number"  pattern="[0-9.-]"  name='longitude' id='longitude'
                                        class="form-control <?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Enter longitude" value="<?php echo e(old('longitude')); ?>" min="-180" max="180"  required>
                                    <?php if($errors->has('longitude')): ?>
                                        <?php $__errorArgs = ['longitude'];
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
                                            Please enter a valid longitude.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>                      
                        <div class="form-group mb-3">
                            <label for=""
                                class="<?php if($errors->has('market_address')): ?> has-error <?php endif; ?> fw-bold">Market
                                Address</label><br />
                            <textarea name='market_address' id='market_address' class="form-control <?php $__errorArgs = ['market_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Enter market address" rows="3"><?php echo e(old('market_address')); ?></textarea>
                        </div>

                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn"
                                class="btn btn-lg btn-success btn-submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <script>
            $(function() {

            });
        </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/market/create.blade.php ENDPATH**/ ?>