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
        		
			<table style="width:100%; " >				
                    <thead>
                            <tr>
                                <th >สังกัดกรม</th>
                                <th class="text-center">จำนวนโครงการ</th>
                                <th class="text-center">จำนวนหน่วยงานที่จัด</th>
                                <th class="text-center">จำนวนผู้เข้าร่วม</th>
                                <th class="text-center">จำนวนผู้มีอาชีพ</th>
                                <th class="text-center">ร้อยละการมีอาชีพ</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @if( count($readinesssection) > 0 )
                            @php
                                $total_actualparticipate=0;
                                $total_sum=0;
                                $totalhasoccupation = 0;
                            @endphp
                                @foreach( $department as $item )
                                    @php
                                        $num = $readinesssection->where('department_id', $item->department_id)->count();
                                        $numsection = count($readinesssection->where('department_id', $item->department_id)->groupBy('section_id')->all());
                                         $actualparticipate = 0;
                                         $sum=0;
                                       
                                         $_readinesssection = $readinesssection->where('department_id', $item->department_id);                                            

                                            foreach($_readinesssection as $sec){
                                                $actualparticipate = $participategroup->where('department_id' , $sec->department_id)->count();
                                                // $actualparticipate = $actualparticipate  + $participate->where('readiness_section_id' , $sec->readiness_section_id)->sum('participate_num'); 
                                                $total_actualparticipate = $total_actualparticipate + $participate->where('readiness_section_id' , $sec->readiness_section_id)->sum('participate_num'); 
                                                $sum = $sum + $readinesssection->where('readiness_section_id' , $sec->readiness_section_id)->first()->actualexpense;
                                                $total_sum = $total_sum + $readinesssection->where('readiness_section_id' , $sec->readiness_section_id)->first()->actualexpense;
                                            }    
                                        $registers = $participategroup->where('department_id', $item->department_id)->all();

                                        $hasoccupation=0;
                                        if (count($registers) !=0 ){
                                        foreach($registers as $_item){
                                           
                                            $registerhasoccupation = $personalassessment->where('register_id', $_item->register_id)
                                                                                    ->where('occupation_id','!=',1)
                                                                                    ->first();
                                            if(count($registerhasoccupation) != 0 ){
                                                $hasoccupation = $hasoccupation + 1;
                                                $totalhasoccupation++;
                                            }
                                        }
                                    }
                                    @endphp

                                    <tr>
                                        <td >{{ $item->department_name }}</td>
                                        <td class="text-center">{{ $num }}</td>
                                        <td class="text-center">{{ $numsection }}</td> 
                                        <td class="text-center">{{ $actualparticipate }}</td>
                                        <td class="text-center">{{ $hasoccupation }}</td>
                                        @if ($actualparticipate !=0 )
                                        <td class="text-center">{{ number_format( ($hasoccupation/ $actualparticipate) * 100 , 2) }}</td>                                         
                                            @else
                                            <td class="text-center">0</td>                                         
                                        @endif
                                    </tr>

                                @endforeach
                            @endif

                        </tbody>
                        {{-- @if( count($readiness) > 0 )
                        @php
                            $num = $readiness->count();
                            $target = $readiness->where('department_id', $item->department_id)->sum('targetparticipate');
                            $participate = $participategroup->where('department_id', $item->department_id)->count('register_id');      
                        @endphp
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="1">รวม</td>
                                    <td class="text-center">{{ $readiness->count() }}</td>
                                    <td class="text-center">{{ $participategroup->count('register_id') }}</td>
                                    <td class="text-center">{{ $totalhasoccupation }}</td>
                                    <td class="text-center">{{ number_format( ($totalhasoccupation/ $participategroup->count('register_id')) * 100 , 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif --}}

                    </table>			
	</div>
@stop