@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
{!! Form::open([ 'url' => 'recurit/assesment/edit' , 'method' => 'post', 'files' => 'true'  ]) !!} 
<div class="padding-md">
<input type="hidden" value="{{$registerassesmentfit->register_assesment_fit_id}}" name="register_assesment_fit_id">
<input type="hidden" value="{{$register->register_id}}" name="register_id">
    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/assesment') }}">การประเมินบุคลิกภาพ</a></li>
        <li><a href="{{ url('recurit/assesment/view/'.$register->register_id) }}">บุคลิกภาพบุคคล</a></li>
        <li>บันทึกการประเมินบุคลิกภาพ</li>    
    </ul>

   
    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                บันทึกการประเมินบุคลิกภาพ : {{ $register->name }}  {{ $register->lastname }}
            </div>
        </div>
        <div class="col-sm-3">
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
            

            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">
                    ประเมินบุคลิกภาพ
                </div>
                <div class="smart-widget-inner">
                    <div class="widget-tab clearfix">
                        <ul class="tab-bar">
                            <li class="active"><a href="#styleTab_assessment1" data-toggle="tab"><i class="fa fa-list"></i> ผลการประเมิน(กรมจัดหางาน)</a></li>
                            <li class=""><a href="#styleTab_assessment2" data-toggle="tab"><i class="fa fa-picture-o"></i> ความเหมาะสม</a></li>
                            <li class=""><a href="#styleTab_assessor" data-toggle="tab"><i class="fa fa-picture-o"></i> ผู้ประเมิน</a></li>
                            <li class=""><a href="#styleTab_attachment" data-toggle="tab"><i class="fa fa-picture-o"></i> เอกสารแนบ</a></li>
                        </ul>
                    </div>
                    <div class="smart-widget-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="styleTab_assessment1">    
                                <div class="row">
                                    @if( count($assessment) > 0 )
                                        @foreach( $assessment as $item )
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>{{ $item->assessmentname }}</label>
                                                    <input type="number" min="0" max="99" step="1" name="assessment[{{ $item->assessment_id }}]" class="form-control" required="" value="{{ $item->register_assessment_point }}" />
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div><!-- ./tab-pane -->
                            <div class="tab-pane fade" id="styleTab_assessment2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>อาชีพก่อนเข้าร่วมโครงการ</label>
                                            <input type="text" name="occupationbefore" class="form-control" value="{{$registerassesmentfit->occupationbefore}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ความเหมาะสมอาชีพปัจจุบัน</label> 
                                            <select class="form-control" name="currentoccupationfit" required >
                                                @foreach( $fitstatus as $item )  
                                                    <option value="{{ $item->fit_status_id }}"  @if ($item->fit_status_id == $registerassesmentfit->currentoccupationfit) selected @endif >{{ $item->fit_status_name }}  </option>                                             
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ความต้องการผู้เข้าร่วมโครงการ : อาชีพ</label>
                                            <select class="form-control" name="registeroccupationneedfit" required >
                                                @foreach( $fitstatus as $item )  
                                                    <option value="{{ $item->fit_status_id }}" @if ($item->fit_status_id == $registerassesmentfit->registeroccupationneedfit) selected @endif >{{ $item->fit_status_name }}</option>                                             
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ความต้องการผู้เข้าร่วมโครงการ : การศึกษา</label>                                            
                                            <select class="form-control" name="registereducationneedfit" required >
                                                @foreach( $fitstatus as $item )  
                                                    <option value="{{ $item->fit_status_id }}" @if ($item->fit_status_id == $registerassesmentfit->registereducationneedfit) selected @endif >{{ $item->fit_status_name }}</option>                                             
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>การให้การอบรม : อาชีพ</label>                                            
                                            <select class="form-control" name="registeroccupationtrainfit" required >
                                                @foreach( $fitstatus as $item )  
                                                    <option value="{{ $item->fit_status_id }}" @if ($item->fit_status_id == $registerassesmentfit->registeroccupationtrainfit) selected @endif  >{{ $item->fit_status_name }}</option>                                             
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>การให้การอบรม : การศึกษา</label>
                                            <select class="form-control" name="registereducationtrainfit" required >
                                                @foreach( $fitstatus as $item )  
                                                    <option value="{{ $item->fit_status_id }}" @if ($item->fit_status_id == $registerassesmentfit->registereducationtrainfit) selected @endif >{{ $item->fit_status_name }}</option>                                             
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>การมอบหมายงาน</label>
                                            <select class="form-control" name="jobassignmentfit" required >
                                                @foreach( $fitstatus as $item )  
                                                    <option value="{{ $item->fit_status_id }}" @if ($item->fit_status_id == $registerassesmentfit->jobassignmentfit) selected @endif >{{ $item->fit_status_name }}</option>                                             
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>การให้การช่วยเหลือ</label>
                                            <textarea class="form-control" name="needhelp" rows="3">{{ $registerassesmentfit->needhelp }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>การให้คำปรึกษา</label>
                                            <textarea class="form-control" name="needrecommend" rows="3">{{ $registerassesmentfit->needrecommend }}</textarea>
                                        </div>
                                    </div>

                                </div>      
                            </div><!-- ./tab-pane -->
                            <div class="tab-pane fade" id="styleTab_assessor">    
                                <div class="row ">
                                    <div class="col-md-12 input_assessor">
                                        <button type="button" class="btn btn-success add_assessor"> <i class="fa fa-plus"></i> เพิ่มผู้ประเมิน</button>
                                        <button type="button" class="btn btn-danger remove_assessor"><i class="fa fa-times"></i> ลบผู้ประเมิน</button>
                                        <hr>
                                        @if( count( $assessor ) > 0 )
                                            @foreach ( $assessor as $key => $item )
                                                @if( $key == 0 )
                                                    <div class="row removeassessor1">
                                                @else
                                                    <div class="row removeassessor{{ $key + 1 }}">
                                                @endif
                                                    <div class="col-md-12">
                                                            <input type="hidden" name="assessor_id[]" value="{{ $item->assessor_id }}" />
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>ชื่อ-สกุล</label>
                                                                <input type="text" name="assessor[]" class="form-control" value="{{ $item->assessor_name }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>หน่วยงาน</label>
                                                                <input type="text" name="assessorposition[]" class="form-control" value="{{ $item->assessor_position }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div><!-- ./tab-pane -->
                            <div class="tab-pane fade in active" id="styleTab_attachment">    
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>เอกสารแนบ <span class="text-danger">*ไฟล์ pdf ผลการประเมินจากกรมจัดหางาน</span></label>
                                    	<input type="file" name="attachment"  id="doc" class="filestyle"  />
                                    </div>
                                </div>
                                
                                <div class="row" style="margin-top:10px">
                                        <div class="col-md-12">
                                                <div class="table">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>ชื่อไฟล์</th>
                                                                    <th>ดาวน์โหลด</th>
                                                                    <th>ลบ</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if( !empty($registerassesmentfit->attachment) )
                                                               
                                                                <tr>
                                                                    <td>ผลการประเมิน</td>
                                                                    <td><a href="{{ asset($registerassesmentfit->attachment) }}" class="btn btn-info text-right" target="_blank"> <i class="fa fa-download"></i> ดาวน์โหลด</a> </td>
                                                                    <td><a href="{{ url('recurit/assesment/deleteattachment/'.$registerassesmentfit->register_assesment_fit_id) }}" class="btn btn-danger text-right" onclick="return confirm('ต้องการลบไฟล์!!')"><i class="fa fa-remove"></i> ลบ</a> </td>
                                                                </tr>
                                                              
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                            </div>
                                </div>
                            </div><!-- ./tab-pane -->
                        </div><!-- ./tab-content -->
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
    $(".remove_assessor").prop("disabled",false);
    var max_assessor      = 10; //maximum input boxes allowed
    var wrapper_assessor         = $(".input_assessor"); //Fields wrapper
    var add_assessor      = $(".add_assessor"); //Add button ID
    var html_assessor = "";
    var number_assessor = $('input[name="assessor_id[]"]').length ; //1; //initlal text box count

    $(add_assessor).click(function(e){ //on add input button click
        if(number_assessor < max_assessor){ //max input box allowed
            number_assessor++; //text box increment
            
            html_assessor =  "<div class='row removeassessor"+number_assessor+"'>";
            html_assessor += "<div class='col-md-12'>";
            html_assessor += "<input type='hidden' name='assessor_id[]' />";
            html_assessor += "<div class='col-md-6'>";
            html_assessor += "<div class='form-group'>";
            html_assessor += "<label>ชื่อ-สกุล</label>";
            html_assessor += "<input type='text' name='assessor[]' class='form-control'/>";
            html_assessor += "</div>";
            html_assessor += "</div>";
            html_assessor += "<div class='col-md-6'>";
            html_assessor += "<div class='form-group'>";
            html_assessor += "<label>ตำแหน่ง</label>";
            html_assessor += "<input type='text' name='assessorposition[]' class='form-control' />";
            html_assessor += "</div>";
            html_assessor += "</div>";
            html_assessor += "</div>";
            html_assessor += "</div>";

            $(wrapper_assessor).append(html_assessor); //add input box

            $('.datepicker').datepicker({
                language: 'th',
                format : "dd/mm/yyyy",
                thaiyear: true,
                autoclose:true,
                orientation: "bottom left",
            });
        }

        if( number_assessor > 1 ){
            $(".remove_assessor").prop("disabled",false);
        }

        if( number_assessor == 10 ){
            $(add_assessor).prop("disabled" , true);
        }
    });
    
    $(".remove_assessor").click(function(){
        if( number_assessor > 0 ){

            index=$('input[name="assessor_id[]"]').length;
            var names=document.getElementsByName('assessor_id[]');
            assessorid = names[index-1].value;

            $(".removeassessor"+number_assessor).remove(); number_assessor--;
            $(add_assessor).prop("disabled" , false);

            $(function(){
                $.ajax({
                    type:"get",
                    url:"{{ url('api/deleteassessor') }}",
                    dataType:"Html",
                    data:{
                        assessor_id : assessorid,
                    },
                    success : function(data){
                        if(data != ""){
                            alert(data);
                        }
                    }
                })
            })

        }

        // if( number_assessor == 1 ){
        //     $(".remove_assessor").prop("disabled",true);
        // }
    })
    $('#doc').filestyle({
        buttonName : 'btn-success',
        buttonText : ' ไฟล์ผลการประเมิน',
        // input: false,
        icon: false,
    });
</script>
@stop