@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container"  style="max-width:960px">
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
								<th class="text-center">หน่วยงาน</th>
								<th class="text-center">จำนวนจ้างงาน</th>
								@foreach( $position as $key => $item )
									<th class="text-center">{{$item->position_name}}</th>
								@endforeach
								<th class="text-center">จำนวนลาออก</th>
								<th class="text-center">จำนวนยกเลิกจ้างงาน</th>
							</tr>
						</thead>

						<tbody>
							@if( count($section) > 0 )
							@foreach( $section as $key => $item )
								@php( $numhired = $employ->where('section_id' , $item->section_id)->where('generate_status',1)->count() )
								@php( $numresign = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',1)->count() )
								@php( $numfire = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',2)->count() )
								<tr>
									<td class="text-left">{{ $item->section_name }}</td>
									<td class="text-center">{{ $numhired }}</td> 
									@foreach( $position as $key => $_item )
									@php( $num = $employ->where('section_id' , $item->section_id)->where('position_id' , $_item->position_id)->where('generate_status',1)->count() )
										<td class="text-center">{{$num}}</td>
									@endforeach
									<td class="text-center">{{ $numresign }}</td>
									<td class="text-center">{{ $numfire }}</td>     
			   
								</tr>
							@endforeach
							@endif
						</tbody>
						@if( count($section) > 0 )
							<tfoot>
								<tr>
									<td class="text-right" colspan="1"><strong>สรุปรายการ</strong> </td>
									<td class="text-center" ><strong>{{ $employ->where('generate_status',1)->count() }}</strong> </td>
									@foreach( $position as $key => $_item )
									@php( $num = $employ->where('position_id' , $_item->position_id)->where('generate_status',1)->count() )
										<td class="text-center"><strong>{{ $num }}</strong> </td>
									@endforeach
									<td class="text-center" ><strong>{{ $resign->where('resign_status',1)->where('resign_type',1)->count() }}</strong> </td>
									<td class="text-center"><strong>{{ $resign->where('resign_status',1)->where('resign_type',2)->count()  }}</strong> </td>
								</tr>
							</tfoot>
						@endif
					</table>			
				{{-- <thead>
					<tr>
						<th style="width:40%; text-align: center;" class="text-center">หน่วยงาน</th>
						<th style="width:20%; text-align: center;" class="text-center">จำนวนจ้างงาน</th>
						<th style="width:20%; text-align: center;"  class="text-center">จำนวนลาออก</th>
						<th style="width:20%; text-align: center;"  class="text-center">จำนวนยกเลิกจ้างงาน</th>
					</tr>
				</thead>
				<tbody>
					@if( count($section) > 0 )
					@foreach( $section as $key => $item )
						@php( $numhired = $employ->where('section_id' , $item->section_id)->where('generate_status',1)->count() )
						@php( $numresign = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',1)->count() )
						@php( $numfire = $resign->where('section_id' , $item->section_id)->where('resign_status',1)->where('resign_type',2)->count() )
						<tr>
							<td class="text-left">{{ $item->section_name }}</td>
							<td style="text-align: center;" >{{ $numhired }}</td>
							<td style="text-align: center;" >{{ $numresign }}</td>
							<td style="text-align: center;" >{{ $numfire }}</td>                           
						</tr>
					@endforeach
					@endif
				</tbody>
				@if( count($section) > 0 )
				<tfoot>
					<tr>
						<td class="bold" style="text-align: center;" colspan="1">รวม</td>
						<td class="bold" style="text-align: center;" >{{ $employ->where('generate_status',1)->count() }}</td>
						<td class="bold" style="text-align: center;" >{{ $resign->where('resign_status',1)->where('resign_type',1)->count() }}</td>
						<td class="bold" style="text-align: center;" >{{ $resign->where('resign_status',1)->where('resign_type',2)->count()  }}</td>
					</tr>
				</tfoot>
			@endif
		</table>			 --}}
	</div>
@stop