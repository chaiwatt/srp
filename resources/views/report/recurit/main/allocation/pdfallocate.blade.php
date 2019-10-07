@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>รายงานผลการจ้างงานโครงการคืนคนดีสู่สังคม</h1>
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
						<th style="width:20%; text-align: center;" class="text-center">จำนวนจ้างงาน</th>
						<th style="width:20%; text-align: center;"  class="text-center">จำนวนลาออก</th>
						<th style="width:20%; text-align: center;"  class="text-center">จำนวนยกเลิกจ้างงาน</th>
					</tr>
				</thead>
				<tbody>
					@if( count($department) > 0 )
                        @foreach( $department as $item )
                        @php( $numresign = $resign->where('resign_type',1)->where('department_id' , $item->department_id)->count() )
                        @php( $numfire = $resign->where('resign_type',2)->where('department_id' , $item->department_id)->count() )
                        @php( $numhired = $employ->where('department_id' , $item->department_id)->count() )
                            <tr>
                                <td class="text-left">{{ $item->department_name }}</td>
                                <td style="text-align: center;" >{{ $numhired }}</td>
                                <td style="text-align: center;" >{{ $numresign }}</td>
                                <td style="text-align: center;" >{{ $numfire }}</td>                           
                            </tr>
                        @endforeach
                    @endif    
				</tbody>                
                @if( count($department) > 0 )
                <tfoot>
                    <tr>
                        <td class="text-right" style="text-align: center;" colspan="1">รวม</td>
                        <td class="text-center" style="text-align: center;" >{{ $employ->count() }}</td>
                        <td class="text-center" style="text-align: center;" >{{ $resign->where('resign_type',1)->count() }}</td>
                        <td class="text-center" style="text-align: center;" >{{ $resign->where('resign_type',2)->count()  }}</td>
                    </tr>
                </tfoot>
            @endif

		</table>			
	</div>
@stop