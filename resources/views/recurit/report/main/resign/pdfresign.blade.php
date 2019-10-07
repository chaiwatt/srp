@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปการสำรวจการลาออก</h1>
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
        		
        @if( count($numdepartment) > 0 )
            @foreach( $numdepartment as $key => $item )
                <div class="txt01">
                    <h1>{{$item->department_name}}</h1>
                </div>
                    <table style="width:100%; " >	
                        <thead>
                            <tr>
                                @if( count($position) > 0 )
                                    @foreach( $position as $_item )
                                        @if ($item->department_id == $_item->department_id )
                                            <th>{{ $_item->position_name }}</th>
                                        @endif
                                    @endforeach
                                @endif
                                <th class="text-center">รวม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sumposition=0;
                            @endphp
                            @foreach( $position as $value )
                                @if ($item->department_id == $value->department_id )
                                    @php
                                        $value = $resign->where('position_id' , $value->position_id)->where('department_id' , $item->department_id)->count();
                                        $sumposition = $sumposition +   $value ;
                                    @endphp
                                    <td>{{ $value }}</td>
                                @endif
                            @endforeach
                            <td class="text-center" style="width:100px">{{ $sumposition }}</td>
                        </tbody> 
                    </table>
                    
                    <table style="width:100%; " >	
                        <thead>
                            <tr>
                                <th>เหตุผลการลาออก </th>
                                <th class="text-center">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( count($reason) > 0 )
                                @foreach( $reason as $key => $check )

                                @if ($item->department_id == $check->department_id )
                                    <tr>
                                        <td >{{ $check->reasonname }}</td>
                                        <td class="text-center" style="width:100px">{{ $resign->where('reason_id' , $check->reason_id)->where('department_id', $item->department_id)->count() }}</td>
                                    </tr>
                                @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
            @endforeach
        @endif	
	</div>
@stop