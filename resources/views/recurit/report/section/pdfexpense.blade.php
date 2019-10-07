@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container"  style="max-width:960px">
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
                    {{-- <table class="table table-striped"> --}}
                            <thead>
                                <tr>
                                    <th class="text-center">เดือน</th>
                                    <th class="text-center">วันที่จ่าย</th>
                                    <th >คำขึ้นต้น</th>
                                    <th >ชื่อ</th>
                                    <th >นามสกุล</th>
                                    <th >ตำแหน่ง</th>
                                    <th class="text-center">เลขที่บัตรประชาชน</th>
                                    <th class="text-center">หักขาดเงิน</th>
                                    <th class="text-center">หักค่าปรับ</th>
                                    <th class="text-center">ค่าจ้างที่ได้รับ</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if( count($payment) > 0 )
                                @foreach( $payment as $key => $item )
                                    <tr>
                                        <td class="text-center">{{ str_pad( ($item->payment_month) , 2 ,"0",STR_PAD_LEFT)  }}</td>
                                        <td class="text-center">{{ $item->paymentdateth }}</td>
                                        <td>{{ $item->registerprefixname }}</td>
                                        <td>{{ $item->registername }}</td>
                                        <td>{{ $item->registerlastname }}</td>
                                        <td>{{ $item->positionname }}</td>
                                        <td class="text-center">{{ $item->registerpersonid }}</td>
                                        <td class="text-right">{{ number_format($item->payment_absence , 2) }}</td>
                                        <td class="text-right">{{ number_format($item->payment_fine , 2) }}</td>
                                        <td class="text-right">{{ number_format($item->payment_salary , 2) }}</td>
                                    </tr>
                                @endforeach
                                @endif
                                    <tr>
                                        <td colspan="7"  style="text-align:center">รวม</td>
                                        <td class="text-right">{{ number_format( $payment->sum( 'payment_absence' ) , 2 ) }}</td>
                                        <td class="text-right">{{ number_format( $payment->sum( 'payment_fine' ) , 2 ) }}</td>
                                        <td class="text-right">{{ number_format( $payment->sum( 'payment_salary' ) , 2 ) }}</td>
                                    </tr>
                            </tbody>
                        </table>		
	</div>
@stop