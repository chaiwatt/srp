@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>จัดสรรงบประมาณ จากเงินคืน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                จัดสรรงบประมาณ จากเงินคืน : ปีงบประมาณ {{ $settingyear->setting_year }} 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> จัดสรรงบประมาณ จากเงินคืน ( {{ number_format( $budget ,2) }} บาท )  </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">

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
                        {!! Form::open([ 'route' =>  ['project.refund.save','id' => $id ] , 'method' => 'post' ]) !!} 
                            <div class="form-group">
                                <label>จำนวนเงินที่ต้องการจัดสรร</label>
                                <input type="number" name="number" step="0.01" min="0" class="form-control" required="" />
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
</div>


@stop

@section('pageScript')

@stop