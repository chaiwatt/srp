<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('assesment/section')); ?>">รายการประเมิน</a></li>
        <li>เพิ่มการประเมินบุคคล</li>    
    </ul>
<?php echo Form::open([ 'url' => 'assesment/section/assessmentsave' , 'method' => 'post' ]); ?> 
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่มการประเมินบุคคล 
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                <a href="<?php echo e(url('assesment/section/editassessment/'.$assesment->project_assesment_id)); ?>" class="btn btn-success"><i class="fa fa-pencil"></i> แก้ไขรายการ</a>
            </div>
        </div>
    </div>
</div>
    <div class="padding-md">
    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการประเมิน: <?php echo e($assesment->assesment_name); ?> </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        
                        <input type="hidden" name="assesment_id" value="<?php echo e($assesment->project_assesment_id); ?>" />
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
                                <label>ผู้รับการประเมิน</label>
                                <select class="form-control" name="register"  id="register" required>
                                        <?php if( count($register) > 0 ): ?>
                                        <option value="">เลือกรายการ</option>
                                        <?php $__currentLoopData = $register; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->register_id); ?>"><?php echo e($item->registerprefixname); ?><?php echo e($item->registername); ?> <?php echo e($item->registerlastname); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                </select> 
                            </div>
                            <div class="form-group">
                                <label>ระดับการประเมิน</label>
                                <select class="form-control" name="score" id="score" required>
                                    <?php if( count($score) > 0 ): ?>
                                    <option value="">เลือกระดับ</option>
                                    <?php $__currentLoopData = $score; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->score_id); ?>"><?php echo e($item->score_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>ข้อคิดเห็นอื่นๆ</label>
                                <textarea class="form-control" name="detail"  id="detail"></textarea>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">
 $("#register").change(function(){        
        if( $("#register").val() != "" ){
             $.ajax({
                type:"get",
                url : "<?php echo e(url('assesment/section/followupdetail')); ?>",
                dataType:"Json",
                data : {
                    assesment_id : "<?php echo e($assesment->project_assesment_id); ?>",
                    register : document.getElementById("register").value,
                },
                success : function(response){
                    console.log(response);
                    if( response.row > 0 ){
                        for( var i=0;i<response.row;i++ ){
                            $('#score').val(response.assessment[i].score_id);
                            $('#detail').val(response.assessment[i].othernote);
                    }
                }
            }
        })
    }
})
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>