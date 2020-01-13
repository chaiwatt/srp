<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">
    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('project/allocation/department')); ?>">รายการ งบประมาณที่ได้รับการจัดสรร</a></li>
        <li>จัดสรรงบประมาณจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                จัดสรรงบประมาณจ้างงาน ปีงบประมาณ : <?php echo e($project->year_budget); ?> 
            </div>
        </div>
    </div>

    <?php if( $search != "" ): ?>
        <div class="row">
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

                <?php echo Form::open([ 'url' => 'project/allocation/department/create' , 'method' => 'post' ]); ?> 
                <input type="hidden" name="id" value="<?php echo e($budget->budget_id); ?>">

                <?php if( $budget->budget_id == 1 ): ?>
                    <div class="smart-widget widget-dark-blue">

                        <div class="smart-widget-header"> <?php echo e($budget->budget_name); ?> ( งบประมาณคงเหลือ = <?php echo e(number_format($transaction->transaction_balance,2)); ?> ) </div>
                        <div class="smart-widget-body">
                            <div class="smart-widget-body  padding-md">
                                <?php if( count($section) > 0 ): ?>
                                <?php $__currentLoopData = $section; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php 
                                        $query = $allocation->where('section_id' , $value->section_id)->sum('allocation_price') ;
                                        $num =count($generate->where('section_id', $value->section_id));
                                        $allocate =  $num * $salary * 9;
                                     ?>                                                   
                                    <div class="form-group">
                                        <label><?php echo e($value->section_name); ?> (จ้างงาน <?php echo e($num); ?> คน, งบประมาณ <?php echo e($allocate); ?> บาท) </label><?php if($allocate == 0): ?> <label class="text-danger">!! ยังไม่ได้จัดสรรจำนวนจ้างงาน</label><?php endif; ?>
                                        <input type="number" name="number[<?php echo e($value->section_id); ?>]" class="form-control" step="0.01" autocomplete="off" value="<?php echo e($query); ?>" <?php if($allocate == 0): ?> readonly <?php endif; ?>>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
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
    <?php endif; ?>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>