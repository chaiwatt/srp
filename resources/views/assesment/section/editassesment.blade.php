@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>   
        <li>แก้ไขรายการประเมิน</li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                    แก้ไขรายการประเมิน
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> แก้ไขรายการประเมิน </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md"> <!-- form create project -->
                    {!! Form::open([ 'url' => 'assesment/section/editaccessment' , 'method' => 'post' ]) !!} 
                        <input type="hidden" name="assesment_id" value="{{$assesment->project_assesment_id}}">
                        <div class="form-group">
                            <label>ชื่อรายการประเมิน</label>
                            <input type="text" name="assesment" class="form-control" required value="{{$assesment->assesment_name}}" />
                        </div>
                        <div class="form-group">
                                <label>ผู้ประเมิน</label>
                                <input type="text" name="assesor" class="form-control" required value="{{$assesment->assesor}}" />
                            </div>
                        <div class="form-group">
                            <label>รายละเอียดการประเมิน</label>
                        <textarea name="description" class="form-control" >{{ $assesment->project_assesment_desc }}</textarea>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('pageScript')
<script type="text/javascript">
    $('.datepicker').datepicker({
        language: 'th',
        format : "dd/mm/yyyy",
        thaiyear: true,
        autoclose:true,
        orientation: "bottom left",
    });
</script>
@stop