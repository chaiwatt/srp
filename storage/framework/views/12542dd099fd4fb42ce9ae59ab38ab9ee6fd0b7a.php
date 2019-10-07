<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>รายการฝึกอบรมเตรียมความพร้อม</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                    รายการฝึกอบรมเตรียมความพร้อม ปีงบประมาณ : <?php echo e($project->year_budget); ?>

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
                <div class="smart-widget-header"> รายการฝึกอบรมเตรียมความพร้อม</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >วันที่เพิ่ม</th>
                                    <th >ชื่อหลักสูตร</th>
                                    <th class="text-center">เป้าหมายผู้เข้าร่วม</th>
                                    <th >สถานะ</th>
                                    <th class="text-right">บันทึก</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $totaltarget =0;
                                 ?>
                                <?php if( count($readiness) > 0 ): ?>
                                    <?php $__currentLoopData = $readiness; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php 
                                        $totaltarget += $item->projectreadinesstarget ;
                                        $waitrefund=0;
                                            if($item->completed == 1){
                                                $waitrefund = $item->budget - ($item->actualexpense + $item->refund);
                                            }
                                     ?>
                                        <tr>
                                            <td ><?php echo e($item->adddate); ?></td>
                                            <td ><?php echo e($item->projectreadinessname); ?></td>                                            
                                            <td class="text-center"><?php echo e($item->projectreadinesstarget); ?></td>
                                            <td ><?php echo e($item->projectcomplete); ?><?php if($waitrefund > 0): ?> <span class="text-danger"><a href="<?php echo e(url('readiness/project/section/refund/'.$item->readiness_section_id)); ?>" class="btn btn-danger btn-xs" >คืนเงิน <?php echo e($waitrefund); ?> บาท </a></span> <?php endif; ?></td>
                                            <td class="text-right"><a href="<?php echo e(url('readiness/project/section/manage/'.$item->readiness_section_id)); ?>" class="btn btn-info" >บันทึก</a></td>                                               
                                        </tr> 
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>                                        
                                    <td class="text-center"><strong><?php echo e($totaltarget); ?></strong> </td>                                             
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
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">
    $(".readiness_id").change(function(){
    		$.ajax({
    			type:"get",
    			url:"<?php echo e(url('readiness/project/section/toggle')); ?>",
    			data:{
    				readiness_id : $(this).attr('data-pk'),
                    status :  $(this).prop("checked"),
                    section :  "<?php echo e($auth->section_id); ?>",
                    department :  "<?php echo e($auth->department_id); ?>",
                    project_id :  "<?php echo e($project->project_id); ?>",
    			},
    			success:function(response){
                    console.log(response);
    				window.location.reload();
    			}
    		})
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>