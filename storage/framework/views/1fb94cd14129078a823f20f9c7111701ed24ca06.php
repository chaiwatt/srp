<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('setting/section')); ?>">ตั้งค่า รายการหน่วยงานย่อย</a></li>
        <li>เพิ่ม รายการหน่วยงานย่อย</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่ม รายการหน่วยงานย่อย
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header">  เพิ่ม รายการหน่วยงานย่อย </div>
            <div class="smart-widget-body">

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

                <div class="smart-widget-body  padding-md"> <!-- form create project -->
                    <?php echo Form::open([ 'url' => 'setting/section/create' , 'method' => 'post' ]); ?> 
                        <div class="form-group">
                            <label>หน่วยงาน</label>
                            <select class="form-control" name="department" id="department"></select>
                        </div>
                        <div class="form-group">
                            <label>จังหวัด</label>
                            <select class="form-control" name="province">
                                <?php $__currentLoopData = $province; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->province_id); ?>"><?php echo e($item->province_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>  
                        <div class="form-group">
                            <label>รหัสหน่วยงาน</label>
                            <input type="number" name="code" class="form-control" required="" />
                        </div>
                        <div class="form-group">
                            <label>ชื่อหน่วยงานย่อย</label>
                            <input type="text" name="name" class="form-control" required="" />
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
    $(function(){
        $.ajax({
            type:"get",
            url:"<?php echo e(url('api/department')); ?>",
            dataType:"Json",
            data:{
                department : "",
            },
            success : function(data){
                var html = "<option value=''>เลือก หน่วยงาน</option>";
                if(data.row > 0){
                    for(var i=0;i<data.row;i++){
                        if( data.department[i].department_id == data.filter_department ){
                            html += "<option value='"+ data.department[i].department_id +"' selected>" + data.department[i].department_name +"</option>"
                        }
                        else{
                            html += "<option value='"+ data.department[i].department_id +"' > " + data.department[i].department_name +"</option>"
                        }
                    }
                }

                $("#department").html(html);
            }
        })
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>