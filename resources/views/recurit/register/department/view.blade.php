@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/register/section') }}">ผู้สมัครร่วมโครงการ</a></li>
        <li>แบบฟอร์มแก้ไขเข้าร่วมโครงการ</li>    
    </ul>

    {!! Form::open([ 'url' => 'recurit/register/section/edit' , 'method' => 'post' , 'files' => 'true' , 'multiple'  ]) !!} 
    <input type="hidden" name="id" value="{{ $register->register_id }}" />
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ข้อมูลผู้สมัคร : {{ $register->name }} {{ $register->lastname }}
            </div>
        </div>
        <div class="col-sm-6">

        </div>
    </div>

    		<!-- Modal -->
		<div class="modal fade" id="cert">
            <div class="modal-dialog">
              <div class="modal-content" >
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                      <h4 class="modal-title" style="font-size: 22px">สร้างใบรับรอง</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>วันเริ่มงาน</label>
                                <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                    <input type="text" disabled class="form-control" name="certdatestart" id ="certdatestart" readonly="" value="" autocomplete="off" required="">
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>วันสิิ้นสุด</label>
                                <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                    <input type="text" disabled class="form-control" name="certdateend" id="certdateend" readonly="" value="" autocomplete="off" required="">
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>
                        </div>                       
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>จำนวนเดือน</label>
                                    <input type="text" disabled name="nummonthwork" id ="nummonthwork" class="form-control" value="" />
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ผู้รับรอง</label>
                                    <input type="text" disabled name="certername" id="certername" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ตำแหน่ง</label>
                                    <input type="text" disabled name="certerposition" id="certerposition" class="form-control" value="" />
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="modal-footer">
                      {{-- <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button> --}}
                      <a id ="btncreatecert"  class="btn btn-primary">สร้างใบรับรอง</a>
                    </div>
              </div>
            </div>
      </div>

    <div class="row">
        <div class="col-sm-9">
            <div class="form-group">
                <div class="col-md-5 page-title "><strong>ผลการพิจารณา</strong></div>
                <div class="col-md-7">
                    <div class="radio">
                        <div class="custom-radio m-right-xs">
                            <input disabled type="radio" id="radio1" name="stackRadio" value="0" {{ $register->register_type==0?'checked':'' }} >
                            <label for="radio1"></label>
                        </div>
                        <div class="inline-block vertical-top">
                            ยังไม่ได้คัดเลือก
                        </div>
                    </div>
                    <div class="radio">
                        <div class="custom-radio m-right-xs">
                            <input disabled type="radio" id="radio2" name="stackRadio" value="1" {{ $register->register_type==1?'checked':'' }}>
                            <label for="radio2"></label>
                        </div>
                        <div class="inline-block vertical-top">
                            ผ่านการพิจารณา
                        </div>      
                    </div>
                    <div class="radio">
                        <div class="custom-radio m-right-xs">
                            <input disabled type="radio" id="radio3" name="stackRadio" value="2" {{ $register->register_type==2?'checked':'' }}>
                            <label for="radio3"></label>
                        </div>
                        <div class="inline-block vertical-top">
                            ไม่ผ่านการพิจารณา
                        </div>      
                    </div>
                </div><!-- /.col -->
            </div>
        </div>
        <div class="col-sm-3">
            <div class="pull-right">
                <img src="{{ asset( $register->picture ) }}" width="120" height="140">
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
                            <select class="form-control"  disabled name="position" required>
                                {{ $register->position_id}}
                                    @if( count($position) > 0 )
                                    @foreach( $position as $item )
                                        <option value="{{ $item->position_id }}" @if ($item->position_id  == $register->position_id) selected  @endif  >{{ $item->position_name }}</option>
                                    @endforeach
                                    @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>อาชีพที่ต้องการฝึกอบรม</label>
                        <input type="text" disabled name="career" class="form-control" value="{{ $register->career }}" />
                    </div>
                    <div class="col-md-3">
                        <label>อนาคตต้องการประกอบอาชีพ/อบรม</label>
                        <input type="text" disabled name="career_future" class="form-control" value="{{ $register->career_future }}" />
                    </div>
                    <div class="col-md-3">
                        <label>เลขที่ใบสมัคร</label><small class="text-danger">*</small>
                        <input type="text" disabled name="application_no" value="{{ $register->application_no }}"  class="form-control"  />
                    </div>
                </div>
            </div>

            @if ($register->register_type==1)
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <label>วันที่เริ่มจ้างงาน</label>
                        <div id="starthiredate"  class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                            <input type="text" disabled class="form-control" name="starthiredate"  autocomplete="off" >
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>วันที่เริ่มจ้างสิ้นสุด</label>
                        <div id="endhiredate"  class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                            <input type="text" disabled class="form-control" name="endhiredate"  autocomplete="off" >
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>เลขที่สัญญาจ้าง</label>
                        <input type="text" disabled name="contract_no" value="{{ $register->contract_no }}"  class="form-control"  />
                    </div>
                </div>
            </div> 
            <hr>
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <label>ผู้ลงนามสัญญา</label>
                        <input type="text" disabled class="form-control" name="representativename"  value="{{ $register->representativename }}" autocomplete="off" >
                    </div>
                    <div class="col-md-6">
                        <label>ตำแหน่ง</label>                      
                        <input type="text" disabled class="form-control" name="representativeposition" value="{{ $register->representativeposition }}" autocomplete="off" >
                    </div>
                </div>
            </div>  
            @endif
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
                                                <input type="text" disabled name="person_id" id="person_id" class="form-control" required="" value="{{ $register->person_id }}" />
                                                <span class="help-block text-danger" id="response_person_id"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>คำนำหน้าชื่อ</label><small class="text-danger">*</small>
                                            {{-- <select class="form-control"  disabled name="prefix" id="prefix"></select> --}}
                                            <select class="form-control"  disabled name="prefix" required>
                                                    @if( count($prefix) > 0 )
                                                    @foreach( $prefix as $item )
                                                        <option value="{{ $item->prefix_id }}" @if ($item->prefix_id  == $register->prefix_id) selected  @endif >{{ $item->prefix_name }}</option>
                                                    @endforeach
                                                    @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>ชื่อ</label><small class="text-danger">*</small>
                                            <input type="text" disabled name="name" class="form-control" required="" value="{{ $register->name }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>นามสกุล</label><small class="text-danger">*</small>
                                                <input type="text" disabled name="lastname" class="form-control" value="{{ $register->lastname }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>วัน/เดือน/ปี เกิด</label><small class="text-danger">*</small>
                                            <div id="birthday"  class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                                                <input type="text" disabled class="form-control" name="birthday"  autocomplete="off" required="">
                                                <span class="add-on"><i class="icon-th"></i></span>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <label>เลือกไฟล์รูป</label>
                                            <input disabled type="file" name="picture" id="picture" class="filestyle" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>สัญชาติ</label><small class="text-danger">*</small>
                                                <input type="text" disabled name="nationality" class="form-control" required="" value="{{ $register->nationality }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>เชื้อชาติ</label><small class="text-danger">*</small>
                                            <input type="text" disabled name="ethnicity" class="form-control" required="" value="{{ $register->ethnicity }}" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>ศาสนา</label><small class="text-danger">*</small>
                                            {{-- <select class="form-control"  disabled name="religion" id="religion" required></select> --}}
                                            <select class="form-control"  disabled name="religion" required>
                                                    @if( count($religion) > 0 )
                                                    @foreach( $religion as $item )
                                                        <option value="{{ $item->religion_id }}" @if ($item->religion_id  == $register->religion_id) selected  @endif >{{ $item->religion_name }}</option>
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
                                                {{-- <select class="form-control"  disabled name="military" id="military" required></select> --}}
                                                <select class="form-control"  disabled name="military" required>
                                                        @if( count($military) > 0 )
                                                        @foreach( $military as $item )
                                                            <option value="{{ $item->military_id }}" @if ($item->military_id  == $register->military_id) selected  @endif >{{ $item->military_name }}</option>
                                                        @endforeach
                                                        @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>สถานะ</label><small class="text-danger">*</small>
                                            {{-- <select class="form-control"  disabled name="married" id="married" required></select> --}}
                                            <select class="form-control"  disabled name="married" required>
                                                    @if( count($married) > 0 )
                                                    @foreach( $married as $item )
                                                        <option value="{{ $item->married_id }}" @if ($item->married_id  == $register->married_id) selected  @endif >{{ $item->married_name }}</option>
                                                    @endforeach
                                                    @endif
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>จำนวนบุตร</label>
                                            <input disabled type="number" name="baby" class="form-control" value="{{ $register->baby }}" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>โทรศัพท์</label><small class="text-danger">*</small>
                                            <input type="text" disabled name="phone" class="form-control" value="{{ $register->phone }}" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>อีเมลล์</label>
                                                <input type="text" disabled name="email" class="form-control" value="{{ $register->email }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>เฟสบุ๊ค</label>
                                            <input type="text" disabled name="facebook" class="form-control" value="{{ $register->facebook }}" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>กลุ่ม</label><small class="text-danger">*</small>
                                            <select class="form-control"  disabled name="group" required>
                                                    @if( count($group) > 0 )
                                                    @foreach( $group as $item )
                                                        <option value="{{ $item->group_id }}"  @if ($item->group_id  == $register->group_id) selected  @endif >{{ $item->group_name }}</option>
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
                                                <input type="text" disabled name="father_name" class="form-control" value="{{ $register->father_name }}"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>นามสกุลบิดา</label>
                                            <input type="text" disabled name="father_lastname" class="form-control" value="{{ $register->lastname }}"  />
                                        </div>
                                        <div class="col-md-4">
                                            <label>อาชีพบิดา</label>
                                            <input type="text" disabled name="father_career" class="form-control" value="{{ $register->father_career }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อมารดา</label>
                                                <input type="text" disabled name="mother_name" class="form-control" value="{{ $register->mother_name }}"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>นามสกุลมารดา</label>
                                            <input type="text" disabled name="mother_lastname" class="form-control" value="{{ $register->mother_lastname }}"  />
                                        </div>
                                        <div class="col-md-4">
                                            <label>อาชีพมารดา</label>
                                            <input type="text" disabled name="mother_career" class="form-control" value="{{ $register->mother_career }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อคู่สมรส</label>
                                                <input type="text" disabled name="spouse_name" class="form-control" value="{{ $register->spouse_name }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>นามสกุลคู่สมรส</label>
                                            <input type="text" disabled name="spouse_lastname" class="form-control" value="{{ $register->spouse_lastname }}" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>อาชีพคู่สมรส</label>
                                            <input type="text" disabled name="spouse_career" class="form-control" value="{{ $register->spouse_career }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อผู้ติดต่อเร่งด่วน</label><small class="text-danger">*</small>
                                                <input type="text" disabled name="urgent_name" class="form-control" value="{{ $register->urgent_name }}"  required/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>สกุลผู้ติดต่อเร่งด่วน</label><small class="text-danger">*</small>
                                            <input type="text" disabled name="urgent_lastname" class="form-control" value="{{ $register->urgent_lastname }}" required />
                                        </div>
                                        <div class="col-md-4">
                                            <label>ความสัมพันธ์</label><small class="text-danger">*</small>
                                            <input type="text" disabled name="urgent_relationship" class="form-control" value="{{ $register->urgent_relationship }}" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>เบอร์โทร</label><small class="text-danger">*</small>
                                                <input type="text" disabled name="urgent_phone" class="form-control" value="{{ $register->urgent_phone }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>อีเมล์</label>
                                            <input type="text" disabled name="urgent_email" class="form-control" value="{{ $register->urgent_email }}" />
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
                                                <input type="text" disabled name="address" class="form-control" value="{{ $register->address }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>หมู่ที่</label>
                                                <input type="text" disabled name="moo" class="form-control" value="{{ $register->moo }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ถนน/ซอย</label>
                                                <input type="text" disabled name="soi" class="form-control" value="{{ $register->soi }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>จังหวัด</label><small class="text-danger">*</small>
                                                <select disabled class="form-control " id="province" name="province" required></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>อำเภอ</label><small class="text-danger">*</small>
                                                <select disabled class="form-control " id="amphur" name="amphur" required></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ตำบล</label><small class="text-danger">*</small>
                                                <select disabled class="form-control " id="district" name="district" required></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>รหัสไปรษณีย์</label><small class="text-danger">*</small>
                                                <input type="text" disabled name="postalcode" class="form-control" value="{{ $register->postalcode }}" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr />

                                <h3>ที่อยู่ปัจจุบัน</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>เลขที่</label><small class="text-danger">*</small>
                                                <input type="text" disabled name="address_now" class="form-control" value="{{ $register->address_now }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>หมู่ที่</label>
                                                <input type="text" disabled name="moo_now" class="form-control" value="{{ $register->moo_now }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ถนน/ซอย</label>
                                                <input type="text" disabled name="soi_now" class="form-control" value="{{ $register->soi_now }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>จังหวัด</label><small class="text-danger">*</small>
                                                <select class="form-control"  disabled id="now_province" name="province_now" required></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>อำเภอ</label><small class="text-danger">*</small>
                                                <select class="form-control"  disabled id="now_amphur" name="amphur_now" required></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ตำบล</label><small class="text-danger">*</small>
                                                <select class="form-control"  disabled id="now_district" name="district_now" required></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>รหัสไปรษณีย์</label><small class="text-danger">*</small>
                                                <input type="text" disabled name="postalcode_now" class="form-control" value="{{ $register->postalcode_now }}"  required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- ./tab-pane -->

                            <div class="tab-pane fade" id="styleTab_educatation">

                            	@if( count($education) > 0 )
                            	@foreach( $education as $item )
                                    @php( $value = $registereducation->where('education_id' , $item->education_id)->first() )
                            		<div class="row">
	                                    <div class="col-md-12">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>{{ $item->education_name }}</label>
                                                    @if( count($value) > 0 )
	                                                <input type="text" disabled name="education_name[{{ $item->education_id }}]" class="form-control"  value="{{ $value->register_education_name }}" />
                                                    @else
                                                    <input type="text" disabled name="education_name[{{ $item->education_id }}]" class="form-control"  />
                                                    @endif
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>ปี พ.ศ. ตั้งแต่ - ถึง</label>
                                                    @if( count($value) > 0 )
	                                                <input type="text" disabled name="education_year[{{ $item->education_id }}]" class="form-control" value="{{ $value->register_education_year }}" />
                                                    @else
                                                    <input type="text" disabled name="education_year[{{ $item->education_id }}]" class="form-control" />
                                                    @endif
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
                            	@endforeach
                            	@endif
                            </div>

                            <div class="tab-pane fade" id="styleTab_skill">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ความสามารถโปรแกรม MS</label>
                                            <select class="select2 width-100" name="software[]" multiple="" style="width:100%">
                                                @if( count($software) > 0 )
                                                @foreach( $software as $item )
                                                    @php( $value = $registersoftware->where('software_id' , $item->software_id)->first() )
                                                    @if( count($value) > 0 )
                                                    <option value="{{ $item->software_id }}" selected="">{{ $item->software_name }}</option>
                                                    @else
                                                    <option value="{{ $item->software_id }}">{{ $item->software_name }}</option>
                                                    @endif
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ความสามารถโปรแกรมอื่นๆ</label>
                                            <input type="text" disabled name="software_about"  class="form-control" value="{{ $register->software_about }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ความสามารถพิเศษ</label>
                                            <select  class="select2 width-100" style="width:100%" name="skill[]" multiple="">
                                                @if( count($skill) > 0 )
                                                @foreach( $skill as $item )
                                                    @php( $value = $registerskill->where('skill_id' , $item->skill_id)->first() )
                                                    @if( count($value) > 0 )
                                                    <option value="{{ $item->skill_id }}" selected="">{{ $item->skill_name }}</option>
                                                    @else
                                                    <option value="{{ $item->skill_id }}">{{ $item->skill_name }}</option>
                                                    @endif
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ความสามารถพิเศษอื่นๆ</label>
                                            <input type="text" disabled name="skill_about" class="form-control" value="{{ $register->skill_about }}" />
                                        </div>
                                    </div>


                                </div> 
                            </div>

                            <div class="tab-pane fade" id="styleTab_training">
                                <div class="row ">
                                    <div class="col-md-12 input_training">
                                        
                                        {{-- <button type="button" class="btn btn-success add_training"> <i class="fa fa-plus"></i> เพิ่มรายการฝึกอบรมวิชาชีพ</button>
                                        <button type="button" class="btn btn-danger remove_training"><i class="fa fa-times"></i> ลบรายการ</button> --}}

                                        <hr>

                                        @if( count( $registertraining ) > 0 )
                                        @foreach( $registertraining as $key => $item )

                                        @if( $key == 0 )
                                        <div class="row removetraining1">
                                        @else
                                        <div class="row removetraining{{ $key + 1 }}">
                                        @endif
                                            <div class="col-md-12">
                                                    <input type="hidden" name="training_id[]" class="form-control" value="{{ $item->register_training_id }}" />
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>เริ่มวันที่</label>
                                                        <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                                            <input type="text" disabled class="form-control" name="training_datestart[]" readonly="" autocomplete="off" required="" value="{{ $item->datestartinput }}">
                                                            <span class="add-on"><i class="icon-th"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>ถึงวันที่</label>
                                                        <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                                            <input type="text" disabled class="form-control" name="training_dateend[]" readonly="" autocomplete="off" required="" value="{{ $item->dateendinput }}">
                                                            <span class="add-on"><i class="icon-th"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>หลักสูตร</label>
                                                        <input type="text" disabled name="course[]" class="form-control" value="{{ $item->register_training_course }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>หน่วยงาน</label>
                                                        <input type="text" disabled name="department[]" class="form-control" value="{{ $item->register_training_department }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach
                                        @endif

                                    </div>
                                </div>    
                            </div>

                            <div class="tab-pane fade" id="styleTab_expereince">
                                <div class="row ">
                                    <div class="col-md-12 input_experience">
                                        
                                        {{-- <button type="button" class="btn btn-success add_experience"> <i class="fa fa-plus"></i> เพิ่มประสบการณ์ทำงาน</button>
                                        <button type="button" class="btn btn-danger remove_experience"><i class="fa fa-times"></i> ลบรายการ</button>

                                        <hr> --}}

                                        @if( count( $registerexperience ) > 0 )
                                        @foreach( $registerexperience as $key => $item )
                                        @if( $key == 0 )
                                        <div class="row removeexp1">
                                        @else
                                        <div class="row removeexp{{ $key + 1 }}">
                                        @endif
                                            <div class="col-md-12">
                                                <input type="hidden" name="experience_id[]" class="form-control" value="{{ $item->register_experience_id }}" />
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>วันเริ่มทำงาน</label>
                                                        <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                                                            <input type="text" disabled class="form-control" name="experience_datestart[]" readonly="" autocomplete="off" required="" value="{{ $item->datestartinput }}">
                                                            <span class="add-on"><i class="icon-th"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>วันสิ้นสุดทำงาน</label>
                                                        <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                                                            <input type="text" disabled class="form-control" name="experience_dateend[]" readonly="" autocomplete="off" required="" value="{{ $item->dateendinput }}">
                                                            <span class="add-on"><i class="icon-th"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>บริษัท/องค์กร</label>
                                                        <input type="text" disabled name="experience_company[]" class="form-control" value="{{ $item->register_experience_company }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>ตำแหน่ง</label>
                                                        <input type="text" disabled name="experience_position[]" class="form-control" value="{{ $item->register_experience_position }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>ลักษณะงาน</label>
                                                        <input type="text" disabled name="experience_description[]" class="form-control" value="{{ $item->register_experience_description }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>สาเหตุที่ออก</label>
                                                        <input type="text" disabled name="experience_resign[]" class="form-control" value="{{ $item->register_experience_resign }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="styleTab_attachment">
                                {{-- <div class="row ">
                                    <div class="col-md-12">
                                        <label>เอกสารแนบ <span class="text-danger">*ขนาดไฟล์ไม่เกิน 3MB และรวมทั้งหมดไม่เกิน 10MB</span></label>
                                    	<input type="file" name="document[]"  id="doc" class="filestyle" multiple="" />
                                    </div>
                                </div> --}}

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
                                            @if( count($registerdocument) > 0 )
                                            @foreach( $registerdocument as $item )
                                            <tr>
                                                <td>{{ $item->register_document_name }}</td>
                                                <td><a href="{{ asset($item->register_document_file) }}" class="btn btn-info text-right" target="_blank"> <i class="fa fa-download"></i> ดาวน์โหลด</a> </td>
                                                <td><a href="{{ url('recurit/register/section/delete-file/'.$item->register_document_id) }}" class="btn btn-danger text-right"><i class="fa fa-remove"></i> ลบ</a> </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="styleTab_personcase">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>รหัสสำนักงานเจ้าของคดี</label>
                                            <input disabled type="number" min="0" name="register_office_case" class="form-control"  value="{{ $register->register_office_case }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>เลขทะเบียนคดี</label>
                                        <input type="text" disabled name="register_number_case" class="form-control"  value="{{ $register->register_number_case }}" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ประเภทคดี</label>
                                            <select class="form-control"  disabled  name="register_type_case" >
                                                @if( count($registertype) > 0 )
                                                @foreach( $registertype as $item )
                                                    <option value="{{ $item->register_type_id }}" @if ($item->register_type_id  == $register->register_type_case) selected  @endif >{{ $item->register_type_name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ปีทะเบียนคดี</label>
                                            <input disabled type="number" min="1111" max="9999" name="register_year_case" class="form-control" value="{{ $register->register_year_case }}" />
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
            alert('ขนาดไฟล์รวมกันเกิน 10MB');
        }
    });

    $(document).on('click', '#modalcert', function(e){
        e.preventDefault();

        $('#cert').modal('show');

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


    if ("{{ $register->starthiredate }}" != '0000-00-00' ) {
        $('#starthiredate').datepicker({
            format: 'dd/mm/yyyy',
            language: 'th',     
            autoclose: true,         
            thaiyear: true              
        }).datepicker("setDate", "{{ $register->starthireinput }}");  
    }
    if ("{{ $register->endhiredate }}" != '0000-00-00' ) {
        $('#endhiredate').datepicker({
            format: 'dd/mm/yyyy',
            language: 'th',  
            autoclose: true,             
            thaiyear: true              
        }).datepicker("setDate", "{{ $register->endhireinput }}");  
    }

    $('#birthday').datepicker({
        format: 'dd/mm/yyyy',
        language: 'th',  
        autoclose: true,             
        thaiyear: true              
    }).datepicker("setDate", "{{ $register->birthdayinputeng }}"); 

    $("#person_id").change(function(){
        $.ajax({
            type:"get",
            url:"{{ url('api/register-person') }}",
            data:{
                person_id : $("#person_id").val(),
            },
            success : function(data){
                $("#response_person_id").text(data);
            }
        })
    })


    $.ajax({
        type:"get",
        url : "{{ url('api/province') }}",
        dataType:"Json",
        data : {
            province : "{{ $register->province_id }}"
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
            province : "{{ $register->province_id }}",
            amphur : "{{ $register->amphur_id }}",
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
            amphur : "{{ $register->amphur_id }}",
            district : "{{ $register->district_id }}"
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
            // $("#amphur").select2();

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
            province : "{{ $register->province_id_now }}"
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
            province : "{{ $register->province_id_now }}",
            amphur : "{{ $register->amphur_id_now }}",
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
            amphur :  "{{ $register->amphur_id_now }}",
            district : "{{ $register->district_id_now }}"
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
        }
    })


    $(".remove_training").prop("disabled",false);
    var max_training      = 10; //maximum input boxes allowed
    var wrapper_training         = $(".input_training"); //Fields wrapper
    var add_training      = $(".add_training"); //Add button ID
    var html_training = "";
    var number_training = $('input[name="training_datestart[]"]').length ;    // "{{ count($registertraining) }}"; //initlal text box count

    $(add_training).click(function(e){ //on add input button click
        if(number_training < max_training){ //max input box allowed
            number_training++; //text box increment
            
            html_training =  "<div class='row removetraining"+number_training+"'>";
            html_training += "<div class='col-md-12'>";
            html_experience += "<input type='hidden' name='training_id[]' required=''>";
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
        if( number_training > 0 ){

            index=$('input[name="training_id[]"]').length;
            var names=document.getElementsByName('training_id[]');
            training_id = names[index-1].value;

            $(".removetraining"+number_training).remove(); number_training--;
            $(add_training).prop("disabled" , false);

            $(function(){
                $.ajax({
                    type:"get",
                    url:"{{ url('api/deleteregistertraining') }}",
                    dataType:"Html",
                    data:{
                        training_id : training_id,
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

    //end tab 2

    $(".remove_experience").prop("disabled",false);
    var max_experience      = 10; //maximum input boxes allowed
    var wrapper_experience         = $(".input_experience"); //Fields wrapper
    var add_experience      = $(".add_experience"); //Add button ID
    var html_experience = "";
    var number_experience =  $('input[name="experience_datestart[]"]').length ;// "{{ count($registerexperience) }}"; //initlal text box count

    $(add_experience).click(function(e){ //on add input button click
        if(number_experience < max_experience){ //max input box allowed
            number_experience++; //text box increment
            
            html_experience =  "<div class='row removeexp"+number_experience+"'>";
            html_experience += "<div class='col-md-12'>";
            html_experience += "<input type='hidden' name='experience_id[]' required=''>";
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
        if( number_experience > 0 ){

            index=$('input[name="experience_id[]"]').length;
            var names=document.getElementsByName('experience_id[]');
            experience_id = names[index-1].value;

            $(".removeexp"+number_experience).remove(); number_experience--;
            $(add_experience).prop("disabled" , false);

            $(function(){
                $.ajax({
                    type:"get",
                    url:"{{ url('api/deleteregisterexpereince') }}",
                    dataType:"Html",
                    data:{
                        experience_id : experience_id,
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
@stop