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
        Permissions
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title py-1"><i class="fa fa-list"></i>
                                <?php if(request()->get('status') == 'archived'): ?>
                                    Archived
                                <?php endif; ?> Permissions
                            </h3>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        <?php if(request()->get('status') == 'archived'): ?>
                                            Archived
                                        <?php endif; ?> Permissions
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if(request()->get('status') != 'archived'): ?>
                                <a href="<?php echo e(url('/permissions?status=archived')); ?>">Archived permissions</a>
                            <?php else: ?>
                                <a href="<?php echo e(url('/permissions')); ?>">Permissions</a>
                            <?php endif; ?>
                            <?php if((request()->get('status') == 'archived') && ($permissions->total() >0)): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.restore')): ?>
                                    <div class="float-end">
                                        <a href="" class="btn btn-primary btn-sm btn-restore-all"
                                            onclick="event.preventDefault(); restoreAllConfirmation()"><i
                                                class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                        <form id="restore-all-form" action="<?php echo e(route('permissions.restore-all')); ?>"
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
                                <div class="col-md-3 col-sm-12">
                                    <select name="search_status" class="form-select" id="search_status">
                                        <option value="">Select Status</option>
                                        <option value="1">Active
                                        </option>
                                        <option value="-1">Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-5 col-sm-12 px-0">
                                    <div class="input-group">
                                        <input type="text" name="search_text" value="" class="form-control"
                                            placeholder="Search by text">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary mx-1" name="submit_btn" type="submit"
                                                value="search">
                                                <i class="fa fa-search"></i> Search
                                            </button>
                                            <a href='<?php echo e(request()->get('status') == 'archived' ? url('/permissions?status=archived') : url('/permissions')); ?>'
                                                class="btn btn-xs btn-secondary mx-1"><i class="fa fa-refresh"></i></a>
                                            <button class="btn btn-xs btn-success float-end" name="submit_btn"
                                                value="export" type="submit">
                                                <i class="fa-solid fa-download"></i> Export
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission.create')): ?>
                                        <a href="<?php echo e(route('permissions.create')); ?>"
                                            class="btn btn-xs btn-outline-primary float-end" name="create_new"
                                            type="button">
                                            <i class="fa-solid fa-plus"></i> Create Permission
                                        </a>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </form>
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Name</th>
                                    <th>Group Name</th>
                                    <th>Guard Name</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($index + $permissions->firstItem()); ?></td>
                                        <td><?php echo e($val->name); ?></td>
                                        <td><?php echo e($val->group_name); ?></td>
                                        <td><?php echo e($val->guard_name); ?></td>
                                        <td><?php echo e($val->created_at); ?></td>
                                        <td><?php echo e($val->updated_at); ?></td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <?php if(request()->get('status') == 'archived'): ?>
                                                    <span class="badge bg-secondary">Archived</span>
                                                <?php else: ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission.edit')): ?>
                                                        <input class="form-check-input active_inactive_btn "
                                                            status="<?php echo e($val->status); ?>"
                                                            <?php echo e($val->status == -1 ? '' : ''); ?> table="permissions"
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
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission.restore')): ?>
                                    <a href="" class="btn btn-primary btn-sm btn-restore-<?php echo e($val->id); ?>"
                                        onclick="event.preventDefault(); restoreConfirmation(<?php echo e($val->id); ?>)"><i
                                            class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                    <form id="restore-form-<?php echo e($val->id); ?>"
                                        action="<?php echo e(route('permissions.restore', Crypt::encryptString($val->id))); ?>" method="POST"
                                        style="display: none">
                                        <?php echo method_field('POST'); ?>
                                        <?php echo csrf_field(); ?>
                                    </form>
                                <?php endif; ?>
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission.force_delete')): ?>
                                    <a href="" class="btn btn-danger btn-sm btn-force-delete-<?php echo e($val->id); ?>"
                                        onclick="event.preventDefault(); forceDelete(<?php echo e($val->id); ?>)"><i
                                            class="fa-solid fa-remove"></i> Force Delete</a>
                                    <form id="force-delete-form-<?php echo e($val->id); ?>" style="display: none"
                                        action="<?php echo e(route('permissions.force-delete', Crypt::encryptString($val->id))); ?>"
                                        method="POST">
                                        <?php echo method_field('DELETE'); ?>
                                        <?php echo csrf_field(); ?>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission.edit')): ?>
                                    <a href="<?php echo e(route('permissions.edit', Crypt::encryptString($val->id))); ?>"
                                        class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-pencil"></i> Edit</a>
                                <?php endif; ?>
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission.delete')): ?>
                                    <a href="" class="btn btn-outline-danger btn-sm btn-delete-<?php echo e($val->id); ?>"
                                        onclick="event.preventDefault(); confirmDelete(<?php echo e($val->id); ?>)"><i
                                            class="fa-solid fa-trash"></i> Delete</a>
                                    <form id="delete-form-<?php echo e($val->id); ?>" style="display: none"
                                        action="<?php echo e(route('permissions.destroy', Crypt::encryptString($val->id))); ?>" method="POST">
                                        <?php echo method_field('DELETE'); ?>
                                        <?php echo csrf_field(); ?>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>

                        </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        </table>
                        <?php echo e($permissions->withQueryString()->links()); ?>

                    </div>
                </div>
            </div>
        </div>
        </div>

        <?php $__env->startPush('scripts'); ?>
            <script>
               
            </script>
        <?php $__env->stopPush(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/permission/index.blade.php ENDPATH**/ ?>