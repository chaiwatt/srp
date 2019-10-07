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
                <div class="smart-widget-header"> รายการได้รับจัดสรร </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center success">จำนวนจัดสรรรวม</th>
                                    <?php if( count($position) > 0 ): ?>
                                    <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th class="text-center"><?php echo e($item->position_name); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if( count($section) > 0 ): ?>
                                <?php $__currentLoopData = $section; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr> 
                                        <td class="text-center"> <strong><?php echo e($generate->count()); ?></strong> </td>
                                        <?php if( count($position) > 0 ): ?>
                                        <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php ( $query = $generate->where('position_id' , $value->position_id)->count() ); ?>
                                            <th class="text-center"><?php echo e($query); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
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

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> บันทึกตำแหน่ง </div>
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
                                    <th class="text-center">จำนวนเดือนเบิกจ่าย</th>
                                    
                                    <th class="text-center">จำนวนสัญญา</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-right">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if( count($generate) > 0 ): ?>
                                <?php $__currentLoopData = $generate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php 
                                        $query = $payment->where('generate_code' , $item->generate_code)->count() ;
                                        $positionsalary = $position->first()->position_salary; // $payment->where('generate_code' , $item->generate_code)->first()->position_salary;
                                        $num = $allgenerate->where('generate_code', $item->generate_code)->count() ;
                                     ?>
                                    <tr>
                                        <td ><?php echo e($item->generate_code); ?></td>
                                        <td><?php echo e($item->positionname); ?></td>
                                        <td class="text-center"><?php echo e($query); ?> / <?php echo e($item->generate_allocation / $positionsalary); ?></td>
                                        <td class="text-center"><?php echo e($num); ?></td>
                                        <td class="text-center"><?php echo e($item->generatestatusname); ?></td>
                                        
                                        <td class="text-right">
                                            <?php if( $item->generate_status == 0 && $item->generate_refund == 0 ): ?>
                                                <a href="<?php echo e(url('recurit/hire/section/create/'.$item->generate_id)); ?>" class="btn btn-warning">คัดเลือก</a>
                                                
                                            <?php else: ?>
                                                <a href="<?php echo e(url('recurit/hire/section/view/'.$item->generate_id)); ?>" class="btn btn-primary">รายละเอียด</a>
                                                
                                            <?php endif; ?>
                                            
                                            <a href="<?php echo e(url('recurit/hire/section/history/'.$item->generate_id)); ?>" class="btn btn-success">ประวัติ</a>
                                            <a href="<?php echo e(url('recurit/hire/section/editnummonth/'.$item->generate_id)); ?>" class="btn btn-default">จัดสรรเดือน</a>
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
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>