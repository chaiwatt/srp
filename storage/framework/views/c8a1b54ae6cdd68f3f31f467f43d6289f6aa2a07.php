<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('recurit/employ/section')); ?>">รายการจัดสรรการจ้างงาน</a></li>
        <li>เพิ่มรายการจัดสรรการจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่มรายการจัดสรรการจ้างงาน : ปีงบประมาณ <?php echo e($project->year_budget); ?> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> จำนวนจัดสรรการจ้างงาน (กรอบจ้างงาน <?php echo e($employ); ?> คน) </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <?php echo Form::open([ 'url' => 'recurit/employ/section/create' , 'method' => 'post' ]); ?> 

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
                                        <th style="vertical-align: middle; width:30%" class="text-center" rowspan="2">หน่วยงาน</th>
                                        <th style="vertical-align: middle;" class="text-center" rowspan="2">จำนวนที่ขอ</th>
                                        <th class="text-center" colspan="<?php echo e(count($position)+1); ?>">ตำแหน่งที่ขอ</th>
                                    </tr>
                                    <tr>
                                        <?php if(count($position) > 0): ?>
                                        <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th class="text-center"><?php echo e($item->position_name); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if( count($section) > 0 ): ?>
                                    <?php $__currentLoopData = $section; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php ( $query = $survey->where('section_id' , $item->section_id)->sum('survey_amount') ); ?>
                                        <tr>
                                        <td ><?php echo e($item->section_name); ?> 
                                            <?php if(!empty($item->surveyhostname)): ?>
                                            <br> <small class="text-success">(<?php echo e($item->surveyhostname); ?>)</small> 
                                            <?php endif; ?>
                                           
                                        </td>
                                            <td class="text-center"><?php echo e($query); ?></td>
                                            <?php if( count($position) > 0 ): ?>
                                            <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php ( $query = $survey->where('section_id' , $item->section_id)->where('position_id' , $value->position_id)->last() ); ?>
                                                <?php ( $number = $generate->where('section_id' , $item->section_id)->where('position_id' , $value->position_id)->count() ); ?>
                                                <td>
                                                    <div class="form-group text-center">
                                                        <label>ร้องขอ(<?php echo e($query->survey_amount); ?>) / จัดสรรให้</label>
                                                        <input type="number" min="0" name="number[<?php echo e($item->section_id); ?>][<?php echo e($value->position_id); ?>]" class="form-control text-center" step="1" value="<?php echo e($number); ?>" />
                                                    </div>
                                                </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
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
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>