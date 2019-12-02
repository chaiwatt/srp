<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>รายการงบประมาณที่ได้รับการจัดสรร</li>    
    </ul>

    <div class="row">
        <div class="col-sm-7">
            <div class="page-title">
                งบประมาณที่ได้รับการจัดสรร ปีงบประมาณ : <?php echo e($project->year_budget); ?>

            </div>
        </div>
        <div class="col-sm-5">
            <div class="pull-right">
                  <a href="<?php echo e(url('project/allocation/department/create')); ?>" class="btn btn-success">จัดสรรงบประมาณจ้างงาน</a>
            </div>
        </div>
    </div>

    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> รายการงบประมาณที่ได้รับการจัดสรร </div>
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
                            <th>รายการค่าใช้จ่าย</th>
                            <th class="text-center">งบประมาณจัดสรร</th>
                            <th class="text-center">รับโอนแล้ว</th>
                            <th class="text-center">ยังไม่ได้รับโอน</th>
                            <th class="text-center">จำนวนครั้งที่รับโอน</th>
                            
                            <th class="text-center">ประวัติรับโอน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $totalallocation_price=0;
                            $totaltransferallocation=0;
                            $totalpendingtraansfer=0;
                            $totaltransfercount=0;
                         ?>
                        <?php if( count($allocation) > 0 ): ?>
                        <?php $__currentLoopData = $allocation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                            $totalallocation_price += $item->allocation_price;
                            $totaltransferallocation += $item->transferallocation ;
                            $totaltransfercount += $item->transfercount;
                         ?>
                            <tr>
                                <td><?php echo e($item->budgetname); ?></td>
                                <td class="text-center"><?php echo e(number_format( $item->allocation_price , 2 )); ?></td>
                                <td class="text-center"><?php echo e(number_format( $item->transferallocation , 2 )); ?></td>                               
                                <td class="text-center"><?php echo e(number_format( $item->allocation_price - $item->transferallocation , 2)); ?></td>
                                
                                <td class="text-center"><?php echo e($item->transfercount); ?></td>
                                
                                <td class="text-right">
                                    <a href="<?php echo e(url('project/allocation/department/view/'.$item->budget_id )); ?>" class="btn btn-info"><i class="fa fa-eye"></i> รายการรับโอน</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-center" ><strong>สรุปรายการ</strong> </td>
                            <td class="text-center"><strong><?php echo e(number_format($totalallocation_price,2)); ?></strong></td>                                        
                            <td class="text-center"><strong><?php echo e(number_format($totaltransferallocation,2)); ?></strong></td>                                        
                            <td class="text-center"><strong><?php echo e(number_format($totalallocation_price-$totaltransferallocation,2)); ?></strong></td>                                        
                            <td class="text-center"><strong><?php echo e($totaltransfercount); ?></strong></td>                                        
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>