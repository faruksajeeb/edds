 <?php $__env->slot('title', null, []); ?> 
    Options
 <?php $__env->endSlot(); ?>

<div>
    <section>

        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header bg-white my-0 pt-2 pb-0">
                        <div class="row ">
                            <div class="col-md-8">
                                <h4 class="card-title py-1"><i class="fa fa-list"></i> Options</h4>
                                
                            </div>
                            <div class="col-md-4 col-sm-12 text-end">
                                
                                <a class="btn btn-sm btn-success float-end" wire:click.prevent="render('excelExport')"><i
                                        class="fa-solid fa-download"></i> Export</a>
                                
                                
                                
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-outline-primary float-end me-1"
                                    data-bs-toggle="modal" data-bs-target="#addModal"
                                    wire:click="resetInputFields()">
                                    <i class="fa-solid fa-plus"></i> Create New
                                </button>
                                
                                
                            </div>

                        </div>
                    </div>
                    <div class="card-body py-1">
                        <div class="row my-1">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input class="form-control border-end-0 border rounded-pill" type="text"
                                        placeholder="Search..." wire:model="searchTerm">
                                </div>
                                
                            </div>
                            <div class="col-md-2">
                                <select name="" id="" wire:model='status' class="form-control">
                                    <option value="">--Status--</option>
                                    <option value="1">Active</option>
                                    <option value="-1">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div wire:ignore>
                                    <select name="option_group_name" id="option_group_name"
                                        wire:model='option_group_name' class="form-control select2">
                                        <option value="">--Option Group--</option>
                                        <?php $__currentLoopData = $option_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($val->option_group_name); ?>"><?php echo e($val->option_group_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div>
                                    You have selected: <strong><?php echo e($option_group_name); ?></strong>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select name="" id="" wire:model='orderBy' class="form-control">
                                    <option value="">--Order By--</option>
                                    <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($col); ?>"><?php echo e($col); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="" id="" wire:model='sortBy' class="form-control">
                                    <option value="">--Sort By--</option>
                                    <option value="DESC">Decending</option>
                                    <option value="ASC">Ascending</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                Per Page
                                <select name="" id="" class="py-0" wire:model='pazeSize'>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="100">100</option>
                                    <option value="500">500</option>
                                </select>
                                Current Page <?php echo e($options->currentPage()); ?>

                            </div>
                        </div>

                        <table class="table table-striped table-brodered table-sm">
                            <thead>
                                <tr>
                                    <th>Sl.</th>
                                    <th>Option Group Name</th>
                                    <th>Option Value</th>
                                    <th>Option Value2</th>
                                    <th>Option Value3</th>
                                    <th>Status</th>
                                    
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + $options->firstItem()); ?></td>
                                        <td><?php echo e(str_replace('_', ' ', $val->option_group_name)); ?></td>
                                        <td><?php echo e(str_replace('_', ' ', $val->option_value)); ?></td>
                                        <td><?php echo e(str_replace('_', ' ', $val->option_value2)); ?></td>
                                        <td><?php echo e(str_replace('_', ' ', $val->option_value3)); ?></td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input active_inactive_btn "
                                                    status="<?php echo e($val->status); ?>" <?php echo e($val->status == -1 ? '' : ''); ?>

                                                    table="options" type="checkbox" id="row_<?php echo e($val->id); ?>"
                                                    value="<?php echo e(Crypt::encryptString($val->id)); ?>"
                                                    <?php echo e($val->status == 1 ? 'checked' : ''); ?> style="cursor:pointer">
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <button class="btn btn-sm btn-success me-1 py-1 mt-1 "
                                                wire:click.prevent="edit('<?php echo e(Crypt::encryptString($val->id)); ?>')"
                                                data-bs-toggle="modal"  
                                                data-bs-target="#editModal" title="Edit"><i
                                                    class="fa-solid fa-file-pen"></i></button>

                                            <button class="btn btn-sm btn-danger py-1 mt-1 del_btn"
                                                
                                                wire:click.prevent="$emit('triggerDelete','<?php echo e(Crypt::encryptString($val->id)); ?>')"
                                                 title="Delete"><i
                                                    class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer " wire:key="$options->id">
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo e($options->links()); ?>

                            </div>
                            <div class="col-md-6 text-end">
                                <div>
                                    <p class="text-sm text-gray-700 leading-5">
                                        <?php echo __('Showing'); ?>

                                        <span class="font-medium"><?php echo e($options->firstItem()); ?></span>
                                        <?php echo __('to'); ?>

                                        <span class="font-medium"><?php echo e($options->lastItem()); ?></span>
                                        <?php echo __('of'); ?>

                                        <span class="font-medium"><?php echo e($options->total()); ?></span>
                                        <?php echo __('results'); ?>

                                    </p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <?php echo $__env->make('livewire.backend.option.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('livewire.backend.option.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </section>
</div>
<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#option_group_name').select2();
            $('#option_group_name').on('change', function(e) {
                var data = $('#option_group_name').select2("val");
                Livewire.emit('listenerReferenceHere',data);               
                window.livewire.find('<?php echo e($_instance->id); ?>').set('option_group_name', data);
            });
        });
        document.addEventListener('DOMContentLoaded', function() {

            window.livewire.find('<?php echo e($_instance->id); ?>').on('triggerDelete', deleteId => {
                Swal.fire({
                    title: 'Are You Sure?',
                    text: 'This record will be deleted!',
                    type: "warning",
                    showCancelButton: true,
                    // confirmButtonColor: 'var(--success)',
                    // cancelButtonColor: 'var(--primary)',
                    confirmButtonText: 'Delete!'
                }).then((result) => {
                    //if user clicks on delete
                    if (result.value) {
                        // calling destroy method to delete
                        window.livewire.find('<?php echo e($_instance->id); ?>').call('destroy', deleteId)
                        // success response
                        //responseAlert({title: session('message'), type: 'success'});

                    } else {
                        Swal.fire({
                            title: 'Operation Cancelled!',
                            type: 'success'
                        });
                    }
                });
            });
        })
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/html/edds/resources/views/livewire/backend/option/index.blade.php ENDPATH**/ ?>