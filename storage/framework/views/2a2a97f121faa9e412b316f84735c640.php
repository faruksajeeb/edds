<!-- Modal -->
<div wire:ignore.self class="modal fade" id="editModal" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form wire:submit.prevent="update" class="needs-validation" method="POST" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Edit Category
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <?php if(session()->has('message')): ?>
                        <div class="alert alert-danger"><?php echo e(session('message')); ?></div>
                    <?php endif; ?>
            
                    
                    <div class="form-group row">
                        <label for="option-group" class="form-label">Category Name:</label>
                        <div class="col-12">
                            <input type="text" name="name" wire:model="name"
                                class="form-control form-control-lg option_group_name" placeholder="Enter Category Name">
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
                                <label>Category Image <span class="text-danger"></span></label>
                                <input name="new_image" id="new_image" wire:model="new_image"
                                    class="form-control new_image <?php $__errorArgs = ['new_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="file"
                                    >
                                <?php if($new_image): ?>
                                    <img src="<?php echo e($new_image->temporaryUrl()); ?>" width="100" alt="product image" />
                                <?php else: ?> 
                                    <img src="<?php echo e(asset('frontend-assets/imgs/categories')); ?>/<?php echo e($old_image); ?>" width="80" height="80" alt="<?php echo e($name); ?>">
                                <?php endif; ?>
                                
                                <?php $__errorArgs = ['new_image'];
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
                            class="fa fa-save"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
    <script>
$(document).ready(function() {
          $('#editModal').on('shown.bs.modal', function (e) {
            
        });
});
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/html/edds/resources/views/livewire/backend/category/edit.blade.php ENDPATH**/ ?>