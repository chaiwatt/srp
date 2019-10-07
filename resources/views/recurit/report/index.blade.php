@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานการจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายงานการจ้างงาน : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row padding-md">
        @if( count($department) > 0 )
        @foreach( $department as $key =>  $item )
            @php( $value = $generate->where('department_id' , $item->department_id)->count() )
            @php( $query = $employ->where('department_id' , $item->department_id)->count() )
            <div class="col-lg-4 col-sm-6">
                @if( ($key+1) % 4 == 1 )
                <div class="statistic-box bg-danger m-bottom-md">
                @elseif( ($key+1) % 4 == 2 )
                <div class="statistic-box bg-info m-bottom-md">
                @elseif( ($key+1) % 4 == 3 )
                <div class="statistic-box bg-purple m-bottom-md">
                @elseif( ($key+1) % 4 == 0 )
                <div class="statistic-box bg-success m-bottom-md">
                @endif
                    <div class="statistic-title">
                       {{ $item->department_name }}
                    </div>

                    <div class="statistic-value">
                        @if( $query != 0 )
                        {{ $value }} / {{ $query }} 
                        @else
                        0
                        @endif
                    </div>
                </div>
            </div>

        @endforeach
        @endif
    </div>

    <div class="row padding-md">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header">
                จำนวนจ้างงาน
            </div>
            <div class="smart-widget-inner">
                <div id="morris-line-example" style="height: 300px;"></div>
            </div><!-- ./smart-widget-inner -->
        </div>
    </div>

    <div class="row padding-md">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> สรุปรายการเบิกจ่าย </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">กรม</th>
                                <th class="text-center">งบประมาณจัดสรร</th>
                                <th class="text-center">รับโอนจริง</th>
                                <th class="text-center">เบิกจ่ายจริง</th>
                                <th class="text-center">ตำแหน่งที่ได้รับจัดสรร</th>
                                <th class="text-center">จำนวนที่ได้รับการจัดสรร(ตำแหน่ง)</th>
                                <th class="text-center">จ้างแล้ว(คน)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalallocation = 0;
                                $totalaltransfer = 0;
                                $totalalpayment = 0;
                                $totalqtyallocate = 0;
                                $totalqtyhire = 0;
                            @endphp
                            @if( count( $department ) > 0 )
                            @foreach( $department as $item )
                                <tr>
                                    @php( $value1 = $allocation->where('department_id' , $item->department_id)->sum('allocation_price') )
                                    @php( $value2 = $transfer->where('department_id' , $item->department_id)->sum('transfer_price') )
                                    @php( $value3 = $payment->where('department_id' , $item->department_id)->sum('payment_salary') )
                                    @php( $value4 = $refund->where('department_id' , $item->department_id)->sum('refund_price') )

                                    @php
                                    $totalallocation +=$value1;
                                    $totalaltransfer  +=$value2;
                                    $totalalpayment += $value3 ;
                                    @endphp

                                    <td style="vertical-align: middle;" class="text-center" rowspan="{{ count($position[$item->department_id])+1 }}">{{ $item->department_name }}</td>
                                    <td style="vertical-align: middle;" class="text-center" rowspan="{{ count($position[$item->department_id])+1 }}">{{ number_format( $value1 , 2 ) }}</td>
                                    <td style="vertical-align: middle;" class="text-center" rowspan="{{ count($position[$item->department_id])+1 }}">{{ number_format( $value2 , 2 ) }}</td>
                                
                                    <td style="vertical-align: middle;" class="text-center" rowspan="{{ count($position[$item->department_id])+1}}">
                                        {{ number_format( $value3  , 2 ) }} <br />
                                        @if( $value2 != 0 )
                                        {{  number_format( ( ($value3)/($value2) ) * 100 , 2) }} %
                                        @else
                                        ( 0% ) 
                                        @endif
                                    </td>
                                </tr>
                                @if( count($position[$item->department_id]) > 0  )
                                @foreach( $position[$item->department_id] as $value )
                                <tr>
                                    <td>{{ $value->position_name }}</td>
                                    @php
                                        $query = $employ->where('position_id' , $value->position_id)->where('department_id' , $item->department_id)->count() ;
                                        $totalqtyallocate +=$query ;
                                    @endphp
                                    <td class="text-right">{{ $query }}</td>
                                    @php
                                        $query = $employ->where('position_id' , $value->position_id)->where('department_id' , $item->department_id)->where('generate_status' , 1)->count();
                                        $totalqtyhire += $query ;
                                    @endphp
                                    
                                    <td class="text-right">{{ $query }}</td>
                                    @php
                                        
                                        
                                    @endphp
                                </tr>
                                @endforeach
                                @endif
                            @endforeach
                            @endif
                        </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="1"><strong>สรุปรายการ</strong> </td>
                                    <td class="text-center"><strong>{{number_format($totalallocation, 2 )  }}</strong></td>
                                    <td class="text-center"><strong>{{ number_format($totalaltransfer, 2 )}}</strong></td>
                                    <td class="text-center"><strong>{{ number_format($totalalpayment, 2 )}}</strong></td>
                                    <td class="text-right"  colspan="2"><strong>{{$totalqtyallocate}}</strong></td>
                                    <td class="text-right"><strong>{{$totalqtyhire}}</strong></td>
                                </tr>
                            </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row padding-md">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> เบิกจ่ายการจ้างงาน </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">จัดสรร</th>
                                <th class="text-center">จ้างงาน</th>
                                <th class="text-center">ลาออก</th>
                                <th class="text-center">ยกเลิกจ้างงาน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @if( $generate->count() > 0 )
                                @php( $sumgen = $generate->where('generate_status' , 1)->count() )
                                @php( $sign = $resign->where('resign_type' , 1)->count() )
                                @php( $cancel = $resign->where('resign_type' , 2)->count() )
                                <td class="text-center">{{ $employ->count() }}</td>
                                <td class="text-center">{{ $sumgen }} ( {{ number_format( ( ($sumgen)/($employ->count() ) ) * 100 , 2) }} % ) </td>
                                <td class="text-center">{{ $sign }} ( {{ number_format( ( $sign/$employ->count()) * 100 , 2 ) }} % )</td>
                                <td class="text-center">{{ $cancel }} ( {{ number_format( ( $cancel/$employ->count()) * 100 , 2 ) }} % )</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row padding-md">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header">
                จำนวนจ้างงาน
            </div>
            <div class="smart-widget-inner">
                <div id="morris-line" style="height: 300px;"></div>
            </div><!-- ./smart-widget-inner -->
        </div>
    </div>

