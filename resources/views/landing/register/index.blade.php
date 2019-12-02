@extends('layout.singleblog')

@section('pageCss')
@stop

@section('blogcontent')

<div class="padding-md">

    {!! Form::open([ 'url' => 'landing/register/create' , 'method' => 'post' , 'files' => 'true' ]) !!} 
    <input type="hidden" name="departmentid" value="{{ $departmentid }}">
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                แบบฟอร์มสมัครจ้างเหมา ปีงบประมาณ  : {{ $project->year_budget }}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> ส่งข้อมูลการสมัคร</a>
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
                    <div class="form-group">
                        <label>ตำแหน่งที่จ้าง</label>
                        <select class="form-control" name="position" required>
                            @if( count($position) > 0 )
                            @foreach( $position as $item )
                                <option value="{{ $item->position_id }}">{{ $item->position_name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">
                    รายการสำรวจ
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
                                                <label>หมายเลขบัตรประชาชน</label>
                                                <input type="text" name="person_id" id="person_id" class="form-control" required="" />
                                                <span class="help-block text-danger" id="response_person_id"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>คำขึ้นต้น</label>
                                            <select class="form-control" name="prefix" required>
                                                @if( count($prefix) > 0 )
                                                @foreach( $prefix as $item )
                                                    <option value="{{ $item->prefix_id }}">{{ $item->prefix_name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>ชื่อ</label>
                                            <input type="text" name="name" class="form-control" required="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>นามสกุล</label>
                                                <input type="text" name="lastname" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>วัน/เดือน/ปี เกิด</label>
                                            <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                                <input type="text" class="form-control" name="birthday" readonly="" autocomplete="off" required="">
                                                <span class="add-on"><i class="icon-th"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>เลือกไฟล์รูปถ่าย</label>
                                            <input type="file" name="picture" id="picture" class="filestyle" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>สัญชาติ</label>
                                                <input type="text" name="nationality" class="form-control" value="ไทย" required="" />
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>เชื้อชาติ</label>
                                            <input type="text" name="ethnicity" class="form-control" value="ไทย" required="" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>ศาสนา</label>
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
                                                <label>การรับราชการทหาร</label>
                                                <select class="form-control" name="military" required>
                                                    @if( count($military) > 0 )
                                                    @foreach( $military as $item )
                                                        <option value="{{ $item->military_id }}">{{ $item->military_name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>สถานะ</label>
                                            <select class="form-control" name="married" required>
                                                @if( count($married) > 0 )
                                                @foreach( $married as $item )
                                                    <option value="{{ $item->married_id }}">{{ $item->married_name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>จำนวนบุตร</label>
                                            <input type="number" name="baby" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                                <label>โทรศัพท์</label>
                                                <input type="text" name="phone" class="form-control" required />
                                            </div>
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
                                    </div>
                                </div>
                            <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อบิดา</label>
                                                <input type="text" name="father_name" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>นามสกุลบิดา</label>
                                            <input type="text" name="father_lastname" class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>อาชีพบิดา</label>
                                            <input type="text" name="father_career" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>ชื่อมารดา</label>
                                                <input type="text" name="mother_name" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>นามสกุลมารดา</label>
                                            <input type="text" name="mother_lastname" class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>อาชีพมารดา</label>
                                            <input type="text" name="mother_career" class="form-control" />
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
                                                <label>ชื่อผู้ติดต่อเร่งด่วน</label>
                                                <input type="text" name="urgent_name" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>สกุลผู้ติดต่อเร่งด่วน</label>
                                            <input type="text" name="urgent_lastname" class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>ความสัมพันธ์</label>
                                            <input type="text" name="urgent_relationship" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>เบอร์โทร</label>
                                                <input type="text" name="urgent_phone" class="form-control" />
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
                                                <label>เลขที่</label>
                                                <input type="text" name="address" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>จังหวัด</label>
                                                <select class="form-control " id="province" name="province"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>อำเภอ</label>
                                                <select class="form-control " id="amphur" name="amphur"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ตำบล</label>
                                                <select class="form-control " id="district" name="district"></select>
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
                                                <label>เลขที่</label>
                                                <input type="text" name="address_now" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>จังหวัด</label>
                                                <select class="form-control" id="now_province" name="province_now"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>อำเภอ</label>
                                                <select class="form-control" id="now_amphur" name="amphur_now"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ตำบล</label>
                                                <select class="form-control" id="now_district" name="district_now"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- ./tab-pane -->
                            <div class="tab-pane fade" id="style3Tab2">

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

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ความสามารถโปรแกรม MS</label>
                                                <select class="select2 width-100" name="software[]" multiple=""   style="width:100%">
                                                    @if( count($software) > 0 )
                                                    @foreach( $software as $item )
                                                        <option value="{{ $item->software_id }}">{{ $item->software_name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ความสามารถโปรแกรมอื่นๆ</label>
                                                <input type="text" name="software_about" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ความสามารถพิเศษ</label>
                                                <select class="select2 width-100" name="skill[]" multiple="" style="width:100%">
                                                    @if( count($skill) > 0 )
                                                    @foreach( $skill as $item )
                                                        <option value="{{ $item->skill_id }}">{{ $item->skill_name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ความสามารถพิเศษอื่นๆ</label>
                                                <input type="text" name="skill_about" class="form-control" />
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
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="style3Tab4">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label>เอกสารแนบ <span class="text-danger">*เป็นไฟล์ pdf เท่านั้น เช่น บัตรประชาชน.pdf</span></label>
                                    	<input type="file" name="document[]" multiple="" id="doc" class="filestyle" />
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
    
    //Select2
    $('.select2').select2();

    $('#doc').filestyle({
        buttonName : 'btn-success',
        buttonText : ' เลือกไฟล์',
         input: false,
        icon: false,
    });

    $('#picture').filestyle({
        buttonName : 'btn-success btn-xs',
        buttonText : ' เลือกไฟล์',
         input: false,
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

    $("#person_id").change(function(){
        $.ajax({
            type:"get",
            dataType:"Html",
            url:"{{ url('api/register-contractor') }}",
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

    //now address
    //end tab1

    //end tab 2

    $(".remove_experience").prop("disabled",true);
    var max_experience  = 10; //maximum input boxes allowed
    var wrapper_experience  = $(".input_experience"); //Fields wrapper
    var add_experience = $(".add_experience"); //Add button ID
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
</script>
@stop