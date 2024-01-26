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
        Markets
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
                                <?php endif; ?> Markets
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        <?php if(request()->get('status') == 'archived'): ?>
                                            Deleted
                                        <?php endif; ?> Markets
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if(request()->get('status') != 'archived'): ?>
                                <a href="<?php echo e(url('/markets?status=archived')); ?>">Deleted Markets</a>
                            <?php else: ?>
                                <a href="<?php echo e(url('/markets')); ?>">Markets</a>
                            <?php endif; ?>
                            <?php if(request()->get('status') == 'archived' && $markets->total() > 0): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('market.restore')): ?>
                                    <div class="float-end">
                                        <a href="" class="btn btn-primary btn-sm btn-restore-all"
                                            onclick="event.preventDefault(); restoreAllConfirmation()"><i
                                                class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                        <form id="restore-all-form" action="<?php echo e(route('markets.restore-all')); ?>"
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
                                    <select name="search_area" class="form-select" id="search_area">
                                        <option value="">Select Area</option>
                                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($area->id); ?>"
                                                <?php echo e(request()->get('search_area') == $area->id ? 'selected' : ''); ?>>
                                                <?php echo e($area->value); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <select name="search_status" class="form-select" id="search_status">
                                        <option value="">Select Status</option>
                                        <option value="7"
                                            <?php echo e(request()->get('search_status') == 7 ? 'selected' : ''); ?>>Active
                                        </option>
                                        <option value="-7"
                                            <?php echo e(request()->get('search_status') == -7 ? 'selected' : ''); ?>>Inactive
                                        </option>
                                    </select>
                                    <input type="text" name="search_text" value="<?php echo e(request()->get('search_text')); ?>"
                                        class="form-control" placeholder="Search by text">
                                </div>
                                <div class="col-md-12 col-sm-12 px-0 mt-1 input-group">
                                    <button class="btn btn-secondary me-1 filter_btn" name="submit_btn" type="submit"
                                        value="search">
                                        <i class="fa fa-search"></i> Filter Data
                                    </button>
                                    <a href='<?php echo e(request()->get('status') == 'archived' ? url('/markets?status=archived') : url('/markets')); ?>'
                                        class="btn btn-xs btn-primary me-1 refresh_btn"><i class="fa fa-refresh"></i>
                                        Refresh</a>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('market.export')): ?>
                                        
                                        

                                        <button class="btn btn-xs btn-success float-end me-1 export_btn" name="submit_btn"
                                            value="export" type="submit">
                                            <i class="fa-solid fa-download"></i> Export
                                        </button>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('market.import')): ?>
                                        <a href="<?php echo e(route('markets.import')); ?>" class="btn btn-xs btn-info float-end"
                                            name="create_new" type="button">
                                            <i class="fa-solid fa-upload"></i> Import
                                        </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('market.create')): ?>
                                        <a href="<?php echo e(route('markets.create')); ?>"
                                            class="btn btn-xs btn-outline-primary float-end" name="create_new"
                                            type="button">
                                            <i class="fa-solid fa-plus"></i> Create Market
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Market In English</th>
                                        <th>Market In Bangla</th>
                                        <th>Area</th>
                                        <th>Latitude </th>
                                        <th>Longitude </th>
                                       
                                        <th>SMS Code</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $markets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($index + $markets->firstItem()); ?></td>
                                            <td class="text-nowrap"><?php echo e($val->value); ?></td>
                                            <td class="text-nowrap"><?php echo e($val->value_bangla); ?></td>
                                            <td class="text-nowrap"><?php echo e(isset($val->area) ? $val->area->value : ''); ?>

                                            </td>
                                            <td class="text-nowrap"><?php echo e($val->latitude); ?></td>
                                            <td class="text-nowrap"><?php echo e($val->longitude); ?></td>
                                            <td class="text-nowrap"><?php echo e($val->sms_code); ?></td>                                            
                                            <td>
                                                <div class="form-check form-switch">
                                                    <?php if(request()->get('status') == 'archived'): ?>
                                                        <span class="badge bg-secondary">Archived</span>
                                                    <?php else: ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('market.edit')): ?>
                                                            <input class="form-check-input active_inactive_btn "
                                                                status="<?php echo e($val->status); ?>"
                                                                <?php echo e($val->status == -7 ? '' : ''); ?> table="markets"
                                                                type="checkbox" id="row_<?php echo e($val->id); ?>"
                                                                value="<?php echo e(Crypt::encryptString($val->id)); ?>"
                                                                <?php echo e($val->status == 7 ? 'checked' : ''); ?>

                                                                style="cursor:pointer">
                                                        <?php endif; ?>
                                        <?php endif; ?>
                            </div>
                            </td>
                            <td class="text-nowrap">
                                <?php if(request()->get('status') == 'archived'): ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('market.restore')): ?>
                                        <a href="" class="btn btn-primary btn-sm btn-restore-<?php echo e($val->id); ?>"
                                            onclick="event.preventDefault(); restoreConfirmation(<?php echo e($val->id); ?>)"><i
                                                class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                        <form id="restore-form-<?php echo e($val->id); ?>"
                                            action="<?php echo e(route('markets.restore', Crypt::encryptString($val->id))); ?>"
                                            method="POST" style="display: none">
                                            <?php echo method_field('POST'); ?>
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('market.force_delete')): ?>
                                        <a href="" class="btn btn-danger btn-sm btn-force-delete-<?php echo e($val->id); ?>"
                                            onclick="event.preventDefault(); forceDelete(<?php echo e($val->id); ?>)"><i
                                                class="fa-solid fa-remove"></i> Force Delete</a>
                                        <form id="force-delete-form-<?php echo e($val->id); ?>" style="display: none"
                                            action="<?php echo e(route('markets.force-delete', Crypt::encryptString($val->id))); ?>"
                                            method="POST">
                                            <?php echo method_field('DELETE'); ?>
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    <?php endif; ?>
                                <?php else: ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('market.edit')): ?>
                                        <?php if($val->status == 7): ?>
                                            <a href="<?php echo e(route('markets.edit', Crypt::encryptString($val->id))); ?>"
                                                class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-pencil"></i>
                                                Edit</a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('market.delete')): ?>
                                        <a href=""
                                            class="btn btn-outline-danger btn-sm btn-delete-<?php echo e($val->id); ?>"
                                            onclick="event.preventDefault(); confirmDelete(<?php echo e($val->id); ?>)"><i
                                                class="fa-solid fa-trash"></i> Delete</a>
                                        <form id="delete-form-<?php echo e($val->id); ?>" style="display: none"
                                            action="<?php echo e(route('markets.destroy', Crypt::encryptString($val->id))); ?>"
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
                        </div>
                        <?php echo e($markets->withQueryString()->links()); ?>

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
<?php endif; ?>
<?php /**PATH D:\laragon\www\laravel\edds\resources\views/market/index.blade.php ENDPATH**/ ?>