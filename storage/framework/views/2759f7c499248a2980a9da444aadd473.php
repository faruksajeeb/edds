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
        Edit Question
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Edit Question</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Question & Answer</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo e(url('questions')); ?>">Questions</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('questions.update', Crypt::encryptString($questionInfo->id))); ?>"
                        method="POST" class="needs-validation" novalidate>
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <div class="form-group my-1">
                            <label for=""
                                class="<?php if($errors->has('value_bangla')): ?> has-error <?php endif; ?> fw-bold">Type Of Category
                                *</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">--select category--</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->id); ?>"
                                        <?php echo e($val->id == old('category_id', $questionInfo->category_id) ? 'selected' : ''); ?>>
                                        <?php echo e($val->option_value); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('category_id')): ?>
                                <?php $__errorArgs = ['category_id'];
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
                                    Please select category.
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group my-1">
                            <label for=""
                                class="<?php if($errors->has('value_bangla')): ?> has-error <?php endif; ?> fw-bold">Respondent
                                *</label>
                            <select name="respondent[]" id="respondent" class="form-select  js-states select2"
                                multiple="multiple" data-placeholder="Select one or more..." required>
                                <?php $__currentLoopData = $respondents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->option_value); ?>" 
                                        <?php echo e(in_array($val->option_value, old('respondent', explode(',', $questionInfo->respondent))) ? 'selected' : ''); ?>>
                                        <?php echo e($val->option_value); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('respondent')): ?>
                                <?php $__errorArgs = ['respondent'];
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
                                    Please select respondent.
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
                                placeholder="Enter question value" rows="3" required><?php echo e(old('value', $questionInfo->value)); ?></textarea>
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
                                Bangla*</label><br />
                            <textarea name='value_bangla' id='value_bangla' class="form-control <?php $__errorArgs = ['value_bangla'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Enter question value in bangla" rows="3" required><?php echo e(old('value_bangla', $questionInfo->value_bangla)); ?></textarea>
                            <?php if($errors->has('value_bangla')): ?>
                                <?php $__errorArgs = ['value_bangla'];
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
                                    Please enter a value bangla.
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group my-1">
                            <label for=""
                                class="<?php if($errors->has('value_bangla')): ?> has-error <?php endif; ?> fw-bold">Input Method
                                *</label>
                            <select name="input_method" id="input_method" class="form-select" onchange="showInputType(this.value)" required>
                                <option value="">--select input method--</option>
                                <option value="text_box"
                                    <?php echo e(old('input_method', $questionInfo->input_method) == 'text_box' ? 'selected' : ''); ?>>
                                    Text Box</option>
                                <option value="select_box"
                                    <?php echo e(old('input_method', $questionInfo->input_method) == 'select_box' ? 'selected' : ''); ?>>
                                    Select Box</option>
                                <option value="check_box"
                                    <?php echo e(old('input_method', $questionInfo->input_method) == 'check_box' ? 'selected' : ''); ?>>
                                    Checkbox</option>
                                <option value="radio_button"
                                    <?php echo e(old('input_method', $questionInfo->input_method) == 'radio_button' ? 'selected' : ''); ?>>
                                    Radio Button
                                </option>
                            </select>
                            <?php if($errors->has('input_method')): ?>
                                <?php $__errorArgs = ['input_method'];
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
                                    Please select input method.
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group my-1 input_type_section">
                            <label for=""
                                class="<?php if($errors->has('input_type')): ?> has-error <?php endif; ?> fw-bold">Input Type
                                *</label>
                            <select name="input_type" id="input_type" class="form-select" >
                                <option value="">--select input type--</option>
                                
                                <option value="alphanumeric"
                                    <?php echo e(old('input_type', $questionInfo->input_type) == 'alphanumeric' ? 'selected' : ''); ?>>
                                    Alphanumeric</option>
                                <option value="numeric"
                                    <?php echo e(old('input_type', $questionInfo->input_type) == 'numeric' ? 'selected' : ''); ?>>
                                    Numeric
                                </option>
                            </select>
                            <?php if($errors->has('input_type')): ?>
                                <?php $__errorArgs = ['input_type'];
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
                                    Please select input type.
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group my-1">
                            <label for="" class="<?php if($errors->has('is_required')): ?> has-error <?php endif; ?> fw-bold">Is
                                Required? *</label>
                            <select name="is_required" id="is_required" class="form-select" required>
                                <option value="">--select one--</option>
                                <option value="yes"
                                    <?php echo e(old('is_required', $questionInfo->is_required) == 'yes' ? 'selected' : ''); ?>>Yes
                                </option>
                                <option value="no"
                                    <?php echo e(old('is_required', $questionInfo->is_required) == 'no' ? 'selected' : ''); ?>>
                                    No</option>
                            </select>
                            <?php if($errors->has('is_required')): ?>
                                <?php $__errorArgs = ['is_required'];
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
                                    Please select one.
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group my-1">
                            <label for=""
                                class="<?php if($errors->has('image_require')): ?> has-error <?php endif; ?> fw-bold">Image Required?
                                *</label>
                            <select name="image_require" id="image_require" class="form-select" required>
                                <option value="">--select one--</option>
                                <option value="yes"
                                    <?php echo e(old('image_require', $questionInfo->image_require) == 'yes' ? 'selected' : ''); ?>>
                                    Yes
                                </option>
                                <option value="no"
                                    <?php echo e(old('image_require', $questionInfo->image_require) == 'no' ? 'selected' : ''); ?>>
                                    No</option>
                            </select>
                            <?php if($errors->has('image_require')): ?>
                                <?php $__errorArgs = ['image_require'];
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
                                    Please select one.
                                </div>
                            <?php endif; ?>
                        </div>
                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="btn btn-lg btn-success btn-submit">Save
                                Changes</button>
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
            let inputTypeVal = $("#input_method").val();
            if (inputTypeVal == 'text_box') {
                $('.input_type_section').show();
                $("#input_type").prop('required', true);
            } else {
                $('.input_type_section').hide();
                $("#input_type").prop('required', false);
            }
            const showInputType = (val) => {

                if (val == 'text_box') {
                    $('.input_type_section').show('slow');
                    $("#input_type").prop('required', true);
                } else {
                    $('.input_type_section').hide('slow');
                    $("#input_type").prop('required', false);
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
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/question/edit.blade.php ENDPATH**/ ?>