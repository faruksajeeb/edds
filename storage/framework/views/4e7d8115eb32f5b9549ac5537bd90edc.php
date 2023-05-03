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
        
        
        <form action="" method="POST" class="mt-2">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-3">
                    <select name="chart_type" id="chart_type" class="form-select">
                        <option value="">--Select Chart Type--</option>
                        <option value="column">Column</option>
                        <option value="bar">Bar</option>
                        <option value="pie">Pie</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="date_from" id="date_from" placeholder="Date From" class="datepicker form-control" required/>
                </div>
                <div class="col-md-3">
                    <input type="text" name="date_to" id="date_to" placeholder="Date To" class="datepicker form-control" required/>
                </div>
                <div class="col-md-3">
                    <button class="form-control btn btn-secondary">Generate</button>
                </div>
            </div>
        </form>
        <div class="row chart_report mx-1 my-3">
            <div class="col-md-12 chart_container h-100 bg-white">

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