@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('assesment/section') }}">รายการประเมิน</a></li>
        <li>เพิ่มการประเมินบุคคล</li>    
    </ul>
{!! Form::open([ 'url' => 'assesment/section/assessmentsave' , 'method' => 'post' ]) !!} 
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่มการประเมินบุคคล 
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
                <div class="smart-widget-header"> รายการประเมิน: {{$assesment->assesment_name}} </div>
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
                                <label>ผู้รับการประเมิน</label>
                                <select class="form-control" name="register"  id="register" required>
                                        @if( count($register) > 0 )
                                        <option value="">เลือกรายการ</option>
                                        @foreach( $register as $item )
                                            <option value="{{ $item->register_id }}">{{ $item->registerprefixname }}{{ $item->registername }} {{ $item->registerlastname }}</option>
                                        @endforeach
                                        @endif
                                </select> 
                            </div>
                            <div class="form-group">
                                <label>ระดับการประเมิน</label>
                                <select class="form-control" name="score" id="score" required>
                                    @if( count($score) > 0 )
                                    <option value="">เลือกระดับ</option>
                                    @foreach( $score as $item )
                                        <option value="{{ $item->score_id }}">{{ $item->score_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label>ข้อคิดเห็นอื่นๆ</label>
                                <textarea class="form-control" name="detail"  id="detail"></textarea>
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
                            $('#score').val(response.assessment[i].score_id);
                            $('#detail').val(response.assessment[i].othernote);
                    }
                }
            }
        })
    }
})
</script>
@stop