<?php $__env->startPush('styles'); ?>
<style>

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
        Edit Question
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="background-color: #ECF4D6;">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Edit Question</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#"> Question & Answer </a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo e(url('questions')); ?>"> Questions </a></li>
                                    <li class="breadcrumb-item " aria-current="page"> Edit </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('questions.update', Crypt::encryptString($questionInfo->id))); ?>" method="POST" class="needs-validation" novalidate>
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <input type="text" name="currentPage" value="<?php echo e($currentPage); ?>">
                        <div class="form-group mb-3">
                            <label for=""
                                class="<?php if($errors->has('value_bangla')): ?> has-error <?php endif; ?> fw-bold">Type Of Category
                                <span class='text-danger'>*<span></label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">--select category--</option>
                                <option value="0" <?php echo e(($questionInfo->category_id==0)?'selected':''); ?>>General Category</option>
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
                        <div class="form-group mb-3">
                            <label for="respondent_type" class="<?php if($errors->has('value_bangla')): ?> has-error <?php endif; ?> fw-bold">Respondent Types<span class='text-danger'>*<span></label>
                            <select name="respondent_type[]" id="respondent_type" class="form-select select2" data-placeholder="Select one or more..."  multiple required>
                                
                                <?php $__currentLoopData = $respondent_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $respondent_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($respondent_type->option); ?>" <?php echo e(in_array($respondent_type->option,explode(",",old('respondent_type',$questionInfo->respondent_type)))?'selected':''); ?>><?php echo e($respondent_type->option); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('respondent_type')): ?>
                            <?php $__errorArgs = ['respondent_type'];
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
                                Please select a respondent_type.
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="<?php if($errors->has('question')): ?> has-error <?php endif; ?> fw-bold">Qusetion in English <span class='text-danger'>*<span></label><br />
                            <textarea name='question' id='question' class="form-control <?php $__errorArgs = ['question'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter question in English" rows="3" required><?php echo e(old('question', $questionInfo->question)); ?></textarea>
                            <?php if($errors->has('question')): ?>
                            <?php $__errorArgs = ['question'];
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
                                Please enter a question in english.
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="" class="<?php if($errors->has('question_bangla')): ?> has-error <?php endif; ?> fw-bold">Qusetion
                                in Bangla <span class='text-danger'>*<span></label><br />
                            <textarea name='question_bangla' id='question_bangla' class="form-control <?php $__errorArgs = ['question_bangla'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter question in Bangla" rows="3" required><?php echo e(old('question_bangla', $questionInfo->question_bangla)); ?></textarea>
                            <?php if($errors->has('question_bangla')): ?>
                            <?php $__errorArgs = ['question_bangla'];
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
                                Please enter a question in bangla.
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group my-3">
                            <label for="" class="<?php if($errors->has('question_bangla')): ?> has-error <?php endif; ?> fw-bold">Related To
                                <span class='text-danger'>*<span></label>
                            <select name="related_to" id="related_to" class="form-select" onchange="showQuestion(this.value)" required>
                                <option value="">--select related to--</option>
                                <option value="level1" <?php echo e(old('related_to',$questionInfo->related_to) == 'level1' ? 'selected' : ''); ?>>Level 1</option>
                                <option value="question" <?php echo e(old('related_to',$questionInfo->related_to) == 'question' ? 'selected' : ''); ?>>Question</option>
                                <option value="answare" <?php echo e(old('related_to',$questionInfo->related_to) == 'answare' ? 'selected' : ''); ?>>Answer</option>
                            </select>
                            <?php if($errors->has('related_to')): ?>
                            <?php $__errorArgs = ['related_to'];
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
                                Please select related to.
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group my-3 relation_section">
                            <label for="" class="<?php if($errors->has('question_bangla')): ?> has-error <?php endif; ?> fw-bold">Relation With
                                <span class='text-danger'>*<span></label>
                            <select name="relation_id" id="relation_id" class="form-select" required>
                                    <!-- get by JS -->
                            </select>
                            <?php if($errors->has('relation_id')): ?>
                            <?php $__errorArgs = ['relation_id'];
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
                                Please select relation.
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group my-3">
                            <label for="" class="<?php if($errors->has('question_bangla')): ?> has-error <?php endif; ?> fw-bold">Answer Type
                                <span class='text-danger'>*<span></label>
                            <select name="answare_type" id="answare_type" class="form-select" onchange="showInputType(this.value)" required>
                                <option value="">--select answer type--</option>
                                <option value="checkbox" <?php echo e(old('answare_type',$questionInfo->answare_type) == 'checkbox' ? 'selected' : ''); ?>>Checkbox</option>
                                <option value="radio" <?php echo e(old('answare_type',$questionInfo->answare_type) == 'radio' ? 'selected' : ''); ?>>Radio Button</option>
                                <option value="input" <?php echo e(old('answare_type',$questionInfo->answare_type) == 'input' ? 'selected' : ''); ?>>Input Field
                                <option value="image" <?php echo e(old('answare_type',$questionInfo->answare_type) == 'image' ? 'selected' : ''); ?>>Image
                                <option value="label" <?php echo e(old('answare_type',$questionInfo->answare_type) == 'label' ? 'selected' : ''); ?>>Label
                                </option>
                            </select>
                            <?php if($errors->has('answare_type')): ?>
                            <?php $__errorArgs = ['answare_type'];
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
                                Please select answer type.
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group my-2 input_type_section">
                            <label for="" class="<?php if($errors->has('input_type')): ?> has-error <?php endif; ?> fw-bold">Input Type
                                <span class='text-danger'>*<span></label>
                            <select name="input_type" id="input_type" class="form-select">
                                <option value="">--select input type--</option>
                                <option value="text" <?php echo e(old('input_type',$questionInfo->input_type) == 'text' ? 'selected' : ''); ?>>Text</option>
                                <option value="alphanumeric" <?php echo e(old('input_type',$questionInfo->input_type) == 'alphanumeric' ? 'selected' : ''); ?>>
                                    Alphanumeric</option>
                                <option value="numeric" <?php echo e(old('input_type',$questionInfo->input_type) == 'numeric' ? 'selected' : ''); ?>>
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
                        <div class="form-group my-3">
                            <label for="" class="<?php if($errors->has('is_required')): ?> has-error <?php endif; ?> fw-bold">Is Required? <span class='text-danger'>*<span></label>
                            <select name="is_required" id="is_required" class="form-select" required>
                                <option value="">--select one--</option>
                                <option value="yes" <?php echo e(old('is_required',$questionInfo->is_required) == 'yes' ? 'selected' : ''); ?>>Yes
                                </option>
                                <option value="no" <?php echo e(old('is_required',$questionInfo->is_required) == 'no' ? 'selected' : ''); ?>>
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
                        <div class="form-group my-3">
                            <label for="" class="<?php if($errors->has('info')): ?> has-error <?php endif; ?> fw-bold">Info<span class='text-danger'><span></label>
                            <input type="text" name="info" id="info" value="<?php echo e(old('info',$questionInfo->info)); ?>" class="form-control"/>                            
                        </div>
                        <div class="form-group my-3">
                            <label for="" class="<?php if($errors->has('info_bangla')): ?> has-error <?php endif; ?> fw-bold">Info Bangla<span class='text-danger'><span></label>
                            <input type="text" name="info_bangla" id="info_bangla" value="<?php echo e(old('info_bangla',$questionInfo->info_bangla)); ?>" class="form-control"/>                            
                        </div>
                        <div class="form-group my-3">
                            <label for="" class="<?php if($errors->has('sub_info')): ?> has-error <?php endif; ?> fw-bold">Sub Info<span class='text-danger'><span></label>
                            <input type="text" name="sub_info" id="sub_info" value="<?php echo e(old('sub_info',$questionInfo->sub_info)); ?>" class="form-control"/>                            
                        </div>
                        <div class="form-group my-3">
                            <label for="" class="<?php if($errors->has('sub_info_bangla')): ?> has-error <?php endif; ?> fw-bold">Sub Info Bangla<span class='text-danger'><span></label>
                            <input type="text" name="sub_info_bangla" id="sub_info_bangla" value="<?php echo e(old('sub_info_bangla',$questionInfo->sub_info_bangla)); ?>" class="form-control"/>                            
                        </div>

                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="btn btn-lg btn-success btn-submit"><i class="fa fa-save"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
    <script>
        $(function() {

            updateOptions("<?php echo e($questionInfo->related_to); ?>");

        });
        
        let relatedTo = $("#related_to").val();
        
        if (relatedTo && relatedTo != 'level1') {
            $('.relation_section').show();
            $("#relation_id").prop('required', true);
        } else {           
            $('.relation_section').hide();
            $("#relation_id").prop('required', false);
        }


        let inputMethodVal = $("#answare_type").val();
        if (inputMethodVal == 'input') {
            $('.input_type_section').show();
            $("#input_type").prop('required', true);
        } else {
            $('.input_type_section').hide();
            $("#input_type").prop('required', false);
        }

        function updateOptions(type) {
            // alert(type);
            var questionOptions = <?php echo json_encode($questions); ?>;
            var answerOptions = <?php echo json_encode($answers); ?>;



            var options = type === 'question' ? questionOptions : answerOptions;
            var optionsSelect = $('#relation_id');

            // Clear existing options
            optionsSelect.empty();

            // Add new options
            optionsSelect.append($('<option>', {
                    value: '',
                    text: type === 'question' ? '--select question--' : '--select answer--'
                }));
            $.each(options, function(index, value) {
                optionsSelect.append($('<option>', {
                    value: value.id,
                    text: type === 'question' ? value.question + ' ('+value.question_bangla+')' : value.answare + ' ('+value.answare_bangla+')'
                }));
            });
            $('#relation_id').val('<?php echo e($questionInfo->relation_id); ?>');

        }

        const showQuestion = (val) => {
            if (val != 'level1') {
                updateOptions(val);
                $('.relation_section').show('slow');
                // if (val == 'question') {
                //     $('#question_section').show();
                //     $('#answer_section').hide();
                // } else if (val == 'answare') {
                //     $('#answer_section').show();
                //     $('#question_section').hide();
                // }
                $("#relation_id").prop('required', true);
            } else {
                $('.relation_section').hide('slow');
                $("#relation_id").prop('required', false);
            }
        }

        const showInputType = (val) => {
            if (val == 'input') {
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
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\laravel\edds\resources\views/question/edit.blade.php ENDPATH**/ ?>