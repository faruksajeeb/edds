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
        Questions
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
                                <?php endif; ?> Questions
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Question & Answer</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        <?php if(request()->get('status') == 'archived'): ?>
                                            Deleted
                                        <?php endif; ?> Questions
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if(request()->get('status') != 'archived'): ?>
                                <a href="<?php echo e(url('/questions?status=archived')); ?>">Deleted Questions</a>
                            <?php else: ?>
                                <a href="<?php echo e(url('/questions')); ?>">Questions</a>
                            <?php endif; ?>
                            <?php if(request()->get('status') == 'archived' && $questions->total() > 0): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question.restore')): ?>
                                    <div class="float-end">
                                        <a href="" class="btn btn-primary btn-sm btn-restore-all"
                                            onclick="event.preventDefault(); restoreAllConfirmation()"><i
                                                class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                        <form id="restore-all-form" action="<?php echo e(route('questions.restore-all')); ?>"
                                            style="display:inline" method="POST">
                                            <?php echo method_field('POST'); ?>
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <form action="" method="GET">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="status"
                                value="<?php echo e(request()->get('status') == 'archived' ? 'archived' : ''); ?>">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 px-0 input-group">
                                    <select name="search_category" class="form-select" id="search_category">
                                        <option value="">Select Category</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"
                                                <?php echo e(request()->get('search_category') == $category->id ? 'selected' : ''); ?>>
                                                <?php echo e($category->option_value); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <select name="search_respondent" class="form-select" id="search_respondent">
                                        <option value="">Select Respondent</option>
                                        <?php $__currentLoopData = $respondents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $respondent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($respondent->option_value); ?>"
                                                <?php echo e(request()->get('search_respondent') == $respondent->option_value ? 'selected' : ''); ?>>
                                                <?php echo e($respondent->option_value); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <select name="search_status" class="form-select" id="search_status">
                                        <option value="">Select Status</option>
                                        <option value="1"
                                            <?php echo e(request()->get('search_status') == '1' ? 'selected' : ''); ?>>Active
                                        </option>
                                        <option value="-1"
                                            <?php echo e(request()->get('search_status') == '-1' ? 'selected' : ''); ?>>Inactive
                                        </option>
                                    </select>
                                    <input type="text" name="search_text"
                                        value="<?php echo e(request()->get('search_text')); ?>" class="form-control"
                                        placeholder="Search by value, value bangla">
                                </div>
                                <div class="col-md-12 col-sm-12 px-0 input-group mt-1">
                                    <button class="btn btn-secondary me-1 filter_btn" name="submit_btn" type="submit"
                                        value="search">
                                        <i class="fa fa-search"></i> Filter Data
                                    </button>
                                    <a href='<?php echo e(request()->get('status') == 'archived' ? url('/questions?status=archived') : url('/questions')); ?>'
                                        class="btn btn-xs btn-primary me-1 refresh_btn"><i class="fa fa-refresh"></i>
                                        Refresh</a>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question.export')): ?>
                                        

                                        <button class="btn btn-xs btn-success float-end me-1 export_btn" name="submit_btn"
                                            value="export" type="submit">
                                            <i class="fa-solid fa-download"></i> Export
                                        </button>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question.create')): ?>
                                        <a href="<?php echo e(route('questions.create')); ?>"
                                            class="btn btn-xs btn-outline-primary float-end" name="create_new"
                                            type="button">
                                            <i class="fa-solid fa-plus"></i> Create Question
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-3 col-sm-12 px-0">
                                    <div class="input-group">
                                        <div class="input-group-append">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">

                                </div>

                            </div>
                        </form>
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Value</th>
                                    <th>Value Bangla</th>
                                    <th>Category</th>
                                    <th>Respondent</th>
                                    <th>Sub Questions</th>
                                    <th>Input Method</th>
                                    
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($index + $questions->firstItem()); ?></td>
                                        <td><?php echo e($val->value); ?></td>
                                        <td><?php echo e($val->value_bangla); ?></td>
                                        <td><?php echo e(optional($val->category)->option_value); ?></td>
                                        <td><?php echo e($val->respondent); ?></td>
                                        <td>
                                            <?php if($val->subQuestions->count() > 0): ?>
                                                <dl class="row mb-0 sub_question" style="height: 20px; overflow: hidden"
                                                    id="sub_question<?php echo e($index); ?>">
                                                    <?php $__currentLoopData = $val->subQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subQuestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <dd class="col-sm-12 pb-0 ">
                                                            <?php echo e($key + 1); ?>. <?php echo e(optional($subQuestion)->value); ?>

                                                        </dd>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </dl>
                                                <button
                                                    onclick="$('#sub_question<?php echo e($index); ?>').toggleClass('h-auto')"
                                                    class="btn btn-sm btn-link">Show more >></button>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($val->input_method); ?></td>
                                        
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <?php if(request()->get('status') == 'archived'): ?>
                                                    <span class="badge bg-secondary">Deleted</span>
                                                <?php else: ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question.edit')): ?>
                                                        <input class="form-check-input active_inactive_btn "
                                                            status="<?php echo e($val->status); ?>"
                                                            <?php echo e($val->status == -1 ? '' : ''); ?> table="questions"
                                                            type="checkbox" id="row_<?php echo e($val->id); ?>"
                                                            value="<?php echo e(Crypt::encryptString($val->id)); ?>"
                                                            <?php echo e($val->status == 1 ? 'checked' : ''); ?>

                                                            style="cursor:pointer">
                                                    <?php endif; ?>
                                    <?php endif; ?>
                        </div>
                        </td>
                        <td class="text-nowrap">
                            <?php if(request()->get('status') == 'archived'): ?>
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question.restore')): ?>
                                    <a href="" class="btn btn-primary btn-sm btn-restore-<?php echo e($val->id); ?>"
                                        onclick="event.preventDefault(); restoreConfirmation(<?php echo e($val->id); ?>)"><i
                                            class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                    <form id="restore-form-<?php echo e($val->id); ?>"
                                        action="<?php echo e(route('questions.restore', Crypt::encryptString($val->id))); ?>"
                                        method="POST" style="display: none">
                                        <?php echo method_field('POST'); ?>
                                        <?php echo csrf_field(); ?>
                                    </form>
                                <?php endif; ?>
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question.force_delete')): ?>
                                    <a href=""
                                        class="disabled btn btn-danger btn-sm btn-force-delete-<?php echo e($val->id); ?>"
                                        onclick="event.preventDefault(); forceDelete(<?php echo e($val->id); ?>)"><i
                                            class="fa-solid fa-remove "></i> Force Delete</a>
                                    <form id="force-delete-form-<?php echo e($val->id); ?>" style="display: none"
                                        action="<?php echo e(route('questions.force-delete', Crypt::encryptString($val->id))); ?>"
                                        method="POST">
                                        <?php echo method_field('DELETE'); ?>
                                        <?php echo csrf_field(); ?>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question.edit')): ?>
                                    <?php if($val->status == 1): ?>
                                        <a href="<?php echo e(route('questions.edit', Crypt::encryptString($val->id))); ?>"
                                            class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-pencil"></i> Edit</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question.delete')): ?>
                                    <a href="" class="btn btn-outline-danger btn-sm btn-delete-<?php echo e($val->id); ?>"
                                        onclick="event.preventDefault(); confirmDelete(<?php echo e($val->id); ?>)"><i
                                            class="fa-solid fa-trash"></i> Delete</a>
                                    <form id="delete-form-<?php echo e($val->id); ?>" style="display: none"
                                        action="<?php echo e(route('questions.destroy', Crypt::encryptString($val->id))); ?>"
                                        method="POST">
                                        <?php echo method_field('DELETE'); ?>
                                        <?php echo csrf_field(); ?>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>

                        </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center">No records found. </td>
                        </tr>
                        <?php endif; ?>
                        </tbody>
                        </table>
                        <?php echo e($questions->withQueryString()->links()); ?>

                    </div>
                </div>
            </div>
        </div>
        </div>

        <?php $__env->startPush('scripts'); ?>
            <script></script>
        <?php $__env->stopPush(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/question/index.blade.php ENDPATH**/ ?>