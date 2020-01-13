<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>รายการจัดสรร</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                รายการจัดสรร ปีงบประมาณ : <?php echo e($project->year_budget); ?>

            </div>
        </div>
    </div>



    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> รายการจัดสรร </div>
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
                            <th >หน่วยงานย่อย</th>
                            <th >รายการค่าใช้จ่าย</th>
                            <th class="text-center">งบประมาณจัดสรร</th>
                            <th class="text-center">โอนไปแล้ว</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $totalallocation_price =0;
                            $totaltransferallocation=0;
                         ?>
                        <?php if( count($allocation) > 0 ): ?>
                        <?php $__currentLoopData = $allocation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                            $totalallocation_price += $item->allocation_price ;
                            $totaltransferallocation += $item->transferallocation ;
                         ?>
                            <tr>
                                <td><?php echo e($item->section_name); ?></td>
                                <td><?php echo e($item->budget_name); ?></td>
                                <td class="text-center"><?php echo e(number_format( $item->allocation_price , 2 )); ?></td>
                                <td class="text-center"><?php echo e(number_format( $item->transferallocation , 2 )); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-center" colspan="2" ><strong>สรุปรายการ</strong> </td>
                            <td class="text-center"><strong><?php echo e(number_format($totalallocation_price,2)); ?></strong></td>                                        
                            <td class="text-center"><strong><?php echo e(number_format($totaltransferallocation,2)); ?></strong></td>                                        
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">
    $(".table").dataTable();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>