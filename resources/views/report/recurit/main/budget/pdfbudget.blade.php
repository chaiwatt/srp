@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>รายงานผลการเบิกจ่ายโครงการคืนคนดีสู่สังคม</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>ประจำปีงบประมาณ พ.ศ. {{ $setting->setting_year }}</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>{{ $header }}</h1>
		</div>
		<div class="txt01 txt-center">
				<h1>************************************</h1>
		</div>
			<table style="width:100%; ">				
				<thead>
					<tr>
						<th style="width:40%; text-align: center;" class="text-center">หน่วยงาน</th>
						<th style="width:20%; text-align: center;" class="text-center">เบิกจ่ายเงินเดือน</th>
						<th style="width:20%; text-align: center;"  class="text-center">หักขาดงาน</th>
						<th style="width:20%; text-align: center;"  class="text-center">หักอื่นๆ</th>
					</tr>
				</thead>
				<tbody>
                @if( count($department) > 0 )
                    @foreach( $department as $key => $item )
                        @php( $paid = $payment->where('department_id' , $item->department_id)->sum('payment_salary') )
                        @php( $absence = $payment->where('department_id' , $item->department_id)->sum('payment_absence') )
                        @php( $fine = $payment->where('department_id' , $item->department_id)->sum('payment_fine') )
                        <tr>
                            <td style="text-align: left;" >{{ $item->department_name }}</td>
                            <td style="text-align: center;" >{{ $paid }}</td>
                            <td style="text-align: center;" >{{ $absence }}</td>
                            <td style="text-align: center;" >{{ $fine }}</td>                           
                        </tr>
                    @endforeach
                @endif

				</tbody>

                @if( count($department) > 0 )
                <tfoot>
                    <tr>
                        <td class="text-right" style="text-align: center;" colspan="1">รวม</td>
                        <td class="text-center" style="text-align: center;" >{{ $payment->sum('payment_salary') }}</td>
                        <td class="text-center" style="text-align: center;" >{{ $payment->sum('payment_absence') }}</td>
                        <td class="text-center" style="text-align: center;" >{{ $payment->sum('payment_fine') }}</td>
                    </tr>
                </tfoot>
            @endif

		</table>			
	</div>
@stop