<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>โครงการรอพิจารณา</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                โครงการรอพิจารณา ปีงบประมาณ : <?php echo e($project->year_budget); ?>

            </div>
        </div>
    </div>

    <div class="row">
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

        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการฝึกอบรมเตรียมความพร้อม รอพิจารณา</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >วันที่</th>
                                    <th >กรมสังกัด</th>   
                                    <th >ชื่อโครงการ</th>                                
                                    <th class="text-center">กรอบเป้าหมายผู้เข้าร่วม</th>
                                    <th class="text-center">งบประมาณ</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if( count($readiness) > 0 ): ?>
                                    <?php $__currentLoopData = $readiness; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($item->project_status == 0): ?>
                                            <tr>
                                                <td ><?php echo e($item->adddate); ?></td>
                                                <td ><?php echo e($item->departmentname); ?></td>
                                                <td><?php echo e($item->project_readiness_name); ?></td>                
                                                <td class="text-center"><?php echo e($item->targetparticipate); ?></td>
                                                <td class="text-center"><?php echo e($item->budget); ?></td>
                                                <td class="text-right">
                                                    <?php if($item->project_status == 0): ?>
                                                        <a href="<?php echo e(url('readiness/project/main/approve/'.$item->project_readiness_id)); ?>" class="btn btn-warning btn-xs" >อนุมัติโครงการ</a>
                                                    <?php endif; ?>
                                                    <a href="<?php echo e(url('readiness/project/main/edit/'.$item->project_readiness_id)); ?>" class="btn btn-info btn-xs">เพิ่มเติม</a>
                                                </td>
                                            </tr> 
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <ul class="pagination pagination-split pull-right">
                        </ul>

                    </div>
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