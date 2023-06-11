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
        <img style="width:200px" src="<?php echo e(asset('/uploads/'.$theme_settings->website_logo)); ?>" alt="Logo" />
        <h4 id="title" style="padding:5px;background-color:#F5DEB3;color:#000000">Survey Report</h4>
    </div>
<?php endif; ?>

<table class="table table-bordered" width="100%">
    <thead>
        <?php if($report_format == 'export'): ?>
            <tr style="">
                <td style="height:70px;text-align:center; padding-top:10px" colspan="7">

                </td>
            </tr>
            <tr>
                <td colspan="7" style="text-align:center;padding:10px; font-weight:bold;background-color:#F5DEB3;color:#000000">
                    <h1>Survey Report</h1>
                </td>
            </tr>
        <?php endif; ?>
       
        
    </thead>
    <tbody>

        <tr style="font-weight:bold;text-align:left">
            <td>
                Division: <?php echo e($division); ?>

            </td>
            <td colspan="2">
                District: <?php echo e($district); ?>

            </td>
            <td colspan="2">
                Thana: <?php echo e($thana); ?>

            </td>
            <td colspan="2" style="text-align:right!important">
                Date From: <?php echo e($date_from); ?>  Date To: <?php echo e($date_to); ?>

            </td>
        </tr>
        <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr style="">
                <td colspan="7" style="padding:15px;background-color: #F5DEB3;"><b># Category:
                        <?php echo e($category['category_name'] != '' ? $category['category_name'] : 'Not Assigned'); ?></b>
                </td>
            </tr>


            <?php $__currentLoopData = $category['category_records']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr style="">
                    <td colspan="7" style="padding:15px;background-color: #F5DEB3;"><b>## Question:
                            <?php echo e($question['question'] != '' ? $question['question'] : 'Not Assigned'); ?></b>
                    </td>
                </tr>
                <?php $__currentLoopData = $question['sub_records']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $sub_question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr style="">
                        <td colspan="7" style="padding:15px;background-color: #F5DEB3;"><b>### Sub Question:
                                <?php echo e($sub_question['sub_question'] != '' ? $sub_question['sub_question'] : 'Not Assigned'); ?></b>
                        </td>
                    </tr>
                    <tr style="font-weight:bold">
                        <td>#</td>
                        <td>Response Date</td>
                        <td>Response By</td>
                        <td>Mobile No</td>
                        <td>Area</td>
                        <td>Market</td>
                        
                        
                        <td style="text-align:center">Response</td>
                    </tr>
                    <?php
                        $subQuestionTotal = 0;
                    ?>
                    <?php $__currentLoopData = $sub_question['records']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($k + 1); ?></td>
                            <td><?php echo e($val->response_date); ?></td>
                            <td><?php echo e($val->full_name); ?></td>
                            <td><?php echo e($val->mobile_no); ?></td>
                            <td><?php echo e($val->area_name); ?></td>
                            <td><?php echo e($val->market_name); ?></td>
                            
                            
                            <td style="text-align:center"><?php echo e($val->response); ?></td>
                        </tr>
                        <?php                            
                            if(is_numeric($val->response)){
                                $subQuestionTotal += $val->response;
                            }else{
                                $subQuestionTotal ++;
                            }
                        ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr style="font-weight:bold">
                        <td colspan="6">Total (<?php echo e($sub_question['sub_question']); ?> )</td>
                        <td style="text-align:center"><?php echo e($subQuestionTotal); ?></td>
                    </tr>
                    <tr>
                        <td colspan="7"></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/report/survey_report_export.blade.php ENDPATH**/ ?>