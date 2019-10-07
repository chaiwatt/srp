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
                <div class="smart-widget-header"> รายการอัตราจ้าง </div>
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
                                    <th >รหัสตำแหน่งงาน</th>
                                    <th >รหัสบัตรประชาชน</th>
                                    <th >คำนำหน้า</th>
                                    <th >ชื่อ</th>
                                    <th >นามสกุล</th>
                                    <th >ตำแหน่งาน</th>
                                    <th class="text-center">เบิกจ่าย</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if( count($generate) > 0 ): ?>
                                <?php $__currentLoopData = $generate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td ><?php echo e($item->generate_code); ?></td>
                                        <td ><?php echo e($item->registerpersonid); ?></td>
                                        <td><?php echo e($item->registerprefixname); ?></td>
                                        <td><?php echo e($item->registername); ?></td>
                                        <td><?php echo e($item->registerlastname); ?></td>
                                        <td><?php echo e($item->positionname); ?></td>
                                        <td class="text-center">
                                            <a href="<?php echo e(url('recurit/payment/section/create/'.$item->generate_id)); ?>" class="btn btn-warning ">เบิกจ่าย</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?php echo e(url('recurit/payment/section/view/'.$item->generate_id)); ?>" class="btn btn-info">เพิ่มเติม</a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
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
	$(".table").dataTable({
		"language": {
		"search": "ค้นหา "
		}
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>