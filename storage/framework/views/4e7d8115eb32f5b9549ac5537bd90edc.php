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
        Dashboard
     <?php $__env->endSlot(); ?>
    <?php $__env->startPush('style'); ?>
        <style>
.card-box .card .numbers{
    font-size:405px!important;
}
            </style>
    <?php $__env->stopPush(); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard.view')): ?>
        <div class="card-box p-1">
            <div class="card mx-1">
                <div class="row ">
                    <div class="col-md-8">
                        <div class="numbers">0</div>
                        <div class="card-name">Total Poultry Infected</div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center border-start">
                        <div class="iconBox">
                            <i class="fa-solid fa-kiwi-bird display-6 "></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row ">
                    <div class="col-md-8">
                        <div class="numbers"> 0</div>
                        <div class="card-name">Total Bird Infected</div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center border-start">
                        <div class="iconBox">
                            <i class="fa-solid fa-dove display-6"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row ">
                    <div class="col-md-8">
                        <div class="numbers"> 0</div>
                        <div class="card-name">Today Poultry Infected</div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center border-start">
                        <div class="iconBox">
                            <i class="fa-solid fa-kiwi-bird display-6 "></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row ">
                    <div class="col-md-8">
                        <div class="numbers"> 0</div>
                        <div class="card-name">Today Bird Infected</div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center border-start">
                        <div class="iconBox">
                            <i class="fa-solid fa-dove display-6"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Modal -->
                  
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/dashboard.blade.php ENDPATH**/ ?>