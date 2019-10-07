@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการคืนเงินงบประมาณ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                รายการคืนเงินงบประมาณ ปีงบประมาณ : {{ $project->year_budget }}
            </div>
        </div>
    </div>

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

    @if (count($refundpending) > 0) 
    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> ยืนยันคืนเงินงบประมาณ </div>
        <div class="smart-widget-body">
            <div class="smart-widget-body  padding-md">          
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th >หน่วยงาน</th>
                            <th >รายการค่าใช้จ่าย</th>
                            <th class="text-center">จำนวนเงินคืน</th>
                            <th class="text-center">ยืนยันคืนเงิน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalwaitprice=0;
                        @endphp
                        @if ($refundpending->count() > 0)
                            @foreach( $refundpending as $key => $item )
                            @php
                                $totalwaitprice += $item->waiting_price;
                            @endphp
                            <tr>
                                <td >{{ $item->departmentname }}</td>
                                <td >{{ $item->budgetname }}</td>
                                <td class="text-center">{{ number_format( $item->waiting_price , 2 ) }}</td>
                                <td class="text-center">
                                    <a href="{{ url('project/refund/main/confirm/'.$item->waiting_id ) }}" class="btn btn-warning btn-xs"> ยืนยันรับคืน</a>
                                </td>
                            </tr>
                        @endforeach
                        @endif

                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right" colspan="2"><strong>สรุปรายการ</strong> </td>
                            <td class="text-center"><strong>{{number_format( $totalwaitprice, 2 ) }}</strong></td>
                           
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    @endif

    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> รายการเงินคืนที่สามารถจัดสรรได้ </div>
        <div class="smart-widget-body">
            <div class="smart-widget-body  padding-md">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">หน่วยงาน</th>
                            <th class="text-center">รายการค่าใช้จ่าย</th>
                            <th class="text-center">จำนวนเงินคืน</th>
                            <th class="text-center">แก้ไขจัดสรร</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalsum=0;
                        @endphp
                        @if( count($sumbydept) > 0 )
                            @foreach( $sumbydept as $key => $item )
                            @php
                                $totalsum += $item->sum;
                            @endphp
                            @if ($item->sum > 0)
                                <tr>
                                    <td class="text-center">{{ $item->departmentname }}</td>
                                    <td class="text-center">{{ $item->budgetname }}</td>
                                    <td class="text-center">{{ number_format( $item->sum , 2 ) }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('project/refund/main/edit/'.$item->department_id .'/' . $item->sum ) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> แก้ไข</a>
                                    </td>
                                </tr>                             
                            @endif
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right" colspan="2"><strong>สรุปรายการ</strong> </td>
                            <td class="text-center"><strong>{{number_format($totalsum, 2 ) }}</strong></td>
                            
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>

@stop

@section('pageScript')
{{-- <script type="text/javascript">
    $(".table").dataTable();
</script> --}}
@stop