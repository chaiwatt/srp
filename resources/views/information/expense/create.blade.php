@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('information/expense') }}">รายงานผลการจัดทำการประชาสัมพัฯธ์</a></li>
        <li>เพิ่มผลการจัดทำการประชาสัมพัฯธ์</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่มผลการจัดทำการประชาสัมพันธ์
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> จัดทำการประชาสัมพันธ์ (คงเหลือ {{ number_format( ( $transfer - $expense ) , 2 ) }} )</div>
                {{-- <div class="smart-widget-header"> เพิ่มผลการจัดทำการประชาสัมพัฯธ์ รายการ ( เงินตั้งต้น {{ number_format( $transfer , 2 ) }} ) - ( ค่าประชาสัมพันธ์ {{ number_format( $expense , 2 ) }} ) - ( คืนเงินประชาสัมพันธ์ {{ number_format( $refund , 2) }} )  = ( คงเหลือ {{ number_format( ( $transfer - $expense - $refund ) , 2 ) }} )</div> --}}
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
                        {!! Form::open([ 'url' => 'information/expense/create' , 'method' => 'post' ]) !!} 
                            <div class="form-group">
                                <label>ชื่อรายการประชาสัมพันธ์</label>
                                <input type="text" name="name" class="form-control" required="" />
                            </div>
                            <div class="form-group">
                                <label>รายละเอียด</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>ประเภทสื่อ</label>
                                <input type="text" name="type" class="form-control" required="" />
                            </div>
                            <div class="form-group">
                                <label>จำนวน</label>
                                <input type="number" name="amount" class="form-control" step="1" required="" />
                            </div>
                            <div class="form-group">
                                <label>เป็นเงิน</label>
                                <input type="number" name="price" class="form-control" step="0.01" required="" />
                            </div>
                            <div class="form-group">
                                <label>ผู้รับจ้าง</label>
                                <input type="text" name="outsource" class="form-control" required="" />
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึกรายการ</button>
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