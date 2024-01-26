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
    Respondent Types
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
                                <?php endif; ?> Respondent Types
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        <?php if(request()->get('status') == 'archived'): ?>
                                        Deleted
                                        <?php endif; ?> Respondent Types
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if(request()->get('status') != 'archived'): ?>
                            <a href="<?php echo e(url('/respondent_types?status=archived')); ?>">Deleted Respondent Types</a>
                            <?php else: ?>
                            <a href="<?php echo e(url('/respondent_types')); ?>">Respondent Types</a>
                            <?php endif; ?>
                            <?php if(request()->get('status') == 'archived' && $respondent_types->total() > 0): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('respondent_type.restore')): ?>
                            <div class="float-end">
                                <a href="" class="btn btn-primary btn-sm btn-restore-all" onclick="event.preventDefault(); restoreAllConfirmation()"><i class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                <form id="restore-all-form" action="<?php echo e(route('respondent_types.restore-all')); ?>" style="display:inline" method="POST">
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
                                <div class="col-md-12 col-sm-12 px-0 input-group">
                                    <select name="search_status" class="form-select" id="search_status">
                                        <option value="">Select Status</option>
                                        <option value="7" <?php echo e(request()->get('search_status') == 7 ? 'selected' : ''); ?>>Active
                                        </option>
                                        <option value="-7" <?php echo e(request()->get('search_status') == -7 ? 'selected' : ''); ?>>Inactive
                                        </option>
                                    </select>
                                    <input type="text" name="search_text" value="<?php echo e(request()->get('search_text')); ?>" class="form-control" placeholder="Search by text">
                                    <button class="btn btn-secondary me-1 filter_btn" name="submit_btn" type="submit" value="search">
                                        <i class="fa fa-search"></i> Filter Data
                                    </button>
                                    <a href='<?php echo e(request()->get('status') == 'archived' ? url('/respondent_types?status=archived') : url('/respondent_types')); ?>' class="btn btn-xs btn-primary me-1 refresh_btn"><i class="fa fa-refresh"></i>
                                        Refresh</a>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('respondent_type.export')): ?>
                                    
                                    

                                    <button class="btn btn-xs btn-success float-end me-1 export_btn" name="submit_btn" value="export" type="submit">
                                        <i class="fa-solid fa-download"></i> Export
                                    </button>
                                    <?php endif; ?>
                                 
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('respondent_type.create')): ?>
                                    <a href="<?php echo e(route('respondent_types.create')); ?>" class="btn btn-xs btn-outline-primary float-end" name="create_new" type="button">
                                        <i class="fa-solid fa-plus"></i> Create Respondent Types
                                    </a>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-12 col-sm-12 px-0 mt-1 input-group">

                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Status</th>
                                        <th>Value</th>
                                        <th>Label In English</th>
                                        <th>Label In Bangla</th>
                                        <th>SMS Code</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $respondent_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($index + $respondent_types->firstItem()); ?></td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <?php if(request()->get('status') == 'archived'): ?>
                                                <span class="badge bg-secondary">Archived</span>
                                                <?php else: ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('respondent_type.edit')): ?>
                                                <input class="form-check-input active_inactive_btn " status="<?php echo e($val->status); ?>" <?php echo e($val->status == -7 ? '' : ''); ?> table="tbl_respopndent" type="checkbox" id="row_<?php echo e($val->id); ?>" value="<?php echo e(Crypt::encryptString($val->id)); ?>" <?php echo e($val->status == 7 ? 'checked' : ''); ?> style="cursor:pointer">
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class=""><?php echo e($val->option); ?></td>
                                        <td class=""><?php echo e($val->label); ?></td>
                                        <td class=""><?php echo e($val->label_bangla); ?></td>
                                        <td class=""><?php echo e($val->sms_code); ?></td>

                                        <td class="text-nowrap">
                                            <?php if(request()->get('status') == 'archived'): ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('respondent_type.restore')): ?>
                                            <a href="" class="btn btn-primary btn-sm btn-restore-<?php echo e($val->id); ?>" onclick="event.preventDefault(); restoreConfirmation(<?php echo e($val->id); ?>)"><i class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                            <form id="restore-form-<?php echo e($val->id); ?>" action="<?php echo e(route('respondent_types.restore', Crypt::encryptString($val->id))); ?>" method="POST" style="display: none">
                                                <?php echo method_field('POST'); ?>
                                                <?php echo csrf_field(); ?>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('respondent_type.force_delete')): ?>
                                            <a href="" class="btn btn-danger btn-sm btn-force-delete-<?php echo e($val->id); ?> disabled" onclick="event.preventDefault(); forceDelete(<?php echo e($val->id); ?>)" disabled><i class="fa-solid fa-remove"></i> Force Delete</a>
                                            <form id="force-delete-form-<?php echo e($val->id); ?>" style="display: none" action="<?php echo e(route('respondent_types.force-delete', Crypt::encryptString($val->id))); ?>" method="POST">
                                                <?php echo method_field('DELETE'); ?>
                                                <?php echo csrf_field(); ?>
                                            </form>
                                            <?php endif; ?>
                                            <?php else: ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('respondent_type.edit')): ?>
                                            <?php if($val->status == 7): ?>
                                            <a href="<?php echo e(route('respondent_types.edit', Crypt::encryptString($val->id))); ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pencil"></i>
                                                Edit</a>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('respondent_type.delete')): ?>
                                            <a href="" class="btn btn-danger btn-sm btn-delete-<?php echo e($val->id); ?>" onclick="event.preventDefault(); confirmDelete(<?php echo e($val->id); ?>)"><i class="fa-solid fa-trash"></i> Delete</a>
                                            <form id="delete-form-<?php echo e($val->id); ?>" style="display: none" action="<?php echo e(route('respondent_types.destroy', Crypt::encryptString($val->id))); ?>" method="POST">
                                                <?php echo method_field('DELETE'); ?>
                                                <?php echo csrf_field(); ?>
                                            </form>
                                            <?php endif; ?>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No records found. </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php echo e($respondent_types->withQueryString()->links()); ?>

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
<?php endif; ?><?php /**PATH D:\laragon\www\laravel\edds\resources\views/respondent_type/index.blade.php ENDPATH**/ ?>