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
        Edit Answer
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="background-color: #ECF4D6;">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Edit Answer</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Question & Answer</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo e(url('answers')); ?>">Answers</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('answers.update', Crypt::encryptString($answerInfo->id))); ?>" method="POST" class="needs-validation" novalidate>
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="currentPage" value="<?php echo e($currentPage); ?>">
                        <div class="form-group mb-3">
                            <label for="respondent_type" class="<?php if($errors->has('value_bangla')): ?> has-error <?php endif; ?> fw-bold">Respondent Types<span class='text-danger'>*<span></label>
                            <select name="respondent_type[]" id="respondent_type" class="form-select select2" data-placeholder="Select one or more..." multiple required>

                                <?php $__currentLoopData = $respondent_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $respondent_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($respondent_type->option); ?>" <?php echo e(in_array($respondent_type->option,explode(",",old('respondent_type',$answerInfo->respondent_type)))?'selected':''); ?>><?php echo e($respondent_type->option); ?></option>
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
                        <div class="form-group my-1">
                            <label for="" class="<?php if($errors->has('answare_bangla')): ?> has-error <?php endif; ?> fw-bold">Question <span class='text-danger'>*<span></label>
                            <select name="question_id" id="question_id" class="form-select" required>
                                <option value="">--select questions--</option>
                                <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val->id); ?>" <?php echo e(old('question_id',$answerInfo->question_id) == $val->id ? 'selected' : ''); ?>><?php echo e($val->question); ?> (<?php echo e($val->question_bangla); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('question_id')): ?>
                            <?php $__errorArgs = ['question_id'];
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
                                Please select a question.
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="<?php if($errors->has('answare')): ?> has-error <?php endif; ?> fw-bold">Answer in English <span class='text-danger'>*<span></label><br />
                            <textarea name='answare' id='answare' class="form-control <?php $__errorArgs = ['answare'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter answer in English" rows="3" required><?php echo e(old('answare',$answerInfo->answare)); ?></textarea>
                            <?php if($errors->has('answare')): ?>
                            <?php $__errorArgs = ['answare'];
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
                                Please enter an answer in English.
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="" class="<?php if($errors->has('answare_bangla')): ?> has-error <?php endif; ?> fw-bold">Answer in
                                Bangla <span class='text-danger'>*<span></label><br />
                            <textarea name='answare_bangla' id='answare_bangla' class="form-control <?php $__errorArgs = ['answare_bangla'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="অনুগ্রহ করে বাংলায় লিখুন" rows="3" required><?php echo e(old('answare_bangla',$answerInfo->answare_bangla)); ?></textarea>
                            <?php if($errors->has('answare_bangla')): ?>
                            <?php $__errorArgs = ['answare_bangla'];
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
                                Please enter an answer in Bangla.
                            </div>
                            <?php endif; ?>
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
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\laravel\edds\resources\views/answer/edit.blade.php ENDPATH**/ ?>