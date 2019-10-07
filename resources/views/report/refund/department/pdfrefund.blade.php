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
                            <th style="width:30%">สำนักงาน</th>
                            <th class="text-center">รายการค่าใช้จ่าย</th>
                            <th class="text-center">จำนวนเงินคืน</th>
                            <th class="text-center">วันที่คืน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( count($sectionrefund) > 0 )
                        @foreach( $sectionrefund as $key => $item )
                            <tr>
                                <td>{{ $item->sectionname }}</td>
                                <td class="text-center">{{ $item->budgetname }}</td>
                                <td class="text-center">{{ number_format( $item->refund_price , 2 ) }}</td>
                                <td class="text-center">{{ $item->thaidate }}</td>
                            </tr>                             
                        @endforeach 
                            @endif
                    </tbody>
                </table>
	</div>
@stop