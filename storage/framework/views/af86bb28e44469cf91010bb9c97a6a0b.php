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
        label{

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
        Edit Role
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title py-1"><i class="fa fa-pencil"></i> Edit Role -
                                <?php echo e(ucwords($roleInfo->name)); ?></h3>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo e(url('roles')); ?>">Role</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('roles.update', Crypt::encryptString($roleInfo->id))); ?>" method="POST" class="needs-validation" novalidate>
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="" class="<?php if($errors->has('name')): ?> has-error <?php endif; ?> fw-bold">Role
                                Name</label><br/>
                            <input type="text" name='name' value="<?php echo e(old('name', $roleInfo->name)); ?>"
                                class="form-control-lg <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        </div>

                        <div class="form-group">
                            <label for="" class="fw-bolder">Role Permissions</label>
                            <br>
                            <label class="checkbox select-all-permission">
                                <input type="checkbox" name="permission_all" id="permission_all" class="largerCheckbox">
                                All
                            </label>
                            <div class="row row-cols-1 row-cols-md-4 gx-4 m-1">
                                <?php $__currentLoopData = $permission_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupIndex => $permission_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $groupWisePermissions = \DB::table('permissions')
                                            ->where('group_name', $permission_group->name)
                                            ->get();
                                    ?>
                                    <div class="col themed-grid-col text-start">
                                        <div class="col-md-12">
                                            <label for="permission_group<?php echo e($groupIndex); ?>"
                                                class="checkbox group-permission <?php echo e($permission_group->name); ?>"
                                                onclick="checkPermissionByGroup('<?php echo e($permission_group->name); ?>')">

                                                <input type="checkbox" class="group largerCheckbox"
                                                    name="group-permission[]"
                                                    <?php echo e(App\Models\User::roleHasPermissions($roleInfo, $groupWisePermissions) ? 'checked' : ''); ?>>
                                                <?php echo e(ucfirst($permission_group->name)); ?>


                                            </label>
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            <ul>
                                                <?php
                                                    $permissinCount = count($groupWisePermissions);
                                                ?>
                                                <?php $__currentLoopData = $groupWisePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li
                                                        class="<?php echo ($index+1<$permissinCount) ? 'border-bottom':'' ?>  p-2">
                                                        <label
                                                            class="checkbox single-permission per-<?php echo e($permission_group->name); ?>"
                                                            onclick="checkUncheckModuleByPermission('per-<?php echo e($permission_group->name); ?>', '<?php echo e($permission_group->name); ?>', <?php echo e(count($groupWisePermissions)); ?>)">
                                                            <input type="checkbox" class="largerCheckbox"
                                                                value="<?php echo e($permission->name); ?>" name="permissions[]"
                                                                id="permission<?php echo e($permission->id); ?>"
                                                                <?php echo e($roleInfo->hasPermissionTo($permission->name) ? 'checked' : ''); ?>>
                                                            <span class=""><?php echo e(ucwords(str_replace('.', ' ', $permission->name))); ?></span>
                                                        </label>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>

                                        </div>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="btn btn-success btn-lg   btn-submit">Save Changes</button>
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
<?php /**PATH /var/www/html/edds/resources/views/role/edit.blade.php ENDPATH**/ ?>