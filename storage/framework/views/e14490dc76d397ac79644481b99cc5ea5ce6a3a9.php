<?php $__env->startSection('pageCss'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('landingcontent'); ?>

    <div class="row" style="margin-top:50px;">
        <?php if(count($information) > 0): ?>
        <?php $__currentLoopData = $information; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-4 text-center">
                <div class="how-it-work-list fadeInRight animation-element disabled">
                    <img src="<?php echo e(asset($item->information_cover)); ?>" class="featured">
                    <h3 class="m-top-md text-upper header" style="font-size:25px"><?php echo e($item->information_title); ?></h3>
                    <p  class="featuretitle"><?php echo e($item->information_description); ?>...</p>
                    <a href="<?php echo e(url('landing/blog/' . $item->information_id )); ?>" class="btn btn-info btn-xs featuretitle"> เพิ่มเติม </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('buttomcontent'); ?>
    <div class="section bg-white section-padding " >
        <div class="container" style="margin-top:-80px; height: 315px;" >
            <div class="row" style="height: 315px;">
                <div class="<?php if(count($youtube) !=0 ): ?> col-md-6  <?php else: ?> col-md-12 <?php endif; ?>"  >                             
                    <div class="smart-widget" style="font-family: THSarabunNew;font-size: 26px">
                        <div class="smart-widget-inner">
                            <ul class="nav nav-tabs tab-style2">
                                <li class="active">
                                    <a href="#style2Tab1" data-toggle="tab">
                                        <span class="icon-wrapper"><i class="fa fa-bullhorn"></i></span>
                                        <span class="text-wrapper">ข่าวประชาสัมพันธ์</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#style2Tab2" data-toggle="tab">
                                        <span class="icon-wrapper"><i class="fa fa-book"></i></span>
                                        <span class="text-wrapper">ดาวน์โหลดเอกสาร</span>
                                    </a>
                                </li>
                            </ul>
   
                            <div class="smart-widget-body" style="font-family: THSarabunNew;font-size: 22px">
                                <div class="tab-content" style="height: 220px;">
                                    <div class="tab-pane fade in active" id="style2Tab1">
                                        <ul class="popular-blog-post">
                                            <?php $__currentLoopData = $new; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="clearfix" style="line-height:50%">
                                                    <div class="img-wrapper clearfix">
                                                        <img src="<?php echo e($item->information_cover); ?>"   style="height:45px" alt="">
                                                    </div>
                                                    <div class="popular-blog-detail" style="line-height:50%">
                                                            <a href="<?php echo e(url('landing/blog/'.$item->first()->information_id)); ?>" class="h5" style="font-size:20px"><?php echo e($item->information_title); ?></a>
                                                        <div class="text-muted m-top-sm"><?php echo e($item->first()->thaiday); ?> <?php echo e($item->first()->thaishortdate); ?></div>
                                                    </div>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <?php echo e($new->links()); ?>

                                    </div>
                                    <div class="tab-pane fade" id="style2Tab2">
                                        <ul style="margin-left:20px">
                                                <?php $__currentLoopData = $docdownload; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li >
                                                    <span><?php echo e($item->docdownload_desc); ?></span> <a href="<?php echo e(asset($item->docdownload_link)); ?>" class="text-success" target="_blank">ดาวน์โหลด</a>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <?php echo e($docdownload->links()); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
                <?php if(count($youtube) != 0): ?>
                <div class="col-md-6 text-center" >   
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo e($youtube->youtube_url); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>   
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.landing', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>