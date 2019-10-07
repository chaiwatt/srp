@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>เบิกจ่ายการติดตามความก้าวหน้า</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เบิกจ่ายการติดตามความก้าวหน้า : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row padding-md">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> เบิกจ่ายการติดตามความก้าวหน้า </div>
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
                                <td class="text-center"> {{ number_format( ( $payment->sum('payment')) , 2 ) }}   ({{ number_format( ( ($payment->sum('cost')/$allocation->allocation_price ) * 100 ) , 2)  }} %) </td>
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