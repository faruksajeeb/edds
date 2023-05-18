<style>
    .title {
        style="background-color: #CCC";
    }

    table {
        border-collapse: collapse;
        font-size: 10px;
    }

    table tbody td,
    th {
        border: 1px solid #000000;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<?php if($report_format == 'pdf'): ?>
    <div id="header" style="text-align:center">
        <img style="width:200px" src="<?php echo e(public_path('/logo.png')); ?>" alt="Logo" />
        <h4 id="title" style="padding:5px;background-color:#e88923;color:#FFFFFF">Survey Report</h4>
    </div>
<?php endif; ?>

<table class="table table-bordered" width="100%">
    <thead>
        <?php if($report_format == 'export'): ?>
            <tr style="">
                <td style="height:70px;text-align:center; padding-top:10px" colspan="8">

                </td>
            </tr>
            <tr>
                <td colspan="8" style="text-align:center;padding:10px; font-weight:bold;">
                    <h1>Survey Report</h1>
                </td>
            </tr>
        <?php endif; ?>


    </thead>
    <tbody>

        <tr style="font-weight:bold;text-align:left">
            <td colspan="2">
                Division: <?php echo e($division); ?>

            </td>
            <td colspan="2">
                District: <?php echo e($district); ?>

            </td>
            <td colspan="2">
                Thana: <?php echo e($thana); ?>

            </td>
            <td colspan="2" style="text-align:right!important">
                Date From: <?php echo e($date_from); ?> Date To: <?php echo e($date_to); ?>

            </td>
        </tr>
        <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr style="">
                <td colspan="8" style="padding:15px;background-color: #C0C0C0;"><b>Category:
                        <?php echo e($category['category_name'] != '' ? $category['category_name'] : 'Not Assigned'); ?></b>
                </td>
            </tr>


            <?php $__currentLoopData = $category['category_records']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr style="">
                    <td colspan="8" style="padding:15px;background-color: #C0C0C0;"><b>Question:
                            <?php echo e($question['question'] != '' ? $question['question'] : 'Not Assigned'); ?></b>
                    </td>
                </tr>
                <tr style="font-weight:bold">
                    <td>#</td>
                    <td>Response ID</td>
                    <td>Response Date</td>
                    <td>Response By</td>
                    <td>Mobile No</td>
                    <td>Area</td>
                    <td>Market</td>
                    
                    
                    
                    <td>
                        <?php
                            $subQuestions = \App\Models\SubQuestion::where('question_id', $question['question_id'])
                                ->where('status', 1)
                                ->get();
                        ?>

                        
                        Response
                    </td>

                </tr>
                <?php $__currentLoopData = $question['records']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($k + 1); ?></td>
                        <td><?php echo e($val->id); ?></td>
                        <td><?php echo e($val->response_date); ?></td>
                        <td><?php echo e($val->full_name); ?></td>
                        <td><?php echo e($val->mobile_no); ?></td>
                        <td><?php echo e($val->area_name); ?></td>
                        <td><?php echo e($val->market_name); ?></td>
                        
                        
                        <td style="text-align:left">
                            

                            <?php
                                $ResValue = '';
                            ?>
                            <?php $__currentLoopData = $subQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $Subval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $data = \App\Models\UserResponseDetail::select('sub_questions.value', 'user_response_details.response')
                                        ->leftJoin('user_responses', 'user_responses.id', '=', 'user_response_details.response_id')
                                        ->leftJoin('sub_questions', 'sub_questions.id', '=', 'user_response_details.sub_question_id')
                                        ->where('user_response_details.question_id', $val->question_id)
                                        ->where('user_response_details.sub_question_id', $Subval->id)
                                        ->where('user_responses.id', $val->id)
                                        ->first();
                                    // $response = $data->response;
                                    if ($data) {
                                        // echo gettype((int) $data->response);
                                        if (is_numeric($data->response)) {
                                            $ResValue .= isset($data->response) ? $data->value . ': ' . $data->response . ', ' : '';
                                        } else {
                                            $ResValue .= isset($data->response) ? $data->response . ', ' : '';
                                        }
                                    }
                                    
                                ?>
                                
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($ResValue); ?>


                            
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/report/question_wise_survey_report_export.blade.php ENDPATH**/ ?>