<?php $__env->startSection('blogcontent'); ?>

<div >

    <div class="row padding-md">
        <div class="col-sm-6">
            <div class="page-title">
               <strong>รายงานทั่วไป ปีงบประมาณ : <?php echo e($setting->setting_year); ?> </strong> 
            </div>
        </div>
        <div class="col-sm-12">
            <ul style="margin-left:50px">
                <li>
                <h3><a href="<?php echo e(url('publicreport/allocation')); ?>">รายงานรายการจ้างงาน</a></h3>
                </li>
                <li>
                    <h3><a href="<?php echo e(url('publicreport/expense')); ?>">รายงานค่าใช้จ่ายจ้างงาน</a></h3>
                </li>
                <li>
                    <h3><a href="<?php echo e(url('publicreport/readiness')); ?>">รายงานอบรมเตรียมความพร้อม</a></h3>
                </li>
                <li>
                    <h3><a href="<?php echo e(url('publicreport/occupation')); ?>">รายงานอบรมวิชาชีพ</a></h3>
                </li>
                <li>
                    <h3><a href="<?php echo e(url('publicreport/hasincome')); ?>">รายงานติดตามผลอบรมวิชาชีพ(มีอาชีพ)</a></h3>
                </li>
                <li>
                    <h3><a href="<?php echo e(url('publicreport/enoughincome')); ?>">รายงานติดตามผลอบรมวิชาชีพ(รายได้เพียงพอ)</a></h3>
                </li>
            </ul>       
        </div>
    </div>



</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">
    $(".table").dataTable({
        "language": {
        "search": "ค้นหา "
        },
        "pageLength": 5
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.publicreport', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>