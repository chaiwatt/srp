<?php $__env->startSection('pageCss'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo Form::open([ 'url' => 'readiness/project/section/manage' , 'method' => 'post' , 'files' => 'true' ]); ?> 
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="<?php echo e(url('landing')); ?>">หน้าเว็บไซต์</a></li>
        <li><a href="<?php echo e(url('readiness/project/section/list')); ?>">โครงการฝึกอบรมเตรียมความพร้อม</a></li>
        <li>บันทึกข้อมูล โครงการฝึกอบรมเตรียมความพร้อม</li>    
    </ul>

    
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                บันทึกข้อมูล โครงการฝึกอบรมเตรียมความพร้อม
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <input type="hidden" name="id" value="<?php echo e($readiness->project_readiness_id); ?>" />
                <input type="hidden" name="readiness_section_id" value="<?php echo e($readiness->readiness_section_id); ?>" />
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="register">
    <div class="modal-dialog">
      <div class="modal-content" >
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title" style="font-size: 22px">เพิ่มรายชื่อใหม่</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>คำนำหน้า </label>
                            <select class="form-control" id="register_prefix"  required="" >
                                <?php if(count($prefix) > 0): ?>
                                    <?php $__currentLoopData = $prefix; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->prefix_id); ?>"><?php echo e($item->prefix_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>ชื่อ</label>
                            <input type="text" id="register_name" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>สกุล</label>
                            <input type="text" id="register_lastname" class="form-control" value="" />
                        </div>
                    </div>
                </div>                       
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>เลขบัตรประชาชน</label>
                            <input type="text" id="register_personid" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>กลุ่ม </label>
                            <select class="form-control" id="register_group"  required="" >
                                <?php if(count($group) > 0): ?>
                                    <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->group_id); ?>"><?php echo e($item->group_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>สำนักงาน </label>
                            <select class="form-control" id="register_section"  required="" >
                                <?php if(count($section) > 0): ?>
                                    <?php $__currentLoopData = $section; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->section_id); ?>"><?php echo e($item->section_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>                         
            </div>
            <div class="modal-footer">
              <a id ="btnaddregister"  class="btn btn-primary">เพิ่มรายชื่อ</a>
            </div>
      </div>
    </div>
