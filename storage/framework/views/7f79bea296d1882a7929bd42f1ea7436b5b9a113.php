<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>โครงการฝึกอบรมวิชาชีพ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                โครงการฝึกอบรมวิชาชีพ ปีงบประมาณ : <?php echo e($project->year_budget); ?>

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
                <div class="smart-widget-header"> รายการฝึกอบรมวิชาชีพ</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >สังกัดกรม</th>
                                    <th >ชื่อโครงการ</th>
                                    <th class="text-center">วันที่</th>
                                    <th class="text-center">กรอบเป้าหมายผู้เข้าร่วม</th>
                                    <th class="text-center">งบประมาณ</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $totaltargetparticipate=0;
                                    $totalbudget =0 ;
                                 ?>
                                <?php if( count($readiness) > 0 ): ?>
                                    <?php $__currentLoopData = $readiness; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($item->project_status == 1): ?>
                                        <?php 
                                          $totaltargetparticipate +=  $item->targetparticipate;
                                          $totalbudget +=  $item->budget;
                                         ?>
                                            <tr>
                                                <td><?php echo e($item->departmentname); ?></td>
                                                <td><?php echo e($item->project_readiness_name); ?></td>
                                                <td class="text-center"><?php echo e($item->adddate); ?></td>
                                                <td class="text-center"><?php echo e($item->targetparticipate); ?></td>
                                                <td class="text-center"><?php echo e($item->budget); ?></td>
                                                <td class="text-right">
                                                    <a href="<?php echo e(url('occupation/project/main/edit/'.$item->project_readiness_id)); ?>" class="btn btn-info btn-xs">แก้ไขการจัดสรร</a>
                                                </td>
                                            </tr> 
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="3"><strong>สรุปรายการ</strong> </td>
                                    <td class="text-center"><strong><?php echo e($totaltargetparticipate); ?></strong></td>
                                    <td class="text-center"><strong><?php echo e(number_format(  $totalbudget, 2 )); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>

                        <ul class="pagination pagination-split pull-right">
                        </ul>

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