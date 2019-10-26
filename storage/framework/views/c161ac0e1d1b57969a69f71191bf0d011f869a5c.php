<?php $__env->startSection('pageCss'); ?>
<style>
.showvideo {
            width: 100%; 
            width: 100%;
            height:auto;
}

</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(route('videolist.index')); ?>">วีดีโอสอนใช้งาน</a></li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                วีดีโอสอนใช้งาน: <?php echo e($video->video_desc); ?>

            </div>
        </div>
    </div>
</div>


    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"><?php echo e($video->video_desc); ?> </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">           
                    <video controls class="showvideo">
                        <source src="<?php echo e(asset($video->video)); ?>" type="video/mp4">
                        
                      Your browser does not support the video tag.
                      </video>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">
    // var $video  = $('video'),
    // $window = $(window); 

    // $(window).resize(function(){
        
    //     var height = $window.height();
    //     $video.css('height', height);
        
    //     var videoWidth = $video.width(),
    //         windowWidth = $window.width(),
    //     marginLeftAdjust =   (windowWidth - videoWidth) / 2;
        
    //     $video.css({
    //         'height': height, 
    //         'marginLeft' : marginLeftAdjust
    //     });
    // }).resize();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>