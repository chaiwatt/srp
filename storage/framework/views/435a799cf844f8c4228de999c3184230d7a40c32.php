<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('recurit/survey/section')); ?>">รายการสำรวจการจ้างงาน</a></li>
        <li>สำรวจความต้องการ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                สำรวจความต้องการ 
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

        <?php echo Form::open([ 'url' => 'recurit/survey/section/create' , 'method' => 'post' ]); ?>

        <input type="hidden" name="id" value="<?php echo e($projectsurvey->project_survey_id); ?>">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการสำรวจ ( <?php echo e($projectsurvey->project_survey_name); ?> ) </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width:40%">ตำแหน่ง</th>
                                    <th style="width:60%">จำนวน</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if( count($position) > 0 ): ?>                               
                                 <?php 
                                       $total = 0;
                                  ?>
                                <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                    $num =0;
                                   
                                    $_survey = $survey->where('position_id',$item->position_id)->first();
                                    if (!empty($_survey) ){
                                     $num =  $_survey->survey_amount;
                                     $total =  $total + $num ;
                                    }
                                 ?>
                                <tr>
                                    <td><?php echo e($item->position_name); ?></td>
                                    <td>
                                        <input type="number" min="0" step="1" value="<?php echo e($num); ?>" name="number[<?php echo e($item->position_id); ?>]" class="form-control" />
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                               
                                    <td><label>บันทึกเพิ่มเติม</label> </td>
                                    <td>                                                              
                                        <textarea class="form-control" rows="3" name="note"><?php if(!empty($surveyhost)): ?><?php echo e($surveyhost->surveyhost_detail); ?> <?php endif; ?></textarea>                                        
                                    </td>
                                <?php endif; ?>
                            </tbody>
                            <?php if(count($_survey) > 0): ?>
                            <tfoot>
                                <tr>
                                    <td class="text-center" colspan="1"><strong>สรุปรายการ</strong></td>
                                    <td><strong><?php echo e($total); ?></strong> </td>
                                </tr>
                            </tfoot>
                            <?php endif; ?>
                        </table>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo Form::close(); ?>

    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">
    
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>