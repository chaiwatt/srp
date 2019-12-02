<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('recurit/survey')); ?>">รายการสำรวจการจ้างงาน</a></li>
        <li>รายละเอียดรายการสำรวจการจ้างงาน</li>    
    </ul>

    <div class="row ">
        <div class="col-sm-9">
            <div class="page-title">
                รายละเอียดรายการสำรวจการจ้างงาน ปีงบประมาณ : <?php echo e($project->year_budget); ?>

            </div>
        </div>
        <div class="col-sm-3">
            <div class="pull-right">
                <a href="<?php echo e(url('recurit/report/department/survey/pdf')); ?>" class="btn btn-success btn-sm"><i class="fa fa-save"></i> ไฟล์ PDF</a>
                
            </div>
        </div>
    </div>

    <div class="row ">

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
                                    <th>หน่วยงาน</th>
                                    <th>บันทึกเพิ่มเติม</th>
                                    <?php if( count($position) > 0 ): ?>
                                    <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th class="text-center"><?php echo e($item->position_name); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <th class="text-center">รวม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if( count($numsection) > 0 ): ?>
                                <?php $__currentLoopData = $numsection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                    $surveyname = $projectsurvey->where('project_survey_id',$item->project_survey_id)->first()->project_survey_name;
                                    $note = $projectsurvey->where('project_survey_id',$item->project_survey_id)->first()->note;
                                    $numproject = $numsection->where('project_survey_id',$item->project_survey_id)->count();
                                 ?>
                                    <tr>
                                        <td ><?php echo e($surveyname); ?></td>
                                        <td><?php echo e($item->sectionname); ?></td>
                                        <td><?php echo e($note); ?></td>
                                        <?php if( count($position) > 0 ): ?>
                                        <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php ( $value = $surveylist->where('position_id' , $value->position_id)->where('section_id' , $item->section_id)->sum('survey_amount') ); ?>
                                            <td class="text-center"><?php echo e($value); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <td class="text-center"><?php echo e($surveylist->where('section_id' , $item->section_id)->sum('survey_amount')); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                           
                            <tfoot>
                                <?php if( count($numsection) > 0 ): ?>
                                    <tr>
                                        <td class="text-center" colspan="3"><strong>สรุปรายการ</strong> </td>
                                        <?php if( count($position) > 0 ): ?>
                                        <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php ( $value = $surveylist->where('position_id' , $value->position_id)->sum('survey_amount') ); ?>
                                            <td class="text-center"><strong><?php echo e($value); ?></strong> </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <td class="text-center"><strong><?php echo e($surveylist->sum('survey_amount')); ?></strong> </td>
                                    </tr>
                                <?php endif; ?>
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