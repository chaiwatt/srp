@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปรายการคืนเงิน</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>ภายใต้งบประมาณโครงการคืนคนดีสู่สังคม ประจำปีงบประมาณ พ.ศ. {{ $setyear }}</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>{{ $header }}</h1>
        </div>
        <div class="txt01 txt-center">
            <h1>************************************</h1>
        </div>
        		
        <table style="width:100%; " >	
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
                @if( count($allrefund) > 0 )
                @foreach( $allrefund as $key => $item )
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
        </table>
	</div>
@stop