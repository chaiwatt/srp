<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('recurit/payment/section/list')); ?>">รายการจ้างงาน</a></li>
        <li>แก้ไขเบิกจ่าย</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                แก้ไขเบิกจ่าย : <?php echo e($payment->registername); ?> <?php echo e($payment->registerlastname); ?>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการ </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <?php echo Form::open([ 'url' => 'recurit/payment/section/edit' , 'method' => 'post' ]); ?> 

                            <input type="hidden" name="payment" value="<?php echo e($payment->payment_id); ?>">
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
                            
                            
                            <div class="form-group">
                                <label>วันเบิกจ่าย</label>
                                <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                                    <input type="text" class="form-control" name="date" value="" autocomplete="off" required="">
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>หักขาดงาน</label>
                                <input type="number" min="0" step="0.01" max="<?php echo e($payment->position_salary); ?>" required="" value="<?php echo e($payment->payment_absence); ?>" name="absence" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label>หักค่าปรับ</label>
                                <input type="number" min="0" step="0.01" max="<?php echo e($payment->position_salary); ?>" required="" value="<?php echo e($payment->payment_fine); ?>" name="fine" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label>ค่าจ้างที่ได้รับ</label>
                                <input type="number" min="0" step="0.01" max="<?php echo e($payment->position_salary); ?>" required="" name="salary" class="form-control" value="<?php echo e($payment->payment_salary); ?>" />
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                                    </div>
                                </div>
                            </div>
                        
                        <?php echo Form::close(); ?>


                    </div>
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
        autoclose:true,
        orientation: "bottom left",
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>