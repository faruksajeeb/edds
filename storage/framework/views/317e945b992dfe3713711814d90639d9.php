<!-- Modal -->
<?php $__currentLoopData = $user_responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="details-modal-<?php echo e($val->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-magnifying-glass"></i> User
                    Response Detail
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent='resetInput'></button>
            </div>
            <div class="modal-body">
                <div wire:loading wire:target="user_responseDetail">
                    <div class="spinner-buser_response spinner-buser_response-sm text-light" role="status">
                        <span class="visually-hidden">Processing...</span>
                    </div>
                </div>
                <?php if(isset($val)): ?>
                <fieldset class="reset">
                    <legend class="reset">Respondent Information</legend>
                    <table class="table table-striped">
                        <tr>
                            <td>Entry Time</td>
                            <td colspan="3">: <?php echo e($val->created_at); ?></td>
                        </tr>
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
                            <td>Respondent Name</td>
                            <td>: <?php echo e(isset($val->registered_user) ? $val->registered_user->full_name : ''); ?>

                            </td>
                            <td>Respondent Mobile</td>
                            <td>: <?php echo e(isset($val->registered_user) ? $val->registered_user->mobile_no : ''); ?>

                            </td>
                        </tr>
                        <tr>
                            <td>Respondent Email</td>
                            <td>: <?php echo e(isset($val->registered_user) ? $val->registered_user->email : ''); ?></td>
                            <td>Division</td>
                            
                            <td>: <?php echo e($val->area_id == 0 ? $val->response_division : optional($val->area)->division); ?>

                            </td>
                        </tr>
                        <tr>
                            <td>District</td>
                            
                            <td colspan="">:
                                <?php echo e($val->area_id == 0 ? $val->response_district : optional($val->area)->district); ?>

                            </td>
                            <td>Upazilla/ Thana</td>
                            <td>: <?php echo e(optional($val->area)->thana); ?></td>
                        </tr>
                        <?php if($val->area_id == 0): ?>
                        <tr>
                            <td>Response Address:</td>
                            <td colspan="3">: <?php echo e($val->formatted_address); ?></td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <td>Area</td>
                            <td>: <?php echo e(optional($val->area)->value); ?></td>
                            <td>Market</td>
                            <td>:
                                <?php echo e(isset($val->market) ? $val->market->value : ($val->market_id == -100 ? $val->market_other : '')); ?>

                            </td>
                        </tr>
                        <?php endif; ?>

                        <tr>
                            <td colspan="2">
                                <?php
                                $responseLatLong = '';
                                if($val->area_id == 0){
                                $responseLatLong = $val->response_location;
                                }else{
                                $responseLatLong = optional($val->market)->latitude.",".optional($val->market)->longitude;
                                }
                                ?>
                                <a href="https://www.google.com/maps/search/?api=1&query=<?php echo e($responseLatLong); ?>" target="_blank" class="float-start"><i class="fa-solid fa-location-dot"></i>
                                    Response Location</a>
                            </td>
                            <td colspan="2"> <a href="https://www.google.com/maps/search/?api=1&query=<?php echo $val->location; ?>" target="_blank" class="float-end"><i class="fa-solid fa-user"></i> User
                                    Location</a></td>
                        </tr>
                    </table>



                </fieldset>
                <fieldset class="reset">
                    <legend class="reset">Response Details</legend>
                    <table class="table">
                        <thead>
                            <tr>
                                
                                <th>Question</th>
                                <!-- <th>Sub Questin</th> -->
                                <th class="text-center">Response</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //print_r($val->user_responseDetails);
                            // $val->userResponseDetails->count();
                            $quesId = '';
                            foreach ($val->userResponseDetails as $item) :
                                $file = $val->id . '_' . $item->question_id . '.jpg';
                            ?>
                                <tr>
                                    <td>
                                        
                                        <?php if($quesId != $item->question_id): ?>
                                        <?php echo e(isset($item->question) ? $item->question->question : ''); ?>

                               
                                        <?php endif; ?>
                                    </td>
                                    <!-- <td><?php echo e(isset($item->subQuestion) ? $item->subQuestion->value : ''); ?></td> -->
                                    <td class="text-center"><?php echo e($item->response); ?>


                                        <?php if($quesId != $item->question_id): ?>
                                        <?php if(Storage::disk('external')->exists($file)): ?>
                                        <!-- <span>Uploaded Image</span><br /> -->
                                        <!-- <a href="../edds_app/tmp_img/<?php echo e($val->id . '_' . $item->question_id); ?>.jpg" target="_blank" title="Uploaded Image" class="text-right float-right preview" > -->
                                            <img data-action="zoom" src="../edds_app/tmp_img/<?php echo e($val->id . '_' . $item->question_id); ?>.jpg" width="150" height="150" alt="Low-Resolution Image">
                                        <!-- </a> -->

                                        <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <?php
                                $quesId = $item->question_id;
                                ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </fieldset>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.verify')): ?>
                <?php if($val->status == 1): ?>
                <a href="" class="btn btn-success btn-verify-<?php echo e($val->id); ?>" onclick="event.preventDefault(); confirmVerify(<?php echo e($val->id); ?>)"><i class="fas fa-check"></i> Verify</a>
                <form id="verify-form-<?php echo e($val->id); ?>" style="display: none" action="<?php echo e(route('user_responses.verify', Crypt::encryptString($val->id))); ?>" method="POST">
                    <?php echo method_field('PUT'); ?>
                    <?php echo csrf_field(); ?>
                </form>
                <?php endif; ?>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent='resetInput'><i class="fa fa-remove"></i> Close</button>

            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH D:\laragon\www\laravel\edds\resources\views/user_response/detail.blade.php ENDPATH**/ ?>