<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>รายการจัดสรรการจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการจัดสรรการจ้างงาน : ปีงบประมาณ <?php echo e($project->year_budget); ?> 
            </div>
        </div>
         <div class="col-sm-6">
            <div class="pull-right">
                <a href="<?php echo e(url('recurit/employ/section/create')); ?>" class="btn btn-success"><i class="fa fa-plus"></i> จัดสรรจำนวนจ้างงาน</a>
                <a href="<?php echo e(url('project/allocation/department/create')); ?>" class="btn btn-info"> จัดสรรงบประมาณจ้างงาน</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการ ( จำนวนกรอบจ้างงาน : <?php echo e($employ->employ_amount); ?> ) </div>
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
                                    <th class="text-center">ที่</th>
                                    <th class="text-center">หน่วยงาน</th>
                                    <th class="text-center">รวม</th>
                                    <?php if( count($position) > 0 ): ?>
                                    <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th class="text-center"><?php echo e($item->position_name); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $totalemploy=0;
                                 ?>
                                <?php if( count($section) > 0 ): ?>
                                <?php $__currentLoopData = $section; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                     $totalemploy += $generate->where('section_id' , $item->section_id)->count();
                                 ?>
                                    <tr> 
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($item->sectionname); ?></td>
                                        <td class="text-center"><?php echo e($generate->where('section_id' , $item->section_id)->count()); ?></td>
                                        <?php if( count($position) > 0 ): ?>
                                        <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php ( $query = $generate->where('position_id' , $value->position_id)->where('section_id' , $item->section_id)->count() ); ?>
                                            <td class="text-center"><?php echo e($query); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>
                                        <td class="text-center" ><strong><?php echo e($totalemploy); ?></strong> </td>
                                        <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php ( $query = $generate->where('position_id' , $value->position_id)->count() ); ?>
                                            <td class="text-center"><strong> <?php echo e($query); ?></strong></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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