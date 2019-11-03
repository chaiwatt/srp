<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('setting/landing')); ?>">ตั้งค่า Landing Page</a></li>
        <li>เพิ่มเอกสารดาวน์โหลด</li>    
    </ul>
    <?php echo Form::open([ 'url' => 'setting/landing/create' , 'method' => 'post', 'files' => 'true' ]); ?> 
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่มเอกสารดาวน์โหลด
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> เอกสาร </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>คำอธิบายไฟล์</label>
                                    <input type="text" name="desc" class="form-control" required/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>เลือกไฟล์</label>
                                <input type="file" name="file" id="file" class="filestyle"  required />
                            </div>     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>

</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">
    $('#file').on('change', function() {
        if($(this)[0].files[0].size/1024  > 10240){
            $("#file").val(null);
            alert('ขนาดไฟล์ต้องไม่เกิน 10MB');
        }
    });
    $('#file').filestyle({
        buttonName : 'btn-info',
        buttonText : ' เลือกไฟล์เอกสาร',
        input: false,
        icon: false,
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>