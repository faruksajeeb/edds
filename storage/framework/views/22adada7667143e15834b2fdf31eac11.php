<?php $__env->startPush('styles'); ?>
<style>
    .drag-icon {
        font-size: 25px;
        color: darkgray;
        cursor: pointer;
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
        Answers
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title py-1"><i class="fa fa-table"></i>
                                <?php if(request()->get('status') == 'archived'): ?>
                                Archived
                                <?php endif; ?> Answers
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Question & Answer</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        <?php if(request()->get('status') == 'archived'): ?>
                                        Archived
                                        <?php endif; ?> Answer
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if(request()->get('status') != 'archived'): ?>
                            <a href="<?php echo e(url('/answers?status=archived')); ?>">Archived Answers</a>
                            <?php else: ?>
                            <a href="<?php echo e(url('/answers')); ?>">Answer</a>
                            <?php endif; ?>
                            <?php if(request()->get('status') == 'archived'): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('answer.restore')): ?>
                            <div class="float-end">
                                <a href="" class="btn btn-primary btn-sm btn-restore-all" onclick="event.preventDefault(); restoreAllConfirmation()"><i class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                <form id="restore-all-form" action="<?php echo e(route('answers.restore-all')); ?>" style="display:inline" method="POST">
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
                            <input type="hidden" name="status" value="<?php echo e(request()->get('status') == 'archived' ? 'archived' : ''); ?>">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 px-0 input-group  mb-1 ">
                                    <select name="search_respondent_type" class="form-select" id="search_respondent_type">
                                        <option value="">Select Respondent Type</option>
                                        <?php $__currentLoopData = $respondent_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $respondent_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($respondent_type->option); ?>" <?php echo e(request()->get('search_respondent_type') == $respondent_type->option ? 'selected' : ''); ?>><?php echo e($respondent_type->option); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <select name="search_status" class="form-select" id="search_status">
                                        <option value="">Select Status</option>
                                        <option value="7">Active
                                        </option>
                                        <option value="-7">Inactive
                                        </option>
                                    </select>

                                    <input type="text" name="search_text" value="" class="form-control" placeholder="Search by text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-sm-12 px-0 ">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary mx-1 filter_btn" name="submit_btn" type="submit" value="search">
                                                <i class="fa fa-search"></i> Filter Data
                                            </button>
                                            <a href='<?php echo e(request()->get('status') == 'archived' ? url('/answers?status=archived') : url('/answers')); ?>' class="btn btn-xs btn-warning me-1"><i class="fa fa-refresh"></i> Refresh</a>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('answer.export')): ?>
                                            <!-- <button class="btn btn-xs btn-danger float-end " name="submit_btn"
                                                value="pdf" type="submit">
                                                <i class="fa-solid fa-download"></i> PDF
                                            </button>  -->
                                            <!-- <button class="btn btn-xs btn-info float-end me-1" name="submit_btn" value="csv" type="submit">
                                                <i class="fa-solid fa-download"></i> CSV
                                            </button> -->

                                            <button class="btn btn-xs btn-success me-1" name="submit_btn" value="export" type="submit">
                                                <i class="fa-solid fa-download"></i> Export
                                            </button>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('answer.create')): ?>
                                            <a href="<?php echo e(route('answers.create')); ?>" class=" float-end btn btn-xs btn-primary float-end" name="create_new" type="button">
                                                <i class="fa-solid fa-plus"></i> Create Answer
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12 ">
                                    <div class="float-end mt-2">
                                        <form action="<?php echo e(url()->current()); ?>" method="GET">
                                            <label for="perPage">Show
                                                <select name="perPage" id="perPage" onchange="this.form.submit()">
                                                    <option value="5" <?php echo e(Request::get('perPage') == 5 ? 'selected' : ''); ?>>5</option>
                                                    <option value="10" <?php echo e(Request::get('perPage') == 10 ? 'selected' : ''); ?>>10
                                                    </option>
                                                    <option value="25" <?php echo e(Request::get('perPage') == 25 ? 'selected' : ''); ?>>25
                                                    </option>
                                                    <option value="50" <?php echo e(Request::get('perPage') == 50 ? 'selected' : ''); ?>>50
                                                    </option>
                                                    <option value="100" <?php echo e(Request::get('perPage') == 100 ? 'selected' : ''); ?>>100
                                                    </option>
                                                    <!-- Add more options if needed -->
                                                </select> entries</label>
                                        </form>
                                    </div>


                                </div>


                            </div>
                        </form>
                        <div class="table-responsive py-3">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap" colspan="2">Order</th>
                                        <th class="text-nowarap">Status</th>
                                        <th class="text-nowarap">Answer in English</th>
                                        <th class="text-nowarap">Answer in Bangla</th>
                                        <th class="text-nowarap">Question</th>
                                        <th class="text-nowarap">Respondent Type</th>
                                        <!-- <th class="text-nowarap">Created At</th>
                                        <th class="text-nowarap">Updated At</th> -->

                                        <th class="text-nowarap">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable" tablename="tbl_a">
                                    <?php $__empty_1 = true; $__currentLoopData = $answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr id="<?php echo e($val->id); ?>">
                                        <td class=''>
                                            <span class="sort bg-red">
                                                <i class="fa-solid fa-up-down-left-right drag-icon"></i>
                                            </span>
                                        </td>
                                        <td><?php echo e($val->sl_order); ?></td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <?php if(request()->get('status') == 'archived'): ?>
                                                <span class="badge bg-secondary">Deleted</span>
                                                <?php else: ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question.edit')): ?>
                                                <input class="form-check-input active_inactive_btn " status="<?php echo e($val->status); ?>" <?php echo e($val->status == -7 ? '' : ''); ?> table="tbl_a" type="checkbox" id="row_<?php echo e($val->id); ?>" value="<?php echo e(Crypt::encryptString($val->id)); ?>" <?php echo e($val->status == 7 ? 'checked' : ''); ?> style="cursor:pointer">
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="text-nowrap"><?php echo e($val->answare); ?></td>
                                        <td class="text-nowrap"><?php echo e($val->answare_bangla); ?></td>
                                        <td class="text-nowrap"><?php echo e(isset($val->question) ? $val->question->question : ''); ?></td>
                                        
                                        <td class="text-nowrap"><?php echo e($val->respondent_type); ?></td>
                                        <!-- <td class="text-nowrap"><?php echo e($val->created_at); ?></td> -->
                                        <!-- <td class="text-nowrap"><?php echo e($val->updated_at); ?></td> -->

                                        <td class="text-nowrap">
                                            <?php if(request()->get('status') == 'archived'): ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('answer.restore')): ?>
                                            <a href="" class="btn btn-primary btn-sm btn-restore-<?php echo e($val->id); ?>" onclick="event.preventDefault(); restoreConfirmation(<?php echo e($val->id); ?>)"><i class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                            <form id="restore-form-<?php echo e($val->id); ?>" action="<?php echo e(route('answers.restore', Crypt::encryptString($val->id))); ?>" method="POST" style="display: none">
                                                <?php echo method_field('POST'); ?>
                                                <?php echo csrf_field(); ?>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('answer.force_delete')): ?>
                                            <a href="" class="btn btn-danger btn-sm btn-force-delete-<?php echo e($val->id); ?>" onclick="event.preventDefault(); forceDelete(<?php echo e($val->id); ?>)"><i class="fa-solid fa-remove"></i> Force Delete</a>
                                            <form id="force-delete-form-<?php echo e($val->id); ?>" style="display: none" action="<?php echo e(route('answers.force-delete', Crypt::encryptString($val->id))); ?>" method="POST">
                                                <?php echo method_field('DELETE'); ?>
                                                <?php echo csrf_field(); ?>
                                            </form>
                                            <?php endif; ?>
                                            <?php else: ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('answer.edit')): ?>
                                            <?php if($val->status == 7): ?>
                                            <a href="<?php echo e(route('answers.edit', [Crypt::encryptString($val->id),'page'=> $answers->currentPage()])); ?>" class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-pencil"></i> Edit</a>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('answer.delete')): ?>
                                            <a href="" class="btn btn-outline-danger btn-sm btn-delete-<?php echo e($val->id); ?>" onclick="event.preventDefault(); confirmDelete(<?php echo e($val->id); ?>)"><i class="fa-solid fa-trash"></i> Delete</a>
                                            <form id="delete-form-<?php echo e($val->id); ?>" style="display: none" action="<?php echo e(route('answers.destroy', Crypt::encryptString($val->id))); ?>" method="POST">
                                                <?php echo method_field('DELETE'); ?>
                                                <?php echo csrf_field(); ?>
                                            </form>
                                            <?php endif; ?>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No records found. </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php echo e($answers->withQueryString()->links()); ?>

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
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\laravel\edds\resources\views/answer/index.blade.php ENDPATH**/ ?>