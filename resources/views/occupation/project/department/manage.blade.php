@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
{!! Form::open([ 'url' => 'occupation/project/department/manage' , 'method' => 'post' , 'files' => 'true' ]) !!} 
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('occupation/project/department/register') }}">โครงการฝึกอบรมวิชาชีพ</a></li>
        <li>บันทึกข้อมูล โครงการฝึกอบรมวิชาชีพ</li>    
    </ul>

    
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                บันทึกข้อมูล โครงการฝึกอบรมวิชาชีพ
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <input type="hidden" name="id" value="{{ $readiness->project_readiness_id }}" />
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
            </div>
        </div>
    </div>
</div>
    <div class="row padding-md">
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
            
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">
                    โครงการ: {{ $readiness->project_readiness_name }}
                </div>
                <div class="smart-widget-inner">
                    <div class="widget-tab clearfix">
                        <ul class="tab-bar">
                            <li class="active"><a href="#style3Tab1" data-toggle="tab"><i class="fa fa-list"></i> รายละเอียดโครงการ</a></li>
                            <li class=""><a href="#style3Tab2" data-toggle="tab"><i class="fa fa-picture-o"></i> รายการผู้เข้าร่วมโครงการ</a></li>
                            <li class=""><a href="#style3Tab3" data-toggle="tab"><i class="fa fa-picture-o"></i> ผู้เข้าร่วมโครงการ</a></li>
                            <li class=""><a href="#style3Tab4" data-toggle="tab"><i class="fa fa-picture-o"></i> เพิ่มวิทยากร</a></li>
                            <li class=""><a href="#style3Tab5" data-toggle="tab"><i class="fa fa-picture-o"></i> เพิ่มเจ้าหน้าที่</a></li>
                            <li class=""><a href="#style3Tab6" data-toggle="tab"><i class="fa fa-picture-o"></i> สถานประกอบการ</a></li>
                            <li class=""><a href="#style3Tab7" data-toggle="tab"><i class="fa fa-picture-o"></i> เพิ่มเติม</a></li>
                        </ul>
                    </div>
                    <div class="smart-widget-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="style3Tab1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>ชื่อหลักสูตร</label>
                                                <input type="text" name="name" class="form-control" value="{{ $readiness->project_readiness_name }}" required="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label>สำนักงานย่อย </label>
                                                <select class="form-control" name="section"  required="" >
                                                    @if(count($section) > 0)
                                                        <option value="">เลือก หน่วยงาน</option>
                                                        @foreach( $section as $item )
                                                            <option value="{{$item->section_id}}" @if($item->section_id == $readiness->section_id) selected @endif >
                                                                {{ $item->section_name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- <div class="form-group">
                                                <label>วันที่จัดโครงการ</label>
                                                <input type="text" name="projectdate" class="form-control datepicker" value="{{ $readiness->adddate }}"  data-provide="datepicker" data-date-language="th-th" autocomplete="off" required="">
                                            </div> --}}
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
                                                <input type="number" min="0"  name="number" value="{{ $readiness->targetparticipate }}" class="form-control" required="" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label>งบประมาณ</label>
                                                <input type="number" min="0" name="budget" value="{{ $readiness->budget }}" class="form-control" required="" disabled>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>เบิกจ่ายจริง  (งบประมาณ คงเหลือ {{ $allreadinessexpense }} บาท)</label>
                                                <input type="number" min="0" name="actualexpense" value="@if(count($readinessexpense)>0){{$readinessexpense->cost}}@endif" class="form-control" required="" >
                                            </div>
                                        </div>
                                    </div>                            
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>รายละเอียดโครงการ</label>
                                                <textarea class="form-control" name="detail" required="">{{ $readiness->project_readiness_desc }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>  

                                <div class="tab-pane fade" id="style3Tab2">
                                    <div class="row ">
                                        <div class="col-md-12 input_participategroup">          
                                            <div class="form-group">
                                                <label>หมายเลขบัตรประชาชน</label>
                                                <input type="text" name="person_id" id="person_id" class="form-control" />
                                                <span class="help-block text-danger" id="response_person_id"></span>
                                            </div>
                                                                     
                                            <button type="button" class="btn btn-success add_participategroup"> <i class="fa fa-plus"></i> เพิ่มผู้เข้าร่วมโครงการ</button>
                                            <button type="button" class="btn btn-danger remove_participategroup"><i class="fa fa-times"></i> ลบผู้เข้าร่วมโครงการ</button>
                                            <hr>
                                            @if( count( $participategroup ) > 0 )
                                                @foreach( $participategroup as $key => $item )
                                                    @php
                                                        $_register =  $register->where('register_id',$item->register_id)->first();
                                                        $p = $prefix->where('prefix_id',$_register->prefix_id)->first()->prefix_name;
                                                        $name = $p . $_register->name . " " . $_register->lastname ;
                                                        $_section = $section->where('section_id',$_register->section_id)->first()->section_name;
                                                        $_group = $group->where('group_id',$_register->group_id)->first()->group_name;
                                                    @endphp
                                                    @if( $key == 0 )
                                                        <div class="row remove_group1">
                                                    @else
                                                        <div class="row remove_group{{ $key + 1 }}">
                                                    @endif
                                                            <div class="col-md-12">
                                                                    <input type="hidden" name="participategroup_id[]" class="form-control" value="{{ $item->register_id }}" />
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>ชื่อ-สกุล</label>
                                                                        <input type="text" name="participategroup_name[]" class="form-control" value="{{ $name }}" disabled />
                                                                    </div>
                                                                </div>
    
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>หมายเลขบัตรประชาชน</label>
                                                                        <input type="text" name="participategroup_hid[]" class="form-control" value="{{ $_register->person_id }}" disabled />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>หน่วยงาน</label>
                                                                        <input type="text" name="participategroup_section[]" class="form-control" value="{{ $_section }}" disabled />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>กลุ่ม</label>
                                                                        <input type="text" name="participate_group[]" class="form-control" value="{{ $_group }}" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                @endforeach
                                            @endif
                                        </div> 
                                        
                                    </div>
                                {{-- </div> --}}
                            </div>                           
                            <div class="tab-pane fade" id="style3Tab3">
                            <div class="row">
                                @if( count($participate) > 0 )
                                    @foreach( $participate as $item )
                                    @php( $value = $reparticipate->where('participate_id' , $item->participate_id)->first() )
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ $item->participate_position }}</label>
                                            @if( count($value) > 0 )
                                            <input type="number" min="0" max="99" step="1" name="participate[{{ $item->participate_id }}]" class="form-control" required="" value="{{ $value->participate_num }}" />
                                            @else
                                            <input type="number" min="0" max="99" step="1" value="0" name="participate[{{ $item->participate_id }}]" class="form-control" required="" />
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            </div>
                            <div class="tab-pane fade" id="style3Tab4">
                                <div class="row ">
                                    <div class="col-md-12 input_trainer"> 
                                        <button type="button" class="btn btn-success add_trainer"> <i class="fa fa-plus"></i> เพิ่มวิทยากร</button>
                                        <button type="button" class="btn btn-danger remove_trainer"><i class="fa fa-times"></i> ลบวิทยากร</button>
                                        <hr>
                                        @if( count( $trainer ) > 0 )
                                            @foreach( $trainer as $key => $item )
                                                @if( $key == 0 )
                                                    <div class="row">
                                                @else
                                                    <div class="row removetrainer{{ $key + 1 }}">
                                                @endif
                                                        <div class="col-md-12">
                                                            <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>ชื่อ-สกุล</label>
                                                                        <input type="text" name="trainer[]" class="form-control" value="{{ $item->trainer_name }}" />
                                                                    </div>
                                                                </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>ตำแหน่ง</label>
                                                                    <input type="text" name="trainerposition[]" class="form-control" value="{{ $item->trainer_position }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>หน่วยงาน</label>
                                                                    <input type="text" name="trainercompany[]" class="form-control" value="{{ $item->company }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>หลักสูตร/วิชา</label>
                                                                    <input type="text" name="course[]" class="form-control" value="{{ $item->course }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="tab-pane fade" id="style3Tab5">
                                <div class="row ">
                                    <div class="col-md-12 input_authority"> 
                                        <button type="button" class="btn btn-success add_authority"> <i class="fa fa-plus"></i> เพิ่มเจ้าหน้าที่</button>
                                        <button type="button" class="btn btn-danger remove_authority"><i class="fa fa-times"></i> ลบเจ้าหน้าที่</button>
                                        <hr>
                                        @if( count( $officer ) > 0 )
                                            @foreach ( $officer as $key => $item )
                                                @if( $key == 0 )
                                                    <div class="row removeauthority1">
                                                @else
                                                    <div class="row removeauthority{{ $key + 1 }}">
                                                @endif
                                                        <div class="col-md-12">
                                                            <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>ชื่อ-สกุล</label>
                                                                        <input type="text" name="authority[]" class="form-control" value="{{ $item->officer_name }}" />
                                                                    </div>
                                                                </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>ตำแหน่ง</label>
                                                                    <input type="text" name="authority_position[]" class="form-control" value="{{ $item->officer_position }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>หน่วยงาน</label>
                                                                    <input type="text" name="authority_company[]" class="form-control" value="{{ $item->officer_company }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            @endforeach
                                        @endif
                                    </div>
                                   
                                </div>
                            </div>

                            <div class="tab-pane fade" id="style3Tab6">
                                <div class="row ">
                                    <div class="col-md-12 input_company"> 
                                        <button type="button" class="btn btn-success add_company"> <i class="fa fa-plus"></i> เพิ่มสถานประกอบการเข้าร่วม</button>
                                        <button type="button" class="btn btn-danger remove_company"><i class="fa fa-times"></i> ลบสถานประกอบการเข้าร่วม</button>
                                        <hr>
                                        @if( count( $company ) > 0 )
                                            @foreach ( $company as $key => $item )
                                            @if( $key == 0 )
                                                <div class="row removecompany1">
                                            @else
                                                <div class="row removecompany{{ $key + 1 }}">
                                            @endif
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>สถานประกอบการ</label>
                                                            <input type="text" name="company[]" class="form-control" value="{{ $item->company_name }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="tab-pane fade" id="style3Tab7">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ปัญหา/อุปสรรค</label>
                                        <textarea class="form-control" name="problem" >{{ $readiness->problemdesc }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ข้อเสนอแนะ</label>
                                        <textarea class="form-control" name="suggestion"  >{{ $readiness->recommenddesc }}</textarea>
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
    {!! Form::close() !!}



@stop

@section('pageScript')
<script type="text/javascript">

    $('#projectdate').datepicker({
        format: 'dd/mm/yyyy',
        todayBtn: true,
        language: 'th', 
        autoclose: true,  
        thaiyear: true              
    }).datepicker("setDate", "{{ $readiness->inputadddate }}");  

    registerid=null;
    registername=null;
    registerprefix=null;
    registersectionname=null;
    registergroup =null;
    registercid =null;
    $("#person_id").change(function(){
        $.ajax({
            type:"get",
            url:"{{ url('api/check-person') }}",
            dataType:"Json",
            data:{
                person_id : $("#person_id").val(),
                department_id : "{{ $department->department_id }}",
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
                        $("#response_person_id").text('ไม่พบข้อมูลผู้สมัคร');
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
                    html_participategroup += "<label>หมายเลขบัตรประชาชน</label>";
                    html_participategroup += "<input type='text' name='participategroup_hid[]' value='"+registercid+"' class='form-control' disabled />";
                    html_participategroup += "</div>";
                    html_participategroup += "</div>";
                    html_participategroup += "<div class='col-md-3'>";
                    html_participategroup += "<div class='form-group'>";
                    html_participategroup += "<label>หน่วยงาน</label>";
                    html_participategroup += "<input type='text' name='participategroup_section[]' value='"+registersectionname+"'  class='form-control'/>";
                    html_participategroup += "</div>";
                    html_participategroup += "</div>";
                    html_participategroup += "<div class='col-md-3'>";
                    html_participategroup += "<div class='form-group'>";
                    html_participategroup += "<label>กลุ่ม</label>";
                    html_participategroup += "<input type='text' name='participate_group[]'  value='"+registergroup+"' class='form-control' />";
                    html_participategroup += "</div>";
                    html_participategroup += "</div>";
                    html_participategroup += "</div>";
                    html_participategroup += "</div>";

                    $(wrapper_participategroup).append(html_participategroup); //add input box
                    $('.datepicker').datepicker({
                        language: 'th',
                        format : "dd/mm/yyyy",
                        thaiyear: true,
                        autoclose:true,
                        orientation: "bottom left",
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
                        url:"{{ url('api/deleteparticipate') }}",
                        dataType:"Html",
                        data:{
                            register_id : regid,
                            readiness_id : "{{ $readiness->project_readiness_id }}",
                            project_type : "{{ $readiness->project_type }}",
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
                html_trainer += "<div class='col-md-3'>";
                html_trainer += "<div class='form-group'>";
                html_trainer += "<label>ตำแหน่ง</label>";
                html_trainer += "<input type='text' name='trainerposition[]' class='form-control'/>";
                html_trainer += "</div>";
                html_trainer += "</div>";
                html_trainer += "<div class='col-md-3'>";
                html_trainer += "<div class='form-group'>";
                html_trainer += "<label>หน่วยงาน</label>";
                html_trainer += "<input type='text' name='trainercompany[]' class='form-control'/>";
                html_trainer += "</div>";
                html_trainer += "</div>";
                html_trainer += "<div class='col-md-3'>";
                html_trainer += "<div class='form-group'>";
                html_trainer += "<label>หลักสูตร/วิชา</label>";
                html_trainer += "<input type='text' name='course[]' class='form-control' />";
                html_trainer += "</div>";
                html_trainer += "</div>";
                html_trainer += "</div>";
                html_trainer += "</div>";

                $(wrapper_trainer).append(html_trainer); //add input box
                $('.datepicker').datepicker({
                    language: 'th',
                    format : "dd/mm/yyyy",
                    thaiyear: true,
                    autoclose:true,
                    orientation: "bottom left",
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
                        url:"{{ url('api/deletetrainer') }}",
                        dataType:"Html",
                        data:{
                            trainer_name : trainer_name,
                            readiness_id : "{{ $readiness->project_readiness_id }}",
                            project_type : "{{ $readiness->project_type }}",
                        },
                        success : function(data){
                            if(data != ""){
                                alert(data);
                            }
                        }
                    })
                })

            }

            // if( number_trainer == 1 ){
            //     $(".remove_trainer").prop("disabled",true);
            // }
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
                autoclose:true,
                orientation: "bottom left",
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
                        url:"{{ url('api/deleteauthority') }}",
                        dataType:"Html",
                        data:{
                            officer_name : authority_name,
                            readiness_id : "{{ $readiness->project_readiness_id }}",
                            project_type : "{{ $readiness->project_type }}",
                        },
                        success : function(data){
                            if(data != ""){
                                alert(data);
                            }
                        }
                    })
                })
            }

        // if( number_authority == 1 ){
        //     $(".remove_authority").prop("disabled",true);
        // }
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
                    autoclose:true,
                    orientation: "bottom left",
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
                        url:"{{ url('api/deletecompany') }}",
                        dataType:"Html",
                        data:{
                            company : company_name,
                            readiness_id : "{{ $readiness->project_readiness_id }}",
                            project_type : "{{ $readiness->project_type }}",
                        },
                        success : function(data){
                            if(data != ""){
                                alert(data);
                            }
                        }
                    })
                })

            }

            // if( number_company == 1 ){
            //     $(".remove_company").prop("disabled",true);
            // }
    })

</script>
@stop