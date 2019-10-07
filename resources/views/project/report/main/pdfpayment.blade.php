@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปรายการผลการเบิกจ่าย</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>ภายใต้งบประมาณโครงการคืนคนดีสู่สังคม ประจำปีงบประมาณ พ.ศ. {{ $setyear}}</h1>
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
                    <th >สำนักงาน</th>
                    <th class="text-center">รับโอน(ครั้ง)</th>
                    <th class="text-center">งบประมาณจัดสรร</th>
                    <th class="text-center">โอนไปแล้ว</th>
                    <th class="text-center">เบิกจ่ายจริง</th>
                    <th class="text-center">คงเหลือ</th>
                    <th class="text-center">ร้อยละเบิกจ่าย</th>
                </tr>
            </thead>
            <tbody>
                @if( count($department) > 0 )
                @foreach( $department as $key => $item )
                @php
                    $numtransfer = $transfer->where('department_id',$item->department_id)->count();
                    $totaltransfer = $transfer->where('department_id',$item->department_id)->sum('transfer_price');
                    $sumpayment = $payment->where('department_id',$item->department_id)->sum('payment_salary');
                    if($item->transferallocation!=0){
                        $percent = number_format( ( $sumpayment / $item->transferallocation )* 100 , 2 );
                    }else{
                        $percent = 0;
                    }
                @endphp
                    <tr>
                        <td>{{ $item->department_name }}</td>
                        <td class="text-center">{{ $numtransfer }}</td>
                        <td class="text-center">{{ number_format( $item->allocation_price , 2 ) }}</td>
                        <td class="text-center">{{ number_format( $totaltransfer, 2 ) }}</td>
                        <td class="text-center">{{ number_format( $sumpayment , 2 ) }}</td>
                        <td class="text-center">{{ number_format( ($item->transferallocation - $sumpayment) , 2 ) }}</td>
                        <td class="text-center">{{ $percent }}</td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
	</div>
@stop