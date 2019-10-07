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
                รายการคืนเงินงบประมาณ ปีงบประมาณ : {{ $settingyear->setting_year }} 
            </div>
        </div>
    </div>

    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> รายการคืนเงินงบประมาณ 
            @php($count = count($allrefund->where("waiting_status", 0)) )
            @if( $count > 0)
                <small class="text-warning">
                    รายการที่ยังไม่ได้รับยืนยัน {{ $count }} รายการ
                </small>
            @endif
        </div>
        <div class="smart-widget-body">
            <div class="smart-widget-body  padding-md">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-left">วันที่คืน</th>
                            <th class="text-left">หน่วยงาน</th>
                            <th class="text-left">รายการค่าใช้จ่าย</th>
                            <th class="text-center">จำนวนเงินคืน</th>                            
                            <th class="text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalwaiting_price_view = 0;
                        @endphp
                        @if( count($allrefund) > 0 )
                            @foreach( $allrefund as $key => $item )
                            @php
                                $totalwaiting_price_view +=$item->waiting_price_view ;
                            @endphp
                                <tr>
                                    <td class="text-left">{{ $item->refunddate }}</td>
                                    <td class="text-left">{{ $item->departmentname }}</td>
                                    <td class="text-left">{{ $item->budgetname }}</td>
                                    <td class="text-center">{{ number_format( $item->waiting_price_view , 2 ) }}</td>                                
                                    @if( $item->waiting_status == 1)
                                        <td class="text-center"><span class="text-default">ยืนยันแล้ว</span></td>
                                        @else
                                        <td class="text-center"><span class="text-danger">รอการยืนยัน</span></td>
                                    @endif
                                </tr>                             
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                            <tr>
                                <td class="text-right" colspan="3"><strong>สรุปรายการ</strong> </td>
                                <td class="text-center"><strong>{{ number_format($totalwaiting_price_view, 2 )}}</strong></td>
                               
                            </tr>
                        </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>

@stop

@section('pageScript')
<script type="text/javascript">
    $(".table").dataTable({
        "language": {
        "search": "ค้นหา "
  }
    });
</script>
@stop