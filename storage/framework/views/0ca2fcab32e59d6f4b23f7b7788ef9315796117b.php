<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>รายการคืนเงินงบประมาณ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                รายการคืนเงินงบประมาณ ปีงบประมาณ : <?php echo e($settingyear->setting_year); ?> 
            </div>
        </div>
    </div>

    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> รายการคืนเงินงบประมาณ </div>
        <div class="smart-widget-body">
            <div class="smart-widget-body  padding-md">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th >สำนักงาน</th>
                            <th class="text-center">รายการค่าใช้จ่าย</th>
                            <th class="text-center">จำนวนเงินคืน</th>
                            <th class="text-center">วันที่คืน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $totalrefund_price=0;
                         ?>
                        <?php if( count($sectionrefund) > 0 ): ?>
                        <?php $__currentLoopData = $sectionrefund; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                            $totalrefund_price += $item->refund_price;
                         ?>
                            <tr>
                                <td><?php echo e($item->sectionname); ?></td>
                                <td class="text-center"><?php echo e($item->budgetname); ?></td>
                                <td class="text-center"><?php echo e(number_format( $item->refund_price , 2 )); ?></td>
                                <td class="text-center"><?php echo e($item->thaidate); ?></td>
                            </tr>                             
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                         <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>
                            <td class="text-center"><strong><?php echo e(number_format($totalrefund_price ,2)); ?></strong></td>                                       
                            
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
    <?php if( count($sectionrefund) > 10 ): ?>
        <script type="text/javascript">
            $(".table").dataTable({
                "language": {
                "search": "ค้นหา "
                }
            });
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>