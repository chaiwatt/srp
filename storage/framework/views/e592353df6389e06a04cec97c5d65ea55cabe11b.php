<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li>รายงานรายการยกเลิกจ้างงาน</li>    
    </ul>

    <div class="row padding-md">
        <div class="col-sm-6">
            <div class="page-title">
                รายงานรายการยกเลิกจ้างงาน ปีงบประมาณ : <?php echo e($setting->setting_year); ?>

            </div>
        </div>
    </div>

    <div class="row padding-md pull-right" >
        <div class="col-sm-12">
            <?php echo Form::open([ 'method' => 'get' , 'id' => 'myform' ]); ?>

            <div class="form-inline no-margin">
                <div class="form-group">
                    <label >เลือกเดือน</label>
                    <select class="form-control" name="month" id="month" >
                        <option value ="0" <?php if( $month == 0): ?> selected <?php endif; ?>  >เลือก เดือน</option>
                        <option value ="1" <?php if( $month == 1): ?> selected <?php endif; ?>  >มกราคม</option>
                        <option value ="2" <?php if( $month == 2): ?> selected <?php endif; ?>  >กุมภาพันธ์</option>
                        <option value ="3" <?php if( $month == 3): ?> selected <?php endif; ?>  >มีนาคม</option>
                        <option value ="4" <?php if( $month == 4): ?> selected <?php endif; ?>  >เมษายน</option>
                        <option value ="5" <?php if( $month == 5): ?> selected <?php endif; ?>  >พฤษภาคม</option>
                        <option value ="6" <?php if( $month == 6): ?> selected <?php endif; ?>  >มิถุนายน</option>
                        <option value ="7" <?php if( $month == 7): ?> selected <?php endif; ?>  >กรกฏาคม</option>
                        <option value ="8" <?php if( $month == 8): ?> selected <?php endif; ?>  >สิงหาคม</option>
                        <option value ="9" <?php if( $month == 9): ?> selected <?php endif; ?>  >กันยายน</option>
                        <option value ="10" <?php if( $month == 10): ?> selected <?php endif; ?>  >ตุลาคม</option>
                        <option value ="11" <?php if( $month == 11): ?> selected <?php endif; ?>  >พฤศจิกายน</option>
                        <option value ="12" <?php if( $month == 12): ?> selected <?php endif; ?>  >ธันวาคม</option>
                    </select>
                </div>    
                <button type="submit" class="btn btn-sm btn-success">ค้นหา</button>
                
                
                <?php if( $month != null ): ?>
                    
                    
                    <a href="<?php echo e(URL::route('cancel.department.export.pdf',['month' => $month ])); ?>" class="btn btn-sm btn-warning">PDF</a>
                    
                <?php endif; ?>
                
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>    

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">รายงานรายการยกเลิกจ้างงาน
                    <?php if(count($monthname) > 0): ?>
                        : เดือน <?php echo e($monthname->month_name); ?>

                    <?php endif; ?> 
                </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body padding-md">                       
                        <table class="table table-striped" id="cancel">
                            <thead>
                                <tr>
                                    <th>หน่วยงาน</th>
                                    <?php if( count($position) > 0 ): ?>
                                    <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th class="text-center"><?php echo e($item->position_name); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <th class="text-center">รวม</th>
                                </tr>
                            </thead>

                            <tbody>
                                    <?php if( count($numsection) > 0 ): ?>
                                    <?php $__currentLoopData = $numsection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php 
                                        $surveyname = $resign->where('section_id',$item->section_id)->first();
                                     ?>
                                        <?php if($resign->where('section_id' , $item->section_id)->count() != 0): ?>
                                            <tr>
                                                <td ><?php echo e($item->sectionname); ?></td>
                                                    <?php if( count($position) > 0 ): ?>
                                                        <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php ( $value = $resign->where('position_id' , $value->position_id)->where('section_id' , $item->section_id)->count() ); ?>
                                                            <td class="text-center"><?php echo e($value); ?></td>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                <td class="text-center"><?php echo e($resign->where('section_id' , $item->section_id)->count()); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                            </tbody>

                            <tfoot>
                                 <?php if( count($numsection) > 0 ): ?>
                                    <tr>
                                        <td class="text-center" ><strong>สรุปรายการ</strong> </td>
                                        <?php if( count($position) > 0 ): ?>
                                        <?php $__currentLoopData = $position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php ( $value = $resign->where('position_id' , $value->position_id)->count() ); ?>
                                            <td class="text-center"><strong><?php echo e($value); ?></strong> </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <td class="text-center"><strong><?php echo e($resign->count()); ?></strong> </td>
                                </tr>
                                <?php endif; ?>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
 
        <div class="col-md-12">
                <div class="smart-widget widget-dark-blue">
                    <div class="smart-widget-header">รายงานรายการยกเลิกจ้างงาน(แยกตามสาเหตุ)
                        <?php if(count($monthname) > 0): ?>
                            : เดือน <?php echo e($monthname->month_name); ?>

                        <?php endif; ?> 
                    </div>
                    <div class="smart-widget-body">
                        <div class="smart-widget-body padding-md">                       
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>เหตุผลการยกเลิกจ้างงาน</th>
                                        <th class="text-center">จำนวน</th>
                                    </tr>
                                </thead>
    
                                <tbody>
                                    <?php if( count($reason) > 0 ): ?>
                                        <?php $__currentLoopData = $reason; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td ><?php echo e($item->reasonname); ?></td>
                                                <td class="text-center"><?php echo e($resign->where('reason_id' , $item->reason_id)->count()); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
    
                                <tfoot>
                                        <?php if( count($numsection) > 0 ): ?>
                                        <tr>
                                            <td class="text-center" >รวม</td>
                                            <td class="text-center"><?php echo e($resign->count()); ?></td>
                                        </tr>
                                    <?php endif; ?>
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
<script type="text/javascript">
    $("#cancel").dataTable({
        "language": {
        "search": "ค้นหา "
        },
        "pageLength": 5
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>