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
        Survey Report
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Survey Report</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <label for="Division" class="col-sm-3 col-form-label">Division</label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-select">
                                    <option value="">--select division--</option>
                                    <option value="dhaka">Dhaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="district" class="col-sm-3 col-form-label">DIstrict</label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-select">
                                    <option value="">--select district--</option>
                                    <option value="dhaka">Dhaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="thana" class="col-sm-3 col-form-label">Thana</label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-select">
                                    <option value="">--select thana--</option>
                                    <option value="dhaka">Dhaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="thana" class="col-sm-3 col-form-label">Area</label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-select">
                                    <option value="">--select area--</option>
                                    <option value="dhaka">Dhaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="thana" class="col-sm-3 col-form-label">Market</label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-select">
                                    <option value="">--select market--</option>
                                    <option value="dhaka">Dhaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="thana" class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-select">
                                    <option value="">--select category--</option>
                                    <option value="dhaka">Dhaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="thana" class="col-sm-3 col-form-label">Subcategory</label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-select">
                                    <option value="">--select subcategory--</option>
                                    <option value="dhaka">Dhaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="ate from" class="col-sm-3 col-form-label">Date From</label>
                            <div class="col-sm-9">
                                <input type="text" class="datepicker form-control" name="date_from"/>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="date to" class="col-sm-3 col-form-label">Date To</label>
                            <div class="col-sm-9">
                                <input type="text" class="datepicker form-control" name="date_from"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn btn-lg btn-secondary">Generate Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/report/survey_report.blade.php ENDPATH**/ ?>