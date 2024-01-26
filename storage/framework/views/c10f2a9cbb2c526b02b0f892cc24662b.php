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
        Dashboard
     <?php $__env->endSlot(); ?>
    <?php $__env->startPush('styles'); ?>
        <style>
            .card-box .card .numbers {
                font-size: 405px !important;
            }

            #svgDistrictWiseMap {
                width: 940px;
                height: 1270px;
            }
        </style>
    <?php $__env->stopPush(); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard.view')): ?>
        
        
        <form action="" method="POST" class="mt-2 chart_form">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-3">
                    <select name="chart_type" id="chart_type" class="form-select">
                        <option value="">--Select Chart Type--</option>
                        <option value="bar" <?php echo e($chart_type == 'bar' ? 'selected' : ''); ?>>Bar</option>
                        <option value="pie" <?php echo e($chart_type == 'pie' ? 'selected' : ''); ?>>Pie</option>
                        <option value="line" <?php echo e($chart_type == 'line' ? 'selected' : ''); ?>>Line</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="date_from" id="date_from" placeholder="Date From"
                        class="datepicker form-control" value="<?php echo e($date_from); ?>" required />
                </div>
                <div class="col-md-3">
                    <input type="text" name="date_to" id="date_to" placeholder="Date To"
                        class="datepicker form-control" value="<?php echo e($date_to); ?>" required />
                </div>
                <div class="col-md-3">
                    <button class="form-control btn btn-secondary generate_btn" type="submit" name="submit_btn"
                        value="submit_btn">Generate</button>
                </div>
            </div>
        </form>
        <div class="row chart_report mx-1 my-3">
            <?php if($chart_type == 'pie'): ?>
                <h5 class="text-center bg-white p-3">Division Wise Response Data</h5>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 chart_container h-100 bg-white py-3">
                        <canvas id="myPieChart<?php echo e($category->id); ?>" height="150px"></canvas>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="col-md-12 chart_container h-100 bg-white">
                    <canvas id="myChart" height="120px"></canvas>
                </div>
            <?php endif; ?>

        </div>


        

        <?php $__env->startPush('scripts'); ?>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script type="text/javascript">
                var labels = <?php echo e(Js::from($labels)); ?>;
                var responses = <?php echo e(Js::from($data)); ?>;
                <?php if($chart_type == 'pie'): ?>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        const data<?php echo e($category->id); ?> = {
                            labels: labels,
                            datasets: [{
                                label: '<?php echo e($category->option_value); ?> Total',
                                data: responses[<?php echo e($category->id); ?>],
                                // data: [0,2,3,4,5,6,7,8],
                                backgroundColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(54, 162, 235)',
                                    'rgb(255, 132, 0)',
                                    'rgb(209, 77, 114)',
                                    'rgb(255, 217, 90)',
                                    'rgb(164, 89, 209)',
                                    'rgb(44, 211, 225)',
                                    'rgb(153, 169, 143)',
                                    'rgb(82, 109, 130)',
                                ],
                                hoverOffset: 4
                            }]
                        };
                        const config<?php echo e($category->id); ?> = {
                            type: 'pie',
                            data: data<?php echo e($category->id); ?>,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    title: {
                                        display: true,
                                        text: '<?php echo e($category->option_value); ?>'
                                    }
                                }
                            },
                        };
                        const myChart<?php echo e($category->id); ?> = new Chart(
                            document.getElementById("myPieChart<?php echo e($category->id); ?>"),
                            config<?php echo e($category->id); ?>

                        );
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>

                    const data = {
                        labels: labels,
                        datasets: [
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                {
                                    label: "<?php echo e($category->option_value); ?>",
                                    // backgroundColor: [
                                    //     'rgba(255, 99, 132, 0.2)',
                                    //     'rgba(255, 159, 64, 0.2)',
                                    //     'rgba(255, 205, 86, 0.2)',
                                    //     'rgba(75, 192, 192, 0.2)',
                                    //     'rgba(54, 162, 235, 0.2)',
                                    //     'rgba(153, 102, 255, 0.2)',
                                    //     'rgba(201, 203, 207, 0.2)'
                                    // ],
                                    // borderColor: [
                                    //     'rgb(255, 99, 132)',
                                    //     'rgb(255, 159, 64)',
                                    //     'rgb(255, 205, 86)',
                                    //     'rgb(75, 192, 192)',
                                    //     'rgb(54, 162, 235)',
                                    //     'rgb(153, 102, 255)',
                                    //     'rgb(201, 203, 207)'
                                    // ],
                                    borderWidth: 1,
                                    data: responses[<?php echo e($category->id); ?>]
                                },
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        ]
                    };

                    const config = {
                        type: '<?php echo e($chart_type); ?>',
                        data: data,
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Division Wise Response Data'
                                }
                            }
                        }
                    };
                    const myChart = new Chart(
                        document.getElementById('myChart'),
                        config
                    );
                <?php endif; ?>


                $(document).on('click', ".generate_btn", function() {
                    $('.generate_btn').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating...'
                    );
                });
            </script>
        <?php $__env->stopPush(); ?>
    <?php endif; ?>
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
<?php /**PATH D:\laragon\www\laravel\edds\resources\views/dashboard.blade.php ENDPATH**/ ?>