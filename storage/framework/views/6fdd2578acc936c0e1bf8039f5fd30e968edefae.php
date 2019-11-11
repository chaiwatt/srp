<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('project/allocation')); ?>">รายการโครงการ</a></li>    
        <li>กำหนดงบประมาณ</li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการงบประมาณ ปีงบประมาณ : <?php echo e($project->year_budget); ?>

            </div>
        </div>
    </div>
</div>

<div class="row padding-md">

    

    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> งบประมาณ ( <?php echo e(number_format( $project->totalbudget , 2)); ?> บาท ) </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">
                <?php echo Form::open([ 'method' => 'post' , 'url' => 'project/allocation/locate' ]); ?> 

                    <input type="hidden" name="id" value="<?php echo e($project->project_id); ?>" />

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
                    
                    <?php if( count($budget) > 0 ): ?>
                    <?php $__currentLoopData = $budget; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php ( $allocate =  $budgetlist->where('budget_id' , $item->budget_id)->first() ); ?>
                        <?php if( count($allocate) > 0 ): ?>
                            <?php ( $number = $allocate->allocate ); ?>
                        <?php else: ?>
                            <?php ( $number = "" ); ?>
                        <?php endif; ?>
                        <div class="form-group">
                            <label><?php echo e($item->budgetname); ?></label>
                            <input type="number" name="budget[<?php echo e($item->budget_id); ?>]" class="form-control" min="0.00" step="0.01" value="<?php echo e($number); ?>">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    <div class="text-right">
                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึกรายการ</button>
                    </div>
                <?php echo Form::close(); ?>

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