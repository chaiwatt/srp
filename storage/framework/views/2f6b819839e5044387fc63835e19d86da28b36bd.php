<?php $__env->startSection('pageCss'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">เว็บไซต์</a></li>
        <li><a href="<?php echo e(url('assesment/section')); ?>">รายการประเมินผล</a></li>
        <li>การประเมินผล</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                การประเมินผล: <?php echo e($assessment->assesment_name); ?>

            </div>
        </div>
        <div class="col-sm-3">
            <div class="pull-right">
                <a href="<?php echo e(url('report/assessment/section/excel/'.$assessment->project_assesment_id)); ?>" class="btn btn-info">Excel</a>
                <a href="<?php echo e(url('report/assessment/section/pdf/'.$assessment->project_assesment_id)); ?>" class="btn btn-warning">PDF</a>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการประเมิน </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >ชื่อ-สกุล</th>
                                    <th >เลบที่บัตรประชาชน</th> 
                                    <th >ผลการประเมิน</th>
                                    <th >การติดตาม</th>
                                    <th >ต้องการสนับสนุน</th>
                                    <th >ความสัมพันธ์ในครอบครัว</th>
                                    <th >การมีรายได้</th>
                                    <th >การมีอาชีพ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if( count($assessee) > 0 ): ?>
                                <?php $__currentLoopData = $assessee; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item->registername); ?></td>
                                        <td ><?php echo e($item->registerpersonid); ?></td>
                                        <td ><?php echo e($item->scorename); ?></td>
                                        <td ><?php echo e($item->followerstatusname); ?></td>
                                        <td ><?php echo e($item->needsupportname); ?> <small class="text-danger"> <?php echo e($item->needsupport_detail); ?></small></td>
                                        <td ><?php echo e($item->familyrelationname); ?> <small class="text-danger"> <?php echo e($item->familyrelation_detail); ?></td>
                                        <td ><?php echo e($item->enoughincomename); ?></td>
                                        <td ><?php echo e($item->occupationname); ?> <small class="text-danger"> <?php echo e($item->occupation_detail); ?></td>
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