@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('transfer/list') }}">รายการ โอนงบประมาณ</a></li>
        <li>แก้ไขโอนงบประมาณ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                แก้ไขโอนงบประมาณ ปีงบประมาณ : {{ $project->year_budget }}
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

        {!! Form::open([ 'url' => 'transfer/edit' , 'method' => 'post' ]) !!} 
        <input type="hidden" name="id" value="{{ $transfer->transfer_id }}">

        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> {{ $budget->budget_name }} </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">
	               <div class="form-group">
	                   <label>{{ $department->department_name }}   </label>
	                   <input type="text" name="number" class="form-control" value="{{ $transfer->transfer_price }}" autocomplete="off">
	               </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="pull-right">
                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>
@stop

@section('pageScript')
@stop