<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>รายการสำรวจการจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการสำรวจการจ้างงาน ปีงบประมาณ : <?php echo e($project->year_budget); ?>

            </div>
        </div>
    </div>

    <div class="row">
        <?php if( Session::has('success') ): ?>
            <div class="alert alert-success alert-custom alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <i class="fa fa-check-circle m-right-xs"></i> <?php echo e(Session::get('success')); ?>

            </div>
        <?php elseif( Session::has('error') ): ?>
            <div class="alert alert-danger alert-custom alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                 <i class="fa fa-times-circle m-right-xs"></i> <?php echo e(Session::get('error')); ?>

            </div>
        <?php endif; ?>
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการสำรวจการจ้างงาน </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>รายการสำรวจ</th>
                                    <th>เริ่มสำรวจ</th>
                                    <th>สิ้นสุดสำรวจ</th>
                                    <th class="text-right">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if( count($projectsurvey) > 0 ): ?>
                                <?php $__currentLoopData = $projectsurvey; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item->project_survey_name); ?></td>
                                        <td><?php echo e($item->surveydatestartth); ?></td>
                                        <td><?php echo e($item->surveydateendth); ?></td>
                                        <td class="text-right">
                                            <?php if( $item->project_survey_datestart <= date('Y-m-d') && $item->project_survey_dateend >= date('Y-m-d') ): ?>
                                                <a href="<?php echo e(url('recurit/survey/section/create/'.$item->project_survey_id)); ?>" class="btn btn-info">แก้ไขรายการ</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการสำรวจการจ้างงานรวม </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >รายการสำรวจ</th>
                                    <th class="text-center">ยอดรวม</th>
                                    <?php if( count($position) > 0 ): ?>
                                    <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th class="text-center"><?php echo e($item->position_name); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $totalsurveysectionsumamount =0;
                                 ?>
                                <?php if( count($surveysum) > 0 ): ?>
                                <?php $__currentLoopData = $surveysum; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                     $totalsurveysectionsumamount  += $item->surveysectionsumamount;
                                 ?>
                                    <tr>
                                        <td><?php echo e($item->project_survey_name); ?></td>
                                        <td class="text-center"><?php echo e($item->surveysectionsumamount); ?></td>
                                        <?php if( count($position) > 0 ): ?>
                                        <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php (   $query = $survey->where('position_id' , $value->position_id)
                                                    ->sum('survey_amount') 
                                                ); ?>
                                            <td class="text-center"> <?php echo e($query); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right"  ><strong>สรุปรายการ</strong> </td>
                                    <td class="text-center"><strong><?php echo e($totalsurveysectionsumamount); ?></strong></td>                                       
                                    <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php (   $query = $survey->where('project_survey_id' , $item->project_survey_id)
                                                ->where('position_id' , $value->position_id)
                                                ->sum('survey_amount') 
                                            ); ?>
                                        <td class="text-center"><strong><?php echo e($query); ?></strong> </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">
    
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>