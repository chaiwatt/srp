<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>การเบิกจ่ายเงินเดือน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                การเบิกจ่ายเงินเดือน : ปีงบประมาณ <?php echo e($project->year_budget); ?> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> การเบิกจ่ายเงินเดือน </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">เดือน</th>
                                    <th class="text-center">ปี</th>
                                    <th >รายการ</th>
                                    <th class="text-center">หักขาดงาน</th>
                                    <th class="text-center">หักค่าปรับ</th>
                                    <th class="text-center">จ่ายจริง</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php ( $absence = 0 ); ?>
                                <?php ( $fine = 0 ); ?>
                                <?php ( $salary = 0 ); ?>
                                <?php if( count( $payment ) > 0 ): ?>
                                <?php $__currentLoopData = $payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-center"><?php echo e(str_pad( ($item->payment_month) , 2 ,"0",STR_PAD_LEFT)); ?></td>
                                        <td class="text-center"><?php echo e($item->payment_year); ?></td>
                                        <td><?php echo e($item->budgetname); ?></td>
                                        <td class="text-center"><?php echo e(number_format( $item->paymentdepartmentabsence , 2)); ?></td>
                                        <td class="text-center"><?php echo e(number_format( $item->paymentdepartmentfine , 2)); ?></td>
                                        <td class="text-center"><?php echo e(number_format( $item->paymentdepartmentsalary , 2)); ?></td>
                                        <td class="text-right">
                                            <a href="<?php echo e(url('recurit/report/department/payment/view/'.$item->department_id.'?month='.$item->payment_month)); ?>" class="btn btn-info">เพิ่มเติม</a>
                                        </td>
                                    </tr>
                                    <?php ( $absence += $item->paymentdepartmentabsence ); ?>
                                    <?php ( $fine += $item->paymentdepartmentfine ); ?>
                                    <?php ( $salary +=  $item->paymentdepartmentsalary); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="3"><strong>สรุปรายการ</strong> </td>
                                    <td class="text-center"><strong><?php echo e(number_format( $absence , 2 )); ?></strong> </td>
                                    <td class="text-center"><strong><?php echo e(number_format( $fine , 2 )); ?></strong> </td>
                                    <td class="text-center"><strong><?php echo e(number_format( $salary , 2 )); ?></strong> </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
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