@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('assesment/section') }}">รายการติดตาม</a></li>
        <li>เพิ่มการติดตามรายบุคคล</li>    
    </ul>
{!! Form::open([ 'url' => 'assesment/section/followupsave' , 'method' => 'post' ]) !!} 
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่มการติดตามรายบุคคล
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                <a href="{{ url('assesment/section/editassessment/'.$assesment->project_assesment_id) }}" class="btn btn-success"><i class="fa fa-pencil"></i> แก้ไขรายการ</a>
            </div>
        </div>
    </div>
</div>
    <div class="padding-md">
    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการติดตาม: {{$assesment->assesment_name}} </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        
                        <input type="hidden" name="assesment_id" value="{{$assesment->project_assesment_id}}" />
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

                            <div class="form-group">
                                <label>ผู้รับการติดตาม</label>
                                <select class="form-control" name="register" id="register" required>
                                        @if( count($register) > 0 )
                                        <option value="">เลือกรายการ</option>
                                        @foreach( $register as $item )
                                            <option value="{{ $item->register_id }}">{{ $item->prefixname }}{{ $item->name }} {{ $item->lastname }}</option>
                                        @endforeach
                                        @endif
                                </select> 
                            </div>

                            <div class="form-group">
                                <label>การติดตาม</label>
                                    <select class="form-control" name="followerstatus" id= "followerstatus"  required>
                                        @if( count($followerstatus) > 0 )
                                        @foreach( $followerstatus as $item )
                                            <option value="{{ $item->follower_status_id }}">{{ $item->follower_status_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                            </div>
 
                            <div class="form-group">
                                <label>ต้องการสนับสนุน</label>
                                <select class="form-control" name="needsupport" id ="needsupport"  required>
                                    @if( count($needsupport) > 0 )
                                    @foreach( $needsupport as $item )
                                        <option value="{{ $item->needsupport_id }}">{{ $item->needsupport_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <div class="form-group" name="needsupport2" id="needsupport2" style="display: none;">
                                    <span class="text-danger">ระบุความต้องการ</span>
                                    <input type="text" class="form-control"  name="needsupport3"  id="needsupport3" >
                                </div>
                            </div>



                            <div class="form-group">
                                <label>ความสัมพันธ์ในครอบครัว</label>
                                <select class="form-control" name="familyrelation" id="familyrelation" required>
                                    @if( count($familyrelation) > 0 )
                                    @foreach( $familyrelation as $item )
                                        <option value="{{ $item->familyrelation_id }}">{{ $item->familyrelation_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <div class="form-group" name="familyrelation2" id="familyrelation2" style="display: none;">
                                    <span class="text-danger">ระบุปัญหา</span>
                                    <input type="text" class="form-control" name="familyrelation3" id="familyrelation3">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>การมีรายได้</label>
                                <select class="form-control" name="enoughincome" id="enoughincome" required>
                                    @if( count($enoughincome) > 0 )
                                    @foreach( $enoughincome as $item )
                                        <option value="{{ $item->enoughincome_id }}">{{ $item->enoughincome_name }}</option>
                                    @endforeach
                                    @endif
                            </select>   
                            
                            </div>

                            <div class="form-group">
                                <label>การมีอาชีพ</label>
                                <select class="form-control" name="occupation" id="occupation" required>
                                    @if( count($occupation) > 0 )
                                    @foreach( $occupation as $item )
                                        <option value="{{ $item->occupation_id }}">{{ $item->occupation_name }}</option>
                                    @endforeach
                                    @endif
                                </select>     
                                <div class="form-group" name="occupation2" id="occupation2" style="display: none;">
                                    <span class="text-danger">ระบุอาชีพ</span>
                                    <input type="text" class="form-control" name="occupation3" id="occupation3">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>ข้อคิดเห็นอื่นๆ</label>
                                <textarea class="form-control" name="detail" id="detail"></textarea>
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
    $("#needsupport").change(function(){
        if( $("#needsupport").val() == 2 ){
            document.getElementById('needsupport2').style.display = "block";
        }else{
            document.getElementById('needsupport2').style.display = "none";
        }
    })

    $("#familyrelation").change(function(){
        if( $("#familyrelation").val() == 3 ){
            document.getElementById('familyrelation2').style.display = "block";
        }else{
            document.getElementById('familyrelation2').style.display = "none";
        }
    })
    
    $("#occupation").change(function(){
        if( $("#occupation").val() != 1 ){
            document.getElementById('occupation2').style.display = "block";
        }else{
            document.getElementById('occupation2').style.display = "none";
        }
    })

    $("#register").change(function(){        
        if( $("#register").val() != "" ){
             $.ajax({
                type:"get",
                url : "{{ url('assesment/section/followupdetail') }}",
                dataType:"Json",
                data : {
                    assesment_id : "{{ $assesment->project_assesment_id }}",
                    register : document.getElementById("register").value,
                },
                success : function(response){
                    console.log(response);
                    if( response.row > 0 ){
                        for( var i=0;i<response.row;i++ ){
                            $('#followerstatus').val(response.assessment[i].follower_status_id);

                            $('#needsupport').val(response.assessment[i].needsupport_id);
                            if(response.assessment[i].needsupport_id == 2){
                                document.getElementById('needsupport2').style.display = "block";
                                document.getElementById('needsupport3').value = response.assessment[i].needsupport_detail;
                            }else{
                                document.getElementById('needsupport2').style.display = "none";
                                document.getElementById('needsupport3').value="";
                            }

                            $('#familyrelation').val(response.assessment[i].familyrelation_id);
                            if(response.assessment[i].familyrelation_id == 3){
                                document.getElementById('familyrelation2').style.display = "block";
                                document.getElementById('familyrelation3').value = response.assessment[i].familyrelation_detail;
                            }else{
                                document.getElementById('familyrelation2').style.display = "none";
                                document.getElementById('familyrelation3').value="";
                            }

                            $('#enoughincome').val(response.assessment[i].enoughincome_id);
                            $('#occupation').val(response.assessment[i].occupation_id);
                            if(response.assessment[i].occupation_id == 3){
                                document.getElementById('occupation2').style.display = "block";
                                document.getElementById('occupation3').value = response.assessment[i].occupation_detail;
                            }else{
                                document.getElementById('occupation2').style.display = "none";
                                document.getElementById('occupation3').value="";
                            }
                            $('#detail').val(response.assessment[i].othernote2);
                    }
                }else{
                    $('#followerstatus').val(1);
                    $('#needsupport').val(1);
                    document.getElementById('needsupport2').style.display = "none";
                    document.getElementById('needsupport3').value="";
                    $('#familyrelation').val(1);
                    document.getElementById('familyrelation2').style.display = "none";
                    document.getElementById('familyrelation3').value="";
                    $('#enoughincome').val(1);
                    $('#occupation').val(1);
                    document.getElementById('occupation2').style.display = "none";
                    document.getElementById('occupation3').value="";
                    document.getElementById('detail').value="";
                }
            }
        })
    }
})

</script>
@stop