<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
    	<meta charset="utf-8">
    	<title>กรมคุมประพฤติ</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="">
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo e(asset('assets/css/font-awesome.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/css/ionicons.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/css/owl.carousel.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/css/owl.theme.default.min.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/css/style.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/css/rs-plugin/css/settings.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/css/extralayers.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('assets/css/simplify.css')); ?>" rel="stylesheet"> 
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">  
       
        <style>
            .mySlides {display:none}
            .w3-left, .w3-right, .w3-badge {cursor:pointer}
            .w3-badge {height:13px;width:13px;padding:0}
      
            .featured {
                height: 150px;
                width: 250px;
            }
            .header {
                font-family: THSarabunNew;
                font-size: 28px;
            }

            .featuretitle {
                margin-top:10px;
                font-family: THSarabunNew;
                font-size: 22px;
            }

            .carousel{

                margin-top: 20px;
            }
            .carousel .item{
                min-height: 350px; /* Prevent carousel from being distorted if for some reason image doesn't load */
            }
            .carousel .item img{
                margin: 0 auto; /* Align slide image horizontally center */
            }
            .bs-example{
                margin: 20px;
            }                  


        </style>

        <?php $__env->startSection('pageCss'); ?>
        <?php echo $__env->yieldSection(); ?>
    </head>
    <body>

    <div class="wrapper front-end-wrapper">
            <header class="navbar front-end-navbar" data-spy="affix" data-offset-top="1">
                <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a href="<?php echo e(url('landing')); ?>" class="navbar-brand"><strong><span class="text-success" style="font-family: THSarabunNew;font-size: 32px">คืนคนดีสู่สังคม</span></strong></a>
                </div>
                <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
                    <ul class="nav navbar-nav">
                    <li>
                        <a href="<?php echo e(url('landing/blog')); ?>" style="font-family: THSarabunNew;font-size: 26px">ข่าวประชาสัมพันธ์</a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('publicreport/report')); ?>" style="font-family: THSarabunNew;font-size: 26px">รายงานโครงการ</a>
                    </li>

                    <?php if( !empty($generalsetting)): ?>
                        <?php if($generalsetting->enable_onlinereg == 1): ?>
                        <li>
                            <a href="<?php echo e(url('landing/register')); ?>" style="font-family: THSarabunNew;font-size: 26px">สมัครงาน</a>
                        </li>
                        <?php endif; ?> 
                    <?php endif; ?>
                    

                    

                    </ul>
                    <ul class="nav navbar-nav navbar-right  m-right-sm">

                      <?php if(count($auth) > 0): ?>
                        <li>
                            <a href="<?php echo e(url('/')); ?>">
                                <i class="fa fa-edit fa-lg"></i><span class="m-left-xs"><?php echo e($auth->name); ?></span>
                            </a>
                        </li>  
                            <li class="btn-link"><a href="<?php echo e(url('/')); ?>" class="btn btn-sm btn-danger" style="font-family: THSarabunNew;font-size: 22px">แดชบอร์ด</a></li>
                        <?php else: ?>
                            <li class="btn-link"><a href="<?php echo e(url('/')); ?>" class="btn btn-sm btn-success" style="font-family: THSarabunNew;font-size: 22px">เข้าสู่ระบบ</a></li>
                      <?php endif; ?>

                    </ul>
                </nav>

            </header>

            <div class="tp-banner-container" >
                <div class="bs-example">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php if( count($picture) > 0 ): ?>
                                <?php $__currentLoopData = $picture; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($key == 0): ?>
                                        <li data-target="#myCarousel" data-slide-to="<?php echo e($key); ?>" class="active"></li>
                                    <?php else: ?>
                                        <li data-target="#myCarousel" data-slide-to="<?php echo e($key); ?>" ></li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </ol>   
                        <div class="carousel-inner">
                            <?php if( count($picture) > 0 ): ?>
                                <?php $__currentLoopData = $picture; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($key == 0): ?>
                                            <div class="item active">
                                                <img src="<?php echo e(asset($item->landingpicture)); ?>" >
                                            </div>
                                        <?php else: ?>
                                            <div class="item">
                                                <img src="<?php echo e(asset($item->landingpicture)); ?>" >
                                            </div>
                                        <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <a class="carousel-control left" href="#myCarousel" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="carousel-control right" href="#myCarousel" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>
            </div>	<!-- ./tp-banner-container -->
            <div class="section bg-white section-padding" >
                <div class="container" style="margin-top:-30px;" >
                    <div class="row" >
                        <div class="col-md-4 text-center" >      
                        </div>
                        <div class="col-md-4 offset-md-4 text-center" style="background-color: #2baab1 ;border-radius: 28px;">
                            <span style="font-family: THSarabunNew;font-size: 40px;color: white" class="text-upper no-m-top" >ข่าวประชาสัมพันธ์<span class="text-success"></span></span>
                        </div>
                    </div>
                    <?php echo $__env->yieldContent('landingcontent'); ?>
                </div>
            </div>

        <?php echo $__env->yieldContent('buttomcontent'); ?>

            <footer class="front-end-footer" style="font-family: THSarabunNew; line-height: 120%">
                <div class="container" >
                    <div class="row">
                        <div class="col-md-4">
                            <h4>กรมคุมประพฤติ</h4>
                            <div  style="font-size: 18px">   
                                <strong>กระทรวงยุติธรรม ศูนย์ราชการเฉลิมพระเกียรติ 80 พรรษา 5 ธันวาคม 2550</strong><br>
                                อาคารราชบุรีดิเรกฤทธิ์ ชั้น 4,6 เลขที่ 120<br>
                                ถนนแจ้งวัฒนะ แขวงทุ่งสองห้อง เขตหลักสี่ กทม.10210<br>
                                <div class="seperator"></div>
                                <strong>โทร : <span class="theme-font">0 2141 4749</span></strong><br>
                                <strong>อีเมลล์ : <span class="theme-font">prprobation@gmail.com</span></strong><br>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-md-4">
                            <h4>กรมราชทัณฑ์</h4>
                            <div style="font-size: 18px">
                                222 ถนนนนทบุรี 1 ตำบลสวนใหญ่ อำเภอเมือง จังหวัดนนทบุรี 11000
                                <div class="seperator"></div>
                                <strong>โทร : <span class="theme-font"></span></strong><br>
                                <strong>อีเมลล์ : <span class="theme-font"></span></strong><br>  
                            </div>
                        </div><!-- ./col -->
                        <div class="col-md-4">
                            <h4>กรมพินิจและคุ้มครองเด็ก</h4>
                            <div style="font-size: 18px">
                                <strong>ศูนย์ราชการเฉลิมพระเกียรติ อาคารราชบุรีดิเรกฤทธิ์ (อาคารเอ ชั้น 5)</strong><br>
                                    เลขที่ 120 หมู่ 3 ถนนแจ้งวัฒนะ แขวงทุ่งสองห้อง<br>
                                    เขตหลักสี่ กรุงเทพมหานคร 10210<br>
                                <div class="seperator"></div>
                                <strong>โทร : <span class="theme-font"></span>02 2141 6470</strong><br>
                                <strong>อีเมลล์ : <span class="theme-font"></span></strong><br>  
                            </div>
                        </div><!-- ./col -->
                    </div><!-- ./row -->
                </div><!-- ./container -->
            </footer>

            <a href="#" class="scroll-to-top hidden-print"><i class="fa fa-chevron-up fa-lg"></i></a>
        </div><!-- /wrapper -->


        <a href="#" class="scroll-to-top hidden-print"><i class="fa fa-chevron-up fa-lg"></i></a>

        <script src="<?php echo e(asset('assets/js/jquery-1.11.1.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/bootstrap/js/bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/modernizr.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/owl.carousel.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/waypoints.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/jquery.scrollTo.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/jquery.localScroll.min.js')); ?>"></script>

        
        
        

        <script src="<?php echo e(asset('assets/js/jquery.themepunch.tools.min.js')); ?>"></script>

        <script src="<?php echo e(asset('assets/js/jquery.themepunch.revolution.min.js')); ?>"></script>
    
        <?php $__env->startSection('pageScript'); ?>
        <?php echo $__env->yieldSection(); ?>

        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>


<script type="text/javascript">

    jQuery(document).ready(function() {		
        //Slider Revolution	
        jQuery('.tp-banner').show().revolution(
        {
            dottedOverlay:"none",
            delay:16000,
            startwidth:1170,
            startheight:700,
            hideThumbs:200,
            
            thumbWidth:100,
            thumbHeight:50,
            thumbAmount:5,
            
            navigationType:"bullet",
            navigationArrows:"solo",
            navigationStyle:"preview4",
            
            touchenabled:"on",
            onHoverStop:"on",
            
            swipe_velocity: 0.7,
            swipe_min_touches: 1,
            swipe_max_touches: 1,
            drag_block_vertical: false,
                                    
            parallax:"mouse",
            parallaxBgFreeze:"on",
            parallaxLevels:[7,4,3,2,5,4,3,2,1,0],
                                    
            keyboardNavigation:"off",
            
            navigationStyle: "preview2",
            navigationHAlign:"center",
            navigationVAlign:"middle",
            navigationHOffset:0,
            navigationVOffset:20,

            soloArrowLeftHalign:"left",
            soloArrowLeftValign:"center",
            soloArrowLeftHOffset:20,
            soloArrowLeftVOffset:0,

            soloArrowRightHalign:"right",
            soloArrowRightValign:"center",
            soloArrowRightHOffset:20,
            soloArrowRightVOffset:0,
                    
            shadow:0,
            fullWidth:"on",
            fullScreen:"off",

            spinner:"spinner4",
            
            stopLoop:"off",
            stopAfterLoops:-1,
            stopAtSlide:-1,

            shuffle:"off",
            
            autoHeight:"off",						
            forceFullWidth:"off",						
                                                
            hideThumbsOnMobile:"off",
            hideNavDelayOnMobile:1500,						
            hideBulletsOnMobile:"off",
            hideArrowsOnMobile:"off",
            hideThumbsUnderResolution:0,
            
            hideSliderAtLimit:0,
            hideCaptionAtLimit:0,
            hideAllCaptionAtLilmit:0,
            startWithSlide:0,
            fullScreenOffsetContainer: ".header"	
        });		
        //End Slider Revolution

        //Section Animation
        if (Modernizr.mq('(min-width: 1349px)')) {
            $('.animation-element').waypoint(function() {
                    $(this).removeClass('disabled');
            }, { offset: 700 });
        }
        else if (Modernizr.mq('(min-width: 992px)') && Modernizr.mq('(max-width: 1349px)')) {
            $('.animation-element').waypoint(function() {
                    $(this).removeClass('disabled');
            }, { offset: 550 });
        }
        else	{
            $('.animation-element').removeClass('disabled');
        }
    });	
    
</script>
        


    <!-- END SCRIPTS -->         
    </body>
</html>