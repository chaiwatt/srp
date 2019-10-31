<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title>คืนคนดีสู่สังคม</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="<?php echo e(asset('assets/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/css/font-awesome.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/css/ionicons.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/css/simplify.css')); ?>" rel="stylesheet">  
    </head>

    <body class="overflow-hidden light-background">
        <div class="wrapper no-navigation preload">
            <div class="sign-in-wrapper">
                <div class="sign-in-inner">
                    <div class="login-brand text-center" style="font-size:40px">
                        <i class="fa fa-database m-right-xs"></i> คืนคนดีสู่สังคม 
                    </div>

        <?php if( Session::has('error') ): ?>
        <div class="alert alert-danger alert-custom alert-dismissible" role="alert" style="font-size:20px">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <i class="fa fa-times-circle m-right-xs"></i> <?php echo e(Session::get('error')); ?>

        </div>
    <?php elseif( Session::has('success') ): ?>
        <div class="alert alert-success alert-custom alert-dismissible" role="alert" style="font-size:20px">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <i class="fa fa-check-circle m-right-xs"></i> <?php echo e(Session::get('success')); ?>

        </div>
    <?php endif; ?>



                    <?php echo Form::open([ 'url' => 'login' , 'method' => 'post' ]); ?>

                        <div class="form-group m-bottom-md">
                            <input type="text" name="username" class="form-control" placeholder="ยูสเซอร์เนม">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="รหัสผ่าน">
                        </div>
                        <div class="m-top-md p-top-sm">
                            <button  class="btn btn-success btn-block" style="font-size:24px">เข้าสู่ระบบ</button>
                        </div>
                    <?php echo Form::close(); ?>

                    <div class="text-center">
                            <a href="<?php echo e(url('landing')); ?>" class="text-success " style="font-size:24px">เข้าสู่หน้าเว็บไซต์</a>
                    </div>
                </div>
            </div>
        </div>

        <a href="#" id="scroll-to-top" class="hidden-print"><i class="icon-chevron-up"></i></a>

        <script src="<?php echo e(asset('assets/js/jquery-1.11.1.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/bootstrap/js/bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/jquery.slimscroll.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/jquery.popupoverlay.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/modernizr.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/simplify/simplify.js')); ?>"></script>
    </body>
</html>
