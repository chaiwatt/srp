@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปการเบิกจ่าย</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>ภายใต้งบประมาณโครงการคืนคนดีสู่สังคม ประจำปีงบประมาณ พ.ศ. {{ $setting->setting_year }}</h1>
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
                            <th >งบประมาณจัดสรร</th>
                            <th class="text-center">จำนวนโอน(ครั้ง)</th>
                            <th class="text-center">รับโอน</th>
                            <th class="text-center">เบิกจ่ายจริง</th>
                            <th class="text-center">งบประมาณคงเหลือ</th>
                            <th class="text-center">ร้อยละคงเหลือ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            if(count($allocation) != 0){
                                $_allocate = $allocation->sum('allocation_price');
                            }else{
                                $_allocate = 0;
                            }
                            if($transfer->count() !=0 ){
                                $numtransfer = $transfer->count();
                            }else{
                                $numtransfer = 0;
                            }
                            if($payment->count() !=0 ){
                                $_payment = $payment->sum('payment_salary');
                            }else{
                                $_payment = 0;
                            }
                            if($transfer->count() !=0 ){
                                $_transfer = $transfer->sum('transfer_price');
                                $percent = ($_payment/$_transfer)*100;
                            }else{
                                $_transfer =0;
                                $percent =0;
                            }

                        @endphp
                            <tr>
                                <td >{{ number_format($_allocate , 2) }}</td>
                                <td class="text-center"> {{ $numtransfer  }}</td>
                                <td class="text-center">{{ number_format($_transfer , 2) }}</td>
                                <td class="text-center">{{ number_format($_payment , 2) }}</td>
                                <td class="text-center">{{ number_format(($_transfer-$_payment) , 2) }}</td>
                                <td class="text-center">{{ number_format($percent , 2) }}</td>
                            </tr>
                    </tbody>
            </table>		
	</div>
@stop