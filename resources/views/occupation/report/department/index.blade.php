@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>เบิกจ่ายการอบรมวิชาชีพ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เบิกจ่ายการอบรมวิชาชีพ : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>
    <div class="row padding-md">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header">รายการฝึกอบรม
            </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body padding-md">                       
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th >วันที่</th>
                                <th >โครงการ</th>                                    
                                <th class="text-center">จำนวนหน่วยงาน</th>
                                <th class="text-center">งบประมาณใช้จริง</th>
                                
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $totalsection =0;
                                $totaltarget = 0;
                                $totalactualparticipate =0;
                                $totalpayment =0;
                            @endphp

                            @if( count($projectreadiness) > 0 )
                            @foreach( $projectreadiness as $key => $item )
                                    
                                    @php                                      
                                        $num = $readinesssection->where('project_readiness_id' , $item->project_readiness_id)->groupBy('section_id')->count();                                        
                                        $sum = $readinesssection->where('project_readiness_id' , $item->project_readiness_id)->sum('actualexpense');
                                        $totalsection += $num;
                                        $totalpayment += $sum;
                                    @endphp
                                    <tr>
                                        <td >{{ $item->adddate  }}</td>
                                        <td >{{ $item->project_readiness_name }}</td>                                            
                                        <td class="text-center">{{ $num }}</td>  
                                        <td class="text-center">{{ number_format( $sum  , 2 ) }}</td>                                             
                                    </tr>
                            @endforeach
                            
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>                                        
                                <td class="text-center"><strong>{{ $totalsection }}</strong> </td>                                                                          
                                <td class="text-center"><strong>{{  number_format( $totalpayment , 2 )}}</strong> </td>   
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row padding-md">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> เบิกจ่ายการอบรมวิชาชีพ </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th >งบประมาณจัดสรร</th>
                                <th class="text-center">รับโอนจริง</th>
                                <th class="text-center">เบิกจ่ายจริง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td > {{ number_format( ( $allocation->allocation_price ) , 2) }}    </td>
                                <td class="text-center"> {{ number_format( (  $allocation->transferallocation) , 2 ) }}  ({{ number_format( ( ($allocation->transferallocation/$allocation->allocation_price ) * 100 ) , 2)  }} %) </td>
                               @if ($transfer->sum('transfer_price') != 0)
                                    <td class="text-center"> {{ number_format( $totalpayment , 2 ) }}   ({{ number_format( ( ($totalpayment/$transfer->sum('transfer_price') ) * 100 ) , 2)  }} %) </td>
                                  @else 
                                    <td class="text-center"> {{ number_format( $totalpayment , 2 ) }}   (0.00 %) </td>
                               @endif
                                
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