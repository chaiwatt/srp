@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">
	<!-- Modal -->

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/register/section') }}">ผู้สมัครร่วมโครงการ</a></li>
        <li>แบบฟอร์มสมัครเข้าร่วมโครงการ</li>    
    </ul>

    {!! Form::open([ 'url' => 'recurit/register/section/create' , 'method' => 'post' , 'files' => 'true' ]) !!} 
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                แบบฟอร์มสมัครเข้าร่วมโครงการ ปีงบประมาณ : {{ $project->year_budget }}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if( Session::has('success') )
                <div class="alert alert-success alert-custom alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-check-circle m-right-xs"></i> {{ Session::get('success') }}
                </div>
            @elseif( Session::has('error') )
                <div class="alert alert-danger alert-custom alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                     <i class="fa fa-times-circle m-right-xs"></i> {{ Session::get('error') }}
                </div>
            @endif
            
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>ตำแหน่งที่จ้าง</label><small class="text-danger">*</small>
                            <select class="form-control" name="position" required>
                                    @if( count($position) > 0 )
                                    @foreach( $position as $item )
                                        <option value="{{ $item->position_id }}">{{ $item->position_name }}</option>
                                    @endforeach
                                    @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>อาชีพที่ต้องการฝึกอบรม</label>
                        <input type="text" name="career" class="form-control"  />
                    </div>
                    <div class="col-md-3">
                        <label>อนาคตต้องการประกอบอาชีพ/อบรม</label>
                        <input type="text" name="career_future" class="form-control"  />
                    </div>
                    <div class="col-md-3">
                        <label>เลขที่ใบสมัคร</label><small class="text-danger">*</small>
                        <input type="text" name="application_no" class="form-control" required />
                    </div>
                </div>
            </div>
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">
                    แบบฟอร์มสมัครเข้าร่วมโครงการ
                </div>
                <div class="smart-widget-inner">
                    <div class="widget-tab clearfix">
                        <ul class="tab-bar">
                            <li class="active"><a href="#styleTab_personal" data-toggle="tab"><i class="fa fa-list"></i> ข้อมูลส่วนตัว</a></li>
                            <li class=""><a href="#styleTab_educatation" data-toggle="tab"><i class="fa fa-picture-o"></i> ประวัติการศึกษา</a></li>
                            <li class=""><a href="#styleTab_expereince" data-toggle="tab"><i class="fa fa-picture-o"></i> ประสบการณ์ทำงาน</a></li>
                            <li class=""><a href="#styleTab_skill" data-toggle="tab"><i class="fa fa-picture-o"></i> ความสามารถ</a></li>
                            <li class=""><a href="#styleTab_training" data-toggle="tab"><i class="fa fa-picture-o"></i> การฝึกอบรม</a></li>
