<?php $__env->startPush('styles'); ?>
    <style>

    </style>
<?php $__env->stopPush(); ?>
<!-- Modal -->
<div wire:ignore.self class="modal fade" id="addModal" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form wire:submit.prevent="store">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Create Category
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"  style="overflow:hidden;">

                    <?php if(session()->has('message')): ?>
                        <div class="alert alert-danger"><?php echo e(session('message')); ?></div>
                    <?php endif; ?>
                    
                    
                    <div class="form-group row">
                        <label for="option-group" class="form-label">Category Name:</label>
                        <div class="col-12">
                            <input type="text" name="name" id="name" wire:model="name"
                                class="form-control form-control-lg name" placeholder="Enter Category Name">
                            <?php $__errorArgs = ['name'];
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
                    <div class="row my-1">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Category Image <span class="text-danger">*</span></label>
                                <input name="image" wire:model="image"
                                    class="form-control add-image image <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="file"
                                    required>
                                <?php if($image): ?>
                                    <img src="<?php echo e($image->temporaryUrl()); ?>" width="100" alt="product image" />
                                <?php endif; ?>
                                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback error_msg"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-md-12">
                            <label for="">Popular: <span class="text-danger">*</span></label>
                            <select name="is_popular" wire:model='is_popular' placeholder='Select a is_popular'
                                class="form-select   is_popular  <?php $__errorArgs = ['is_popular'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value=""> Select Popular </option>
                                <option value="1"> Yes</option>
                                <option value="0"> No</option>
                            </select>
                            <?php $__errorArgs = ['is_popular'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback error_msg"><?php echo e($message); ?></div>
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
            // $('#option_group').select2({
            //     placeholder: 'Select an option group',
            //     dropdownParent:$('#option_group').parent(),
            // });
            $('#option_group').on('change', function(e) {
                var data = $(this).val();
                Livewire.emit('listenerReferenceHere',data);               
                window.livewire.find('<?php echo e($_instance->id); ?>').set('option_group', data);
                // $('#option_group').select2();
            });
        });
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/livewire/backend/category/create.blade.php ENDPATH**/ ?>