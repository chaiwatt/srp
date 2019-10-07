<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">
    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('transfer/department')); ?>">รายการโอนงบประมาณ</a></li>
        <li>โอนงบประมาณ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                โอนงบประมาณ ปีงบประมาณ : <?php echo e($project->year_budget); ?> 
            </div>
        </div>
    </div>


    <?php if( $search != "" ): ?>
        <div class="row">
            <div class="col-md-12">
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

                <?php echo Form::open([ 'url' => 'transfer/department/create' , 'method' => 'post' ]); ?> 
                <input type="hidden" name="id" value="<?php echo e($budget->budget_id); ?>">


                <div class="smart-widget widget-dark-blue">
                    <div class="smart-widget-header"> <?php echo e($budget->budget_name); ?> ( คงเหลือ = <?php echo e(number_format($sum , 2)); ?> )</div>
                    <div class="smart-widget-body">
                        <div class="smart-widget-body  padding-md">
                            <?php if( count($section) > 0 ): ?>
                            <table class="table table-striped">
                                <thead>
                                        <tr>
                                            <th style="width:70%">สำนักงาน</th>
                                            <th style="width:30%" >จำนวนโอน</th>                                                
                                        </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $section; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <?php 
                                            $query = $allocation->where('section_id' , $value->section_id)->first(); 
                                         ?>
                                        <?php if( count($query) == 0 ): ?>
                                            <?php ($number = 0); ?>
                                        <?php else: ?>
                                            <?php ($number = $query->transactionbalance); ?>
                                        <?php endif; ?>
                                        <td>
                                         <label><?php echo e($value->section_name); ?> ( คงเหลือ = <?php echo e($number); ?> )</label>   
                                        </td>
                                        <td><input style="width:100%"  type="number" name="number[<?php echo e($value->section_id); ?>]" class="form-control" step="0.01" autocomplete="off" value=""></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <?php endif; ?>
                        </div>
                    </div>
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
    <?php endif; ?>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">
    $(function(){
        $.ajax({
            type:"get",
            url:"<?php echo e(url('api/projectallocation')); ?>",
            dataType:"Json",
            data:{
                budget : 1,
            },
            success : function(data){
                var html = "<option value=''>เลือกค่าใช้จ่าย</option>";
                if(data.row > 0){
                    for(var i=0;i<data.row;i++){
                        if( data.budget[i].budget_id == data.filter_budget ){
                            html += "<option value='"+ data.budget[i].budget_id +"' selected>" + data.budget[i].budget_name +"</option>"
                        }
                        else{
                            html += "<option value='"+ data.budget[i].budget_id +"' > " + data.budget[i].budget_name +"</option>"
                        }
                    }
                }

                $("#budget").html(html);
            }
        })
    })

       $(".table").dataTable({
        "language": {
        "search": "ค้นหา: "
        },
        "pageLength": 5
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>