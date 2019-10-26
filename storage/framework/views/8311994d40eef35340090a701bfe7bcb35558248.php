<?php $__env->startSection('blogcontent'); ?>

<div class="row">
        <div class="col-md-9">
            <div class="blog-wrapper">
                    <?php if( count($new) > 0 ): ?>
                    <?php $__currentLoopData = $new; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="blog-list">
                                <div class="blog-header clearfix m-bottom-md">
                                    <div class="blog-date" style="font-size:30px;line-height:90%" >
                                        <?php echo e($item->thaiday); ?><br/>
                                        <div class="blog-month" style="font-size:22px" ><?php echo e($item->thaishortdate); ?></div>
                                    </div>
                                    <div class="blog-title">
                                        <div class="text-upper" style="font-size:28px"><?php echo e($item->information_title); ?></div>
                                        <div class="text-muted font-20">
                                            โดย <a href="#">กรมคุมประพฤติ</a>
                                            หมวด <a href="#">ข่าวประชาสัมพันธ์</a>
                                            <span class="m-left-xs m-right-xs">|</span>
                                        </div>
                                    </div>
                                </div><!-- ./blog-header -->
            
                                <div class="text-center">
                                        <img src="<?php echo e(asset($item->information_cover)); ?>" with="400" height="250" >
                                </div>
            
                                <p class="blog-content-lg text-center" style="font-size:22px; margin-top: 20px">
                                       <?php echo e($item->information_description); ?>

                                </p>

                                <div class="m-top-md text-center">
										<a href="<?php echo e(url('landing/blog/'.$item->information_id)); ?>" class="btn btn-danger text-upper">อ่านต่อ</a>
									</div>
     
                            </div><!-- ./blog-list -->
            
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

            </div><!-- ./blog-wrapper -->
        </div><!-- ./col -->

        <div class="col-md-3 pull-right">
            <?php echo Form::open([ 'url' => 'landing/searchblog' , 'method' => 'post' , 'files' => 'true' ]); ?> 
                <div class="form-group">
                    <input type="text" name="search" class="form-control" placeholder="ค้นหา...">
                </div><!-- /form-group -->
                
                
            <?php echo Form::close(); ?>

        </div>

        <div class="col-md-3">
            <hr/>
            <h4 style="font-size:24px">ข่าวล่าสุด</h4>
            <ul class="popular-blog-post">
                <?php $__currentLoopData = $update; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="clearfix" style="line-height:50%">
                        <div class="img-wrapper clearfix">
                            <img src="../<?php echo e($item->information_cover); ?>" alt="">
                        </div>
                        <div class="popular-blog-detail" style="line-height:50%">
                                <a href="<?php echo e(url('landing/blog/'.$item->information_id)); ?>" class="h5" style="font-size:20px"><?php echo e($item->information_title); ?></a>
                            <div class="text-muted m-top-sm"><?php echo e($item->thaiday); ?> <?php echo e($item->thaishortdate); ?></div>
                        </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div><!-- ./col -->
    </div>
                
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.singleblog', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>