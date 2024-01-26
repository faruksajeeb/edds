<div class="topbar row m-0 p-0  sticky-top ">
    <div class="col-md-6 m-0 p-0">
        <div class="toggle  float-start" onclick="toggleMenu()">
        </div>
        <div class="py-3">
            <a href="<?php echo e(route('home')); ?>" > Go to home page </a>
        </div>
    </div>
    <div class="col-md-6 m-0 p-3 ">        
        <div class="dropdown user float-end">
            <a href="#" class="d-flex align-items-center text-black text-decoration-none dropdown-toggle"
                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo e(asset('images/user.png')); ?>" alt="hugenerd" width="30" height="30"
                    class="rounded-circle float-end ">

                <span class="d-none d-sm-inline mx-1"><?php echo e(Auth::user()->name); ?></span>
            </a>

            <ul class="dropdown-menu dropdown-menu-light text-small shadow" aria-labelledby="dropdownUser1">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('change.password')): ?>
                    <li><a class="dropdown-item" href="<?php echo e(route('change-password')); ?>">Change Password</a></li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.profile')): ?>
                    <li><a class="dropdown-item" href="<?php echo e(route('user-profile')); ?>">Profile</a></li>
                <?php endif; ?>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    
                    <!-- Authentication -->
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>

                        <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['class' => 'text-decoration-none','href' => route('logout'),'onclick' => 'event.preventDefault();
                                    this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-decoration-none','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'onclick' => 'event.preventDefault();
                                    this.closest(\'form\').submit();']); ?>
                            <?php echo e(__('Log Out')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                    </form>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a  href="<?php echo e(url('clear')); ?>"  class="dropdown-item" >clear all</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\laravel\edds\resources\views/layouts/topbar.blade.php ENDPATH**/ ?>