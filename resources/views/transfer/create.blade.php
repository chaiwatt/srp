@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('transfer/list') }}">รายการ โอนงบประมาณ</a></li>
        <li>โอนงบประมาณ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                โอนงบประมาณ ปีงบประมาณ : {{ $project->year_budget }}
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

        {!! Form::open([ 'url' => 'transfer/create' , 'method' => 'post' ]) !!} 
        <input type="hidden" name="id" value="{{ $project->project_id }}">
        @if( count($budget) > 0 )
        @foreach( $budget as $item )
            @php( $allocationprice = $allocation->where('budget_id' , $item->budget_id)->sum('allocation_price') )
            @if( $allocationprice != 0 )

                <div class="smart-widget widget-dark-blue">
                    <div class="smart-widget-header"> {{ $item->budget_name }} </div>
                    <div class="smart-widget-body">
                        <div class="smart-widget-body  padding-md">
                            @if( count($department) > 0 )
                            @foreach( $department as $value )
                                @php(
                                    $deptallocat = $allocation->where('budget_id' , $item->budget_id)
                                    ->where('department_id' , $value->department_id)
                                    ->sum('allocation_price')
                                )
                                @php( 
                                    $trans = $transaction->where('budget_id' , $item->budget_id)
                                            ->where('department_id' , $value->department_id)
                                            ->sortBy('transfer_transaction_id')
                                            ->last()
                                )
                                {{-- ตรวจสอบว่ามี transaction หรือไม่ --}}
                                @if( count(  $trans  ) > 0 )
                                @php
                                     $number = $trans->transaction_balance 
                                @endphp
                                @else
                                    @if( $allocationprice != 0)
                                        @php($number = $deptallocat )
                                    @else
                                        @php( $number = 0 )
                                    @endif
                                @endif

                                @if( $allocationprice != 0 && $number != 0 )
    	                            <div class="form-group">
                                        @if ($item->budget_id == 6 )
                                                <label>{{ $value->department_name }}  ( คงเหลือ {{ number_format( $number  , 2)  }} ) </label>@if ($maxremain == 0) <span class="text-danger">หมายเหตุ: ไม่สามารถโอนเงินได้ เนื่องจากยังไม่ได้กำหนดกรอบจ้างเหมา</span> @else <span class="text-danger">หมายเหตุ: ไม่สามารถกรอกเงิน เกิน {{$maxremain}} บาท</span>  @endif 
                                                <input type="number" min="0" @if($maxremain != 0) max="{{$maxremain}}" @endif name="number[{{$item->budget_id}}][{{$value->department_id}}]" class="form-control" autocomplete="off" @if ($maxremain == 0) readonly @endif>
                                            @else
                                                <label>{{ $value->department_name }}  ( คงเหลือ {{ number_format( $number  , 2)  }} ) </label>
                                                <input type="number" min="0" name="number[{{$item->budget_id}}][{{$value->department_id}}]" class="form-control" autocomplete="off">
                                        @endif
    	                               
    	                            </div>
                                @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif

        @endforeach
        @endif

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