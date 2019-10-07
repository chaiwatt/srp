<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>คืนงบประมาณจัดจ้าง</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                คืนงบประมาณจัดจ้าง : ปีงบประมาณ <?php echo e($project->year_budget); ?> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการคืนงบประมาณ </div>
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
                                    <th>ยืนยันคืนเงิน</th>
                                    <th >รหัสตำแหน่ง</th>
                                    <th >ชื่อ-สกุล</th>
                                    <th >ตำแหน่ง</th>
                                    <th class="text-center">จำนวนเงิน</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $totalremain = 0;
                                 ?>
                                <?php if(count($generate) > 0): ?>
                                <?php $__currentLoopData = $generate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                    $totalremain +=  $item->paymentbalance ;
                                 ?>
                                <tr>
                                    <td >                                       
                                        <div class="form-group">
                                            <div class="custom-checkbox">
                                                <input type="checkbox" name="chk<?php echo e($item->generate_id); ?>"  id="chk<?php echo e($item->generate_id); ?>"  >
                                                <label for="chk<?php echo e($item->generate_id); ?>"></label>
                                            </div>
                                        </div>                                      
                                    </td>
                                    <td ><?php echo e($item->generate_code); ?></td>
                                    <td ><?php echo e($item->registerprefixname); ?><?php echo e($item->registername); ?>  <?php echo e($item->registerlastname); ?></td>
                                    <td ><?php echo e($item->positionname); ?></td>
                                    <td class="text-center"><?php echo e(number_format( $item->paymentbalance , 2 )); ?></td>
                                    <td class="text-center">
                                        <?php if($item->paymentbalance > 0): ?>
                                        <div class="btn-group marginTB-xs">
                                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                                    คืนเงินงบประมาณ <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu" role="menu">                                                   
                                                    <li><a id="<?php echo e($item->generate_id); ?>" class="refund" data-id="<?php echo e(url('recurit/refund/section/confirm/'.$item->generate_id )); ?>" >คืนงบประมาณ</a></li>
                                                    <li><a id="<?php echo e($item->generate_id); ?>" class="refund" data-id="<?php echo e(url('recurit/refund/section/confirmanual/'.$item->generate_id )); ?>" >คืนเงินงบประมาณประจำปี</a></li>
                                                  </ul>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>                                        
                                    <td class="text-center"><strong><?php echo e(number_format( $totalremain , 2 )); ?></strong> </td>                                             
    
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
    <script>
        $(document).on("click",".refund",function(e){
            var check = ($('#chk' + $(this).attr('id')).is(":checked"));
            if(check == true){
                var r = confirm("ต้องการคืนเงินงบประมาณ");
                if (r == true) {
                    window.location.href = $(this).attr('data-id');
                }
            }else{
                alert('ยังไม่ได้เช็คเลือกยืนยันการคืนเงิน');
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>