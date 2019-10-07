@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปการรายการลาออก</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>ภายใต้งบประมาณโครงการคืนคนดีสู่สังคม ประจำปีงบประมาณ พ.ศ. {{ $setting->setting_year }}</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>{{ $header }}</h1>
        </div>

        <div class="txt01">
			<h1>รายการลาออก</h1>
		</div>      		
        <table style="width:100%; " >	
            <thead>
                <tr>
                    <th>รหัสตำแหน่ง</th>
                    <th>คำนำหน้า</th>
                    <th >ชื่อ</th>
                    <th >นามสกุล</th>
                    <th >ตำแหน่งที่สมัคร</th>
                    <th class="text-center">วันที่ลาออก</th>
                    <th class="text-center">เหตุผล</th>
                </tr>
            </thead>
            <tbody>
                @if( count($resign) > 0 )
                @foreach( $resign as $key => $item )
                    <tr>
                        <td>{{ $item->generate_code }}</td>
                        <td>{{ $item->registerprefixname }}</td>
                        <td>{{ $item->registername }}</td>
                        <td>{{ $item->registerlastname }}</td>
                        <td>{{ $item->positionname }}</td>
                        <td class="text-center">{{ $item->resigndateth }}</td>
                        <td class="text-center">{{ $item->reasonname }}</td>

                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
		<div class="txt01">
			<h1>รายการลาออก (เหตุผล)</h1>
		</div>
        <table style="width:100%; " >
            <thead>
                <tr>
                    <th>เหตุผล</th>
                    <th>จำนวน</th>
                </tr>
            </thead>
            <tbody>
                @if( count($reason) > 0 )
                @foreach( $reason as $key => $item )
                    <tr>
                        <td>{{ $item->reasonname }}</td>
                        <td>{{ $item->total }}</td>
                     </tr>
                @endforeach
                @endif
            </tbody>
        </table>

	</div>
@stop