</div>



    <div class="row padding-md">
        <div class="col-md-12">
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
            
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">
                    โครงการ: <?php echo e($readiness->projectreadinessname); ?> 
                </div>
                <div class="smart-widget-inner">
                    <div class="widget-tab clearfix">
                        <ul class="tab-bar">
                            <li class="active"><a href="#style3Tab1" data-toggle="tab"><i class="fa fa-list"></i> รายละเอียดโครงการ</a></li>
                            <li class=""><a href="#style3Tab2" data-toggle="tab"><i class="fa fa-picture-o"></i> รายการผู้เข้าร่วมโครงการ</a></li>
                            <li class=""><a href="#style3Tab3" data-toggle="tab"><i class="fa fa-picture-o"></i> สรุปจำนวนผู้เข้าร่วมโครงการ</a></li>
                            <li class=""><a href="#style3Tab4" data-toggle="tab"><i class="fa fa-picture-o"></i> เพิ่มวิทยากร</a></li>
                            <li class=""><a href="#style3Tab5" data-toggle="tab"><i class="fa fa-picture-o"></i> เพิ่มเจ้าหน้าที่</a></li>
                            <li class=""><a href="#style3Tab6" data-toggle="tab"><i class="fa fa-picture-o"></i> สถานประกอบการ</a></li>
                            <li class=""><a href="#style3Tab7" data-toggle="tab"><i class="fa fa-picture-o"></i> เพิ่มเติม</a></li>
                            <li class=""><a href="#styleTab_attachment" data-toggle="tab"><i class="fa fa-picture-o"></i> เอกสารแนบ</a></li>
                        </ul>
                    </div>
                    <div class="smart-widget-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="style3Tab1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>วันที่จัดโครงการ </label>
                                            <div id="projectdate"  class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                                <input type="text" class="form-control" name="projectdate" autocomplete="off" required="">
                                                <span class="add-on"><i class="icon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>กรอบเป้าหมายผู้เข้าร่วมโครงการ</label>
                                                <input type="number" min="0"  name="number" value="<?php echo e($readiness->projectreadinesstarget); ?>" class="form-control" required="" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label>งบประมาณ</label>
                                                <input type="number" min="0" name="budget" value="<?php echo e($readiness->budget); ?>" class="form-control" required="" readonly>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>เบิกจ่ายจริง</label>
                                                <input type="number" min="0" name="actualexpense" value="<?php echo e($readiness->actualexpense); ?>" class="form-control" required="" >
                                            </div>
                                        </div>
                                    </div>                            
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>รายละเอียดโครงการ</label>
                                                <textarea class="form-control" name="detail" required="" disabled><?php echo e($readiness->projectdesc); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>  

                                <div class="tab-pane fade" id="style3Tab2">
                                    <div class="row ">
                                        <div class="col-md-12 input_participategroup">          
                                            <div class="form-group">
                                                <label>หมายเลขบัตรประชาชน <a id="addnewregister" class="text-info"> เพิ่มรายชื่อใหม่</a></label>
                                                <input type="text" name="person_id" id="person_id" class="form-control" />
                                                <span class="help-block text-danger" id="response_person_id"></span>
                                            </div>
                                                                     
                                            <button type="button" class="btn btn-success add_participategroup"> <i class="fa fa-plus"></i> เพิ่มผู้เข้าร่วมโครงการ</button>
                                            <button type="button" class="btn btn-danger remove_participategroup"><i class="fa fa-times"></i> ลบผู้เข้าร่วมโครงการ</button>
                                            <hr>
                                            <?php if( count( $participategroup ) > 0 ): ?>
                                                <?php $__currentLoopData = $participategroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php 
                                                        $_register =  $register->where('register_id',$item->register_id)->first();
                                                        $p = $prefix->where('prefix_id',$_register->prefix_id)->first()->prefix_name;
                                                        $name = $p . $_register->name . " " . $_register->lastname ;

                                                        $_section = $section->where('section_id',$_register->section_id)->first()->section_name;

                                                        $check = $group->where('group_id',$_register->group_id)->first();
                                                        if(!empty($check)){
                                                            $_group = $group->where('group_id',$_register->group_id)->first()->group_name;
                                                        }else{
                                                            $_group ="";
                                                        }                                                        
                                                        $_status = $participategroup->where('register_id',$item->register_id)->first();

                                                     ?>
                                                    <?php if( $key == 0 ): ?>
                                                        <div class="row remove_group1">
                                                    <?php else: ?>
                                                        <div class="row remove_group<?php echo e($key + 1); ?>">
                                                    <?php endif; ?>
                                                            <div class="col-md-12">
                                                                    <input type="hidden" name="participategroup_id[]" class="form-control" value="<?php echo e($item->register_id); ?>" />
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>ชื่อ-สกุล</label>
                                                                        <input type="text" name="participategroup_name[]" class="form-control" value="<?php echo e($name); ?>" />
                                                                    </div>
                                                                </div>
    
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>หมายเลขบัตรประชาชน</label>
                                                                        <input type="text" name="participategroup_hid[]" class="form-control" value="<?php echo e($_register->person_id); ?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label>หน่วยงาน</label>
                                                                        <input type="text" name="participategroup_section[]" class="form-control" value="<?php echo e($_section); ?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label>กลุ่ม</label>
                                                                        <input type="text" name="participate_group[]" class="form-control" value="<?php echo e($_group); ?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label>จบหลักสูตร</label>                                                                        
                                                                            <select class="form-control" name="status[]" >
                                                                                <?php if( count($status) > 0 ): ?>
                                                                                    <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                                                      
                                                                                        <option value="<?php echo e($item->trainning_status_id); ?>" <?php if($item->trainning_status_id == $_status->trainning_status_id ): ?> selected <?php endif; ?> ><?php echo e($item->trainning_status_name); ?></option>                                             
                                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                                                                <?php endif; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </div> 
                                        
                                    </div>
                                
                            </div>                           
                            <div class="tab-pane fade" id="style3Tab3">
                            <div class="row">
                                <?php if( count($participate) > 0 ): ?>
                                    <?php $__currentLoopData = $participate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php ( $value = $reparticipate->where('participate_id' , $item->participate_id)->first() ); ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?php echo e($item->participate_position); ?></label>
                                            <?php if( count($value) > 0 ): ?>
                                            <input type="number" min="0" max="99" step="1" name="participate[<?php echo e($item->participate_id); ?>]" class="form-control" required="" value="<?php echo e($value->participate_num); ?>" />
                                            <?php else: ?>
                                            <input type="number" min="0" max="99" step="1" value="0" name="participate[<?php echo e($item->participate_id); ?>]" class="form-control" required="" />
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                            </div>
                            <div class="tab-pane fade" id="style3Tab4">
                                <div class="row ">
                                    <div class="col-md-12 input_trainer"> 
                                        <button type="button" class="btn btn-success add_trainer"> <i class="fa fa-plus"></i> เพิ่มวิทยากร</button>
                                        <button type="button" class="btn btn-danger remove_trainer"><i class="fa fa-times"></i> ลบวิทยากร</button>
                                        <hr>
                                        <?php if( count( $trainer ) > 0 ): ?>
                                            <?php $__currentLoopData = $trainer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if( $key == 0 ): ?>
                                                    <div class="row">
                                                <?php else: ?>
                                                    <div class="row removetrainer<?php echo e($key + 1); ?>">
                                                <?php endif; ?>
                                                        <div class="col-md-12">
                                                            <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>ชื่อ-สกุล</label>
                                                                        <input type="text" name="trainer[]" class="form-control" value="<?php echo e($item->trainer_name); ?>" />
                                                                    </div>
                                                                </div>

                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>ตำแหน่ง</label>
                                                                    <input type="text" name="trainerposition[]" class="form-control" value="<?php echo e($item->trainer_position); ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>หน่วยงาน</label>
                                                                    <input type="text" name="trainercompany[]" class="form-control" value="<?php echo e($item->company); ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>หลักสูตร/วิชา</label>
                                                                    <input type="text" name="course[]" class="form-control" value="<?php echo e($item->course); ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>ข้อสังเกต</label>
                                                                    <input type="text" name="notice[]" class="form-control" value="<?php echo e($item->notice); ?>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="tab-pane fade" id="style3Tab5">
                                <div class="row ">
                                    <div class="col-md-12 input_authority"> 
                                        <button type="button" class="btn btn-success add_authority"> <i class="fa fa-plus"></i> เพิ่มเจ้าหน้าที่</button>
                                        <button type="button" class="btn btn-danger remove_authority"><i class="fa fa-times"></i> ลบเจ้าหน้าที่</button>
                                        <hr>
                                        <?php if( count( $officer ) > 0 ): ?>
                                            <?php $__currentLoopData = $officer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if( $key == 0 ): ?>
                                                    <div class="row removeauthority1">
                                                <?php else: ?>
                                                    <div class="row removeauthority<?php echo e($key + 1); ?>">
                                                <?php endif; ?>
                                                        <div class="col-md-12">
                                                            <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>ชื่อ-สกุล</label>
                                                                        <input type="text" name="authority[]" class="form-control" value="<?php echo e($item->officer_name); ?>" />
                                                                    </div>
                                                                </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>ตำแหน่ง</label>
                                                                    <input type="text" name="authority_position[]" class="form-control" value="<?php echo e($item->officer_position); ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>หน่วยงาน</label>
                                                                    <input type="text" name="authority_company[]" class="form-control" value="<?php echo e($item->officer_company); ?>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                   
                                </div>
                            </div>

                            <div class="tab-pane fade" id="style3Tab6">
                                <div class="row ">
                                    <div class="col-md-12 input_company"> 
                                        <button type="button" class="btn btn-success add_company"> <i class="fa fa-plus"></i> เพิ่มสถานประกอบการเข้าร่วม</button>
                                        <button type="button" class="btn btn-danger remove_company"><i class="fa fa-times"></i> ลบสถานประกอบการเข้าร่วม</button>
                                        <hr>
                                        <?php if( count( $company ) > 0 ): ?>
                                            <?php $__currentLoopData = $company; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if( $key == 0 ): ?>
                                                <div class="row removecompany1">
                                            <?php else: ?>
                                                <div class="row removecompany<?php echo e($key + 1); ?>">
                                            <?php endif; ?>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>สถานประกอบการ</label>
                                                            <input type="text" name="company[]" class="form-control" value="<?php echo e($item->company_name); ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="tab-pane fade" id="style3Tab7">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ปัญหา/อุปสรรค</label>
                                        <textarea class="form-control" name="problem" ><?php echo e($readiness->problemdesc); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ข้อเสนอแนะ</label>
                                        <textarea class="form-control" name="suggestion" ><?php echo e($readiness->recommenddesc); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="tab-pane fade" id="styleTab_attachment">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label>เอกสารแนบ <span class="text-danger">*แนบไฟล์ เช่น pdf,word,excel,zip,rar,ไฟล์รูป</span></label>
                                        <input type="file" name="document[]"  id="doc" class="filestyle" multiple="" />
                                    </div>
                                </div>
    
                                <br />
                                <div class="table">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ชื่อไฟล์</th>
                                                <th>ดาวน์โหลด</th>
                                                <th>เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if( count($readinesssectiondocument) > 0 ): ?>
                                            <?php $__currentLoopData = $readinesssectiondocument; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($item->document_name); ?></td>
                                                <td><a href="<?php echo e(asset($item->document_file)); ?>" class="btn btn-info text-right" target="_blank"> <i class="fa fa-download"></i> ดาวน์โหลด</a> </td>
                                                <td><a href="<?php echo e(url('readiness/project/section/deletefile/'.$item->readiness_section_document_id)); ?>" class="btn btn-danger text-right"><i class="fa fa-remove"></i> ลบ</a> </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>




