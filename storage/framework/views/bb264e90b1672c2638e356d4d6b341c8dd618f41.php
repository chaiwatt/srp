<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pdfcontent'); ?>
	<div class="container" style="max-width:960px">
		<div class="txt01 txt-center">
			<h1>แบบรายงานรายการประเมิน <?php echo e($assessment->assesment_name); ?> </h1>
		</div>
		<div class="txt01 txt-center">
			<h1>ภายใต้งบประมาณโครงการคืนคนดีสู่สังคม ประจำปีงบประมาณ พ.ศ. <?php echo e($setting->setting_year); ?></h1>
		</div>
		<div class="txt01 txt-center">
			<h1><?php echo e($header); ?></h1>
        </div>
        <div class="txt01 txt-center">
            <h1>************************************</h1>
        </div>
        		
        <table style="width:100%; " >	
            <thead>
                <tr>
                    <th style="width:17%">ชื่อ-สกุล</th>
                    <th >เลขที่บัตรประชาชน</th>
                    <th >ผลการประเมิน</th> 
                    <th >การติดตาม</th>
                    <th >ต้องการสนับสนุน</th>
                    <th >ความสัมพันธ์ในครอบครัว</th>
                    <th >การมีรายได้</th>
                    <th >การมีอาชีพ</th>
                </tr>
            </thead>
            <tbody>
                <?php if( count($assessee) > 0 ): ?>
                <?php $__currentLoopData = $assessee; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->registername); ?></td>
                        <td ><?php echo e($item->registerpersonid); ?></td>
                        <td ><?php echo e($item->scorename); ?></td>
                        <td ><?php echo e($item->followerstatusname); ?></td>
                        <td ><?php echo e($item->needsupportname); ?> <small class="text-danger"> <?php echo e($item->needsupport_detail); ?></small></td>
                        <td ><?php echo e($item->familyrelationname); ?> <small class="text-danger"> <?php echo e($item->familyrelation_detail); ?></td>
                        <td ><?php echo e($item->enoughincomename); ?></td>
                        <td ><?php echo e($item->occupationname); ?> <small class="text-danger"> <?php echo e($item->occupation_detail); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </tbody>
        </table>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.pdf', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>