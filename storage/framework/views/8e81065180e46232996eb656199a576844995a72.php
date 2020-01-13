<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('project/allocation')); ?>">รายการโครงการ</a></li>    
        <li>จัดสรรงบประมาณ</li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการจัดสรรงบประมาณ ปีงบประมาณ <?php echo e($project->year_budget); ?>

            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> 
                จัดสรรงบประมาณ (<?php echo e(number_format( $project->totalbudget  , 2)); ?> บาท) 
               <small class="text-warning">
                <?php if(count($sumbydept) > 0): ?>
                    <?php (
                        $header=""
                    ); ?>
                    <?php $__currentLoopData = $sumbydept; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($dept->sum !=0): ?>
                            <?php ($header .= $dept->departmentname . " " . number_format( $dept->sum  , 2) . " บาท " ); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                    <?php if($sumbydept->sum('sum') > 0): ?>
                        รอเปลี่ยนแปลง <?php echo e($header); ?> 
                    <?php endif; ?>

                <?php endif; ?>
               </small>
        
            </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">
                <?php echo Form::open([ 'method' => 'post' , 'url' => 'project/allocation/deptalllocate' ]); ?> 
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

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">รายการ</th>
                                <th class="text-center">เงินตั้งต้น</th>
                                <?php if( count( $department ) > 0 ): ?>
                                <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                    <th class="text-center"><?php echo e($item->departmentname); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <th class="text-center">เงินคืน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sumrefund = 0;
                             ?>
                            <?php if( count($budget) > 0 ): ?>
                            <?php $__currentLoopData = $budget; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->budget_name); ?></td>
                                    <?php ( $value = $budgetlist->where('budget_id' , $item->budget_id)->first() ); ?>
                                    <?php if( count($value) > 0 ): ?>
                                        <td class="text-right"><?php echo e(number_format( $value->allocate  , 2)); ?></td>
                                    <?php else: ?>
                                        <td class="text-right"><?php echo e(number_format( 0 , 2 )); ?></td>
                                    <?php endif; ?>

                                    <?php if( count( $department ) > 0 ): ?>
                                    <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php ( $query = $allocation->where('budget_id' , $item->budget_id )->where('department_id' , $value->department_id )->sum('allocation_price')  ); ?>
                                        <td><input type="number" class="form-control text-center" min="0.00" step="0.01" name="number[<?php echo e($item->budget_id); ?>][<?php echo e($value->department_id); ?>]" value="<?php echo e($query); ?>" /></td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php 
                                         $query = $waiting->where('budget_id' , $item->budget_id)->sum('waiting_price') ;
                                         $sumrefund +=  $query ;
                                     ?>
                                    <td class="text-right text-danger"> <?php echo e(number_format( $query , 2 )); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                                <tr>
                                    <td class="text-right"><b>รวม</b></td>
                                    <td class="text-right"> <strong><?php echo e(number_format($budgetlist->sum('allocate'),2)); ?></strong> </td>
                                    <?php if( count( $department ) > 0 ): ?>
                                    <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php ( $number = $allocation->where('department_id' , $value->department_id )->sum('allocation_price')  ); ?>
                                        <td class="text-center"><strong> <?php echo e(number_format( $number , 2 )); ?></strong></td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <td class="text-center text-danger"><strong> <?php echo e(number_format( $sumrefund , 2 )); ?></strong></td>
                                </tr>
                        </tbody>
                    </table>
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