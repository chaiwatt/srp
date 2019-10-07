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
        <div class="smart-widget-header"> รายการคืนเงินงบประมาณ </div>
        <div class="smart-widget-body">
            <div class="smart-widget-body  padding-md">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th >สำนักงาน</th>
                            <th class="text-center">รายการค่าใช้จ่าย</th>
                            <th class="text-center">จำนวนเงินคืน</th>
                            <th class="text-center">วันที่คืน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalrefund_price=0;
                        @endphp
                        @if( count($sectionrefund) > 0 )
                        @foreach( $sectionrefund as $key => $item )
                        @php
                            $totalrefund_price += $item->refund_price;
                        @endphp
                            <tr>
                                <td>{{ $item->sectionname }}</td>
                                <td class="text-center">{{ $item->budgetname }}</td>
                                <td class="text-center">{{ number_format( $item->refund_price , 2 ) }}</td>
                                <td class="text-center">{{ $item->thaidate }}</td>
                            </tr>                             
                        @endforeach 
                         @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>
                            <td class="text-center"><strong>{{ number_format($totalrefund_price ,2)  }}</strong></td>                                       
                            
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

@section('pageScript')
    @if( count($sectionrefund) > 10 )
        <script type="text/javascript">
            $(".table").dataTable({
                "language": {
                "search": "ค้นหา "
                }
            });
        </script>
    @endif
@stop