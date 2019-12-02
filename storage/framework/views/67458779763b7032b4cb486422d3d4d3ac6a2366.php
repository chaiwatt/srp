<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>รายการจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการจ้างงาน
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการ</div>
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
                                    <th >รหัสตำแหน่ง</th>
                                    <th >เดือน</th>
                                    <th >วันที่จ่าย</th>
                                    <th >ชื่อ นามสกุล</th>
                                    <th >เลขที่บัตรประชาชน</th>
                                    <th class="text-center">หักขาดเงิน</th>
                                    <th class="text-center">หักค่าปรับ</th>
                                    <th class="text-center">ค่าจ้างที่ได้รับ</th>
                                    <th class="text-center" style="width:50px">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $totalabsent =0;
                                    $totalfine =0;
                                    $totalpayment =0;
                                 ?>
                                <?php if( count($payment) > 0 ): ?>
                                <?php $__currentLoopData = $payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php 
                                        $totalabsent += $item->payment_absence;
                                        $totalfine += $item->payment_fine;
                                        $totalpayment += $item->payment_salary ;
                                     ?>
                                    <tr>
                                        <td ><?php echo e($item->generate_code); ?></td>
                                        <td ><?php echo e(str_pad( ($item->payment_month) , 2 ,"0",STR_PAD_LEFT)); ?></td>
                                        <td ><?php echo e($item->paymentdateth); ?></td>
                                        <td><?php echo e($item->registerprefixname); ?><?php echo e($item->registername); ?> <?php echo e($item->registerlastname); ?></td>
                                        <td ><?php echo e($item->registerpersonid); ?></td>
                                        <td class="text-center"><?php echo e(number_format($item->payment_absence , 2)); ?></td>
                                        <td class="text-center"><?php echo e(number_format($item->payment_fine , 2)); ?></td>
                                        <td class="text-center"><?php echo e(number_format($item->payment_salary , 2)); ?></td>
                                        <td class="text-right">
                                            <a href="<?php echo e(url('recurit/payment/section/edit/'.$item->payment_id)); ?>" class="btn btn-warning btn-xs">แก้ไข</a>
                                            <a href="<?php echo e(url('recurit/payment/section/delete/'.$item->payment_id)); ?>" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบข้อมูล')">ลบ</a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="6" ><strong>สรุปรายการ</strong> </td>
                                    <td class="text-center"><strong><?php echo e(number_format($totalabsent ,2)); ?></strong></td>                                       
                                    <td class="text-center"><strong><?php echo e(number_format($totalfine ,2)); ?></strong></td>                                       
                                    <td class="text-center"><strong><?php echo e(number_format($totalpayment ,2)); ?></strong></td>                                       
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