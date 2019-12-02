<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('recurit/payment/section')); ?>">การเบิกจ่ายเงินเดือน</a></li>
        <li>เบิกจ่าย</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เบิกจ่ายเงินเดือน : <?php echo e($generate->registername); ?> <?php echo e($generate->registerlastname); ?>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> บันทึกเบิกจ่ายเงินเดือน </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <?php echo Form::open([ 'url' => 'recurit/payment/section/create' , 'method' => 'post' ]); ?> 

                            <input type="hidden" name="generate" value="<?php echo e($generate->generate_id); ?>">
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
                                    <input id="paymentdate" type="text" class="form-control" name="date" autocomplete="off" required>
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>หักขาดงาน</label>
                                <input type="number" min="0" step="1" max="<?php echo e($generate->positionsalary); ?>" required value="0"  id="absence" name="absence" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label>หักค่าปรับ</label>
                                <input type="number" min="0" step="1" max="<?php echo e($generate->positionsalary); ?>" required value="0"  id="fine"  name="fine" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label>จำนวนวันที่ทำงาน(ใส่จำนวนวัน 0-31วัน)</label>
                                <input type="number" min="0" step="1" max="31" name="numwork" id="numwork" class="form-control" value="" />
                            </div>

                            <div class="form-group">
                                <label>ค่าจ้างที่ได้รับ</label>
                                <input type="number"  step="0.01" min="0" max="<?php echo e($generate->positionsalary); ?>" required name="salary" id="salary" class="form-control" value="" />
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

    $("#numwork").keyup(function(){
        var val = $('#paymentdate').val(); 
        if(val == ""){
            alert("ยังไม่ได้เลือกเลือกวันที่");
            return ;
        }
        var months = val.split('/');
         $("#salary").val(($(this).val()*getWage(parseInt(months[1])))-$("#absence").val()) ;
    })

    function getWage(month){
        if(month == 1 || month == 3 || month == 5 || month == 7  || month == 8  || month == 10  || month == 12 ){
            return parseFloat(9000/31).toFixed(2);
        }else if (month == 4 || month == 6 || month == 9 || month == 11  ){
            return parseFloat(9000/30).toFixed(2);
        }else{
            return parseFloat(9000/28).toFixed(2);
        }
    }

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>