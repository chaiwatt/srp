@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปผลการจัดโครงการฝึกอบรมวิชาชีพผู้พ้นโทษ</h1>
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
        		
			<table style="width:100%; ">				
				<thead>
					<tr>
                        <th >หน่วยงาน</th>
                        <th >จำนวนโครงการ</th>
                        <th >จำนวนผู้มีอาชีพ</th>
                        <th >จำนวนผู้มีรายได้เพียงพอ</th>
                        <th >ร้อยละรายได้เพียงพอ</th>
					</tr>
				</thead>
				<tbody>
                        @if( count($readiness) > 0 )
                        @php
                            $totalhasoccupation = 0;
                            $totalenoughincome =0;
                        @endphp
                            @foreach( $department as $item )
                                @php
                                    $num = $readiness->where('department_id', $item->department_id)->count();
                                    $target = $readiness->where('department_id', $item->department_id)->sum('targetparticipate');
                                    $participate = $participategroup->where('department_id', $item->department_id)->count('register_id');      
                                    $registers = $participategroup->where('department_id', $item->department_id)->all();
                                    $hasoccupation=0;
                                    $hasoccupation_enoughincome =0;
                                    if (count($registers) !=0 ){
                                        foreach($registers as $_item){
                                            $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                                                    ->where('occupation_id','!=',1)
                                                                                    ->first();
                                            if(count($registerhasoccupation) != 0 ){
                                                $hasoccupation = $hasoccupation + 1;
                                                $totalhasoccupation++;
                                            }

                                            $registerhasoccupationenoughincome = $personalassessment->where('register_id', $_item->register_id)
                                                                                    ->where('occupation_id','!=',1)
                                                                                    ->where('enoughincome_id',2)
                                                                                    ->first();
                                            if(count($registerhasoccupationenoughincome) != 0 ){
                                                $hasoccupation_enoughincome++;
                                                $totalenoughincome++;
                                            }
                                        }
                                }
                                @endphp
                                @if ($num != 0)
                                <tr>
                                    <td >{{ $item->department_name }}</td>
                                    <td class="text-center">{{ $num }}</td>
                                    <td class="text-center">{{ $hasoccupation }}</td>
                                    <td class="text-center">{{ $hasoccupation_enoughincome }}</td>
                                    @if ($hasoccupation !=0 )
                                    <td class="text-center">{{ number_format( ($hasoccupation_enoughincome/ $hasoccupation) * 100 , 2) }}</td>                                         
                                        @else
                                        <td class="text-center"></td>                                         
                                    @endif 
                                </tr>
                                @endif
                            @endforeach
                        @endif

				</tbody>
                @if( count($readiness) > 0 )
                @php
                    $num = $readiness->count();
                    $target = $readiness->where('department_id', $item->department_id)->sum('targetparticipate');
                    $participate = $participategroup->where('department_id', $item->department_id)->count('register_id');      
                    if ($totalenoughincome !=0 ){
                        $percent = number_format( ($totalenoughincome / $totalhasoccupation) * 100 , 2);
                    }else{
                        $percent=0;
                    }   
                @endphp
                    <tfoot>
                        <tr>
                            <td class="text-right" colspan="1">รวม</td>
                            <td class="text-center">{{ $readiness->count() }}</td>                                        
                            <td class="text-center">{{ $totalhasoccupation }}</td>
                            <td class="text-center">{{ $totalenoughincome }}</td>
                            <td class="text-center">{{ $percent }}</td>
                        </tr>
                    </tfoot>
                @endif
		</table>			
	</div>
@stop