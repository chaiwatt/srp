@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการงบประมาณที่ได้รับการจัดสรร</li>    
    </ul>

    <div class="row">
        <div class="col-sm-7">
            <div class="page-title">
                งบประมาณที่ได้รับการจัดสรร ปีงบประมาณ : {{ $project->year_budget }}
            </div>
        </div>
        <div class="col-sm-5">
            <div class="pull-right">
                  <a href="{{ url('project/allocation/department/create') }}" class="btn btn-success">จัดสรรงบประมาณจ้างงาน</a>
            </div>
        </div>
    </div>

    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> รายการงบประมาณที่ได้รับการจัดสรร </div>
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
                            <th>รายการค่าใช้จ่าย</th>
                            <th class="text-center">งบประมาณจัดสรร</th>
                            <th class="text-center">รับโอนแล้ว</th>
                            <th class="text-center">ยังไม่ได้รับโอน</th>
                            <th class="text-center">จำนวนครั้งที่รับโอน</th>
                            {{-- <th class="text-center">โอนให้หน่วยงานย่อยแล้ว</th> --}}
                            <th class="text-center">ประวัติรับโอน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalallocation_price=0;
                            $totaltransferallocation=0;
                            $totalpendingtraansfer=0;
                            $totaltransfercount=0;
                        @endphp
                        @if( count($allocation) > 0 )
                        @foreach( $allocation as $key => $item )
                        @php
                            $totalallocation_price += $item->allocation_price;
                            $totaltransferallocation += $item->transferallocation ;
                            $totaltransfercount += $item->transfercount;
                        @endphp
                            <tr>
                                <td>{{ $item->budgetname }}</td>
                                <td class="text-center">{{ number_format( $item->allocation_price , 2 ) }}</td>
                                <td class="text-center">{{ number_format( $item->transferallocation , 2 )  }}</td>                               
                                <td class="text-center">{{ number_format( $item->allocation_price - $item->transferallocation , 2) }}</td>
                                
                                <td class="text-center">{{ $item->transfercount }}</td>
                                {{-- <td class="text-center">{{number_format( $item->sumtransfer , 2 )}}</td> --}}
                                <td class="text-right">
                                    <a href="{{ url('project/allocation/department/view/'.$item->budget_id ) }}" class="btn btn-info"><i class="fa fa-eye"></i> รายการรับโอน</a>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-center" ><strong>สรุปรายการ</strong> </td>
                            <td class="text-center"><strong>{{ number_format($totalallocation_price,2)  }}</strong></td>                                        
                            <td class="text-center"><strong>{{ number_format($totaltransferallocation,2)  }}</strong></td>                                        
                            <td class="text-center"><strong>{{ number_format($totalallocation_price-$totaltransferallocation,2)  }}</strong></td>                                        
                            <td class="text-center"><strong>{{ $totaltransfercount }}</strong></td>                                        
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

@section('pageScript')
@stop