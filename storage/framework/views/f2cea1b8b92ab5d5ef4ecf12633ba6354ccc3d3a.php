<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>รายการฝึกอบรมวิชาชีพ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                รายการฝึกอบรมวิชาชีพ ปีงบประมาณ : <?php echo e($project->year_budget); ?>

            </div>
        </div>
        <div class="col-sm-3">
            <div class="pull-right">
                <a href="<?php echo e(url('occupation/project/department/create')); ?>" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มโครงการอบรม</a>
            </div>
        </div>
    </div>
</div>
    <div class="row padding-md">
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
                    <div class="smart-widget-header"> รายการฝึกอบรมวิชาชีพ </div>
                    <div class="smart-widget-body">
                        <div class="smart-widget-body  padding-md">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th >ชื่อโครงการ</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">เป้าหมายผู้เข้าร่วม</th>
                                        <th class="text-center">งบประมาณ</th>
                                        <th class="text-center">สถานะโครงการ</th>
                                        <th class="text-center">จำนวนต้องการจัด</th>
                                        <th class="text-center">จำนวนอนุมัติ</th>
                                        <th class="text-center">เพิ่มเติม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $totaltargetparticipate=0;
                                        $totalbudget=0;
                                        $totalrequire =0;
                                        $totalapprove=0;
                                     ?>

                                    <?php if( count($readiness) > 0 ): ?>
                                        <?php $__currentLoopData = $readiness; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php 
                                            $approved = 0;
                                            $num = $readinesssection->where('project_readiness_id',$item->project_readiness_id)->count();
                                            if($num !=0){
                                                $approved = $readinesssection->where('project_readiness_id',$item->project_readiness_id)
                                                ->where('status',1)
                                                ->count();
                                            }
                                            $totaltargetparticipate += $item->targetparticipate;
                                            $totalbudget +=$item->budget;
                                            $totalrequire += $num;
                                            $totalapprove += $approved;
                                         ?>
                                            <tr>
                                                <td><?php echo e($item->project_readiness_name); ?></td>
                                                <td class="text-center"><?php echo e($item->adddate); ?></td>
                                                <td class="text-center"><?php echo e($item->targetparticipate); ?></td>
                                                <td class="text-center"><?php echo e($item->budget); ?></td>
                                                <?php if($item->project_status == 0 ): ?>
                                                    <td class="text-center">ไม่อนุมัติ</td>
                                                <?php else: ?>
                                                    <td class="text-center text-success ">ผ่านการอนุมัติ</td>
                                                <?php endif; ?>
                                                <td class="text-center"><?php echo e($num); ?></td>
                                                <td class="text-center"><?php echo e($approved); ?></td>
                                                <td class="text-right">
                                                    <?php if($item->project_status == 0): ?>
                                                        <a href="<?php echo e(url('occupation/project/department/edit/'.$item->project_readiness_id)); ?>" class="btn btn-info btn-xs" >เพิ่มเติม</a>
                                                        <a href="<?php echo e(url('occupation/project/department/delete/'.$item->project_readiness_id)); ?>" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบโครงการ')" >ลบ</a>
                                                    <?php else: ?>
                                                    <a href="<?php echo e(url('occupation/project/department/sectionlist/'.$item->project_readiness_id)); ?>" class="btn btn-info btn-xs" >รายละเอียด</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>
                                        <td class="text-center"><strong><?php echo e($totaltargetparticipate); ?></strong> </td>                                
                                        <td class="text-center"><strong><?php echo e(number_format( $totalbudget , 2 )); ?></strong> </td>    
                                        <td class="text-center" ><strong></strong> </td>                                
                                        <td class="text-center" ><strong><?php echo e($totalrequire); ?></strong> </td>                                
                                        <td class="text-center"><strong><?php echo e($totalapprove); ?></strong> </td>                                
                                    </tr>
                                </tfoot>
                            </table>
    
                            <ul class="pagination pagination-split pull-right">
                            </ul>
    
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