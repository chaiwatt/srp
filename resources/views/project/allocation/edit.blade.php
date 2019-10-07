@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('project/allocation') }}">รายการโครงการ</a></li>    
        <li>แก้ไข โครงการ</li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                แก้ไข โครงการ
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> แก้ไข โครงการ </div>
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
                    {!! Form::open([ 'url' => 'project/allocation/edit' , 'method' => 'post' ]) !!}
                        <input type="hidden" name="id" value="{{ $project->project_id }}">
                        <div class="form-group">
                            <label>วันเริ่มโครงการ </label>
                            <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                <input type="text" class="form-control" name="date_start" autocomplete="off" required="" value="{{ $project->startdateth }}">
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>วันสิ้นสุดโครงการ</label>
                            <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                <input type="text" class="form-control" name="date_end"  value="{{ $project->enddateth }}" autocomplete="off" required="">
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>ปีงบประมาณ</label>
                            <input type="number" name="year" min="2500" max="9999" class="form-control" value="{{ $project->year_budget }}" />
                        </div>
                        <div class="form-group">
                            <label>เงินตั้งต้น</label>
                            <input type="number" name="budget" min="0.00" step="0.01" class="form-control" value="{{ $project->totalbudget }}" />
                        </div>
                        <div class="form-group">
                            <label>รายละเอียดโครงการ</label>
                            <textarea name="description" class="form-control">{{ $project->project_description }}</textarea>
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
        format : "dd/mm/yyyy",
        autoclose:false,
        thaiyear: true,
        language: 'th',
    });
</script>
@stop