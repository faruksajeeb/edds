<?php $__env->startPush('styles'); ?>
<style>
  #preview-image {
            max-width: 300px;
            max-height: 300px;
            margin-top: 20px;
        }
</style>
<?php $__env->stopPush(); ?>
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
        Edit App Footer Logo
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="background-color: #ECF4D6;">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Edit App Footer Logo</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo e(url('app_footer_logos')); ?>">app footer logoss</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('app_footer_logos.update', Crypt::encryptString($editInfo->id))); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-3">
                            <label for="" class="<?php if($errors->has('hospital_name_english')): ?> has-error <?php endif; ?> fw-bold">App Footer Logo <span class="text-danger">*</span></label><br />

                            <?php
                                // Extract the base64 encoded data from the string
                                $base64Data = substr($editInfo->logo_base64, strpos($editInfo->logo_base64, ',') + 1);

                                // Create a data URL for the image
                                $dataUrl = 'data:image/png;base64,' . $base64Data;
                            ?>


                            <input type="file" name='app_footer_logo' id='app_footer_logo' class=" my-3 form-control "  accept="image/*" onchange="previewImage()" required>
                            <img id="preview-image"  src="<?php echo e($dataUrl); ?>" alt="Base64 Image" width="300">

                            <?php if($errors->has('app_footer_logo')): ?>
                            <?php $__errorArgs = ['app_footer_logo'];
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
                                Please select app footer logo.
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="my-3 btn btn-lg btn-success btn-submit"><i class="fa fa-save"></i> Save Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
    <script>
       function previewImage() {
            var input = document.getElementById('app_footer_logo');
            var preview = document.getElementById('preview-image');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
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
<?php endif; ?><?php /**PATH D:\laragon\www\laravel\edds\resources\views/app_footer_logo/edit.blade.php ENDPATH**/ ?>