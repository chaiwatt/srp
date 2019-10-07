<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('readiness/project/department')); ?>">รายการฝึกอบรมเตรียมความพร้อม</a></li>    
        <li>โครงการฝึกอบรมเตรียมความพร้อม</li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                โครงการฝึกอบรมเตรียมความพร้อม
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> โครงการฝึกอบรม: <?php echo e($readiness->project_readiness_name); ?> </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md"> 
                    <?php echo Form::open([ 'url' => 'readiness/project/department/edit' , 'method' => 'post' ]); ?> 
                        <input type="hidden" name="id" value="<?php echo e($readiness->project_readiness_id); ?>">
                        <div class="form-group">
                            <label>ชื่อโครงการ</label>
                        <input type="text" name="name" class="form-control" value="<?php echo e($readiness->project_readiness_name); ?>" required="" />
                        </div>
                        <div class="form-group">
                            <label>วันที่จัดโครงการ</label>
                        <input type="text" name="projectdate" class="form-control datepicker" value="<?php echo e($readiness->adddate); ?>"  data-provide="datepicker" data-date-language="th-th" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label>กรอบเป้าหมายผู้เข้าร่วมโครงการ</label>
                        <input type="number" min="0"  name="number" value="<?php echo e($readiness->targetparticipate); ?>" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>งบประมาณ</label>
                        <input type="number" min="0" name="budget" value="<?php echo e($readiness->budget); ?>" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>รายละเอียดโครงการ</label>
                        <textarea class="form-control" name="detail" required=""><?php echo e($readiness->project_readiness_desc); ?></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                        </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">
    $('.datepicker').datepicker({
        language: 'th',
        format : "dd/mm/yyyy",
        thaiyear: true,
        autoclose:false,
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>