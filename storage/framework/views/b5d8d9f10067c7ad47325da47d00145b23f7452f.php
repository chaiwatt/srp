<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('occupation/project/department')); ?>">รายการฝึกอบรมวิชาชีพ</a></li>
        <li>รายการพิจารณา</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                    รายการพิจารณา : <?php echo e($projectreadiness->project_readiness_name); ?>

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
                                    <th >วันที่สำรวจ</th>
                                    <th >สำนักงาน</th>                                    
                                    <th class="text-right">อนุมัติให้จัดกิจกรรม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if( count($readinesssection) > 0 ): ?>
                                    <?php $__currentLoopData = $readinesssection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <tr>
                                            <td ><?php echo e($item->surveydate); ?></td>
                                            <td><?php echo e($item->sectionname); ?></td>
                                            
                                            <td class="text-right">
                                                <div class="form-group">
                                                    <div class="custom-checkbox">
                                                        <div class="form-group">
                                                            <div class="custom-checkbox">
                                                                <input type="checkbox" class="section_id" data-pk="<?php echo e($item->section_id); ?>,<?php echo e($item->department_id); ?>" id="<?php echo e($item->section_id); ?>" <?php echo e($item->status==1?'checked':''); ?> >
                                                                <label for="<?php echo e($item->section_id); ?>"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">
    $(".section_id").change(function(){
        var array = $(this).attr('data-pk').split(',');
        $('input:checkbox').attr('disabled','true');
    		$.ajax({
    			type:"get",
    			url:"<?php echo e(url('readiness/project/department/approve')); ?>",
    			data:{
    				readiness_id :  "<?php echo e($projectreadiness->project_readiness_id); ?>",
                    status :  $(this).prop("checked"),
                    department :   array[1],
                    section :  array[0],
    			},
    			success:function(response){
    				window.location.reload();
                    $('input:checkbox').attr('disabled','false');
    			},
                error: function(data) {
                    $('input:checkbox').attr('disabled','false');
                },
                complete: function(data) {
                    $('input:checkbox').attr('disabled','false');
                }
    		})
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>