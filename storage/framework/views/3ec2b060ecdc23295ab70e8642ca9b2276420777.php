<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="padding-md">
    <h3 class="header-text m-bottom-md">
        โปรไฟล์ของฉัน
    </h3>
    <?php echo Form::open([ 'url' => 'setting/user/profile/edit' , 'method' => 'post' , 'files' => 'true' ]); ?> 
    <input type="hidden" value="<?php echo e($auth->user_id); ?>" name="userid">
    <input type="hidden" value="<?php if($auth->linenotify_id !=0): ?><?php echo e($auth->linenotify->linenotify_id); ?><?php endif; ?>" name="lineid">
    
    <div class="row user-profile-wrapper">
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
        <div class="col-md-3 user-profile-sidebar m-bottom-md">
            <div class="row">
                <div class="col-sm-4 col-md-12">
                    <div class="user-profile-pic">
                        <img src="<?php echo e(asset($auth->image)); ?>" alt="">
                        <div class="ribbon-wrapper">
                            <?php if($auth->permission == 1): ?>
                                <div class="ribbon-inner shadow-pulse bg-danger">
                            <?php endif; ?>
                            <?php if($auth->permission == 2): ?>
                                <div class="ribbon-inner shadow-pulse bg-info">
                            <?php endif; ?>
                            <?php if($auth->permission == 3): ?>
                                <div class="ribbon-inner shadow-pulse bg-success">
                            <?php endif; ?>
                                <?php echo e($auth->usertype); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-12">
                    <div class="user-name m-top-sm"><?php echo e($auth->name); ?><i class="fa fa-circle text-success m-left-xs font-14"></i></div>

                    <div class="m-top-sm">
                        <div>
                            <i class="fa fa-map-marker user-profile-icon"></i>
                            <?php echo e($location); ?>

                        </div>

                        <div class="m-top-xs">
                            <i class="fa fa-briefcase user-profile-icon"></i>
                            <?php echo e($auth->usertype); ?>

                        </div>
                    </div>

                    <div class="form-group" >
                        <input type="file" name="file" id="file" class="filestyle" >
                    </div> 

                </div>
            </div><!-- ./row -->
        </div><!-- ./col -->
        <div class="col-md-9">
            <div class="smart-widget">
                <div class="smart-widget-inner">
                    <ul class="nav nav-tabs tab-style2 tab-right bg-grey">
		
                          <li>
                              <a href="#profileTab2" data-toggle="tab">
                                  <span class="icon-wrapper"><i class="fa fa-book"></i></span>
                                  <span class="text-wrapper" style="font-size:22px">ข้อมูลส่วนตัว</span>
                              </a>
                          </li>
                          <li class="active">
                              <a href="#profileTab1" data-toggle="tab">
                                  <span class="icon-wrapper"><i class="fa fa-trophy"></i></span>
                                  <span class="text-wrapper" style="font-size:22px">ข้อความระบบ</span>
                              </a>
                          </li>
                    </ul>
                    <div class="smart-widget-body">
                        <div class="tab-content ">
                            <div class="tab-pane fade in active" id="profileTab1">
                                <h3 class="header-text m-bottom-md">
                                    ข้อความระบบ
                                </h3>
                                <div class="row">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th >วันที่</th>
                                                <th >ข้อความ</th>
                                                <th >รายละเอียด</th>
                                                <th class="text-center" style="width:100px">สถานะ</th>
                                                <th class="text-center" style="width:200px"><a href="<?php echo e(url('setting/user/profile/makereadall/')); ?>" class="text-success"> <small>อ่านทั้งหมด </small> </a><a href="<?php echo e(url('setting/user/profile/deleteall/')); ?>" class="text-warning"> <small>ลบทั้งหมด</small> </a></th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if( count($notifymessage) > 0 ): ?>
                                            <?php $__currentLoopData = $notifymessage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php 
                                               if ($item->message_read == 1  ){
                                                    $status ="อ่านแล้ว";
                                               }else{
                                                    $status ="ยังไม่ได้อ่าน";
                                               }
                                             ?>
                                                <tr>
                                                    <td><?php echo e($item->senddate); ?></td>
                                                    <td ><?php echo e($item->message_title); ?></td>
                                                    <td ><?php echo e($item->message_content); ?></td>
                                                    <td class="text-center">                    
                                                        <?php if($item->message_read == 1 ): ?> <span>อ่านแล้ว</span> <?php else: ?> <span class="text-warning">ยังไม่ได้อ่าน</span>  <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if($item->message_read == 0): ?>
                                                            <a href="<?php echo e(url('setting/user/profile/makeread/'.$item->notify_message_id)); ?>" class="btn btn-xs btn-warning">มาร์คอ่าน</a>
                                                            <?php else: ?>
                                                            <a href="<?php echo e(url('setting/user/profile/deletemessage/'.$item->notify_message_id)); ?>" class="btn btn-xs btn-danger">ลบข้อความ</a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>

                                    <?php echo e($notifymessage->links()); ?>


                                    
                                </div><!-- ./row -->

                                
                            </div><!-- ./tab-pane -->


                            <div class="tab-pane fade" id="profileTab2">
                                <h3 class="header-text m-bottom-md">
                                    ข้อมูลส่วนตัว
                                </h3>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ชื่อ-สกุล</label>
                                            <input type="text" name="name" class="form-control" value="<?php echo e($auth->name); ?>" required />
                                    
                                            <label>ยูสเซอร์เนม</label>
                                            <input type="text" name="username" class="form-control" value="<?php echo e($auth->username); ?>" required disabled />
                                    
                                            <label>รหัสผ่าน</label>
                                            <input type="text" name="pass" class="form-control" required />

                                            <label>หน่วยงาน</label>
                                            <input type="text" name="section" class="form-control" value="<?php echo e($location); ?>" disabled />
                                    
                                            <label>ตำแหน่ง</label>
                                            <input type="text" name="position" class="form-control" value="<?php echo e($auth->position); ?>"  />
                                    
                                            <label>Line Notify URL</label>
                                            <?php 
                                                $check = $linenotify->where('user_id',$auth->user_id)->first();
                                                if(!empty($check )){
                                                    $url= $check->url;
                                                    $token = $check->linetoken;
                                                }else{
                                                    $url ="";
                                                    $token="";
                                                }
                                             ?>
                                            <input type="text" name="linenotify" class="form-control" value="<?php echo e($url); ?>" />
                                    
                                            <label>Line Token</label>
                                            <input type="text" name="linetoken" class="form-control" value="<?php echo e($token); ?>" />
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row ">
                                    <div class="col-md-12">
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>


</div><!-- ./padding-md -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>

<script type="text/javascript">
    $('#file').filestyle({
    buttonName : 'btn-success',
    buttonText : ' เลือกรูป',
    input: false,
    icon: false,
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>