<!-- Modal -->
<?php $__currentLoopData = $user_responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="details-modal-<?php echo e($val->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-magnifying-glass-plus"></i> User Response Detail
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  wire:click.prevent='resetInput'></button>
                </div>
                <div class="modal-body">
                    <div wire:loading wire:target="user_responseDetail">
                        <div class="spinner-buser_response spinner-buser_response-sm text-light" role="status">
                            <span class="visually-hidden">Processing...</span>
                        </div>
                    </div>
                    <?php if(isset($val)): ?>
                   <table class="table">
                        <tr>
                            <td >Response ID #</td>
                            <td >: <?php echo e($val->id); ?></td>
                            <td  class="">
                                
                                   Response At
                               
                            </td>
                            <td>: <?php echo e($val->created_at); ?></td>
                        </tr>
                        <tr>
                            <td>User Name</td>
                            <td>: <?php echo e(isset($val->registered_user)?$val->registered_user->full_name:''); ?></td>
                            <td>Mobile</td>
                            <td>: <?php echo e(isset($val->registered_user)?$val->registered_user->mobile_no:''); ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>: <?php echo e(isset($val->registered_user)?$val->registered_user->email:''); ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                   </table>
                    <table class="table">
                        <thead>
                            <tr>
                                
                                <th>Question</th>
                                <th>Sub Questin</th>
                                <th>Response</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //print_r($val->user_responseDetails);
                            foreach($val->userResponseDetails as $item):
                            ?>
                            <tr>
                                <td><?php echo e(isset($item->question)?$item->question->value:''); ?></td>
                                <td><?php echo e(isset($item->subQuestion)?$item->subQuestion->value:''); ?></td>
                                <td><?php echo e($item->response); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>                         
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent='resetInput'><i class="fa fa-remove"></i> Close</button>

                </div>
        </div>
    </div>   
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/user_response/detail.blade.php ENDPATH**/ ?>