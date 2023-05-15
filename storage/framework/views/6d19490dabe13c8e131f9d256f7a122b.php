<?php $__env->startPush('styles'); ?>
    <style>

    </style>
<?php $__env->stopPush(); ?>
<!-- Modal -->
<div wire:ignore.self class="modal fade" id="addModal" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form wire:submit.prevent="store" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Create Subcategory
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"  style="overflow:hidden;">

                    <?php if(session()->has('message')): ?>
                        <div class="alert alert-danger"><?php echo e(session('message')); ?></div>
                    <?php endif; ?>
                    
                    <div class="form-group row">
                        <label for="" class="form-label">Category:</label>
                        <div class="col-12">                  
                                <select name="category_id" wire:model='category_id'
                                    class="form-select category_id">
                                    <option value="">--Category Name--</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($val->id); ?>"><?php echo e($val->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                           
                            <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="option-group" class="form-label">Sub Category Name:</label>
                        <div class="col-12">
                            <input type="text" name="sub_category_name" id="sub_category_name" wire:model="sub_category_name"
                                class="form-control form-control-lg name" placeholder="Enter Subcategory Name">
                            <?php $__errorArgs = ['sub_category_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click="resetInputFields()"><i class="fa fa-remove"></i> Close</button>


                    <button type="button" class="btn btn-warning" wire:click="resetInputFields()"><i
                            class="fa fa-refresh"></i> Reset</button>
                    <button type="submit" class="btn btn-primary" <?php echo e($flag == 1 ? 'disabled' : ''); ?>><i
                            class="fa fa-save"></i> Save New</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
    <script>
         $(document).ready(function() {
          //  $("#option_group").select2({ dropdownParent: "#addModal" });
          $('#addModal').on('shown.bs.modal', function (e) {
            // $('.category_id').select2({
            // placeholder: 'Select a category',
            // dropdownParent:$('.category_id').parent(),
            // });
            $('.category_id').on('change', function(e) {
                var data = $(this).val();
                Livewire.emit('listenerReferenceHere',data);               
                window.livewire.find('<?php echo e($_instance->id); ?>').set('category_id', data);
                // $('#option_group').select2();
            });
        });
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/livewire/backend/sub_category/create.blade.php ENDPATH**/ ?>