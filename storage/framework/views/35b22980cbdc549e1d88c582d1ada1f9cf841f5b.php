<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>รายการประเมินผล</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการประเมินผล ปีงบประมาณ : <?php echo e($project->year_budget); ?>

            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="<?php echo e(url('assesment/section/create')); ?>" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มรายการประเมิน</a>
            </div>
        </div>
    </div>
</div>
    <div class="padding-md">
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
                <div class="smart-widget-header"> รายการประเมิน </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >ชื่อรายการประเมิน</th>
                                    <th class="text-center">วันที่ประเมิน</th>
                                    <th class="text-center">จำนวนผู้ประเมิน</th>
                                    <th class="text-center">ผู้ประเมิน</th>
                                    <th class="text-center">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $totalassessment =0;
                                 ?>
                                <?php if( count($assesment) > 0 ): ?>
                                <?php $__currentLoopData = $assesment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                    $count = $personalassesment->where('project_assesment_id',$item->project_assesment_id )->count();
                                    $totalassessment += $count;
                                 ?>
                                    <tr>
                                        <td><?php echo e($item->assesment_name); ?></td>
                                        <td class="text-center"><?php echo e($item->assigndate); ?></td>
                                        <td class="text-center"><?php echo e($count); ?></td>
                                        <td class="text-center"><?php echo e($item->assesor); ?></td>
                                        <td class="text-right">
                                            <a href="<?php echo e(url('assesment/section/assessmentedit/'.$item->project_assesment_id)); ?>" class="btn btn-info btn-xs">ประเมิน</a>
                                            <a href="<?php echo e(url('assesment/section/followupedit/'.$item->project_assesment_id)); ?>" class="btn btn-warning btn-xs">ติดตาม</a>
                                            <a href="<?php echo e(url('assesment/section/view/'.$item->project_assesment_id)); ?>" class="btn btn-success btn-xs">รายละเอียด</a>
                                            <a href="<?php echo e(url('assesment/section/delete/'.$item->project_assesment_id)); ?>" class="btn btn-danger btn-xs">ลบ</a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>                                        
                                    <td class="text-center"><strong><?php echo e($totalassessment); ?></strong> </td>                                             
                                    
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