<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>การจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                การจ้างงาน : ปีงบประมาณ <?php echo e($project->year_budget); ?> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการจ้างงาน </div>
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
                                    <th>รหัสตำแหน่ง</th>
                                    <th>ตำแหน่ง</th>
                                    <th>ชื่อ-สกุล</th>
                                    <th class="text-center">เลขที่สัญญาจ้าง</th>
                                    <th class="text-center">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if( count($generate) > 0 ): ?>
                                <?php $__currentLoopData = $generate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php ( $query = $payment->where('generate_code' , $item->generate_code)->count() ); ?>
                                    <tr>
                                        <td ><?php echo e($item->generate_code); ?></td>
                                        <td><?php echo e($item->positionname); ?></td>
                                  
                                        <td ><?php echo e($item->registerprefixname); ?><?php echo e($item->registername); ?> <?php echo e($item->registerlastname); ?></td>
                                        <td class="text-center"><?php echo e($item->registercontractid); ?></td>

                                        <td class="text-right">
                                            <?php if(!Empty($item->register_id)): ?>
                                            <a href="<?php echo e(url('recurit/register/section/edit/'.$item->register_id)); ?>" class="btn btn-info">รายละเอียด</a>
                                            <?php endif; ?>
                                                
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