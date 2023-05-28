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
        Edit Market
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Edit Market</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo e(url('markets')); ?>">Markets</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('markets.update', Crypt::encryptString($marketInfo->id))); ?>"
                        method="POST" class="needs-validation" novalidate>
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <div class="form-group my-1">
                            <label for="" class="<?php if($errors->has('value_bangla')): ?> has-error <?php endif; ?> fw-bold">Area *</label>
                            <select name="area_id" id="area_id" class="form-select" required>
                                <option value="">--select areas--</option>
                                <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                    
                                    <option value="<?php echo e($val->id); ?>" <?php echo e(($val->id==old('area_id',$marketInfo->area_id)) ?'selected':''); ?>><?php echo e($val->value); ?></option>
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
                                class="<?php if($errors->has('value')): ?> has-error <?php endif; ?> fw-bold">Value *</label><br />
                            <textarea name='value' id='value' class="form-control <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Enter value" rows="3" required><?php echo e(old('value',$marketInfo->value)); ?></textarea>
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
                                    Please enter a value.
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for=""
                                class="<?php if($errors->has('value_bangla')): ?> has-error <?php endif; ?> fw-bold">Value
                                Bangla</label><br />
                            <textarea name='value_bangla' id='value_bangla' class="form-control <?php $__errorArgs = ['value_bangla'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Enter value in bangla" rows="3"><?php echo e(old('value_bangla',$marketInfo->value_bangla)); ?></textarea>
                        </div>
                       
                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="btn btn-lg btn-success btn-submit">Save Changes</button>
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
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/market/edit.blade.php ENDPATH**/ ?>