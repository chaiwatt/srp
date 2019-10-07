@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปการจ่ายเงินเดือน รายบุคคล</h1>
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
                        {{-- วันที่จ่าย	คำขึ้นต้น	ชื่อ	นามสกุล	เลขที่บัตรประชาชน	หักขาดเงิน	หักค่าปรับ	ค่าจ้างที่ได้รับ --}}
                        <th>วันที่จ่าย</th>
                        <th>หักขาดเงิน</th>
                        <th>หักค่าปรับ</th>
                        <th>ค่าจ้างที่ได้รับ</th>
                    </tr>
                </thead>

                <tbody>
                    @if( count($payment) > 0 )
                    @foreach( $payment as $key => $item )
                            <tr>
                                <td >{{ $item->paymentdateth }}</td>
                                <td class="text-center" >{{ $item->payment_absence }}</td>
                                <td class="text-center" >{{ $item->payment_fine}}</td>
                                <td class="text-center" >{{ $item->payment_salary}}</td>
                                
                            </tr>
                    @endforeach
                    @endif
                </tbody>
                <tfoot>
                    @if( count($payment) > 0 )
                        <tr>
                            <td class="text-center" >รวม</td>
                            <td class="text-center">{{ $payment->sum('payment_absence') }}</td>
                            <td class="text-center">{{ $payment->sum('payment_fine') }}</td>
                            <td class="text-center">{{ number_format($payment->sum('payment_salary') , 2)  }}</td>
                        </tr>
                    @endif
                </tfoot>
            </table>

	</div>
@stop