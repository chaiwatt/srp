<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>ตั้งค่าปีงบประมาณ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ตั้งค่าปีงบประมาณ
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="<?php echo e(url('setting/year/create')); ?>" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มปีงบประมาณ</a>
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> รายการปีงบประมาณ </div>
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
                                <th width="50">#</th>
                                <th>ปีงบประมาณ</th>
                                <th width="120">เลือกปีงบประมาณ</th>
                                <th width="150" class="text-right">เพิ่มเติม</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php if( count($settingyear) > 0 ): ?>
                            <?php $__currentLoopData = $settingyear; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key + 1); ?></td>
                                    <td><?php echo e($item->setting_year); ?></td>
                                    <td class="text-center">
                                    	<div class="form-group">
											<div class="custom-checkbox">
												<input type="checkbox" class="select_year" data-pk="<?php echo e($item->setting_year_id); ?>" id="<?php echo e($item->setting_year_id); ?>" <?php echo e($item->setting_status==1?'checked':''); ?> >
												<label for="<?php echo e($item->setting_year_id); ?>"></label>
											</div>
										</div>
                                    </td>
                                    <td class="text-right">
                                        <a href="<?php echo e(url('setting/year/delete/'.$item->setting_year_id)); ?>" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันลบปีงบประมาณ')"> ลบปีงบประมาณ</a>
                                        
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
                        

<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">
    $(".select_year").change(function(){
    	value = $(this).prop("checked");
    	if( value ){
    		$.ajax({
    			type:"post",
    			url:"<?php echo e(url('setting/year/selectyear')); ?>",
    			data:{
    				id : $(this).attr('data-pk'),
    			},
    			success:function(response){
    				window.location.reload();
    			}
    		})
    	}
    	else{
    		alert("กรุณาเลือกปีงบประมาณ");
    		$(this).prop('checked' , true);
    	}
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>