<!--                             <li class=""><a href="#styleTab_assesment" data-toggle="tab"><i class="fa fa-picture-o"></i> ประเมินบุคลิกภาพ</a></li> -->
                            <li class=""><a href="#styleTab_attachment" data-toggle="tab"><i class="fa fa-picture-o"></i> เอกสารแนบ</a></li>
                            <li class=""><a href="#styleTab_personcase" data-toggle="tab"><i class="fa fa-picture-o"></i> ประวัติทางคดี</a></li>
                        </ul>
                    </div>
                    <div class="smart-widget-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="styleTab_personal">
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>หมายเลขบัตรประชาชน</label><small class="text-danger">*</small>
                                                <input type="text" name="person_id" id="person_id" class="form-control" required="" />
                                                <span class="help-block text-danger" id="response_person_id"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>คำนำหน้าชื่อ</label><small class="text-danger">*</small>
                                            <select class="form-control" name="prefix" required>
                                                    @if( count($prefix) > 0 )
                                                    @foreach( $prefix as $item )
                                                        <option value="{{ $item->prefix_id }}">{{ $item->prefix_name }}</option>
                                                    @endforeach
                                                    @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>ชื่อ</label><small class="text-danger">*</small>
                                            <input type="text" name="name" class="form-control" required="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>นามสกุล</label><small class="text-danger">*</small>
                                                <input type="text" name="lastname" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>วัน/เดือน/ปี เกิด</label><small class="text-danger">*</small>
                                            <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                                <input type="text" class="form-control" name="birthday" autocomplete="off" required="">
                                                <span class="add-on"><i class="icon-th"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>เลือกไฟล์รูป</label><small class="text-danger">*</small>
                                            <input type="file" name="picture" id="picture" class="filestyle"  required />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>สัญชาติ</label><small class="text-danger">*</small>
                                                <input type="text" name="nationality" class="form-control" value="ไทย" required="" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>เชื้อชาติ</label><small class="text-danger">*</small>
                                            <input type="text" name="ethnicity" class="form-control" value="ไทย" required="" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>ศาสนา</label><small class="text-danger">*</small>
                                            <select class="form-control" name="religion" required>
                                                    @if( count($religion) > 0 )
                                                    @foreach( $religion as $item )
                                                        <option value="{{ $item->religion_id }}">{{ $item->religion_name }}</option>
                                                    @endforeach
                                                    @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>การรับราชการทหาร</label><small class="text-danger">*</small>
                                                <select class="form-control" name="military" required>
                                                        @if( count($military) > 0 )
                                                        @foreach( $military as $item )
                                                            <option value="{{ $item->military_id }}">{{ $item->military_name }}</option>
                                                        @endforeach
                                                        @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>สถานะ</label><small class="text-danger">*</small>
                                            <select class="form-control" name="married" required>
                                                    @if( count($married) > 0 )
                                                    @foreach( $married as $item )
                                                        <option value="{{ $item->married_id }}">{{ $item->married_name }}</option>
                                                    @endforeach
                                                    @endif
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>จำนวนบุตร</label>
                                            <input type="number" name="baby" class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>โทรศัพท์</label><small class="text-danger">*</small>
                                            <input type="text" name="phone" class="form-control" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>อีเมลล์</label>
                                                <input type="text" name="email" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>เฟสบุ๊ค</label>
                                            <input type="text" name="facebook" class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>กลุ่ม</label><small class="text-danger">*</small>
                                            {{-- <select class="form-control" name="group" id="group" required ></select> --}}
                                            <select class="form-control" name="group" required>
                                                    @if( count($group) > 0 )
                                                    @foreach( $group as $item )
                                                        <option value="{{ $item->group_id }}">{{ $item->group_name }}</option>
                                                    @endforeach
                                                    @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อบิดา</label>
                                                <input type="text" name="father_name" class="form-control"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>นามสกุลบิดา</label>
                                            <input type="text" name="father_lastname" class="form-control"  />
                                        </div>
                                        <div class="col-md-4">
                                            <label>อาชีพบิดา</label>
                                            <input type="text" name="father_career" class="form-control"  />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อมารดา</label>
                                                <input type="text" name="mother_name" class="form-control"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>นามสกุลมารดา</label>
                                            <input type="text" name="mother_lastname" class="form-control"  />
                                        </div>
                                        <div class="col-md-4">
                                            <label>อาชีพมารดา</label>
                                            <input type="text" name="mother_career" class="form-control"  />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อคู่สมรส</label>
                                                <input type="text" name="spouse_name" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>นามสกุลคู่สมรส</label>
                                            <input type="text" name="spouse_lastname" class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>อาชีพคู่สมรส</label>
                                            <input type="text" name="spouse_career" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อผู้ติดต่อเร่งด่วน</label><small class="text-danger">*</small>
                                                <input type="text" name="urgent_name" class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>สกุลผู้ติดต่อเร่งด่วน</label><small class="text-danger">*</small>
                                            <input type="text" name="urgent_lastname" class="form-control" required />
                                        </div>
                                        <div class="col-md-4">
                                            <label>ความสัมพันธ์</label><small class="text-danger">*</small>
                                            <input type="text" name="urgent_relationship" class="form-control" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>เบอร์โทร</label><small class="text-danger">*</small>
                                                <input type="text" name="urgent_phone" class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>อีเมล์</label>
                                            <input type="text" name="urgent_email" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <hr />

                                <h3>ที่อยู่ตามทะเบียนบ้าน</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>เลขที่</label><small class="text-danger">*</small>
                                                <input type="text" name="address" class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>หมู่ที่</label><small class="text-danger">*</small>
                                                <input type="text" name="moo" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ถนน/ซอย</label>
                                                <input type="text" name="soi" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>จังหวัด</label><small class="text-danger">*</small>
                                                <select class="form-control " id="province" name="province" required></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>อำเภอ</label><small class="text-danger">*</small>
                                                <select class="form-control " id="amphur" name="amphur" required></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ตำบล</label><small class="text-danger">*</small>
                                                <select class="form-control " id="district" name="district" required></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>รหัสไปรษณีย์</label><small class="text-danger">*</small>
                                                <input type="text" name="postalcode" class="form-control" required/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr />
                                <div class="form-group">
                                        <span style ="font-size:24px">ที่อยู่ปัจจุบัน</span>
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="chksameaddress" name = "chksameaddress">
                                        <label for="chksameaddress"></label>
                                    </div>
                                    <span style ="font-size:20px"> ใช้ที่อยู่ตามทะเบียนบ้าน</span>
                                </div><!-- /form-group -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>เลขที่</label><small class="text-danger">*</small>
                                                <input type="text" name="address_now" class="form-control"  />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>หมู่ที่</label><small class="text-danger">*</small>
                                                <input type="text" name="moo_now" class="form-control"  />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ถนน/ซอย</label>
                                                <input type="text" name="soi_now" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>จังหวัด</label><small class="text-danger">*</small>
                                                <select class="form-control" id="now_province" name="province_now"  ></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>อำเภอ</label><small class="text-danger">*</small>
                                                <select class="form-control" id="now_amphur" name="amphur_now"  ></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ตำบล</label><small class="text-danger">*</small>
                                                <select class="form-control" id="now_district" name="district_now" ></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>รหัสไปรษณีย์</label><small class="text-danger">*</small>
                                                <input type="text" name="postalcode_now" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- ./tab-pane -->
                            <div class="tab-pane fade" id="styleTab_educatation">

                            	@if( count($education) > 0 )
                            	@foreach( $education as $item )
                            		<div class="row">
	                                    <div class="col-md-12">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>{{ $item->education_name }}</label>
	                                                <input type="text" name="education_name[{{ $item->education_id }}]" class="form-control" />
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>ปี พ.ศ. ตั้งแต่ - ถึง</label>
	                                                <input type="text" name="education_year[{{ $item->education_id }}]" class="form-control" />
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
                            	@endforeach
                            	@endif
                            </div>
                            <div class="tab-pane fade" id="styleTab_expereince">
                                <div class="row ">
                                    <div class="col-md-12 input_experience">
                                        <button type="button" id="btnexperience" class="btn btn-success"> <i class="fa fa-plus"></i> เพิ่มประสบการณ์ทำงาน</button>
                                        <button type="button" class="btn btn-success add_experience"> <i class="fa fa-plus"></i> เพิ่มประสบการณ์ทำงาน</button>
                                        <button type="button" class="btn btn-danger remove_experience"><i class="fa fa-times"></i> ลบรายการ</button>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="styleTab_attachment">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label>เอกสารแนบ <span class="text-danger">*ขนาดไฟล์ไม่เกิน 3MB และรวมทั้งหมดไม่เกิน 10MB</span></label>
                                    	<input type="file" name="document[]"  id="doc" class="filestyle" multiple="" />
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="styleTab_skill">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ความสามารถโปรแกรม MS</label>
                                            <select class="select2 width-100" name="software[]" multiple="" style="width:100%">
                                                @if( count($software) > 0 )
                                                @foreach( $software as $item )
                                                    <option value="{{ $item->software_id }}">{{ $item->software_name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ความสามารถโปรแกรมอื่นๆ</label>
                                            <input type="text" name="software_about" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ความสามารถพิเศษ</label>
                                            <select class="select2 width-100"  name="skill[]" multiple="" style="width:100%">
                                                @if( count($skill) > 0 )
                                                @foreach( $skill as $item )
                                                    <option value="{{ $item->skill_id }}">{{ $item->skill_name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ความสามารถพิเศษอื่นๆ</label>
                                            <input type="text" name="skill_about" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="styleTab_training">
                                <div class="row ">
                                    <div class="col-md-12 input_training">
                                        <button type="button" class="btn btn-success add_training"> <i class="fa fa-plus"></i> เพิ่มรายการฝึกอบรมวิชาชีพ</button>
                                        <button type="button" class="btn btn-danger remove_training"><i class="fa fa-times"></i> ลบรายการ</button>
                                        <hr>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="styleTab_personcase">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>รหัสสำนักงานเจ้าของคดี</label>
                                            <input type="text" name="register_office_case" id="register_office_case"  class="form-control" />
                                            <span class="help-block text-danger" id="response_register_office_case"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>เลขทะเบียนคดี</label>
                                        <input type="text" name="register_number_case" class="form-control" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ประเภทคดี</label>
                                            <select class="form-control"  name="register_type_case" >
                                                @if( count($registertype) > 0 )
                                                @foreach( $registertype as $item )
                                                    <option value="{{ $item->register_type_id }}">{{ $item->register_type_name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ปีทะเบียนคดี</label>
                                            <input type="number" min="1111" max="9999" name="register_year_case" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- ./tab-content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@stop

@section('pageScript')
<script type="text/javascript">

    $("#btnexperience").click(function(){           
        $('#experienceModal').modal('show');
    });
        

    $('#picture').on('change', function() {
        if($(this)[0].files[0].size/1024  > 250){
            $("#picture").val(null);
            alert('ไฟล์รูปต้องไม่เกิน 250KB');
        }
    });

    $('#doc').on('change', function() {
        var attachedfiles = document.getElementById('doc');
        var sumfilesize =0;
        for (var i = 0; i < attachedfiles.files.length; i++) {
            sumfilesize =  attachedfiles + attachedfiles.files[i].size/1024;
            if(attachedfiles.files[i].size/1024 > 1000){
                $("#doc").val(null);
                alert('ขนาดไฟล์เกิน 3MB');
                return;
            }
        }
        if(sumfilesize > 10240){
            $("#doc").val(null);
            alert('ขนาดไฟล์รวมเกิน 10MB');
        }
    });



    $(document).ready(function() {
        $('.select2').select2();
    });

    $('#picture').filestyle({
        buttonName : 'btn-success',
        buttonText : ' เลือกรูป',
        // input: false,
        icon: false,
    });

    $('#doc').filestyle({
        buttonName : 'btn-success',
        buttonText : ' เลือกไฟล์',
        // input: false,
        icon: false,
    });

    $("#personaldata").click(function(){
        if( $("#person_id").val() != "" ){
            $.ajax({
                type:"get",
                url:"https://npcsolution.com/testapi/personaldata.php",
                jsonp: "callback",
                dataType: "jsonp",
                crossDomain: true,
                data:{
                    id : $("#person_id").val()
                },
                success:function(response){
                    console.log( response );
                }   
            })
        }
        else{
            alert("กรอกรหัสบัตรประชาชน");
        }
    })

	$("form").keypress(function(event){
         if(event.keyCode==13){
            return false;
         }
     });

    $('.datepicker').datepicker({
        language: 'th',
        format : "dd/mm/yyyy",
        thaiyear: true,
        autoclose:true,
        orientation: "bottom left",
    });

    $("#person_id").change(function(){
        var person = $("#person_id").val();
        $.ajax({
            type:"get",
            url:"{{ url('api/register-person') }}",
            data:{
                person_id : person,
            },
            success : function(data){
                console.log(data);
                
                if(data == 'มีรหัสบัตรประชาชนอยู่ในระบบแล้ว แต่ยังไม่ active'){
                   if (confirm(data + ' ต้องการ acttive หรือไม่')) {
                    activeperson(person);
                    } 
                }else{
                    $("#response_person_id").text(data);
                }
            }
        })
    })

    function activeperson(person){
         console.log(person);
        $.ajax({
            type:"get",
            url:"{{ url('api/active-person') }}",
            data:{
                person_id : person,
            },
            success : function(data){
                //return data;
                 window.location.href = data;
                
            }
        })
    }
        

     $("#register_office_case").change(function(){
        $.ajax({
            type:"get",
            url:"{{ url('api/sectionexist') }}",
            data:{
                section_id : $("#register_office_case").val(),
            },
            success : function(data){
                $("#response_register_office_case").text(data);
            }
        })
    })   

    $.ajax({
        type:"get",
        url : "{{ url('api/province') }}",
        dataType:"Json",
        data : {
            province : ""
        },
        success : function(response){
            if( response.row > 0 ){
                html = "<option value='0'>กรุณาเลือก จังหวัด</option>";
                for( var i=0;i<response.row;i++ ){
                    if( response.province[i].province_id == response.filter ){
                        html += "<option value='"+ response.province[i].province_id +"' selected>"+ response.province[i].province_name +"</option>";
                    }
                    else{
                        html += "<option value='"+ response.province[i].province_id +"'>"+ response.province[i].province_name +"</option>";
                    }
                }
                $("#province").html( html );
            }
        }
    })

    $.ajax({
        type:"get",
        url : "{{ url('api/amphur') }}",
        dataType:"Json",
        data : {
            province : "",
            amphur : "",
        },
        success : function(response){
            if( response.row > 0 ){
                html = "<option value='0'>กรุณาเลือก อำเภอ</option>";
                for( var i=0;i<response.row;i++ ){
                    if( response.amphur[i].amphur_id == response.filter ){
                        html += "<option value='"+ response.amphur[i].amphur_id +"' selected>"+ response.amphur[i].amphur_name +"</option>";
                    }
                    else{
                        html += "<option value='"+ response.amphur[i].amphur_id +"'>"+ response.amphur[i].amphur_name +"</option>";
                    }
                }
                $("#amphur").html( html );
            }
        }
    })

    $.ajax({
        type:"get",
        url : "{{ url('api/district') }}",
        dataType:"Json",
        data : {
            amphur : "",
            district : ""
        },
        success : function(response){
            if( response.row > 0 ){
                html = "<option value='0'>กรุณาเลือก ตำบล</option>";
                for( var i=0;i<response.row;i++ ){
                    if( response.district[i].district_id == response.filter ){
                        html += "<option value='"+ response.district[i].district_id +"' selected>"+ response.district[i].district_name +"</option>";
                    }
                    else{
                        html += "<option value='"+ response.district[i].district_id +"'>"+ response.district[i].district_name +"</option>";
                    }
                }
                $("#district").html( html );
            }
        }
    })

    // $.ajax({
    //     type:"get",
    //     url:"{{ url('api/group') }}",
    //     dataType:"Json",
    //     data:{
    //         group : "",
    //     },
    //     success : function(data){
    //         var html = "<option value=''>เลือก กลุ่ม</option>";
    //         if(data.row > 0){
    //             for(var i=0;i<data.row;i++){
    //                 if( data.group[i].group_id == data.filter ){
    //                     html += "<option value='"+ data.group[i].group_id +"' selected >"+ data.group[i].group_name +"</option>"
    //                 }
    //                 else{
    //                     html += "<option value='"+ data.group[i].group_id +"' > "+ data.group[i].group_name +"</option>"
    //                 }
    //             }
    //         }

    //         $("#group").html(html);
    //     }
    // })


    $("#province").change(function(){
        if( $("#province").val() != 0 ){

            $.ajax({
                type:"get",
                url : "{{ url('api/amphur') }}",
                dataType:"Json",
                data : {
                    province : $("#province").val(),
                    amphur : ""
                },
                success : function(response){
                    if( response.row > 0 ){
                        html = "<option value='0'>กรุณาเลือก อำเภอ</option>";
                        for( var i=0;i<response.row;i++ ){
                            if( response.amphur[i].amphur_id == response.filter ){
                                html += "<option value='"+ response.amphur[i].amphur_id +"' selected>"+ response.amphur[i].amphur_name +"</option>";
                            }
                            else{
                                html += "<option value='"+ response.amphur[i].amphur_id +"'>"+ response.amphur[i].amphur_name +"</option>";
                            }
                        }
                        $("#amphur").html( html );
                    }
                }
            })

            $("#district").html("<option value='0'>กรุณาเลือก ตำบล</option>");
            
        }
        else{
            $("#amphur").html("<option value='0'>กรุณาเลือก อำเภอ</option>");
            $("#amphur").select2();

            $("#district").html("<option value='0'>กรุณาเลือก ตำบล</option>");
        }

    })

    $("#amphur").change(function(){
        if( $("#amphur").val() != 0 ){
            $.ajax({
                type:"get",
                url : "{{ url('api/district') }}",
                dataType:"Json",
                data : {
                    amphur : $("#amphur").val(),
                    district : "",
                },
                success : function(response){
                    if( response.row > 0 ){
                        html = "<option value='0'>กรุณาเลือก ตำบล</option>";
                        for( var i=0;i<response.row;i++ ){
                            if( response.district[i].district_id == response.filter ){
                                html += "<option value='"+ response.district[i].district_id +"' selected>"+ response.district[i].district_name +"</option>";
                            }
                            else{
                                html += "<option value='"+ response.district[i].district_id +"'>"+ response.district[i].district_name +"</option>";
                            }
                        }
                        $("#district").html( html );
                    }
                }
            })
        }
        else{
            $("#district").html("<option value='0'>กรุณาเลือก ตำบล</option>");
            $("#district").select2();
        }
    })

    //address

    $.ajax({
        type:"get",
        url : "{{ url('api/province') }}",
        dataType:"Json",
        data : {
            province : ""
        },
        success : function(response){
            if( response.row > 0 ){
                html = "<option value='0'>กรุณาเลือก จังหวัด</option>";
                for( var i=0;i<response.row;i++ ){
                    if( response.province[i].province_id == response.filter ){
                        html += "<option value='"+ response.province[i].province_id +"' selected>"+ response.province[i].province_name +"</option>";
                    }
                    else{
                        html += "<option value='"+ response.province[i].province_id +"'>"+ response.province[i].province_name +"</option>";
                    }
                }
                $("#now_province").html( html );
            }
        }
    })

    $.ajax({
        type:"get",
        url : "{{ url('api/amphur') }}",
        dataType:"Json",
        data : {
            province : "",
            amphur : "",
        },
        success : function(response){
            if( response.row > 0 ){
                html = "<option value='0'>กรุณาเลือก อำเภอ</option>";
                for( var i=0;i<response.row;i++ ){
                    if( response.amphur[i].amphur_id == response.filter ){
                        html += "<option value='"+ response.amphur[i].amphur_id +"' selected>"+ response.amphur[i].amphur_name +"</option>";
                    }
                    else{
                        html += "<option value='"+ response.amphur[i].amphur_id +"'>"+ response.amphur[i].amphur_name +"</option>";
                    }
                }
                $("#now_amphur").html( html );
            }
        }
    })

    $.ajax({
        type:"get",
        url : "{{ url('api/district') }}",
        dataType:"Json",
        data : {
            amphur : "",
            district : ""
        },
        success : function(response){
            if( response.row > 0 ){
                html = "<option value='0'>กรุณาเลือก ตำบล</option>";
                for( var i=0;i<response.row;i++ ){
                    if( response.district[i].district_id == response.filter ){
                        html += "<option value='"+ response.district[i].district_id +"' selected>"+ response.district[i].district_name +"</option>";
                    }
                    else{
                        html += "<option value='"+ response.district[i].district_id +"'>"+ response.district[i].district_name +"</option>";
                    }
                }
                $("#now_district").html( html );
            }
        }
    })


    $("#now_province").change(function(){
        if( $("#now_province").val() != 0 ){

            $.ajax({
                type:"get",
                url : "{{ url('api/amphur') }}",
                dataType:"Json",
                data : {
                    province : $("#now_province").val(),
                    amphur : ""
                },
                success : function(response){
                    if( response.row > 0 ){
                        html = "<option value='0'>กรุณาเลือก อำเภอ</option>";
                        for( var i=0;i<response.row;i++ ){
                            if( response.amphur[i].amphur_id == response.filter ){
                                html += "<option value='"+ response.amphur[i].amphur_id +"' selected>"+ response.amphur[i].amphur_name +"</option>";
                            }
                            else{
                                html += "<option value='"+ response.amphur[i].amphur_id +"'>"+ response.amphur[i].amphur_name +"</option>";
                            }
                        }
                        $("#now_amphur").html( html );
                    }
                }
            })

            $("#now_district").html("<option value='0'>กรุณาเลือก ตำบล</option>");
            
        }
        else{
            $("#now_amphur").html("<option value='0'>กรุณาเลือก อำเภอ</option>");
            $("#now_amphur").select2();

            $("#now_district").html("<option value='0'>กรุณาเลือก ตำบล</option>");
        }

    })

    $("#now_amphur").change(function(){
        if( $("#now_amphur").val() != 0 ){
            $.ajax({
                type:"get",
                url : "{{ url('api/district') }}",
                dataType:"Json",
                data : {
                    amphur : $("#now_amphur").val(),
                    district : "",
                },
                success : function(response){
                    if( response.row > 0 ){
                        html = "<option value='0'>กรุณาเลือก ตำบล</option>";
                        for( var i=0;i<response.row;i++ ){
                            if( response.district[i].district_id == response.filter ){
                                html += "<option value='"+ response.district[i].district_id +"' selected>"+ response.district[i].district_name +"</option>";
                            }
                            else{
                                html += "<option value='"+ response.district[i].district_id +"'>"+ response.district[i].district_name +"</option>";
                            }
                        }
                        $("#now_district").html( html );
                    }
                }
            })
        }
        else{
            $("#now_district").html("<option value='0'>กรุณาเลือก ตำบล</option>");
            $("#now_district").select2();
        }
    })


    $(".remove_training").prop("disabled",true);
    var max_training      = 10; //maximum input boxes allowed
    var wrapper_training         = $(".input_training"); //Fields wrapper
    var add_training      = $(".add_training"); //Add button ID
    var html_training = "";
    var number_training = 1; //initlal text box count

    $(add_training).click(function(e){ //on add input button click
        if(number_training < max_training){ //max input box allowed
            number_training++; //text box increment
            
            html_training =  "<div class='row removetraining"+number_training+"'>";
            html_training += "<div class='col-md-12'>";
            html_training += "<div class='col-md-3'>";
            html_training += "<div class='form-group'>";
            html_training += "<label>เริ่มวันที่</label>";
            html_training += "<div class='input-append date datepicker' data-provide='datepicker' data-date-language='th-th'>";
            html_training += "<input type='text' class='form-control' name='training_datestart[]' readonly='' autocomplete='off' required=''>";
            html_training += "<span class='add-on'><i class='icon-th'></i></span>";
            html_training += "</div>";
            html_training += "</div>";
            html_training += "</div>";
            html_training += "<div class='col-md-3'>";
            html_training += "<div class='form-group'>";
            html_training += "<label>ถึงวันที่</label>";
            html_training += "<div class='input-append date datepicker' data-provide='datepicker' data-date-language='th-th'>";
            html_training += "<input type='text' class='form-control' name='training_dateend[]' readonly='' autocomplete='off' required=''>";
            html_training += "<span class='add-on'><i class='icon-th'></i></span>";
            html_training += "</div>";
            html_training += "</div>";
            html_training += "</div>";
            html_training += "<div class='col-md-3'>";
            html_training += "<div class='form-group'>";
            html_training += "<label>หลักสูตร</label>";
            html_training += "<input type='text' name='course[]' class='form-control'/>";
            html_training += "</div>";
            html_training += "</div>";
            html_training += "<div class='col-md-3'>";
            html_training += "<div class='form-group'>";
            html_training += "<label>หน่วยงาน</label>";
            html_training += "<input type='text' name='department[]' class='form-control' />";
            html_training += "</div>";
            html_training += "</div>";
            html_training += "</div>";
            html_training += "</div>";

            $(wrapper_training).append(html_training); //add input box

            $('.datepicker').datepicker({
                language: 'th',
                format : "dd/mm/yyyy",
                thaiyear: true,
                autoclose:true,
                orientation: "bottom left",
            });
        }

        if( number_training > 1 ){
            $(".remove_training").prop("disabled",false);
        }

        if( number_training == 10 ){
            $(add_training).prop("disabled" , true);
        }
    });
    
    $(".remove_training").click(function(){
        if( number_training > 1 ){
            $(".removetraining"+number_training).remove(); number_training--;

            $(add_training).prop("disabled" , false);
        }

        if( number_training == 1 ){
            $(".remove_training").prop("disabled",true);
        }
    })

    //end tab 2

    $(".remove_experience").prop("disabled",true);
    var max_experience      = 10; //maximum input boxes allowed
    var wrapper_experience         = $(".input_experience"); //Fields wrapper
    var add_experience      = $(".add_experience"); //Add button ID
    var html_experience = "";
    var number_experience = 1; //initlal text box count

    $(add_experience).click(function(e){ //on add input button click
        if(number_experience < max_experience){ //max input box allowed
            number_experience++; //text box increment
            
            html_experience =  "<div class='row removeexp"+number_experience+"'>";
            html_experience += "<div class='col-md-12'>";
            html_experience += "<div class='col-md-2'>";
            html_experience += "<div class='form-group'>";
            html_experience += "<label>วันเริ่มทำงาน</label>";
            html_experience += "<div class='input-append date datepicker' data-provide='datepicker' data-date-language='th-th'>";
            html_experience += "<input type='text' class='form-control' name='experience_datestart[]' readonly='' autocomplete='off' required=''>";
            html_experience += "<span class='add-on'><i class='icon-th'></i></span>";
            html_experience += "</div>";
            html_experience += "</div>";
            html_experience += "</div>";
            html_experience += "<div class='col-md-2'>";
            html_experience += "<div class='form-group'>";
            html_experience += "<label>วันสิ้นสุดทำงาน</label>";
            html_experience += "<div class='input-append date datepicker' data-provide='datepicker' data-date-language='th-th'>";
            html_experience += "<input type='text' class='form-control' name='experience_dateend[]' readonly='' autocomplete='off' required=''>";
            html_experience += "<span class='add-on'><i class='icon-th'></i></span>";
            html_experience += "</div>";
            html_experience += "</div>";
            html_experience += "</div>";
            html_experience += "<div class='col-md-2'>";
            html_experience += "<div class='form-group'>";
            html_experience += "<label>บริษัท/องค์กร</label>";
            html_experience += "<input type='text' name='experience_company[]' class='form-control'/>";
            html_experience += "</div>";
            html_experience += "</div>";
            html_experience += "<div class='col-md-2'>";
            html_experience += "<div class='form-group'>";
            html_experience += "<label>ตำแหน่ง</label>";
            html_experience += "<input type='text' name='experience_position[]' class='form-control' />";
            html_experience += "</div>";
            html_experience += "</div>";
            html_experience += "<div class='col-md-2'>";
            html_experience += "<div class='form-group'>";
            html_experience += "<label>ลักษณะงาน</label>";
            html_experience += "<input type='text' name='experience_description[]' class='form-control' />";
            html_experience += "</div>";
            html_experience += "</div>";
            html_experience += "<div class='col-md-2'>";
            html_experience += "<div class='form-group'>";
            html_experience += "<label>สาเหตุที่ออก</label>";
            html_experience += "<input type='text' name='experience_resign[]' class='form-control' />";
            html_experience += "</div>";
            html_experience += "</div>";
            html_experience += "</div>";
            html_experience += "</div>";
            html_experience += "<hr />";

            $(wrapper_experience).append(html_experience); //add input box

            $('.datepicker').datepicker({
                language: 'th',
                format : "dd/mm/yyyy",
                thaiyear: true,
                autoclose:true,
                orientation: "bottom left",
            });
        }

        if( number_experience > 1 ){
            $(".remove_experience").prop("disabled",false);
        }

        if( number_experience == 10 ){
            $(add_experience).prop("disabled" , true);
        }
    });
    
    $(".remove_experience").click(function(){
        if( number_experience > 1 ){
            $(".removeexp"+number_experience).remove(); number_experience--;

            $(add_experience).prop("disabled" , false);
        }

        if( number_experience == 1 ){
            $(".remove_experience").prop("disabled",true);
        }
    })


    // $("#chksameaddress").change(function(){
    //     if ($(this).prop("checked") ){
            
    //         // var province = document.getElementById("province").value;
    //         document.getElementById('now_province').value = document.getElementById("province").value;
    //         document.getElementById('now_amphur').value = document.getElementById("amphur").value;
    //         alert(document.getElementById("amphur").value);
    //         // alert(province);
    //     }
    // 		// $.ajax({
    // 		// 	type:"get",
    // 		// 	url:"{{ url('readiness/project/section/toggle') }}",
    // 		// 	data:{
    // 		// 		readiness_id : $(this).attr('data-pk'),
    //         //         status :  $(this).prop("checked"),
    //         //         section :  "{{ $auth->section_id }}",
    //         //         department :  "{{ $auth->department_id }}",
    //         //         project_id :  "{{ $project->project_id }}",
    // 		// 	},
    // 		// 	success:function(response){
    //         //         console.log(response);
    // 		// 		window.location.reload();
    // 		// 	}
    // 		// })
    // })


</script>
@stop