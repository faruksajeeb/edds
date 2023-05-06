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
        Theme Settings
     <?php $__env->endSlot(); ?>
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="page-header py-3 my-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Theme Settings</h3>
                        </div>
                    </div>
                </div>

                <form action="<?php echo e(route('theme-setting')); ?>" method="POST" class="needs-validation"
                    enctype="multipart/form-data" novalidate>
                    <?php echo method_field('PUT'); ?>
                    <?php echo csrf_field(); ?>
                    <div class="form-group row py-1">
                        <label class="col-lg-3 col-form-label">Website Name</label>
                        <div class="col-lg-9">
                            <input name="website_name"
                                class="form-control   <?php $__errorArgs = ['website_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e($themeSettings ? $themeSettings->website_name : old('website_name')); ?>"
                                type="text" required>
                            <div class="invalid-feedback">Website Name is required!</div>
                            <?php $__errorArgs = ['website_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Website Logo</label>
                        <div class="col-lg-7">
                            <input type="file" name="website_logo" id="website_logo"
                                class="form-control   <?php $__errorArgs = ['website_logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e($themeSettings ? $themeSettings->website_logo : old('website_logo')); ?>"
                                required>
                            <div class="invalid-feedback">Website logo is required!</div>
                            <?php $__errorArgs = ['website_logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <span class="form-text text-muted">Recommended image size is 40px x 40px</span>
                        </div>
                        <div class="col-lg-2">
                            <div class="img-thumbnail float-end"><img id="website_logo_preview"
                                    src="uploads/<?php echo e($themeSettings ? $themeSettings->website_logo : old('website_logo')); ?>"
                                    alt="" width="40" height="40"></div>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Favicon</label>
                        <div class="col-lg-7">
                            <input type="file" name="website_favicon" id="website_favicon"
                                class="form-control   <?php $__errorArgs = ['website_favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <div class="invalid-feedback">Website favicon is required!</div>
                            <?php $__errorArgs = ['website_favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <span class="form-text text-muted">Recommended image size is 16px x 16px</span>
                        </div>
                        <div class="col-lg-2">
                            <div class="settings-image img-thumbnail float-end">
                                <img id="website_favicon_preview" src="uploads/<?php echo e($themeSettings ? $themeSettings->website_favicon : old('website_favicon')); ?>" class="img-fluid" width="16" height="16" alt="">
                                </div>
                        </div>
                    </div>
                    <br>
                    <div class="submit-section">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <button class="btn btn-lg btn-outline-secondary submit-btn rounded-pill">Save
                                Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <script>
            website_logo.onchange = evt => {
                const [file] = website_logo.files
                if (file) {
                    website_logo_preview.src = URL.createObjectURL(file)
                }
            }

            website_favicon.onchange = evt => {
                const [file] = website_favicon.files
                if (file) {
                    website_favicon_preview.src = URL.createObjectURL(file)
                }
            }
        </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/settings/theme-setting.blade.php ENDPATH**/ ?>