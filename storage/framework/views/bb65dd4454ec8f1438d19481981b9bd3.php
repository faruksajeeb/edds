<!-- Modal -->
<?php $__currentLoopData = $user_responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="details-modal-<?php echo e($val->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-magnifying-glass"></i> User
                        Response Detail ( <?php echo e($val->id); ?>)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent='resetInput'></button>
                </div>
                <div class="modal-body">
                    <div wire:loading wire:target="user_responseDetail">
                        <div class="spinner-buser_response spinner-buser_response-sm text-light" role="status">
                            <span class="visually-hidden">Processing...</span>
                        </div>
                    </div>
                    <?php if(isset($val)): ?>
                        <fieldset class="reset">
                            <legend class="reset">User Information</legend>
                            <table class="table">
                                <tr>
                                    <td class="">
                                        Response Date
                                    </td>
                                    <td>: <?php echo e($val->response_date); ?></td>
                                    <td>Respondent Type</td>
                                    <td>:
                                        <?php echo e(isset($val->registered_user) ? $val->registered_user->respondent_type : ''); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>User Name</td>
                                    <td>: <?php echo e(isset($val->registered_user) ? $val->registered_user->full_name : ''); ?>

                                    </td>
                                    <td>Mobile</td>
                                    <td>: <?php echo e(isset($val->registered_user) ? $val->registered_user->mobile_no : ''); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>: <?php echo e(isset($val->registered_user) ? $val->registered_user->email : ''); ?></td>
                                    <td>Division</td>
                                    <td>: <?php echo e(isset($val->registered_user) ? $val->registered_user->division : ''); ?></td>
                                </tr>
                                <tr>
                                    <td>District</td>
                                    <td>: <?php echo e(isset($val->registered_user) ? $val->registered_user->district : ''); ?></td>
                                    <td>Thana</td>
                                    <td>: <?php echo e(isset($val->registered_user) ? $val->registered_user->thana : ''); ?></td>
                                </tr>
                                <tr>
                                    <td>Area</td>
                                    <td>: <?php echo e(isset($val->area) ? $val->area->value : ''); ?></td>
                                    <td>Market</td>
                                    <td>: <?php echo e(isset($val->market) ? $val->market->value : (($val->market_id==-100)?$val->market_other:'')); ?></td>
                                </tr>
                            </table>
                            <a href="https://www.google.com/maps/search/?api=1&query=<?php echo $val->location ?>" target="_blank">Response Location</a>

                        </fieldset>
                        <fieldset class="reset">
                            <legend class="reset">Response Details</legend>
                            <table class="table">
                                <thead>
                                    <tr>
                                        
                                        <th>Question</th>
                                        <th>Sub Questin</th>
                                        <th class="text-center">Response</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                            //print_r($val->user_responseDetails);
                            // $val->userResponseDetails->count();
                            $quesId = '';
                            foreach($val->userResponseDetails as $item):
                                    $file = $item->question_id.'_'.$item->sub_question_id.'.jpg';
                            ?>
                                    <tr>
                                        <td>
                                            
                                            <?php if($quesId != $item->question->id): ?>
                                                <?php echo e(isset($item->question) ? $item->question->value : ''); ?>

                                                <br/>
                                                <?php if(Storage::disk('external')->exists($file)): ?>
                                                    <a href="../edds_app/tmp_img/<?php echo e($item->question_id . '_' . $item->sub_question_id); ?>.jpg"
                                                        target="_blank">Uploaded Image</a>
                                                    
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(isset($item->subQuestion) ? $item->subQuestion->value : ''); ?></td>
                                        <td class="text-center"><?php echo e($item->response); ?></td>
                                    </tr>

                                    <?php
                                        $quesId = $item->question->id;
                                    ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </fieldset>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click.prevent='resetInput'><i class="fa fa-remove"></i> Close</button>

                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/user_response/detail.blade.php ENDPATH**/ ?>