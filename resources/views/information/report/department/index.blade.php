@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานการเบิกจ่ายการจัดทำประชาสัมพันธ์</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                การเบิกจ่ายการจัดทำประชาสัมพันธ์ : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>
    {{-- return $payment->sum('expense_price');
     return $allocation->allocation_price . "  " . $allocation->transferallocation ; --}}

    <div class="row padding-md">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> เบิกจ่ายการจัดทำประชาสัมพันธ์ </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">งบประมาณจัดสรร</th>
                                <th class="text-center">รับโอนจริง</th>
                                <th class="text-center">เบิกจ่ายจริง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"> {{ number_format( ( $allocation->allocation_price ) , 2) }}    </td>
                                <td class="text-center"> {{ number_format( (  $allocation->transferallocation) , 2 ) }}  ({{ number_format( ( ($allocation->transferallocation/$allocation->allocation_price ) * 100 ) , 2)  }} %) </td>
                                <td class="text-center"> {{ number_format( ( $payment->sum('expense_price')) , 2 ) }}   ({{ number_format( ( ($payment->sum('expense_price')/$allocation->allocation_price ) * 100 ) , 2)  }} %) </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


@stop

@section('pageScript')
@stop