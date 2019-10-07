@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('project/allocation/department/list') }}">รายการ โอนเงิน</a></li>
        <li>ประวัติการโอนเงินงบประมาณ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                ประวัติการโอนเงินงบประมาณ ปีงบประมาณ : {{ $project->year_budget }}
            </div>
        </div>
    </div>

    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> รายการโอนเงินงบประมาณ </div>
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
                            <th class="text-center">วันที่แจ้งโอน</th>
                            <th class="text-center">หน่วยงาน</th>
                            <th class="text-center">รายการ</th>
                            <th class="text-center">จำนวนเงินรับโอน</th>
                            <th class="text-center">เพิ่มเติม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            
                        @endphp
                        @if( count($transfer) > 0 )
                        @foreach( $transfer as $key => $item )
                            <tr>
                                <td>{{ $item->transferdateth }}</td>
                                <td>{{ $item->departmentname }}</td>
                                <td>{{ $item->sectionname }}</td>
                                <td>{{ $item->budgetname }}</td>
                                <td class="text-right">{{ number_format( $item->transfer_department_price , 2 ) }}</td>
                                <td></td>
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