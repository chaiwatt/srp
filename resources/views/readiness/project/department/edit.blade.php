@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('readiness/project/department') }}">รายการฝึกอบรมเตรียมความพร้อม</a></li>    
        <li>โครงการฝึกอบรมเตรียมความพร้อม</li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                โครงการฝึกอบรมเตรียมความพร้อม
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> โครงการฝึกอบรม: {{ $readiness->project_readiness_name }} </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md"> 
                    {!! Form::open([ 'url' => 'readiness/project/department/edit' , 'method' => 'post' ]) !!} 
                        <input type="hidden" name="id" value="{{ $readiness->project_readiness_id }}">
                        <div class="form-group">
                            <label>ชื่อโครงการ</label>
                        <input type="text" name="name" class="form-control" value="{{ $readiness->project_readiness_name }}" required="" />
                        </div>
                        <div class="form-group">
                            <label>วันที่จัดโครงการ</label>
                        <input type="text" name="projectdate" class="form-control datepicker" value="{{ $readiness->adddate }}"  data-provide="datepicker" data-date-language="th-th" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label>กรอบเป้าหมายผู้เข้าร่วมโครงการ</label>
                        <input type="number" min="0"  name="number" value="{{ $readiness->targetparticipate }}" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>งบประมาณ</label>
                        <input type="number" min="0" name="budget" value="{{ $readiness->budget }}" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>รายละเอียดโครงการ</label>
                        <textarea class="form-control" name="detail" required="">{{ $readiness->project_readiness_desc }}</textarea>
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