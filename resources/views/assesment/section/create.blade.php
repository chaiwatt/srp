@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>   
        <li>เพิ่มรายการประเมิน</li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                    เพิ่มรายการประเมิน ปีงบประมาณ: {{ $project->year_budget }}
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> เพิ่มรายการประเมิน </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md"> <!-- form create project -->
                    {!! Form::open([ 'url' => 'assesment/section/create' , 'method' => 'post' ]) !!} 
                        <div class="form-group">
                            <label>ชื่อรายการประเมิน</label>
                            <input type="text" name="assesment" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>วันที่</label>
                            <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                <input type="text" class="form-control" name="assesmentdate" readonly="" autocomplete="off" required="">
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                                <label>ผู้ประเมิน</label>
                                <input type="text" name="assesor" class="form-control" required />
                            </div>
                        <div class="form-group">
                            <label>รายละเอียดการประเมิน</label>
                            <textarea name="description" class="form-control"></textarea>
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