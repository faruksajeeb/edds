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
        App Footer Logos
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
                                <?php endif; ?> App Footer Logos
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        <?php if(request()->get('status') == 'archived'): ?>
                                        Deleted
                                        <?php endif; ?> App Footer Logos
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if(request()->get('status') != 'archived'): ?>
                            <a href="<?php echo e(url('/app_footer_logos?status=archived')); ?>">Deleted App Footer Logos</a>
                            <?php else: ?>
                            <a href="<?php echo e(url('/app_footer_logos')); ?>">App Footer Logos</a>
                            <?php endif; ?>
                            <?php if(request()->get('status') == 'archived' && $app_footer_logos->total() > 0): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_footer_logo.restore')): ?>
                            <div class="float-end">
                                <a href="" class="btn btn-primary btn-sm btn-restore-all" onclick="event.preventDefault(); restoreAllConfirmation()"><i class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                <form id="restore-all-form" action="<?php echo e(route('app_footer_logos.restore-all')); ?>" style="display:inline" method="POST">
                                    <?php echo method_field('POST'); ?>
                                    <?php echo csrf_field(); ?>
                                </form>
                            </div>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">

                        </div>
                        <div class="col-md-3">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_footer_logo.create')): ?>
                            <?php if(request()->get('status') != 'archived'): ?>
                            <a href="<?php echo e(route('app_footer_logos.create')); ?>" class="btn btn-xs btn-primary float-end" name="create_new" type="button">
                                <i class="fa-solid fa-plus"></i> Add App Footer Logo
                            </a>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="">

                        <div class="table-responsive">
                            <table class="table table-sm mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap" colspan="2">Order</th>
                                        <th>Status </th>
                                        <th>Logo</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable" tablename="tbl_logos">
                                    <?php $__empty_1 = true; $__currentLoopData = $app_footer_logos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr id="<?php echo e($val->id); ?>">
                                        <td class=''>
                                            <span class="sort bg-red">
                                                <i class="fa-solid fa-up-down-left-right drag-icon"></i>
                                            </span>
                                        </td>
                                        <td><?php echo e($index + $app_footer_logos->firstItem()); ?></td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <?php if(request()->get('status') == 'archived'): ?>
                                                <span class="badge bg-secondary">Archived</span>
                                                <?php else: ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_footer_logo.edit')): ?>
                                                <input class="form-check-input active_inactive_btn " status="<?php echo e($val->status); ?>" <?php echo e($val->status == -7 ? '' : ''); ?> table="tbl_logos" type="checkbox" id="row_<?php echo e($val->id); ?>" value="<?php echo e(Crypt::encryptString($val->id)); ?>" <?php echo e($val->status == 7 ? 'checked' : ''); ?> style="cursor:pointer">
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="text-nowrap ">
                                            <?php
                                            // Extract the base64 encoded data from the string
                                            $base64Data = substr($val->logo_base64, strpos($val->logo_base64, ',') + 1);

                                            // Create a data URL for the image
                                            $dataUrl = 'data:image/png;base64,' . $base64Data;
                                            ?>
                                            <!-- <img src="<?php echo e($dataUrl); ?>" alt="Base64 Image" width="100" height="100"> -->
                                            <img src="<?php echo e($val->logo_url); ?>" alt="Logo" width="100" height="100">
                                        </td>

                                        <td class="text-nowrap text-center">
                                            <?php if(request()->get('status') == 'archived'): ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_footer_logo.restore')): ?>
                                            <a href="" class="btn btn-primary btn-sm btn-restore-<?php echo e($val->id); ?>" onclick="event.preventDefault(); restoreConfirmation(<?php echo e($val->id); ?>)"><i class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                            <form id="restore-form-<?php echo e($val->id); ?>" action="<?php echo e(route('app_footer_logos.restore', Crypt::encryptString($val->id))); ?>" method="POST" style="display: none">
                                                <?php echo method_field('POST'); ?>
                                                <?php echo csrf_field(); ?>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_footer_logo.force_delete')): ?>
                                            <a href="" class="btn btn-danger btn-sm btn-force-delete-<?php echo e($val->id); ?> disabled" onclick="event.preventDefault(); forceDelete(<?php echo e($val->id); ?>)" disabled><i class="fa-solid fa-remove"></i> Force Delete</a>
                                            <form id="force-delete-form-<?php echo e($val->id); ?>" style="display: none" action="<?php echo e(route('app_footer_logos.force-delete', Crypt::encryptString($val->id))); ?>" method="POST">
                                                <?php echo method_field('DELETE'); ?>
                                                <?php echo csrf_field(); ?>
                                            </form>
                                            <?php endif; ?>
                                            <?php else: ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_footer_logo.edit')): ?>
                                            <?php if($val->status == 7): ?>
                                            <a href="<?php echo e(route('app_footer_logos.edit', Crypt::encryptString($val->id))); ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pencil"></i>
                                                Edit</a>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_footer_logo.delete')): ?>
                                            <a href="" class="btn btn-danger btn-sm btn-delete-<?php echo e($val->id); ?>" onclick="event.preventDefault(); confirmDelete(<?php echo e($val->id); ?>)"><i class="fa-solid fa-trash"></i> Delete</a>
                                            <form id="delete-form-<?php echo e($val->id); ?>" style="display: none" action="<?php echo e(route('app_footer_logos.destroy', Crypt::encryptString($val->id))); ?>" method="POST">
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
                        <?php echo e($app_footer_logos->withQueryString()->links()); ?>

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
<?php endif; ?><?php /**PATH D:\laragon\www\laravel\edds\resources\views/app_footer_logo/index.blade.php ENDPATH**/ ?>