<?php $__env->startSection('pageCss'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>รายการ ผู้สมัครร่วมโครงการ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการ ผู้สมัครร่วมโครงการ
            </div>
        </div>
        <div class="col-sm-6">
        	<div class="pull-right">
				<a href="<?php echo e(url('recurit/register/department/excel')); ?>" class="btn btn-info">ส่งออก Excel</a>
			</div>
        </div>	
    </div>

    <div class="row">
	    <div class="col-md-12">
	        <div class="smart-widget widget-dark-blue">
	            <div class="smart-widget-header"> 
	            	รายการ ผู้สมัครร่วมโครงการ 
	            </div>
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

	                    <div class="pull-right">
	                    <?php echo Form::open([ 'method' => 'get' , 'id' => 'myform' ]); ?>

						<div class="form-group">
							<div class="input-group">
								<select class="form-control" name="filter">
									<option value="" <?php echo e($filter==""?'selected':''); ?>>ปีงบประมาณปัจจุบัน</option>
									<option value="1 <?php echo e($filter==1?'selected':''); ?>">ทั้งหมด</option>
								</select>
								<div class="input-group-btn">
									<button class="btn btn-success no-shadow btn-sm" tabindex="-1">ค้นหา</button>
								</div>
							</div>
						</div>
	            		<?php echo Form::close(); ?>

	            		</div>
	                    
	                    <table class="table table-striped">
	                        <thead>
	                            <tr>
	                                
									
									<th hidden>#</th>
									<th >ชื่อ นามสกุล</th>
									<th >หน่วยงาน</th>
									
									<th >ตำแหน่ง</th>
									
									<th >สถานะ</th>
									<th >ระยะเวลาจ้างงาน</th>
	                                <th class="text-center">เพิ่มเติม</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            <?php if( count($register) > 0 ): ?>
								<?php $__currentLoopData = $register; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php 
									$check = $employ->where('register_id',$item->register_id)->first();
								 ?>
	                                <tr>
											<td hidden><?php echo e($item->section_id); ?></td>
	                                    
	                                    
										<td ><?php echo e($item->prefixname); ?><?php echo e($item->name); ?> <?php echo e($item->lastname); ?></td>
										<td><?php echo e($item->sectionname); ?></td>
										
										<td><?php echo e($item->positionname); ?></td>
										<?php if(!empty($check)): ?>
											<td ><?php echo e($item->registertypename); ?> <span class="text-success">(จ้างงาน)</span> </td>
											<?php else: ?>
											<td ><?php echo e($item->registertypename); ?></td>
										<?php endif; ?>
										<td><?php echo e($item->starthiredateinput); ?> - <?php echo e($item->endhiredateinput); ?></td>
	                                    <td class="text-right">
	                                    	<a href="<?php echo e(url('recurit/register/department/view/'.$item->register_id)); ?>" class="btn btn-info btn-xs">เพิ่มเติม</a>
	                                    	
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
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">
	$(".table").dataTable({
		"language": {
		"search": "ค้นหา ",
	
		}
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>