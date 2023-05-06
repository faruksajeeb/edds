<?php $__env->startPush('styles'); ?>
    <style>
        ul {
            list-style: none;
            font-size:17px;
        }

        input.largerCheckbox {
            width: 17px;
            height: 17px;
        }
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
        Edit User
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title py-1"><i class="fa fa-pencil"></i> Edit User</h3>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo e(url('users')); ?>">Users</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body  p-3">
                    <form action="<?php echo e(route('users.update', Crypt::encryptString($user->id))); ?>" method="POST" class="needs-validation" novalidate>
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <div class="row  p-3">
                            <div class="col-md-5 border border-1  p-3">
                                <div class="form-group">
                                    <label for="">User Name</label>
                                    <input type="text" name='name' value="<?php echo e(old('name', $user->name)); ?>"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">User Email</label>
                                    <input type="text" name='email' value="<?php echo e(old('email', $user->email)); ?>"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name='password' value="<?php echo e(old('password')); ?>"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="password" name='password_confirmation' class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="roles">Assign Roles</label>
                                    <select name="roles[]" id="" class="form-control select2" multiple
                                        required>
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->id); ?>"
                                                <?php echo e($user->hasRole($role->id) ? 'selected' : ''); ?>><?php echo e(ucwords($role->name)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="" class="fw-bolder">User Permissions</label>
                                    <br>
                                    <label class="checkbox select-all-permission">
                                        <input type="checkbox" name="permission_all" id="permission_all">
                                        All
                                    </label>

                                    <hr>
                                    <?php $__currentLoopData = $permission_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupIndex => $permission_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="permission_group<?php echo e($groupIndex); ?>"
                                                    class="checkbox group-permission <?php echo e($permission_group->group_name); ?>"
                                                    onclick="checkPermissionByGroup('<?php echo e($permission_group->group_name); ?>')">
                                                    <input type="checkbox" class="group" name="group-permission[]">
                                                    <?php echo e(ucfirst($permission_group->group_name)); ?>


                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <?php
                                                    $groupWisePermissions = \DB::table('permissions')
                                                        ->where('group_name', $permission_group->group_name)
                                                        ->get();
                                                ?>
                                                <ul>
                                                    <?php
                                                        $permissinCount = count($groupWisePermissions);
                                                    ?>
                                                    <?php $__currentLoopData = $groupWisePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li
                                                            class="<?php echo ($index+1<$permissinCount) ? 'border-bottom':'' ?>  p-2">
                                                            <label
                                                                class="checkbox single-permission per-<?php echo e($permission_group->group_name); ?>"
                                                                onclick="checkUncheckModuleByPermission('per-<?php echo e($permission_group->group_name); ?>', '<?php echo e($permission_group->group_name); ?>', <?php echo e(count($groupWisePermissions)); ?>)">
                                                                <input type="checkbox" value="<?php echo e($permission->name); ?>"
                                                                    name="permissions[]"
                                                                    id="permission<?php echo e($permission->id); ?>"  <?php echo e(($user->hasPermissionTo($permission->name)? 'checked':'')); ?>>
                                                                <?php echo e(ucwords(str_replace('.', ' ', $permission->name))); ?>

                                                            </label>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>

                                            </div>
                                        </div>
                                        <?php echo ($groupIndex+1<count($permission_groups)) ? '<hr>':'' ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>

                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="btn btn-success  btn-submit">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <script>
            $(function() {
                allChecked();
            });
            $('.select-all-permission input').on('click', function() {
                if ($(this).is(':checked')) {
                    $(".group-permission input").prop("checked", true);
                    $(".single-permission input").prop("checked", true);
                } else {
                    $(".group-permission input").prop("checked", false);
                    $(".single-permission input").prop("checked", false);
                }
            });

            function checkPermissionByGroup(groupName) {

                const singleCheckBox = $('.per-' + groupName + " input");
                if ($('.' + groupName + " input").is(':checked')) {

                    singleCheckBox.prop("checked", true);
                } else {

                    singleCheckBox.prop("checked", false);
                }
                allChecked();
            }

            function checkUncheckModuleByPermission(permissionClassName, GroupClassName, countTotalPermission) {
                const groupIdCheckBox = $('.' + GroupClassName + " input");
                if ($('.' + permissionClassName + " input:checked").length == countTotalPermission) {
                    groupIdCheckBox.prop("checked", true);
                } else {
                    groupIdCheckBox.prop("checked", false);
                }
                allChecked();
            }

            function allChecked() {
                const countTotalPermission = <?php echo e(count($permissions)); ?>

                //alert($(".permission input:checked").length);
                if ($(".single-permission input:checked").length == countTotalPermission) {
                    $('.select-all-permission input').prop("checked", true);
                } else {
                    $('.select-all-permission input').prop("checked", false);
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
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/users/edit.blade.php ENDPATH**/ ?>