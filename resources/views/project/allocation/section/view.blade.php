@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('project/allocation/section') }}">รายการงบประมาณที่ได้รับการจัดสรร</a></li>
        <li>ประวัติการรับโอนเงินงบประมาณ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                ประวัติการรับโอนเงินงบประมาณ ปีงบประมาณ : {{ $project->year_budget }}
            </div>
        </div>
    </div>

    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> รายการรับโอนเงินงบประมาณ ( {{ $budget->budget_name }} )</div>
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
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th >วันที่แจ้งโอน</th>
                            <th class="text-center">จำนวนเงินรับโอน</th>
                            <th class="text-center">จำนวนครั้งที่รับโอน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( count($transfer) > 0 )
                        @foreach( $transfer as $key => $item )
                            <tr>
                                <td>{{ $item->transferdateth }}</td>
                                <td class="text-center">{{ number_format( $item->transfer_price , 2 ) }}</td>
                                <td class="text-center">{{ $item->transfer_amount }}</td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

@section('pageScript')
@stop