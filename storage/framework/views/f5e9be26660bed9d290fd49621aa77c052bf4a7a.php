<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>ตั้งค่า ผู้สมัครไม่ Active</li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ตั้งค่า ผู้สมัครไม่ Active
            </div>
        </div>
        
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> รายการ ผู้สมัครไม่ Active </div>
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
                                <th>ชื่อ-สกุล</th>
                                <th>หมายเลขบัรประชาชน</th>
                                <th>กรม</th>
                                <th>สำนักงาน</th>
                                <th>เพิ่มเติม</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $registers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $register): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($register->prefixname); ?><?php echo e($register->name); ?> <?php echo e($register->lastname); ?></td>
                                    <td><?php echo e($register->person_id); ?></td>
                                    <td><?php echo e($register->departmentname); ?></td>
                                    <td><?php echo e($register->sectionname); ?></td>
                                    <td>                                        
                                        <a href="<?php echo e(url('setting/inactiveregister/delete/'.$register->register_id)); ?>" class="btn btn-xs btn-danger" onclick="return confirm('ยืนยันการลบผู้สมัคร')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
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