@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('occupation/project/department') }}">รายการฝึกอบรมวิชาชีพ</a></li>    
        <li>เพิ่มโครงการฝึกอบรมวิชาชีพ</li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่มโครงการฝึกอบรมวิชาชีพ
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> โครงการฝึกอบรมวิชาชีพ </div>
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

                <div class="smart-widget-body  padding-md"> 
                    {!! Form::open([ 'url' => 'occupation/project/department/save' , 'method' => 'post' ]) !!} 
                        <div class="form-group">
                            <label>ชื่อโครงการ</label>
                            <input type="text" name="name" class="form-control" required="" />
                        </div>
                        <div class="form-group">
                            <label>วันที่จัดโครงการ</label>
                            <input type="text" name="projectdate" class="form-control datepicker"  data-provide="datepicker" data-date-language="th-th" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label>กรอบเป้าหมายผู้เข้าร่วมโครงการ</label>
                            <input type="number" min="0"  name="number" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>งบประมาณ</label>
                            <input type="number" min="0" name="budget" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>รายละเอียดโครงการ</label>
                                <textarea class="form-control" name="detail" required=""></textarea>
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