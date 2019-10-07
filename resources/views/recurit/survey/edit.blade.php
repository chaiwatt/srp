@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/survey') }}">รายการสำรวจการจ้างงาน</a></li>    
        <li>แก้ไขรายการสำรวจการจ้างงาน</li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                แก้ไขรายการสำรวจการจ้างงาน
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> แก้ไขรายการสำรวจการจ้างงาน </div>
            <div class="smart-widget-body">
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

                <div class="smart-widget-body  padding-md"> <!-- form create project -->
                    {!! Form::open([ 'url' => 'recurit/survey/edit' , 'method' => 'post' ]) !!} 
                        <input type="hidden" name="id" value="{{ $survey->project_survey_id }}" />
                        <div class="form-group">
                            <label>ชื่อรายการสำรวจ</label>
                            <input type="text" name="name" class="form-control" required="" value="{{ $survey->project_survey_name }}" />
                        </div>
                        <div class="form-group">
                            <label>วันเริ่มโครงการ </label>
                            <div id="date_start"  class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                                <input type="text" class="form-control" name="date_start"  autocomplete="off" required="">
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>วันสิ้นสุดโครงการ</label>
                            <div id="date_end" class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                                <input type="text" class="form-control" name="date_end"  autocomplete="off" required="">
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
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

    $('#date_start').datepicker({
        format: 'dd/mm/yyyy',
        language: 'th',     
        autoclose: true,         
        thaiyear: true              
    }).datepicker("setDate", "{{ $survey->surveydatestartinput }}");  

    $('#date_end').datepicker({
        format: 'dd/mm/yyyy',
        language: 'th',  
        autoclose: true,             
        thaiyear: true              
    }).datepicker("setDate", "{{ $survey->surveydateendinput }}");  
 
</script>
@stop