</div>


@stop

@section('pageScript')
<script type="text/javascript">
	$(function(){

		Morris.Bar({
            element: 'morris-line',
            data: [
                { xkey : 'จัดสรร' , count : {{ $employ->count() }} },
                { xkey : 'จ้างงาน' , count : {{ $sumgen }} },
                { xkey : 'ลาออก' , count : {{ $sign }} },
                { xkey : 'ยกเลิกจ้างงาน' , count : {{ $cancel }} },
            ],
            xkey: 'xkey',
            ykeys : ['count'],
            labels : ['จำนวน'],
            resize: true,
            parseTime:false,
        });

		Morris.Bar({
            element: 'morris-line-example',
            data: [
                @if( count($department) > 0 )
                @foreach( $department as $item )
                    @php( $value = $generate->where('department_id' , $item->department_id)->count() )
                    @php( $query = $employ->where('department_id' , $item->department_id)->count() )
                    { position: '{{ $item->department_name }}', hire: {{ $query }} , employ : {{ $value}} },
                @endforeach
                @endif
            ],
            xkey: 'position',
            ykeys: ['hire' , 'employ'],
            labels: ['จำนวนจัดสรร' , 'จัดจ้างแล้ว'],
            resize: true,
            parseTime:false,
        });
	})
</script>
@stop