<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageScript'); ?>
<script type="text/javascript">

    $(document).on('click', '#addnewregister', function(e){
        e.preventDefault();

        $('#register').modal('show');

    }); 

    $('#doc').filestyle({
        buttonName : 'btn-success',
        buttonText : ' เลือกไฟล์',
        // input: false,
        icon: false,
    });

    $("#btnaddregister").click(function(){
            $(function(){
                $.ajax({
                    type:"get",
                    url:"<?php echo e(url('readiness/project/section/register')); ?>",
                    dataType:"Html",
                    data:{
                        section : document.getElementById("register_section").value,
                        prefix : document.getElementById("register_prefix").value,
                        name : document.getElementById("register_name").value,
                        lastname : document.getElementById("register_lastname").value,
                        personid : document.getElementById("register_personid").value,
                        group : document.getElementById("register_group").value,
                    },
                    success : function(data){
                        if(data != ""){
                            $('#register').modal('hide');
                            alert(data);

                        }
                    }
                })
            })
    })

    $('#projectdate').datepicker({
        format: 'dd/mm/yyyy',
        todayBtn: true,
        language: 'th',   
        thaiyear: true              
    }).datepicker("setDate", "<?php echo e($readiness->helddateinput); ?>");  

    registerid=null;
    registername=null;
    registerprefix=null;
    registersectionname=null;
    registergroup =null;
    registercid =null;
    $("#person_id").change(function(){
        $.ajax({
            type:"get",
            url:"<?php echo e(url('api/check-person')); ?>",
            dataType:"Json",
            data:{
                person_id : $("#person_id").val(),
                department_id : "<?php echo e($department->department_id); ?>",
            },
            success : function(data){
                    if(data.row > 0){
                        for(var i=0;i<data.row;i++){
                            $("#response_person_id").text(data.register[i].name + "  " + data.register[i].lastname) ;
                            registerid = data.register[i].register_id;
                            registersectionname = data.customdata[i].section_name;
                            registername =  data.customdata[i].prefix + data.register[i].name + "  " + data.register[i].lastname;
                            registergroup = data.customdata[i].group_name;
                            registercid =  data.register[i].person_id ;
                        }
                    }else{
                        $("#response_person_id").text('ไม่พบข้อมูลผู้สมัคร โปรดเพิ่มรายชื่อใหม่');
                    }
            }
        })
    })


    $(".remove_participategroup").prop("disabled",false);
        var max_participategroup  = 200; //maximum input boxes allowed
        var wrapper_participategroup  = $(".input_participategroup"); //Fields wrapper
        var add_participategroup  = $(".add_participategroup"); //Add button ID
        var html_participategroup = "";
        var number_participategroup = $('input[name="participategroup_id[]"]').length ; //1 ; //initlal text box count
        $(add_participategroup).click(function(e){ //on add input button click
            if(number_participategroup < max_participategroup){ //max input box allowed
                if(registerid != null){
                    number_participategroup++; //text box increment
                    html_participategroup =  "<div class='row remove_group"+number_participategroup+"'>";
                    html_participategroup += "<div class='col-md-12'>";
                    html_participategroup += "<input type='hidden' name='participategroup_id[]' value='"+registerid+"' class='form-control'  />";
                    html_participategroup += "<div class='col-md-3'>";
                    html_participategroup += "<div class='form-group'>";
                    html_participategroup += "<label>ชื่อ-สกุล</label>";
                    html_participategroup += "<input type='text' name='participategroup_name[]' value='"+registername+"' class='form-control'/>";
                    html_participategroup += "</div>";
                    html_participategroup += "</div>";
                    html_participategroup += "<div class='col-md-3'>";
                    html_participategroup += "<div class='form-group'>";
                    html_participategroup += "<label>บัตรประชาชน</label>";
                    html_participategroup += "<input type='text' name='participategroup_hid[]' value='"+registercid+"' class='form-control'/>";
                    html_participategroup += "</div>";
                    html_participategroup += "</div>";
                    html_participategroup += "<div class='col-md-2'>";
                    html_participategroup += "<div class='form-group'>";
                    html_participategroup += "<label>หน่วยงาน</label>";
                    html_participategroup += "<input type='text' name='participategroup_section[]' value='"+registersectionname+"'  class='form-control'/>";
                    html_participategroup += "</div>";
                    html_participategroup += "</div>";
                    html_participategroup += "<div class='col-md-2'>";
                    html_participategroup += "<div class='form-group'>";
                    html_participategroup += "<label>กลุ่ม</label>";
                    html_participategroup += "<input type='text' name='participate_group[]'  value='"+registergroup+"' class='form-control' />";
                    html_participategroup += "</div>";
                    html_participategroup += "</div>";
                    html_participategroup += "<div class='col-md-2'>";
                    html_participategroup += "<div class='form-group'>";
                    html_participategroup += "<label>จบหลักสูตร</label>";
                    html_participategroup += "<select class='form-control' name='status[]'><option value='0' seclected>จบ</option><option value='1'>ไม่จบ</option></select>";
                    html_participategroup += "</div>";
                    html_participategroup += "</div>";
                    html_participategroup += "</div>";
                    html_participategroup += "</div>";

                    $(wrapper_participategroup).append(html_participategroup); //add input box
                    $('.datepicker').datepicker({
                        language: 'th',
                        format : "dd/mm/yyyy",
                        thaiyear: true,
                        autoclose:false,
                    });

                registerid=null;
                registername=null;
                registerprefix=null;
                registersectionname=null;
                registergroup =null;
                registercid =null;
            }
        }
            if( number_participategroup > 1 ){
                $(".remove_participategroup").prop("disabled",false);
            }

            if( number_participategroup == 200 ){
                $(add_participategroup).prop("disabled" , true);
            }
        });
        
        $(".remove_participategroup").click(function(){
            if( number_participategroup > 0 ){
                index=$('input[name="participategroup_id[]"]').length;
                var names=document.getElementsByName('participategroup_id[]');
                regid = names[index-1].value;
                $(".remove_group"+number_participategroup).remove(); number_participategroup--;
                $(add_participategroup).prop("disabled" , false);
                $(function(){
                    $.ajax({
                        type:"get",
                        url:"<?php echo e(url('api/deleteparticipate')); ?>",
                        dataType:"Html",
                        data:{
                            register_id : regid,
                            readiness_id : "<?php echo e($readiness->project_readiness_id); ?>",
                            readiness_section_id : "<?php echo e($readiness->readiness_section_id); ?>",
                            project_type : "<?php echo e($readiness->project_type); ?>",
                        },
                        success : function(data){
                            if(data != ""){
                                alert(data);
                            }
                        }
                    })
                })
            }
    })    

    //tab 4
    $(".remove_trainer").prop("disabled",false);
        var max_trainer  = 20; //maximum input boxes allowed
        var wrapper_trainer  = $(".input_trainer"); //Fields wrapper
        var add_trainer      = $(".add_trainer"); //Add button ID
        var html_trainer = "";
        var number_trainer = $('input[name="trainer[]"]').length ;  //initlal text box count
        $(add_trainer).click(function(e){ //on add input button click
            if(number_trainer < max_trainer){ //max input box allowed
                number_trainer++; //text box increment
                html_trainer =  "<div class='row removetrainer"+number_trainer+"'>";
                html_trainer += "<div class='col-md-12'>";
                html_trainer += "<div class='col-md-3'>";
                html_trainer += "<div class='form-group'>";
                html_trainer += "<label>ชื่อ-สกุล</label>";
                html_trainer += "<input type='text' name='trainer[]' class='form-control'/>";
                html_trainer += "</div>";
                html_trainer += "</div>";
                html_trainer += "<div class='col-md-2'>";
                html_trainer += "<div class='form-group'>";
                html_trainer += "<label>ตำแหน่ง</label>";
                html_trainer += "<input type='text' name='trainerposition[]' class='form-control'/>";
                html_trainer += "</div>";
                html_trainer += "</div>";
                html_trainer += "<div class='col-md-2'>";
                html_trainer += "<div class='form-group'>";
                html_trainer += "<label>หน่วยงาน</label>";
                html_trainer += "<input type='text' name='trainercompany[]' class='form-control'/>";
                html_trainer += "</div>";
                html_trainer += "</div>";
                html_trainer += "<div class='col-md-2'>";
                html_trainer += "<div class='form-group'>";
                html_trainer += "<label>หลักสูตร/วิชา</label>";
                html_trainer += "<input type='text' name='course[]' class='form-control' />";
                html_trainer += "</div>";
                html_trainer += "</div>";
                html_trainer += "<div class='col-md-3'>";
                html_trainer += "<div class='form-group'>";
                html_trainer += "<label>ข้อสังเกต</label>";
                html_trainer += "<input type='text' name='notice[]' class='form-control' />";
                html_trainer += "</div>";
                html_trainer += "</div>";
                html_trainer += "</div>";
                html_trainer += "</div>";

                $(wrapper_trainer).append(html_trainer); //add input box
                $('.datepicker').datepicker({
                    language: 'th',
                    format : "dd/mm/yyyy",
                    thaiyear: true,
                    autoclose:false,
                });
            }
            if( number_trainer > 1 ){
                $(".remove_trainer").prop("disabled",false);
            }

            if( number_trainer == 20 ){
                $(add_trainer).prop("disabled" , true);
            }
        });
        
        $(".remove_trainer").click(function(){
            if( number_trainer > 0 ){
                index=$('input[name="trainer[]"]').length;
                var names=document.getElementsByName('trainer[]');
                trainer_name = names[index-1].value;
                $(".removetrainer"+number_trainer).remove(); number_trainer--;
                $(add_trainer).prop("disabled" , false);

                $(function(){
                    $.ajax({
                        type:"get",
                        url:"<?php echo e(url('api/deletetrainer')); ?>",
                        dataType:"Html",
                        data:{
                            trainer_name : trainer_name,
                            readiness_id : "<?php echo e($readiness->project_readiness_id); ?>",
                            readiness_section_id : "<?php echo e($readiness->readiness_section_id); ?>",
                            project_type : "<?php echo e($readiness->project_type); ?>",
                        },
                        success : function(data){
                            if(data != ""){
                                alert(data);
                            }
                        }
                    })
                })

            }
    })

  //tab 5
  $(".remove_authority").prop("disabled",false);
    var max_authority   = 10; //maximum input boxes allowed
    var wrapper_authority   = $(".input_authority"); //Fields wrapper
    var add_authority  = $(".add_authority"); //Add button ID
    var html_authority = "";
    var number_authority = $('input[name="authority[]"]').length  ; //1; //initlal text box count

    $(add_authority).click(function(e){ //on add input button click
        if(number_authority < max_authority){ //max input box allowed
            number_authority++; //text box increment
            
            html_authority =  "<div class='row removeauthority"+number_authority+"'>";
            html_authority += "<div class='col-md-12'>";

            html_authority += "<div class='col-md-4'>";
            html_authority += "<div class='form-group'>";
            html_authority += "<label>ชื่อ-สกุล </label>";
            html_authority += "<input type='text' name='authority[]' class='form-control' />";
            html_authority += "</div>";
            html_authority += "</div>";
            html_authority += "<div class='col-md-4'>";
            html_authority += "<div class='form-group'>";
            html_authority += "<label>ตำแหน่ง </label>";
            html_authority += "<input type='text' name='authority_position[]' class='form-control' />";
            html_authority += "</div>";
            html_authority += "</div>";
            html_authority += "<div class='col-md-4'>";
            html_authority += "<div class='form-group'>";
            html_authority += "<label>หน่วยงาน </label>";
            html_authority += "<input type='text' name='authority_company[]' class='form-control' />";
            html_authority += "</div>";
            html_authority += "</div>";
            html_authority += "</div>";
            html_authority += "</div>";

            $(wrapper_authority).append(html_authority); //add input box

            $('.datepicker').datepicker({
                language: 'th',
                format : "dd/mm/yyyy",
                thaiyear: true,
                autoclose:false,
            });
        }

        if( number_authority > 1 ){
            $(".remove_authority").prop("disabled",false);
        }

        if( number_authority == 10 ){
            $(add_authority).prop("disabled" , true);
        }
    });
    
    $(".remove_authority").click(function(){
        if( number_authority > 0 ){
            index=$('input[name="authority[]"]').length;
            var names=document.getElementsByName('authority[]');
            authority_name = names[index-1].value;

            $(".removeauthority"+number_authority).remove(); number_authority--;
            $(add_authority).prop("disabled" , false);

                $(function(){
                    $.ajax({
                        type:"get",
                        url:"<?php echo e(url('api/deleteauthority')); ?>",
                        dataType:"Html",
                        data:{
                            officer_name : authority_name,
                            readiness_id : "<?php echo e($readiness->project_readiness_id); ?>",
                            project_type : "<?php echo e($readiness->project_type); ?>",
                        },
                        success : function(data){
                            if(data != ""){
                                alert(data);
                            }
                        }
                    })
                })
            }
    })


  //tab 6
    $(".remove_company").prop("disabled",false);
        var max_company  = 20; //maximum input boxes allowed
        var wrapper_company         = $(".input_company"); //Fields wrapper
        var add_company      = $(".add_company"); //Add button ID
        var html_company = "";
        var number_company = $('input[name="company[]"]').length ; //initlal text box count
        $(add_company).click(function(e){ //on add input button click
            if(number_company < max_company){ //max input box allowed
                number_company++; //text box increment
                html_company =  "<div class='row removecompany"+number_company+"'>";
                html_company += "<div class='col-md-12'>";
                html_company += "<div class='form-group'>";
                html_company += "<label>สถานประกอบการ</label>";
                html_company += "<input type='text' name='company[]' class='form-control'/>";
                html_company += "</div>";
                html_company += "</div>";
                html_company += "</div>";

                $(wrapper_company).append(html_company); //add input box
                $('.datepicker').datepicker({
                    language: 'th',
                    format : "dd/mm/yyyy",
                    thaiyear: true,
                    autoclose:false,
                });
            }
            if( number_company > 1 ){
                $(".remove_company").prop("disabled",false);
            }

            if( number_company == 20 ){
                $(add_company).prop("disabled" , true);
            }
        });
        
        $(".remove_company").click(function(){
            if( number_company > 0 ){
                index=$('input[name="company[]"]').length;
                var names=document.getElementsByName('company[]');
                company_name = names[index-1].value;

                $(".removecompany"+number_company).remove(); number_company--;
                $(add_company).prop("disabled" , false);

                $(function(){
                    $.ajax({
                        type:"get",
                        url:"<?php echo e(url('api/deletecompany')); ?>",
                        dataType:"Html",
                        data:{
                            company : company_name,
                            readiness_id : "<?php echo e($readiness->project_readiness_id); ?>",
                            project_type : "<?php echo e($readiness->project_type); ?>",
                        },
                        success : function(data){
                            if(data != ""){
                                alert(data);
                            }
                        }
                    })
                })

            }
    })

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.mains', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>