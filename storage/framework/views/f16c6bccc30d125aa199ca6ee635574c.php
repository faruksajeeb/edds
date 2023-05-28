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
        Users
     <?php $__env->endSlot(); ?>
    <?php
        $loggedUser = Auth::guard('web')->user();
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title py-1"><i class="fa fa-list"></i>
                                <?php if(request()->get('status') == 'archived'): ?>
                                    Archived
                                <?php endif; ?> Users
                            </h5>

                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
                                    <li class="breadcrumb-item " aria-current="page"><?php if(request()->get('status') == 'archived'): ?>
                                        Archived
                                    <?php endif; ?> Users</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if(request()->get('status') != 'archived'): ?>
                                <a href="<?php echo e(url('/users?status=archived')); ?>">Archived users</a>
                            <?php else: ?>
                                <a href="<?php echo e(url('/users')); ?>">Users</a>
                            <?php endif; ?>
                            <?php if((request()->get('status') == 'archived') && ($users->total() >0)): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.restore')): ?>
                                    <div class="float-end">
                                        <a href="" class="btn btn-primary btn-sm btn-restore-all"
                                            onclick="event.preventDefault(); restoreAllConfirmation()"><i
                                                class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                        <form id="restore-all-form" action="<?php echo e(route('users.restore-all')); ?>"
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
                            <input type="hidden" name="status" value="<?php echo e((request()->get('status') == 'archived') ? 'archived':''); ?>">
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
                                <div class="col-md-6 col-sm-12 px-0">
                                    <div class="input-group">
                                        <input type="text" name="search_text" value="" class="form-control"
                                            placeholder="Search by text">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary mx-1" name="submit_btn" type="submit"
                                                value="search">
                                                <i class="fa fa-search"></i> Search
                                            </button>
                                            <a href='<?php echo e((request()->get('status') == 'archived') ? url('/users?status=archived'): url('/users')); ?>' class="btn btn-xs btn-secondary mx-1"><i class="fa fa-refresh"></i></a>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.export')): ?>
                                                <button class="btn btn-xs btn-success float-end mx-1" name="submit_btn"
                                                    value="export" type="submit">
                                                    <i class="fa-solid fa-download"></i> Export
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.create')): ?>
                                        <a href="<?php echo e(route('users.create')); ?>"
                                            class="btn btn-xs btn-outline-primary float-end" name="create_new"
                                            type="button">
                                            <i class="fa-solid fa-plus"></i> Create New
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
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Permissions</th>
                                    
                                    <th class="text-end">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($key + $users->firstItem()); ?></td>
                                        <td><?php echo e($val->name); ?></td>
                                        <td><?php echo e($val->email); ?></td>
                                        <td>
                                            <?php $__currentLoopData = $val->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge bg-info text-dark"><?php echo e($role->name); ?></span>
                                                
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </td>
                                        <td width="30%">
                                            * User can access assigned role permissions. <br />
                                            <?php if(count($val->permissions) > 0): ?>
                                                and also access below permissions too.
                                                <?php $__currentLoopData = $val->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge bg-info text-dark"><?php echo e($permission->name); ?></span>
                                                    
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <br />
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td class="text-end">
                                            <div class="form-check form-switch">
                                                <?php if(request()->get('status') == 'archived'): ?>
                                                    <span class="badge bg-secondary">Archived</span>
                                                <?php else: ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.edit')): ?>
                                                        <input class="form-check-input active_inactive_btn "
                                                            status="<?php echo e($val->status); ?>"
                                                            <?php echo e($val->status == -1 ? '' : ''); ?> table="users"
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
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.restore')): ?>
                                                    <a href=""
                                                        class="btn btn-primary btn-sm btn-restore-<?php echo e($val->id); ?>"
                                                        onclick="event.preventDefault(); restoreConfirmation(<?php echo e($val->id); ?>)"><i
                                                            class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                                    <form id="restore-form-<?php echo e($val->id); ?>"
                                                        action="<?php echo e(route('users.restore', Crypt::encryptString($val->id))); ?>"
                                                        method="POST" style="display: none">
                                                        <?php echo method_field('POST'); ?>
                                                        <?php echo csrf_field(); ?>
                                                    </form>
                                                <?php endif; ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.force_delete')): ?>
                                                    <a href=""
                                                        class="btn btn-danger btn-sm btn-force-delete-<?php echo e($val->id); ?>"
                                                        onclick="event.preventDefault(); forceDelete(<?php echo e($val->id); ?>)"><i
                                                            class="fa-solid fa-remove"></i> Force Delete</a>
                                                    <form id="force-delete-form-<?php echo e($val->id); ?>" style="display: none"
                                                        action="<?php echo e(route('users.force-delete', Crypt::encryptString($val->id))); ?>"
                                                        method="POST">
                                                        <?php echo method_field('DELETE'); ?>
                                                        <?php echo csrf_field(); ?>
                                                    </form>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.edit')): ?>
                                                    <a href="<?php echo e(route('users.edit', Crypt::encryptString($val->id))); ?>"
                                                        class="btn btn-outline-warning btn-sm"><i
                                                            class="fa-solid fa-pencil"></i> Edit</a>
                                                <?php endif; ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.delete')): ?>
                                                    <a href=""
                                                        class="btn btn-outline-danger btn-sm btn-delete-<?php echo e($val->id); ?>"
                                                        onclick="event.preventDefault(); confirmDelete(<?php echo e($val->id); ?>)"><i
                                                            class="fa-solid fa-trash"></i> Delete</a>
                                                    <form id="delete-form-<?php echo e($val->id); ?>" style="display: none"
                                                        action="<?php echo e(route('users.destroy', Crypt::encryptString($val->id))); ?>"
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
                                        <td colspan="7" class="text-center">No records found. </td>
                                    </tr>
                                    <?php endif; ?>
                            </tbody>
                        </table>
                        <?php echo e($users->withQueryString()->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('styles'); ?>
        <style>
            
        </style>
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('scripts'); ?>
        <script></script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/users/index.blade.php ENDPATH**/ ?>