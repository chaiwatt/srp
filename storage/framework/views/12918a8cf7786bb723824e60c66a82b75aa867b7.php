<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>รายการ โอนงบประมาณ</li>    
    </ul>

    <div class="row padding-md">
        <div class="col-sm-9">
            <div class="page-title">
                รายการโอนงบประมาณ ปีงบประมาณ : <?php echo e($project->year_budget); ?>

            </div>
        </div>
        <div class="col-sm-3">
            <div class="pull-right">
                <a href="<?php echo e(url('transfer/create/')); ?>" class="btn btn-success"><i class="fa fa-plus"></i> โอนงบประมาณ</a>
            </div>
        </div>
    </div>


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


    <?php $__currentLoopData = $budgetlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> รายการโอนงบประมาณ <?php echo e($val->budget_name); ?></div>
        <div class="smart-widget-body">
            <div class="smart-widget-body  padding-md">
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>หน่วยงาน</th>
                            <th class="text-center">งบประมาณจัดสรร</th>
                            <th class="text-center">งวดงานที่รับโอน</th>
                            <th class="text-center">จำนวนเงินโอน</th>
                            <th class="text-center">คงเหลือ</th>
                            <th class="text-center">ร้อยละรับโอน</th>
                            <th class="text-right">เพิ่มเติม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $totalallocation =0;
                            $totalnumtransfer =0;
                            $totalsumtransfer =0;
                         ?>

                        <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                            $_allocation = $allocation->where('department_id',$item->department_id)
                            ->where('budget_id',$val->budget_id)->where('allocation_price','!=',0)->first();

                            $_transfercount = $transfer->where('department_id',$item->department_id)
                            ->where('budget_id',$val->budget_id)->count();

                            $_sumtransfer = $transfer->where('department_id',$item->department_id)
                            ->where('budget_id',$val->budget_id)->sum('transfer_price');

                            $_transfer_id = $transfer->where('department_id',$item->department_id)
                            ->where('budget_id',$val->budget_id)->first();
                            
                         ?>
                            <?php if(count($_allocation) != 0 && $_transfercount !=0 ): ?>
                                <?php 
                                    $totalallocation += $_allocation->allocation_price;
                                    $totalnumtransfer += $_transfercount;
                                    $totalsumtransfer += $_sumtransfer;
                                 ?>
                                <tr>
                                    <td><?php echo e($item->department_name); ?></td>
                                    <td class="text-center"><?php echo e(number_format( $_allocation->allocation_price, 2 )); ?></td>
                                    <td class="text-center"><?php echo e($_transfercount); ?></td>
                                    <td class="text-center"><?php echo e(number_format( $_sumtransfer , 2 )); ?></td>
                                    <td class="text-center"><?php echo e(number_format( ($_allocation->allocation_price - $_sumtransfer) , 2 )); ?></td>
                                    <td class="text-center"><?php echo e(number_format( ($_sumtransfer/$_allocation->allocation_price )*100, 2)); ?></td>
                                    <td class="text-right">
                                        <a href="<?php echo e(url('transfer/view/'.$_transfer_id->transfer_id)); ?>" class="btn btn-info btn-xs"> เพิ่มเติม</a>
                                    </td> 
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right" ><strong>สรุปรายการ</strong> </td>
                            <td class="text-center"><strong><?php echo e(number_format( $totalallocation, 2 )); ?></strong></td>
                            <td class="text-center"><strong><?php echo e($totalnumtransfer); ?></strong></td>
                            <td class="text-center"><strong><?php echo e(number_format($totalsumtransfer , 2 )); ?></strong></td>
                            <td class="text-center"><strong><?php echo e(number_format( ($totalallocation - $totalsumtransfer) , 2 )); ?></strong></td>
                            <td class="text-center"><strong><?php echo e(number_format( ($totalsumtransfer/$totalallocation)*100, 2)); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>