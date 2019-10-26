<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">วีดีโอสอนใช้งาน</a></li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการ วีดีโอสอนใช้งาน
            </div>
        </div>
    </div>
</div>


    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> รายการ วีดีโอสอนใช้งาน </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">           
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th >#</th>
                                <th >วีดีโอ</th>
                                <th >หมวด</th>
                                <th >สังกัด</th>
                                <th >เพิ่มเติม</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $videolist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key +1); ?></td>
                                    <td><?php echo e($item->video_desc); ?></td>
                                    <td><?php echo e($item->categoty); ?></td>
                                    <td><?php echo e($item->owner); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('videolist.play',['id' => $item->video_id])); ?>" class="btn btn-xs btn-info">เปิดวีดีโอ</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <ul class="pagination pagination-split pull-right">
                        <?php echo $videolist->render(); ?>

                    </ul>

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