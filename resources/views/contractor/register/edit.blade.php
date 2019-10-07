@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('contractor/register') }}">ผู้สมัครจ้างเหมาบุคลากรช่วยปฏิบัติงาน</a></li>
        <li>แบบฟอร์มแก้ไขเข้าร่วมโครงการ</li>    
    </ul>

    {!! Form::open([ 'url' => 'contractor/register/edit' , 'method' => 'post' , 'files' => 'true' , 'multiple'  ]) !!} 
    <input type="hidden" name="id" value="{{ $contractor->contractor_id }}" />
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ข้อมูลผู้สมัคร : {{ $contractor->name }} {{ $contractor->lastname }}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('contractor/register/application/'.$contractor->contractor_id) }}" class="btn btn-success">แบบฟอร์มผู้สมัคร</a>
                <a href="{{ url('contractor/register/compact/'.$contractor->contractor_id) }}" class="btn btn-success">ข้อตกลงจ้างเหมา</a>
                <button type="submit" name="submit" value="consider" class="btn btn-success">บันทึกผลพิจารณา</button>
                <button type="submit" name="submit" value="editsave" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
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
                            <input type="radio" id="radio1" name="stackRadio" value="0" {{ $contractor->contractor_type==0?'checked':'' }} >
                            <label for="radio1"></label>
                        </div>
                        <div class="inline-block vertical-top">
                            ยังไม่ได้คัดเลือก
                        </div>
                    </div>
                    <div class="radio">
                        <div class="custom-radio m-right-xs">
                            <input type="radio" id="radio2" name="stackRadio" value="1" {{ $contractor->contractor_type==1?'checked':'' }}>
                            <label for="radio2"></label>
                        </div>
                        <div class="inline-block vertical-top">
                          ผ่านการพิจารณา
                        </div>      
                    </div>
                    <div class="radio">
                        <div class="custom-radio m-right-xs">
                            <input type="radio" id="radio3" name="stackRadio" value="2" {{ $contractor->contractor_type==2?'checked':'' }}>
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
                <img src="{{ asset( $contractor->picture ) }}" width="120" height="140">
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
                <div class="col-md-8">
                    <div class="form-group">
                        <label>ตำแหน่งที่จ้าง</label><small class="text-danger">*</small>
                        <select class="form-control" name="position" id="position"></select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label>เลขที่ใบสมัคร </label><small class="text-danger">*</small>
                    <input type="text" name="application_no" class="form-control" value="{{ $contractor->application_no }}" required />
                </div>
            </div>
            @if ($contractor->contractor_type==1)
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-4">
                    <label>วันที่เริ่มจ้างงาน</label>
                    <div id="starthiredate"  class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                        <input type="text" class="form-control" name="starthiredate"  autocomplete="off" >
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label>วันที่เริ่มจ้างสิ้นสุด</label>
                    <div id="endhiredate"  class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                        <input type="text" class="form-control" name="endhiredate"  autocomplete="off" >
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label>เลขที่สัญญาจ้าง</label>
                    <input type="text" name="contract_no" value="{{ $contractor->contract_no }}"  class="form-control"  />
                </div>
            </div> 
            <hr>
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <label>ผู้ลงนามสัญญา</label>
                        <input type="text" class="form-control" name="representativename"  value="{{ $register->representativename }}" autocomplete="off" >
                    </div>
                    <div class="col-md-12">
                        <label>ตำแหน่ง</label>                      
                        <input type="text" class="form-control" name="representativeposition" value="{{ $register->representativeposition }}" autocomplete="off" >
                    </div>
                </div>
            </div>   
            @endif
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">
                    ข้อมูลผู้สมัคร
                </div>
                <div class="smart-widget-inner">
                    <div class="widget-tab clearfix">
                        <ul class="tab-bar">
                            <li class="active"><a href="#style3Tab1" data-toggle="tab"><i class="fa fa-list"></i> ข้อมูลส่วนตัว</a></li>
                            <li class=""><a href="#style3Tab2" data-toggle="tab"><i class="fa fa-picture-o"></i> ประวัติการศึกษา</a></li>
                            <li class=""><a href="#style3Tab3" data-toggle="tab"><i class="fa fa-picture-o"></i> ประสบการณ์ทำงาน</a></li>
                            <li class=""><a href="#style3Tab4" data-toggle="tab"><i class="fa fa-picture-o"></i> เอกสารแนบ</a></li>
                        </ul>
                    </div>
                    <div class="smart-widget-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="style3Tab1">
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>หมายเลขบัตรประชาชน</label><small class="text-danger">*</small>
                                                <input type="text" name="person_id" id="person_id" class="form-control" required="" value="{{ $contractor->person_id }}" />
                                                <span class="help-block text-danger" id="response_person_id"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>คำนำหน้าชื่อ</label><small class="text-danger">*</small>
                                            <select class="form-control" name="prefix" id="prefix"></select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>ชื่อ</label><small class="text-danger">*</small>
                                            <input type="text" name="name" class="form-control" required="" value="{{ $contractor->name }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>นามสกุล</label><small class="text-danger">*</small>
                                                <input type="text" name="lastname" class="form-control" value="{{ $contractor->lastname }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>วัน/เดือน/ปี เกิด</label><small class="text-danger">*</small>
                                            <div id="birthday" class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                                                <input type="text" class="form-control" name="birthday" autocomplete="off" required="">
                                                <span class="add-on"><i class="icon-th"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>เลือกไฟล์</label>
                                            <input type="file" name="picture" id="picture" class="filestyle" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>สัญชาติ</label><small class="text-danger">*</small>
                                                <input type="text" name="nationality" class="form-control" required="" value="{{ $contractor->nationality }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>เชื้อชาติ</label><small class="text-danger">*</small>
                                            <input type="text" name="ethnicity" class="form-control" required="" value="{{ $contractor->ethnicity }}" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>ศาสนา</label><small class="text-danger">*</small>
                                            <select class="form-control" name="religion" id="religion"></select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>การรับราชการทหาร</label><small class="text-danger">*</small>
                                                <select class="form-control" name="military" id="military"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>สถานะ</label><small class="text-danger">*</small>
                                            <select class="form-control" name="married" id="married"></select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>จำนวนบุตร</label>
                                            <input type="number" name="baby" class="form-control" value="{{ $contractor->baby }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <label>โทรศัพท์</label><small class="text-danger">*</small>
                                            <input type="text" name="phone" class="form-control" value="{{ $contractor->phone }}" />
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>อีเมลล์</label>
                                                <input type="text" name="email" class="form-control" value="{{ $contractor->email }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>เฟสบุ๊ค</label>
                                            <input type="text" name="facebook" class="form-control" value="{{ $contractor->facebook }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อบิดา</label>
                                                <input type="text" name="father_name" class="form-control" value="{{ $contractor->father_name }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>นามสกุลบิดา</label>
                                            <input type="text" name="father_lastname" class="form-control" value="{{ $contractor->lastname }}" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>อาชีพบิดา</label>
                                            <input type="text" name="father_career" class="form-control" value="{{ $contractor->father_career }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อมารดา</label>
                                                <input type="text" name="mother_name" class="form-control" value="{{ $contractor->mother_name }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>นามสกุลมารดา</label>
                                            <input type="text" name="mother_lastname" class="form-control" value="{{ $contractor->mother_lastname }}" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>อาชีพมารดา</label>
                                            <input type="text" name="mother_career" class="form-control" value="{{ $contractor->mother_career }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อคู่สมรส</label>
                                                <input type="text" name="spouse_name" class="form-control" value="{{ $contractor->spouse_name }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>นามสกุลคู่สมรส</label>
                                            <input type="text" name="spouse_lastname" class="form-control" value="{{ $contractor->spouse_lastname }}" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>อาชีพคู่สมรส</label>
                                            <input type="text" name="spouse_career" class="form-control" value="{{ $contractor->spouse_career }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อผู้ติดต่อเร่งด่วน</label><small class="text-danger">*</small>
                                                <input type="text" name="urgent_name" class="form-control" value="{{ $contractor->urgent_name }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>สกุลผู้ติดต่อเร่งด่วน</label><small class="text-danger">*</small>
                                            <input type="text" name="urgent_lastname" class="form-control" value="{{ $contractor->urgent_lastname }}" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>ความสัมพันธ์</label><small class="text-danger">*</small>
                                            <input type="text" name="urgent_relationship" class="form-control" value="{{ $contractor->urgent_relationship }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>เบอร์โทร</label>
                                                <input type="text" name="urgent_phone" class="form-control" value="{{ $contractor->urgent_phone }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>อีเมล์</label>
                                            <input type="text" name="urgent_email" class="form-control" value="{{ $contractor->urgent_email }}" />
                                        </div>
                                    </div>
                                </div>

                                <hr />

                                <h3>เลขที่ตามทะเบียนบ้าน</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>เลขที่</label><small class="text-danger">*</small>
                                                <input type="text" name="address" class="form-control" value="{{ $contractor->address }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>หมู่ที่</label>
                                                <input type="text" name="moo" class="form-control" value="{{ $contractor->moo }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ถนน/ซอย</label>
                                                <input type="text" name="soi" class="form-control" value="{{ $contractor->soi }}" />
                                            </div>
                                        </div>                                       
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>จังหวัด</label><small class="text-danger">*</small>
                                                <select class="form-control " id="province" name="province"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>อำเภอ</label><small class="text-danger">*</small>
                                                <select class="form-control " id="amphur" name="amphur"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ตำบล</label><small class="text-danger">*</small>
                                                <select class="form-control " id="district" name="district"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>รหัสไปรษณีย์</label><small class="text-danger">*</small>
                                                <input type="text" name="postalcode" class="form-control" value="{{ $contractor->postalcode }}"  />
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
                                                <input type="text" name="address_now" class="form-control" value="{{ $contractor->address_now }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>หมู่ที่</label>
                                                <input type="text" name="moo_now" class="form-control" value="{{ $contractor->moo_now }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ถนน/ซอย</label>
                                                <input type="text" name="soi_now" class="form-control" value="{{ $contractor->soi_now }}" />
                                            </div>
                                        </div>                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>จังหวัด</label><small class="text-danger">*</small>
                                                <select class="form-control" id="now_province" name="province_now"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>อำเภอ</label><small class="text-danger">*</small>
                                                <select class="form-control" id="now_amphur" name="amphur_now"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ตำบล</label><small class="text-danger">*</small>
                                                <select class="form-control" id="now_district" name="district_now"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>รหัสไปรษณีย์</label><small class="text-danger">*</small>
                                                <input type="text" name="postalcode_now" class="form-control" value="{{ $contractor->postalcode_now }}"  />
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div><!-- ./tab-pane -->
                            <div class="tab-pane fade" id="style3Tab2">

                            	@if( count($education) > 0 )
                            	@foreach( $education as $item )
                                    @php( $value = $contractoreducation->where('education_id' , $item->education_id)->first() )
                            		<div class="row">
	                                    <div class="col-md-12">
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>{{ $item->education_name }}</label>
                                                    @if( count($value) > 0 )
	                                                <input type="text" name="education_name[{{ $item->education_id }}]" class="form-control"  value="{{ $value->contractor_education_name }}" />
                                                    @else
                                                    <input type="text" name="education_name[{{ $item->education_id }}]" class="form-control"  />
                                                    @endif
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="form-group">
	                                                <label>ปี พ.ศ. ตั้งแต่ - ถึง</label>
                                                    @if( count($value) > 0 )
	                                                <input type="text" name="education_year[{{ $item->education_id }}]" class="form-control" value="{{ $value->contractor_education_year }}" />
                                                    @else
                                                    <input type="text" name="education_year[{{ $item->education_id }}]" class="form-control" />
                                                    @endif
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
                            	@endforeach
                            	@endif


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ความสามารถโปรแกรม MS</label>
                                                <select class="select2 width-100" name="software[]" multiple="" style="width:100%">
                                                    @if( count($software) > 0 )
                                                    @foreach( $software as $item )
                                                        @php( $value = $contractorsoftware->where('software_id' , $item->software_id)->first() )
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ความสามารถโปรแกรมอื่นๆ</label>
                                                <input type="text" name="software_about" class="form-control" value="{{ $contractor->software_about }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ความสามารถพิเศษ</label>
                                                <select class="select2 width-100"  name="skill[]" multiple="" style="width:100%">
                                                    @if( count($skill) > 0 )
                                                    @foreach( $skill as $item )
                                                        @php( $value = $contractorskill->where('skill_id' , $item->skill_id)->first() )
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ความสามารถพิเศษอื่นๆ</label>
                                                <input type="text" name="skill_about" class="form-control" value="{{ $contractor->skill_about }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="tab-pane fade" id="style3Tab3">
                                <div class="row ">
                                    <div class="col-md-12 input_experience">
                                        
                                        <button type="button" class="btn btn-success add_experience"> <i class="fa fa-plus"></i> เพิ่มรายการประสบการณ์ทำงาน</button>
                                        <button type="button" class="btn btn-danger remove_experience"><i class="fa fa-times"></i> ลบรายการ</button>

                                        <br />

                                        @if( count( $contractorexperience ) > 0 )
                                        @foreach( $contractorexperience as $key => $item )
                                        @if( $key == 0 )
                                        <div class="row removeexp1">
                                        @else
                                        <div class="row removeexp{{ $key + 1 }}">
                                        @endif
                                            <div class="col-md-12">
                                                <div class="col-md-2">
                                                        <input type="hidden" name="exp_id[]" class="form-control" value="{{ $item->contractor_experience_id }}" />
                                                    <div class="form-group">
                                                        <label>วันเริ่มทำงาน</label>
                                                        <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                                            <input type="text" class="form-control" name="experience_datestart[]" readonly="" autocomplete="off" required="" value="{{ $item->datestartinput }}">
                                                            <span class="add-on"><i class="icon-th"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>วันสิ้นสุดทำงาน</label>
                                                        <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                                            <input type="text" class="form-control" name="experience_dateend[]" readonly="" autocomplete="off" required="" value="{{ $item->dateendinput }}">
                                                            <span class="add-on"><i class="icon-th"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>บริษัท/องค์กร</label>
                                                        <input type="text" name="experience_company[]" class="form-control" value="{{ $item->contractor_experience_company }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>ตำแหน่ง</label>
                                                        <input type="text" name="experience_position[]" class="form-control" value="{{ $item->contractor_experience_position }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>ลักษณะงาน</label>
                                                        <input type="text" name="experience_description[]" class="form-control" value="{{ $item->contractor_experience_description }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>สาเหตุที่ออก</label>
                                                        <input type="text" name="experience_resign[]" class="form-control" value="{{ $item->contractor_experience_resign }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="style3Tab4">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label>เอกสารแนบ <span class="text-danger">*เป็นไฟล์ pdf เท่านั้น และตั้งชื่อให้ตรงเอกสาร เช่น บัตรประชาชน.pdf</span></label>
                                    	<input type="file" name="document[]"  id="doc" class="filestyle" multiple="" />
                                    </div>
                                </div>

                                <br />
                                <div class="table">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ชื่อไฟล์</th>
                                                <th>ดาวน์โลหด</th>
                                                <th>เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if( count($contractordocument) > 0 )
                                            @foreach( $contractordocument as $item )
                                            <tr>
                                                <td>{{ $item->contractor_document_name }}</td>
                                                <td><a href="{{ asset($item->contractor_document_file) }}" class="btn btn-info text-right" target="_blank"> <i class="fa fa-download"></i> ดาวน์โหลด</a> </td>
                                                <td><a href="{{ url('contractor/register/delete-file/'.$item->contractor_document_id) }}" class="btn btn-danger text-right"><i class="fa fa-remove"></i> ลบ</a> </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
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

    if ("{{ $contractor->starthiredate }}" != '0000-00-00' ) {
        $('#starthiredate').datepicker({
            format: 'dd/mm/yyyy',
            language: 'th',     
            autoclose: true,         
            thaiyear: true              
        }).datepicker("setDate", "{{ $contractor->starthiredateinput }}");  
    }
    if ("{{ $contractor->endhiredate }}" != '0000-00-00' ) {
        $('#endhiredate').datepicker({
            format: 'dd/mm/yyyy',
            language: 'th',  
            autoclose: true,             
            thaiyear: true              
        }).datepicker("setDate", "{{ $contractor->endhiredateinput }}");  
    }

    $('#birthday').datepicker({
        format: 'dd/mm/yyyy',
        language: 'th',  
        autoclose: true,             
        thaiyear: true              
    }).datepicker("setDate", "{{ $contractor->birthdayinputeng }}"); 


    $('.datepicker').datepicker({
        language: 'th',
        format : "dd/mm/yyyy",
        thaiyear: true,
        autoclose:false,
    });

    $("#person_id").change(function(){
        $.ajax({
            type:"get",
            url:"{{ url('api/contractor-contractor') }}",
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
        url:"{{ url('api/contractorposition') }}",
        dataType:"Json",
        data:{
            position : "{{ $contractor->position_id }}",
        },
        success : function(data){
            var html = "<option value=''>เลือก ตำแหน่งที่จ้าง</option>";
            if(data.row > 0){
                for(var i=0;i<data.row;i++){
                    if( data.position[i].position_id == data.filter ){
                        html += "<option value='"+ data.position[i].position_id +"' selected >"+ data.position[i].position_name +"</option>"
                    }
                    else{
                        html += "<option value='"+ data.position[i].position_id +"' > "+ data.position[i].position_name +"</option>"
                    }
                }
            }

            $("#position").html(html);
        }
    })

    $.ajax({
        type:"get",
        url:"{{ url('api/prefix') }}",
        dataType:"Json",
        data:{
            prefix : "{{ $contractor->prefix_id }}",
        },
        success : function(data){
            var html = "<option value=''>เลือก คำนำหน้าชื่อ</option>";
            if(data.row > 0){
                for(var i=0;i<data.row;i++){
                    if( data.prefix[i].prefix_id == data.filter ){
                        html += "<option value='"+ data.prefix[i].prefix_id +"' selected >"+ data.prefix[i].prefix_name +"</option>"
                    }
                    else{
                        html += "<option value='"+ data.prefix[i].prefix_id +"' > "+ data.prefix[i].prefix_name +"</option>"
                    }
                }
            }

            $("#prefix").html(html);
        }
    })

    $.ajax({
        type:"get",
        url:"{{ url('api/religion') }}",
        dataType:"Json",
        data:{
            religion : "{{ $contractor->religion_id }}",
        },
        success : function(data){
            var html = "<option value=''>เลือก ศาสนา</option>";
            if(data.row > 0){
                for(var i=0;i<data.row;i++){
                    if( data.religion[i].religion_id == data.filter ){
                        html += "<option value='"+ data.religion[i].religion_id +"' selected >"+ data.religion[i].religion_name +"</option>"
                    }
                    else{
                        html += "<option value='"+ data.religion[i].religion_id +"' > "+ data.religion[i].religion_name +"</option>"
                    }
                }
            }

            $("#religion").html(html);
        }
    })

    $.ajax({
        type:"get",
        url:"{{ url('api/married') }}",
        dataType:"Json",
        data:{
            married : "{{ $contractor->married_id }}",
        },
        success : function(data){
            var html = "<option value=''>เลือก สถานะ</option>";
            if(data.row > 0){
                for(var i=0;i<data.row;i++){
                    if( data.married[i].married_id == data.filter ){
                        html += "<option value='"+ data.married[i].married_id +"' selected >"+ data.married[i].married_name +"</option>"
                    }
                    else{
                        html += "<option value='"+ data.married[i].married_id +"' > "+ data.married[i].married_name +"</option>"
                    }
                }
            }

            $("#married").html(html);
        }
    })

    $.ajax({
        type:"get",
        url:"{{ url('api/military') }}",
        dataType:"Json",
        data:{
            military : "{{ $contractor->military_id }}",
        },
        success : function(data){
            var html = "<option value=''>เลือก การรับราชการทหาร</option>";
            if(data.row > 0){
                for(var i=0;i<data.row;i++){
                    if( data.military[i].military_id == data.filter ){
                        html += "<option value='"+ data.military[i].military_id +"' selected >"+ data.military[i].military_name +"</option>"
                    }
                    else{
                        html += "<option value='"+ data.military[i].military_id +"' > "+ data.military[i].military_name +"</option>"
                    }
                }
            }

            $("#military").html(html);
        }
    })

    $.ajax({
        type:"get",
        url:"{{ url('api/software') }}",
        dataType:"Json",
        data:{
            software : "{{ $contractor->software_id }}",
        },
        success : function(data){
            var html = "<option value=''>เลือก โปรแกรมที่ใช้งานได้</option>";
            if(data.row > 0){
                for(var i=0;i<data.row;i++){
                    if( data.software[i].software_id == data.filter ){
                        html += "<option value='"+ data.software[i].software_id +"' selected >"+ data.software[i].software_name +"</option>"
                    }
                    else{
                        html += "<option value='"+ data.software[i].software_id +"' > "+ data.software[i].software_name +"</option>"
                    }
                }
            }

            $("#software").html(html);
        }
    })

    $.ajax({
        type:"get",
        url:"{{ url('api/skill') }}",
        dataType:"Json",
        data:{
            skill : "{{ $contractor->skill_id }}",
        },
        success : function(data){
            var html = "<option value=''>เลือก ความสามารถพิเศษ</option>";
            if(data.row > 0){
                for(var i=0;i<data.row;i++){
                    if( data.skill[i].skill_id == data.filter ){
                        html += "<option value='"+ data.skill[i].skill_id +"' selected >"+ data.skill[i].skill_name +"</option>"
                    }
                    else{
                        html += "<option value='"+ data.skill[i].skill_id +"' > "+ data.skill[i].skill_name +"</option>"
                    }
                }
            }

            $("#skill").html(html);
        }
    })
    //------------------

    $.ajax({
        type:"get",
        url : "{{ url('api/province') }}",
        dataType:"Json",
        data : {
            province : "{{ $contractor->province_id }}"
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
            province : "{{ $contractor->province_id }}",
            amphur : "{{ $contractor->amphur_id }}",
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
            amphur : "{{ $contractor->amphur_id }}",
            district : "{{ $contractor->district_id }}"
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
            province : "{{ $contractor->province_id_now }}"
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
            province : "{{ $contractor->province_id_now }}",
            amphur : "{{ $contractor->amphur_id_now }}",
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
            amphur :  "{{ $contractor->amphur_id_now }}",
            district : "{{ $contractor->district_id_now }}"
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

    //now address
    //end tab1


    $.ajax({
        type:"get",
        url:"{{ url('api/software') }}",
        dataType:"Json",
        data:{
            software : "{{ $contractor->software_id }}",
        },
        success : function(data){
            var html = "<option value=''>เลือก ความสามารถโปรแกรม</option>";
            if(data.row > 0){
                for(var i=0;i<data.row;i++){
                    if( data.software[i].software_id == data.filter ){
                        html += "<option value='"+ data.software[i].software_id +"' selected >"+ data.software[i].software_name +"</option>"
                    }
                    else{
                        html += "<option value='"+ data.software[i].software_id +"' > "+ data.software[i].software_name +"</option>"
                    }
                }
            }

            $("#software").html(html);
        }
    })

    $.ajax({
        type:"get",
        url:"{{ url('api/skill') }}",
        dataType:"Json",
        data:{
            skill : "{{ $contractor->skill_id }}",
        },
        success : function(data){
            var html = "<option value=''>เลือก ความสามารถพิเศษ</option>";
            if(data.row > 0){
                for(var i=0;i<data.row;i++){
                    if( data.skill[i].skill_id == data.filter ){
                        html += "<option value='"+ data.skill[i].skill_id +"' selected >"+ data.skill[i].skill_name +"</option>"
                    }
                    else{
                        html += "<option value='"+ data.skill[i].skill_id +"' > "+ data.skill[i].skill_name +"</option>"
                    }
                }
            }

            $("#skill").html(html);
        }
    })

    //end tab 2

    $(".remove_experience").prop("disabled",false);
    var max_experience      = 10; //maximum input boxes allowed
    var wrapper_experience  = $(".input_experience"); //Fields wrapper
    var add_experience      = $(".add_experience"); //Add button ID
    var html_experience = "";
    var number_experience = $('input[name="exp_id[]"]').length ;// "{{ count($contractorexperience) }}"; //initlal text box count

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

            $(wrapper_experience).append(html_experience); //add input box

            $('.datepicker').datepicker({
                language: 'th',
                format : "dd/mm/yyyy",
                thaiyear: true,
                autoclose:false,
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
            index=$('input[name="experience_datestart[]"]').length;
                var names=document.getElementsByName('experience_datestart[]');
                startdate = names[index-1].value;
            $(".removeexp"+number_experience).remove(); number_experience--;
            $(function(){
                $.ajax({
                    type:"get",
                    url:"{{ url('api/deletecontractorexp') }}",
                    dataType:"Html",
                    data:{
                        startdate : startdate,
                    },
                    success : function(data){
                        if(data != ""){
                            alert(data);
                        }
                    }
                })
            })

            $(add_experience).prop("disabled" , false);
        }

    })
</script>
@stop