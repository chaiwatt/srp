@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปการสำรวจความต้องการการจ้างงาน</h1>
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
            <h1> {{$item->department_name}}</h1>
        </div>
       
            <table style="width:100%; " >	
                <thead>
                    <tr>
                        @if( count($position) > 0 )
                            @foreach( $position as $_item )
                                @if ($item->department_id == $_item->department_id )
                                    <th class="text-center">{{ $_item->position_name }}</th>
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
                                $value = $surveylist->where('position_id' , $value->position_id)->where('department_id' , $item->department_id)->sum('survey_amount');
                                $sumposition = $sumposition +   $value ;
                            @endphp
                            <td class="text-center">{{ $value }}</td>
                        @endif
                    @endforeach
                    <td class="text-center" style="width:100px">{{ $sumposition }}</td>
                </tbody>                     
            </table>

        @endforeach
    @endif		
	</div>
@stop