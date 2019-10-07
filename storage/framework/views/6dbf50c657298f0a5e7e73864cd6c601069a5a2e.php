<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('transfer/list')); ?>">รายการ โอนงบประมาณ</a></li>
        <li>โอนงบประมาณ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                โอนงบประมาณ ปีงบประมาณ : <?php echo e($project->year_budget); ?>

            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
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

        <?php echo Form::open([ 'url' => 'transfer/create' , 'method' => 'post' ]); ?> 
        <input type="hidden" name="id" value="<?php echo e($project->project_id); ?>">
        <?php if( count($budget) > 0 ): ?>
        <?php $__currentLoopData = $budget; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php ( $allocationprice = $allocation->where('budget_id' , $item->budget_id)->sum('allocation_price') ); ?>
            <?php if( $allocationprice != 0 ): ?>

                <div class="smart-widget widget-dark-blue">
                    <div class="smart-widget-header"> <?php echo e($item->budget_name); ?> </div>
                    <div class="smart-widget-body">
                        <div class="smart-widget-body  padding-md">
                            <?php if( count($department) > 0 ): ?>
                            <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php (
                                    $deptallocat = $allocation->where('budget_id' , $item->budget_id)
                                    ->where('department_id' , $value->department_id)
                                    ->sum('allocation_price')
                                ); ?>
                                <?php ( 
                                    $trans = $transaction->where('budget_id' , $item->budget_id)
                                            ->where('department_id' , $value->department_id)
                                            ->sortBy('transfer_transaction_id')
                                            ->last()
                                ); ?>
                                
                                <?php if( count(  $trans  ) > 0 ): ?>
                                <?php 
                                     $number = $trans->transaction_balance 
                                 ?>
                                <?php else: ?>
                                    <?php if( $allocationprice != 0): ?>
                                        <?php ($number = $deptallocat ); ?>
                                    <?php else: ?>
                                        <?php ( $number = 0 ); ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if( $allocationprice != 0 && $number != 0 ): ?>
    	                            <div class="form-group">
                                        <?php if($item->budget_id == 6 ): ?>
                                                <label><?php echo e($value->department_name); ?>  ( คงเหลือ <?php echo e(number_format( $number  , 2)); ?> ) </label><?php if($maxremain == 0): ?> <span class="text-danger">หมายเหตุ: ไม่สามารถโอนเงินได้ เนื่องจากยังไม่ได้กำหนดกรอบจ้างเหมา</span> <?php else: ?> <span class="text-danger">หมายเหตุ: ไม่สามารถกรอกเงิน เกิน <?php echo e($maxremain); ?> บาท</span>  <?php endif; ?> 
                                                <input type="number" min="0" <?php if($maxremain != 0): ?> max="<?php echo e($maxremain); ?>" <?php endif; ?> name="number[<?php echo e($item->budget_id); ?>][<?php echo e($value->department_id); ?>]" class="form-control" autocomplete="off" <?php if($maxremain == 0): ?> readonly <?php endif; ?>>
                                            <?php else: ?>
                                                <label><?php echo e($value->department_name); ?>  ( คงเหลือ <?php echo e(number_format( $number  , 2)); ?> ) </label>
                                                <input type="number" min="0" name="number[<?php echo e($item->budget_id); ?>][<?php echo e($value->department_id); ?>]" class="form-control" autocomplete="off">
                                        <?php endif; ?>
    	                               
    	                            </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

            <div class="row">
                <div class="col-sm-12">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                    </div>
                </div>
            </div>

        <?php echo Form::close(); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>