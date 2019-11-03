<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('information')); ?>">รายการข่าวประชาสัมพันธ์</a></li>
        <li>แก้ไขข่าวประชาสัมพันธ์</li>    
    </ul>
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
    <?php echo Form::open([ 'url' => 'setting/landing/edit' , 'method' => 'post' , 'files' => 'true' ]); ?> 
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                แก้ไขภาพ Landing page
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
            </div>
        </div>
    </div>
    
    <div class="row ">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> อัพโหลดภาพ ขนาด 1500x450 pixels </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md"> <!-- form create project -->
                            <div class="col-md-12 m-bottom-sm">
                                <?php if( count($picture) > 0 ): ?>
                                    <?php $__currentLoopData = $picture; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3">
                                        <img src="<?php echo e(asset($item->landingpicture)); ?>" class="img-responsive" />
                                        <center>
                                            <a href="<?php echo e(url('setting/landing/delete-picture/'.$item->setting_landingpicture_id )); ?>" class="btn btn-danger"><i class="fa fa-remove"></i> ลบ</a>
                                        </center>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group ">
                                <label>รูปสไลด์ (Slide)</label>
                                <input type="file" name="picture[]" id="picture" class="filestyle" multiple />
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> วีดีโอ Youtube </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md"> <!-- form create project -->
                        <?php 
                        $val ="";
                        $val2 ="";
                            if(count($youtube) !=0){
                                $val = $youtube->youtube_url;
                                $val2 = $youtube->youtube_id;
                            }
                         ?>
                            <div class="form-group">
                                <label>ลิงค์ Youtube (ต.ย. https://www.youtube.com/watch?v=<span style="color: red">2-ByJ1BllcE</span> ใส่เฉพาะ <span style="color: red">2-ByJ1BllcE</span> )</label>
                                <input type="text" name="youtube" value="<?php echo e($val); ?>" class="form-control" />
                                <input type="hidden" value="<?php echo e($val2); ?>" name ="youtube_id">
                            </div>
                 
                    </div>
                </div>
            </div>
        </div>  
        
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> เอกสารดาวน์โหลด </div>
                <div class="smart-widget-body">
                    <div class="pull-right">
                            <a href="<?php echo e(url('setting/landing/create')); ?>" class="btn btn-default btn-xs" style="margin:5px"><i class="fa fa-plus"></i> เพิ่มเอกสาร</a><br>
                    </div>
                       
                    <div class="smart-widget-body  padding-md"> <!-- form create project -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >คำอธิบาย</th>
                                    <th class="text-right">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if( count($docdownload) > 0 ): ?>
                                    <?php $__currentLoopData = $docdownload; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td ><?php echo e($item->docdownload_desc); ?></td>
                                            <td class="text-right"><a href="<?php echo e(asset($item->docdownload_link)); ?>" class="btn btn-info text-right btn-xs" target="_blank"> <i class="fa fa-download"></i> ดาวน์โหลด</a>
                                                <a href="<?php echo e(url('setting/landing/editdoc/'.$item->docdownload_id)); ?>" class="btn btn-warning text-right btn-xs"><i class="fa fa-pencil"></i> แก้ไข</a>
                                                <a href="<?php echo e(url('setting/landing/delete/'.$item->docdownload_id)); ?>" class="btn btn-danger text-right btn-xs"><i class="fa fa-remove"></i> ลบ</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>  
                        </table>
                        <?php echo e($docdownload->links()); ?>  
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


    $('#picture').on('change', function() {
        var attachedfiles = document.getElementById('picture');
        var sumfilesize =0;
        for (var i = 0; i < attachedfiles.files.length; i++) {
            sumfilesize =  attachedfiles + attachedfiles.files[i].size/1024;
            if(attachedfiles.files[i].size/1024 > 1000){
                $("#picture").val(null);
                alert('ขนาดไฟล์เกิน 3MB');
                return;
            }
        }
        if(sumfilesize > 10240){
            $("#picture").val(null);
            alert('ขนาดไฟล์รวมเกิน 10MB');
        }
    });

    $('#picture').filestyle({
        buttonName : 'btn-info',
        buttonText : ' เลือกรูป',
        input: false,
        icon: false,
    });

    // $('#doc').filestyle({
    //     buttonName : 'btn-success',
    //     buttonText : ' เลือกไฟล์',
    //     // input: false,
    //     icon: false,
    // });


    // $(".file-input").fileinput({
    //     showUpload: false,
    //     showCaption: false,
    //     browseClass: "btn btn-info",
    //     fileType: "any"
    // })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>