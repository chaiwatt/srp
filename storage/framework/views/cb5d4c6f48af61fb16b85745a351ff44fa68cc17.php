<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>รายการข่าวประชาสัมพันธ์</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการข่าวประชาสัมพันธ์ : ปีงบประมาณ <?php echo e($project->year_budget); ?> 
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="<?php echo e(url('information/create')); ?>" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มข่าวประชาสัมพันธ์</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการ </div>
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
                                    <th>ที่</th>
                                    <th>หัวเรื่องข่าว</th>
                                    <th width="300" class="text-right">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if( count($information) > 0 ): ?>
                                <?php $__currentLoopData = $information; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($item->information_title); ?></td>
                                        <td  class="text-right">
                                            <a href="<?php echo e(url('information/edit/'.$item->information_id)); ?>" class="btn btn-warning "><i class="fa fa-pencil"></i> แก้ไข</a>
                                            <a href="<?php echo e(url('information/delete/'.$item->information_id)); ?>" class="btn btn-danger " onclick="return confirm('ยืนยันการลบข้อมูล')"><i class="fa fa-remove"></i> ลบ</a>
                                            <a href="<?php echo e(url('landing/blog/'.$item->information_id)); ?>" class="btn btn-info"><i class="fa fa-bolt"></i> เว็บไซต์</a>
                                            
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>