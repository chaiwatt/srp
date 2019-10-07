<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('project/allocation/department')); ?>">รายการ งบประมาณที่ได้รับการจัดสรร</a></li>
        <li>ประวัติการรับโอนเงินงบประมาณ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                ประวัติการรับโอนเงินงบประมาณ ปีงบประมาณ : <?php echo e($project->year_budget); ?>

            </div>
        </div>
    </div>

    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> รายการรับโอนเงินงบประมาณ </div>
        <div class="smart-widget-body">
            <div class="smart-widget-body  padding-md">

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
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">วันที่แจ้งโอน</th>
                            <th class="text-center">หน่วยงาน</th>
                            <th class="text-center">รายการ</th>
                            <th class="text-center">จำนวนเงินรับโอน</th>
                    </thead>
                    <tbody>
                        <?php if( count($transfer) > 0 ): ?>
                        <?php $__currentLoopData = $transfer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->transferdateth); ?></td>
                                <td><?php echo e($item->departmentname); ?></td>
                                <td><?php echo e($item->budgetname); ?></td>
                                <td class="text-right"><?php echo e(number_format( $item->transfer_price , 2 )); ?></td>
                                <td></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>