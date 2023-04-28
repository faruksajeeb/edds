<?php $__env->startPush('styles'); ?>
    <style>
        ul {
            list-style: none;
            font-size: 17px;
        }

        input.largerCheckbox {
            width: 17px;
            height: 17px;
        }

        label {}
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
        Edit Permission
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title py-1"><i class="fa fa-pencil"></i> Edit Permission</h4>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo e(url('permissions')); ?>">Permission</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('permissions.update', Crypt::encryptString($permissionInfo->id))); ?>"
                        method="POST">
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for=""
                                class="<?php if($errors->has('group_name')): ?> has-error <?php endif; ?> fw-bold">Permission
                                Group *</label><br />
                            <select name="group_name" id="group_name"
                                class="form-select  <?php $__errorArgs = ['group_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">--select permission group--</option>
                                <?php $__currentLoopData = $permission_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val->name); ?>" <?php echo e(($val->name == old('group_name', $permissionInfo->group_name))? 'selected':''); ?>><?php echo e($val->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for=""
                                class="<?php if($errors->has('name')): ?> has-error <?php endif; ?> fw-bold">Permission
                                Name *</label><br />
                            <input type="text" name='name' id='name' value="<?php echo e(old('name', $permissionInfo->name)); ?>"
                                class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Enter permission name">
                        </div>
                        <div class="form-group">
                            <label for="" class="<?php if($errors->has('is_menu')): ?> has-error <?php endif; ?> fw-bold">Is
                                Menu?</label><br />
                            <select name="is_menu" id="is_menu"
                                class="form-select  <?php $__errorArgs = ['is_menu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="no" <?php echo e(old('is_menu',$permissionInfo->is_menu) == 'no' ? 'selected' : ''); ?>>No</option>
                                <option value="yes" <?php echo e(old('is_menu',$permissionInfo->is_menu) == 'yes' ? 'selected' : ''); ?>>Yes</option>
                            </select>
                        </div>
                        <section id="menu_section" style="display: none">
                            <div class="form-group">
                                <label for=""
                                    class="<?php if($errors->has('menu_name')): ?> has-error <?php endif; ?> fw-bold">Menu
                                    Name</label><br />
                                <input type="text" name='menu_name' id='menu_name' value="<?php echo e(old('menu_name',$permissionInfo->menu_name)); ?>"
                                    class="form-control <?php $__errorArgs = ['menu_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="If is menu? Yes. Please enter menu name">
                            </div>
                            <div class="form-group">
                                <label for=""
                                    class="<?php if($errors->has('icon')): ?> has-error <?php endif; ?> fw-bold">Menu
                                    Icon</label><br />
                                <input type="text" name='icon' id='icon' value="<?php echo e(old('icon',$permissionInfo->icon)); ?>"
                                    class="form-control <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="Enter font awesome icon">
                            </div>
                        </section>

                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="btn btn-success btn-lg">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <script>
            $(function() {
                $(function() {
                    $('#menu_section').hide();
                    let isMenu = $('#is_menu').val();
                    menuSectionShowHide(isMenu);
                    $('#is_menu').on('change', function() {
                        let isMenu = $(this).val();
                        menuSectionShowHide(isMenu);
                        $('#name').val(groupName + '.');
                    });
                    $('#group_name').on('change', function() {
                        let groupName = $(this).val();
                        $('#name').val(groupName + '.');
                    });
                });
                menuSectionShowHide = (isMenu) => {
                    if (isMenu === 'yes') {
                        $('#menu_section').show();
                    } else {
                        $('#menu_section').hide();
                    }
                }
            });
        </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/permissions/edit.blade.php ENDPATH**/ ?>