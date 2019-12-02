@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
{!! Form::open([ 'url' => 'followup/manage' , 'method' => 'post' , 'files' => 'true' ]) !!} 
<div class="padding-md">
    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('occupation/project/department/register') }}">โครงการติดตามความก้าวหน้า</a></li>
        <li>บันทึกข้อมูล โครงการติดตามความก้าวหน้า</li>    
    </ul>

    
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                บันทึกข้อมูล โครงการติดตามความก้าวหน้า
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <input type="hidden" id="projectfollowupid" name="id" value="{{ $projectfollowup->project_followup_id }}" />
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
                    โครงการ: {{ $projectfollowup->project_followup_name }}
                </div>
                {{-- hidden select1 --}}
                {{-- <div class="form-group" id ="hiddenselect1" style="display:none;" > --}}
                        <div class="form-group" id ="hiddenselect1" style="display:none;" >
                    <label>ตำแหน่ง</label>                    
                    {{-- <select class="form-control" name="intervieweeposition[]"  >   --}}
                    <select class="form-control" name="tmp1"  >  
                        @foreach( $intervieweegroup as $_item )  
                            <option value="{{ $_item->interviewee_group_id }}" >{{ $_item->interviewee_group_name }}</option>                                                                              
                        @endforeach
                    </select>
                </div>
                {{-- hidden select2 --}}
                <div class="form-group" id ="hiddenselect2" style="display:none;" >
                        <label>หน่วยงาน</label>                    
                        {{-- <select class="form-control" name="intervieweesection[]"  >   --}}
                        <select class="form-control" name="tmp2"  >  
                            @foreach( $followupsection as $_item )  
                                <option value="{{ $_item->section_id }}" >{{ $_item->section_name }}</option>                                                                              
                            @endforeach
                        </select>
                    </div>

                <div class="smart-widget-inner">
                    <div class="widget-tab clearfix">
                        <ul class="tab-bar">
                            <li class="active"><a href="#style3Tab1" data-toggle="tab"><i class="fa fa-list"></i> รายละเอียดโครงการ</a></li>
                            <li class=""><a href="#style3Tab2" data-toggle="tab"><i class="fa fa-picture-o"></i> ติดตามผล</a></li>
                            <li class=""><a href="#style3Tab3" data-toggle="tab"><i class="fa fa-picture-o"></i> การสัมภาษณ์</a></li>                            
                            <li class=""><a href="#style3Tab4" data-toggle="tab"><i class="fa fa-picture-o"></i> เจ้าหน้าที่ออกพื้นที่</a></li>
                            <li class=""><a href="#styleTab_attachment" data-toggle="tab"><i class="fa fa-picture-o"></i> เอกสารแนบ</a></li>
                        </ul>
                    </div>
                    <div class="smart-widget-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="style3Tab1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                    <label>ชื่อโครงการติดตาม</label>
                                                    <input type="text" name="name" class="form-control" value="{{$projectfollowup->project_followup_name}}" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>วันที่เริ่มโครงการ</label>
                                                    <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                                        <input type="text" class="form-control" name="startdate" readonly="" autocomplete="off" required="" value="{{$projectfollowup->projectstartdate}}">
                                                        <span class="add-on"><i class="icon-th"></i></span>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>วันที่สิ้นสุดโครงการ</label>
                                                <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                                    <input type="text" class="form-control" name="enddate" readonly="" autocomplete="off" required="" value="{{ $projectfollowup->projectenddate }}" >
                                                    <span class="add-on"><i class="icon-th"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>งบประมาณ</label>
                                                <input type="text" name="budget" class="form-control" required  value="{{$projectfollowup->project_budget}}" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>เบิกจ่ายจริง</label>
                                                <input type="text" name="actualpayment" class="form-control" required value="{{$projectfollowup->payment}}" />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12 d-inline-block">
                                            <div class="form-group">
                                                <label>เลือกจังหวัด</label>
                                                <select class="select2 width-100" name="province[]" id="province" multiple="" required disabled >
                                                    @if( count($province) > 0 )
                                                        @foreach( $province as $item )  
                                                            @php
                                                                    $val = $selectedprovince->where('map_code',$item->map_code)->first();
                                                            @endphp
                                                                @if (count($val) !=0 )
                                                                        <option value="{{ $item->province_id }}" selected  >{{ $item->province_name }}</option>
                                                                    @else
                                                                        <option value="{{ $item->province_id }}" >{{ $item->province_name }}</option>
                                                                @endif
                                                        @endforeach    
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 d-inline-block">
                                            <div class="form-group">
                                                <label>สำนักงานที่ติดตาม</label>
                                                <select class="select2 width-100" id="section" name="section[]" multiple="" required disabled >
                                                </select>
                                            </div>
                                        </div>
                                    </div>                            
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>รายละเอียดโครงการ</label>
                                                <textarea class="form-control" name="description" required="">{{ $projectfollowup->details }}</textarea>
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
                                                @if( count($projectfollowupdocument) > 0 )
                                                @foreach( $projectfollowupdocument as $item )
                                                <tr>
                                                    <td>{{ $item->document_name }}</td>
                                                    <td><a href="{{ asset($item->document_file) }}" class="btn btn-info text-right" target="_blank"> <i class="fa fa-download"></i> ดาวน์โหลด</a> </td>
                                                    <td><a href="{{ url('followup/delete-file/'.$item->project_followup_document_id) }}" class="btn btn-danger text-right"><i class="fa fa-remove"></i> ลบ</a> </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="style3Tab2">
                                    <div class="row ">
                                        <div class="col-md-12"> 
                                            

                                           <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ชื่อ-สกุล</th>
                                                        <th>เลขบัตรประชาชน</th>
                                                        <th>สำนักงาน</th>
                                                        <th>ความพึงพอใจ</th>
                                                        <th>วางแผนเข้าทำงานหลังครบสัญญา</th>
                                                        <th>ปัญหาและอุปสรรค</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                        
                                                    @if( count($employ) > 0 )
                                                    @foreach( $employ as $key => $item )
                                                        <tr>
                                                            @php
                                                                $check = $followupregister->where('register_id',$item->register_id)->first();                                                                 
                                                            @endphp
                                                            <td>{{ $item->prefixname }}{{ $item->name }} {{ $item->lastname }}</td>
                                                            <td>{{ $item->person_id }}</td>
                                                            <td>{{ $item->sectionname }}</td>
                                                            <td> 
                                                                <select class="form-control" name="sastify[{{ $item->register_id }}]"  >
                                                                    @foreach( $satisfaction as $_item )  
                                                                        @if (!empty($check))
                                                                            <option value="{{ $_item->satisfaction_id }}" @if($_item->satisfaction_id == $check->satisfaction_id) selected @endif>{{ $_item->satisfaction_name }}</option>
                                                                        @else
                                                                            <option value="{{ $_item->satisfaction_id }}" >{{ $_item->satisfaction_name }}</option>
                                                                        @endif                                                                        
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            @if (!empty($check))
                                                                @if($item->register_id == $check->register_id) 
                                                                    <td><input type="text" name="workon[{{ $item->register_id }}]" value="{{$check->workon}}" class="form-control" /></td>
                                                                    <td><input type="text" name="problem[{{ $item->register_id }}]" value="{{$check->problem}}"  class="form-control" /></td>
                                                                @endif
                                                            @else
                                                                <td><input type="text" name="workon[{{ $item->register_id }}]" value="" class="form-control" /></td>
                                                                <td><input type="text" name="problem[{{ $item->register_id }}]" value=""  class="form-control" /></td>
                                                            @endif 
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="style3Tab3">
                                    <div class="row ">
                                        <div class="col-md-12 input_interview"> 
                                            <button type="button" class="btn btn-success add_interview"> <i class="fa fa-plus"></i> เพิ่มรายการสัมภาษณ์</button>
                                            <button type="button" class="btn btn-danger remove_interview"><i class="fa fa-times"></i> ลบรายการสัมภาษณ์</button>
                                            <hr>
                                            @if( count( $teacher ) > 0 )
                                                @foreach( $teacher as $key => $item )
                                                    @if( $key == 0 )
                                                        <div class="row removeinterview1">
                                                    @else
                                                        <div class="row removeinterview{{ $key + 1 }}">
                                                    @endif
                                                    <input type="hidden" name="interview_id[]" class="form-control" value="{{ $item->followup_interview_id }}" />
                                                            <div class="col-md-12">
                                                                <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>ชื่อ-สกุล</label>
                                                                            <input type="text" name="interviewee[]" class="form-control" value="{{ $item->interviewee_name }}" />
                                                                        </div>
                                                                    </div>
    
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label>ตำแหน่ง</label>
                                                                        {{-- <input type="text" name="intervieweeposition[]" class="form-control" value="{{ $item->interviewee_position }}" /> --}}
                                                                        <select class="form-control" name="intervieweeposition[]"  >    
                                                                                @php
                                                                                    $check = $teacher->where('interviewee_group_id',$item->interviewee_group_id)->first();                                                              
                                                                                @endphp
                                                                                @foreach( $intervieweegroup as $_item )  
                                                                                @if (!empty($check))  
                                                                                    @if ($check->interviewee_group_id == $_item->interviewee_group_id)
                                                                                        <option value="{{ $_item->interviewee_group_id }}" selected>{{ $_item->interviewee_group_name }}</option>                                                                       
                                                                                    @else
                                                                                        <option value="{{ $_item->interviewee_group_id }}" >{{ $_item->interviewee_group_name }}</option>    
                                                                                    @endif
                                                                                @else
                                                                                    <option value="{{ $_item->interviewee_group_id }}" >{{ $_item->interviewee_group_name }}</option>                                                                       
                                                                                @endif                                                                                
                                                                                @endforeach
                                                                            </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">                                                                     
                                                                        <label>หน่วยงาน</label>
                                                                        <select class="form-control" name="intervieweesection[]"  >    
                                                                            @foreach( $followupsection as $_item )  
                                                                           
                                                                                @if ($item->interviewee_section == $_item->section_id)
                                                                                    <option value="{{ $_item->section_id }}" selected>{{ $_item->section_name }}</option>                                                                       
                                                                                @else
                                                                                    <option value="{{ $_item->section_id }}" >{{ $_item->section_name }}</option>    
                                                                                @endif
                                                                                                                                                    
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>                                                                
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>บทความสัมภาษณ์</label>
                                                                        <input type="text" name="interviewcontent[]" class="form-control" value="{{ $item->interviewcontent }}" />
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
                                    <div class="col-md-12 input_officer"> 
                                        <button type="button" class="btn btn-success add_officer"> <i class="fa fa-plus"></i> เพิ่มเจ้าหน้าที่</button>
                                        <button type="button" class="btn btn-danger remove_officer"><i class="fa fa-times"></i> ลบเจ้าหน้าที่</button>
                                        <hr>
                                        @if( count( $officer ) > 0 )
                                            @foreach ( $officer as $key => $item )
                                                @if( $key == 0 )
                                                    <div class="row removeofficer1">
                                                @else
                                                    <div class="row removeofficer{{ $key + 1 }}">
                                                @endif
                                                        <div class="col-md-12">
                                                            <input type="hidden" name="officer_id[]" class="form-control" value="{{ $item->interviewer_id }}" />
                                                            <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>ชื่อ-สกุล</label>
                                                                        <input type="text" name="officer[]" class="form-control" value="{{ $item->name }}" />
                                                                    </div>
                                                                </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>ตำแหน่ง</label>
                                                                    <input type="text" name="officer_position[]" class="form-control" value="{{ $item->position }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>หน่วยงาน</label>
                                                                    <input type="text" name="officer_company[]" class="form-control" value="{{ $item->company }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            @endforeach
                                        @endif
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

    $(document).ready(function() {
        $('.select2').select2();
    });

    $('#doc').filestyle({
        buttonName : 'btn-success',
        buttonText : ' เลือกไฟล์',
        // input: false,
        icon: false,
    });

    $(".remove_interview").prop("disabled",false);
        var interviewee_group_selection = "{{$intervieweegroup}}";
        
        var max_interview  = 20; //maximum input boxes allowed
        var wrapper_interview  = $(".input_interview"); //Fields wrapper
        var add_interview      = $(".add_interview"); //Add button ID
        var html_interview = "";
        var number_interview = $('input[name="interviewee[]"]').length ;  //initlal text box count
        $(add_interview).click(function(e){ //on add input button click
            if(number_interview < max_interview){ //max input box allowed
                var _select1 = document.getElementById('hiddenselect1').innerHTML;
                var select1 = _select1.replace("tmp1", "intervieweeposition[]");
                var _select2 = document.getElementById('hiddenselect2').innerHTML;
                var select2 = _select2.replace("tmp2", "intervieweesection[]");
                number_interview++; //text box increment
                html_interview =  "<div class='row removeinterview"+number_interview+"'>";
                html_interview += "<div class='col-md-12'>";
                html_interview += "<input type='hidden' name='interview_id[]' class='form-control'/>";
                html_interview += "<div class='col-md-3'>";
                html_interview += "<div class='form-group'>";
                html_interview += "<label>ชื่อ-สกุล</label>";
                html_interview += "<input type='text' name='interviewee[]' class='form-control'/>";
                html_interview += "</div>";
                html_interview += "</div>";
                html_interview += "<div class='col-md-2'>";
                html_interview += "<div class='form-group'>";
                html_interview += select1;
                html_interview += "</div>";
                html_interview += "</div>";
                html_interview += "<div class='col-md-3'>";
                html_interview += "<div class='form-group'>";
                html_interview += select2;
                html_interview += "</div>";
                html_interview += "</div>";                
                html_interview += "<div class='col-md-4'>";
                html_interview += "<div class='form-group'>";
                html_interview += "<label>บทสัมภาษณ์</label>";
                html_interview += "<input type='text' name='interviewcontent[]' class='form-control' />";
                html_interview += "</div>";
                html_interview += "</div>";
                html_interview += "</div>";
                html_interview += "</div>";

                $(wrapper_interview).append(html_interview); //add input box
                $('.datepicker').datepicker({
                    language: 'th',
                    format : "dd/mm/yyyy",
                    thaiyear: true,
                    autoclose:true,
                    orientation: "bottom left",
                });
            }
            if( number_interview > 1 ){
                $(".remove_interview").prop("disabled",false);
            }

            if( number_interview == 20 ){
                $(add_interview).prop("disabled" , true);
            }
        });
        
        $(".remove_interview").click(function(){
            if( number_interview > 0 ){
                index=$('input[name="interview_id[]"]').length;
                var names=document.getElementsByName('interview_id[]');
                interview_id = names[index-1].value;
                $(".removeinterview"+number_interview).remove(); number_interview--;
                $(add_interview).prop("disabled" , false);
                $(function(){
                    $.ajax({
                        type:"get",
                        url:"{{ url('api/deleteinterviewee') }}",
                        dataType:"Html",
                        data:{
                            interview_id : interview_id,
                            projectfollowup_id : "{{ $projectfollowup->project_followup_id }}",
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
  $(".remove_officer").prop("disabled",false);
    var max_officer   = 10; //maximum input boxes allowed
    var wrapper_officer   = $(".input_officer"); //Fields wrapper
    var add_officer  = $(".add_officer"); //Add button ID
    var html_officer = "";
    var number_officer = $('input[name="officer[]"]').length  ; //1; //initlal text box count

    $(add_officer).click(function(e){ //on add input button click
        if(number_officer < max_officer){ //max input box allowed
            number_officer++; //text box increment
            
            html_officer =  "<div class='row removeofficer"+number_officer+"'>";
            html_officer += "<div class='col-md-12'>";
            html_officer += "<input type='hidden' name='officer_id[]' class='form-control' />";
            html_officer += "<div class='col-md-4'>";
            html_officer += "<div class='form-group'>";
            html_officer += "<label>ชื่อ-สกุล </label>";
            html_officer += "<input type='text' name='officer[]' class='form-control' />";
            html_officer += "</div>";
            html_officer += "</div>";
            html_officer += "<div class='col-md-4'>";
            html_officer += "<div class='form-group'>";
            html_officer += "<label>ตำแหน่ง </label>";
            html_officer += "<input type='text' name='officer_position[]' class='form-control' />";
            html_officer += "</div>";
            html_officer += "</div>";
            html_officer += "<div class='col-md-4'>";
            html_officer += "<div class='form-group'>";
            html_officer += "<label>หน่วยงาน </label>";
            html_officer += "<input type='text' name='officer_company[]' class='form-control' />";
            html_officer += "</div>";
            html_officer += "</div>";
            html_officer += "</div>";
            html_officer += "</div>";

            $(wrapper_officer).append(html_officer); //add input box

            $('.datepicker').datepicker({
                language: 'th',
                format : "dd/mm/yyyy",
                thaiyear: true,
                autoclose:true,
                orientation: "bottom left",
            });
        }

        if( number_officer > 1 ){
            $(".remove_officer").prop("disabled",false);
        }

        if( number_officer == 10 ){
            $(add_officer).prop("disabled" , true);
        }
    });

    
    $(".remove_officer").click(function(){
        if( number_officer > 0 ){
            index=$('input[name="officer_id[]"]').length;
            var names=document.getElementsByName('officer_id[]');
            interviewer = names[index-1].value;

            $(".removeofficer"+number_officer).remove(); number_officer--;
            $(add_officer).prop("disabled" , false);

                $(function(){
                    $.ajax({
                        type:"get",
                        url:"{{ url('api/deleteinterviewer') }}",
                        dataType:"Html",
                        data:{
                            interviewer_id : interviewer,
                            projectfollowup_id : "{{ $projectfollowup->project_followup_id }}",
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



    function sectionList(){
        var values = $('#province').val();
        if (values == null){
            $("#section").empty();
            $("#section").html( "" );
            return;
        }

        $.ajax({
            type:"get",
            url : "{{ url('api/sectionlist') }}",
            dataType:"Json",
            data : {
                provincelist : values,
                id : $('#projectfollowupid').val(),
            },
            success : function(response){
                if( response.row > 0 ){
                    html = "";

                    for( var i=0;i<response.row;i++ ){
                
                        if( response.selectselected[i].check == 1 ){
                            html += "<option value='"+ response.section[i].section_id +"' selected>"+ response.section[i].section_name +"</option>";
                        }
                        else{
                            html += "<option value='"+ response.section[i].section_id +"' >"+ response.section[i].section_name +"</option>";
                        }
                    }
                    $("#section").html( html );
                }
            }
        })
    }

    $("#province").change(function(){
        sectionList();
    })

    $(document).ready(function(){
        var values = $('#province').val();
        var values = $('#province').val();
            if (values != null){
                sectionList();
            }
    });


</script>
@stop