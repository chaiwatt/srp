<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('recurit/assesment')); ?>">ผลการประเมินบุคลิกภาพ</a></li>
        <li>ผลการประเมินบุคลิกภาพ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                    ผลการประเมินบุคลิกภาพ : 
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="<?php echo e(url('recurit/report/department/assessment/excel')); ?>" class="btn btn-info">Excel</a>
                <a href="<?php echo e(url('recurit/report/department/assessment/pdf')); ?>" class="btn btn-warning">PDF</a>
                
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> ผลการประเมินบุคลิกภาพ </div>
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
                                    <th  style="font-size:20px " rowspan="2" >หน่วยงาน</th>
                                    <th  style="font-size:20px " rowspan="2" class="text-center">จำนวนผู้ทดสอบ</th>
                                    <th  style="font-size:20px " rowspan="2" class="text-center">คะแนนเฉลี่ย</th>
                                    <th  style="font-size:20px " colspan="2" class="text-center">ความต้องการ</th>
                                    <th  style="font-size:20px " colspan="2" class="text-center">การให้การอบรม</th>
                                    <th  style="font-size:20px " rowspan="2" class="text-center">การมอบหมายงาน</th>
                                </tr>
                                <tr>
                                    <th  style="font-size:20px " class="text-center">อาชีพ</th>
                                    <th  style="font-size:20px " class="text-center">การศึกษา</th>
                                    <th  style="font-size:20px " class="text-center">อาชีพ</th>
                                    <th  style="font-size:20px " class="text-center">การศึกษา</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $totalnum=0;
                                    $totalavgscore=0;
                                    $totaloccupationneedfit=0;
                                    $totaleducationneedfit=0;
                                    $totaloccupationtrainfit=0;
                                    $totaleducationtrainfit=0;
                                    $totaljobassignmentfit=0;
                                    
                                 ?>

                                <?php if( count($section) > 0 ): ?>
                                <?php $__currentLoopData = $section; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item->sectionname); ?></td>
                                        <?php 
                                            $num = $uniquessesmentfit->where('section_id',$item->section_id)
                                            ->count();
                                            $allscore = $uniquessesment->where('section_id',$item->section_id)
                                            ->sum('register_assessment_point');
                                            $total = $uniquessesment->where('section_id',$item->section_id)->count();
                                            $scoreavg = number_format( ($allscore / $total) , 2);
                                            $occupationneedfit = $uniquessesmentfit->where('section_id',$item->section_id)->where('registeroccupationneedfit',1)
                                            ->count();
                                            $educationneedfit = $uniquessesmentfit->where('section_id',$item->section_id)->where('registereducationneedfit',1)
                                            ->count();

                                            $occupationtrainfit = $uniquessesmentfit->where('section_id',$item->section_id)->where('registeroccupationtrainfit',1)
                                            ->count();
                                            $educationtrainfit = $uniquessesmentfit->where('section_id',$item->section_id)->where('registereducationtrainfit',1)
                                            ->count();
                                            $jobassignmentfit = $uniquessesmentfit->where('section_id',$item->section_id)->where('jobassignmentfit',1)
                                            ->count();

                                            $totalnum +=$num;
                                            $totaloccupationneedfit += $occupationneedfit;
                                            $totaleducationneedfit += $educationneedfit ;
                                            $totaloccupationtrainfit += $occupationtrainfit ;
                                            $totaleducationtrainfit += $educationtrainfit;
                                            $totaljobassignmentfit +=$jobassignmentfit;
                                            $totalavgscore += $scoreavg;

                                         ?>
                                        <td class="text-center"><?php echo e($num); ?></td>
                                        <td class="text-center"><?php echo e($scoreavg); ?></td>
                                        <td class="text-center"><?php echo e($occupationneedfit); ?></td>
                                        <td class="text-center"><?php echo e($educationneedfit); ?></td>
                                        <td class="text-center"><?php echo e($occupationtrainfit); ?></td>
                                        <td class="text-center"><?php echo e($educationtrainfit); ?></td>
                                        <td class="text-center"><?php echo e($jobassignmentfit); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" ><strong>สรุปรายการ</strong> </td>
                                    <td class="text-center"><strong><?php echo e($totalnum); ?></strong> </td>
                                    <?php if(count($section) > 0 ): ?>
                                    <td class="text-center"><strong><?php echo e(number_format( $totalavgscore/count($section), 2 )); ?></strong> </td>
                                        <?php else: ?>
                                    <td class="text-center"><strong>0</strong> </td>
                                    <?php endif; ?>
                                    <td class="text-center"><strong><?php echo e($totaloccupationneedfit); ?></strong> </td>
                                    <td class="text-center"><strong><?php echo e($totaleducationneedfit); ?></strong></td>
                                    <td class="text-center"><strong><?php echo e($totaloccupationtrainfit); ?></strong></td>
                                    <td class="text-center"><strong><?php echo e($totaleducationtrainfit); ?></strong></td>
                                    <td class="text-center"><strong><?php echo e($totaljobassignmentfit); ?></strong></td> 
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
<script type="text/javascript">
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>