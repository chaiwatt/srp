@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปผลการติดตามการจัดโครงการฝึกอบรมวิชาชีพผู้พ้นโทษ</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>ภายใต้งบประมาณโครงการคืนคนดีสู่สังคม ประจำปีงบประมาณ พ.ศ. {{ $setyear }}</h1>
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
                        <th class="text-center">จังหวัด</th>
                        <th class="text-center">จำนวนหน่วยงาน</th>
                        <th class="text-center">จำนวนผู้เข้าร่วม</th>
                        <th class="text-center">จำนวนผู้มีอาชีพ</th>
                        <th class="text-center">ร้อยละการมีอาชีพ</th>
					</tr>
				</thead>
				<tbody>
                        @if( count($occupationdatabysection) > 0 )
                        @php
                            $actualparticipate=0;   
                            $hasoccupation=0;
                            $numsection=0;
                            $percent=0;
                        @endphp
                        @foreach( $occupationdatabysection as $key => $item )
                                <tr>
                                    @php
                                        $actualparticipate = $actualparticipate + $item['actualparticipate'];
                                        $hasoccupation = $hasoccupation + $item['hasoccupation'];
                                        $numsection = $numsection + $item['numsection'];
                                        $percent = $percent + $item['percent'];
                                    @endphp
                                    <td >{{ $item['province']  }}</td>
                                    <td style="text-align: center" >{{ $item['numsection']  }}</td>
                                    <td style="text-align: center" >{{ $item['actualparticipate']  }}</td>
                                    <td style="text-align: center" >{{ $item['hasoccupation']   }}</td> 
                                    <td style="text-align: center" >{{ $item['percent'] }}</td>    
                                </tr>
                        @endforeach
                            @php
                                $percent  =$percent  / ($key+1);
                            @endphp
                        @endif
				</tbody>
                @if( count($occupationdatabysection) > 0 )
                <tfoot>
                    <tr>
                        <td style="text-align: center"  colspan="1"><strong>สรุปรายการ</strong></td>
                        <td style="text-align: center" ><strong>{{ $numsection }}</strong></td>
                        <td style="text-align: center" ><strong>{{ $actualparticipate }}</strong></td>
                        <td style="text-align: center" ><strong>{{ $hasoccupation }}</strong></td>
                        <td style="text-align: center" ><strong>{{ number_format( ($percent) , 2)  }}</strong></td>
                    </tr>
                </tfoot>
            @endif
		</table>			
	</div>
@stop