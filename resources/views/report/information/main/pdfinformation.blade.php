@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปผลการดำเนินงานด้านการประชาสัมพันธ์</h1>
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
                        <th>หน่วยงาน</th>
                        <th>ประเภทสื่อ</th>
                        <th>จำนวนที่จัดทำ</th>
                        <th>จำนวนที่ใช้เงิน</th>
                        <th>ผู้รับจ้าง</th>
                    </tr>
                </thead>
                <tbody>
                    @if( count($expense) > 0 )
                    @foreach( $expense as $key => $item )
                        <tr>
                            <td>{{ $item->departmentname }}</td>
                            <td>{{ $item->expense_type }}</td>
                            <td>{{ $item->expense_amount }}</td>
                            <td>{{ number_format($item->expense_price,2) }}</td>
                            <td>{{ $item->expense_outsource }}</td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>				
	</div>
@stop