<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>กรอบการจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                กรอบการจ้างงาน : ปีงบประมาณ <?php echo e($project->year_budget); ?> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการ </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <?php echo Form::open([ 'url' => 'recurit/employ' , 'method' => 'post' ]); ?> 

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
                                        <th>ที่</th>
                                        <th>ชื่อกรม</th>
                                        <th>จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if( count($department) > 0 ): ?>
                                    <?php 
                                        $total = 0;
                                     ?>
                                    <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php 
                                            $value = $employ->where('department_id' , $item->department_id)->first() ;
                                         ?>
                                        <tr> 
                                            <td><?php echo e($key + 1); ?></td>
                                            <td><?php echo e($item->departmentname); ?></td>
                                            <?php if( count($value) > 0 ): ?>
                                            <?php 
                                                 $total =  $total + $value->employ_amount;
                                             ?>
                                            <td><input type="text" name="amount[<?php echo e($item->department_id); ?>]" class="form-control" value="<?php echo e($value->employ_amount); ?>" /></td>
                                            <?php else: ?>
                                            <td><input type="text" name="amount[<?php echo e($item->department_id); ?>]" class="form-control" value="0" /></td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                                <?php if( count($department) > 0 ): ?>
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="2"><strong>สรุปรายการ</strong> </td>
                                        
                                        <td class="text-left"><strong><?php echo e($total); ?></strong></td>
                                    </tr>
                                </tfoot>
                                <?php endif; ?>
                            </table>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                            </div>
                        <?php echo Form::close(); ?>

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