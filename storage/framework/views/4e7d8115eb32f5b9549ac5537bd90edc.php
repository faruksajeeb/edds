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
            .card-box .card .numbers {
                font-size: 405px !important;
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
                    <input type="text" name="date_from" id="date_from" placeholder="Date From"
                        class="datepicker form-control" required />
                </div>
                <div class="col-md-3">
                    <input type="text" name="date_to" id="date_to" placeholder="Date To"
                        class="datepicker form-control" required />
                </div>
                <div class="col-md-3">
                    <button class="form-control btn btn-secondary">Generate</button>
                </div>
            </div>
        </form>
        <div class="row chart_report mx-1 my-3">
            <div class="col-md-12 chart_container h-100 bg-white">
                <canvas id="myChart" height="120px"></canvas>
            </div>
        </div>
        

        <!-- Modal -->
        
        <?php $__env->startPush('scripts'); ?>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script type="text/javascript">
             var labels =  <?php echo e(Js::from($labels)); ?>;
             var users =  <?php echo e(Js::from($data)); ?>;
  
                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'My First dataset',
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1,
                        data: users
                    }]
                };

                const config = {
                    type: 'bar',
                    data: data,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };

                const myChart = new Chart(
                    document.getElementById('myChart'),
                    config
                );
            </script>
        <?php $__env->stopPush(); ?>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/dashboard.blade.php ENDPATH**/ ?>