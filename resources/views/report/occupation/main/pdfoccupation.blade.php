@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปผลการจัดโครงการฝึกอบรมวิชาชีพ</h1>
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
                                <th>หน่วยงาน</th>
                                <th class="text-center">จำนวนโครงการ</th>
                                <th class="text-center">เป้าหมายเข้าร่วม</th>
                                <th class="text-center">เข้าร่วมจริง</th>
                                <th class="text-center">ร้อยละเข้าร่วม</th>
                                <th class="text-center">งบประมาณใช้จริง</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_target =0 ;
                                $total_actualparticipate =0 ;
                                $total_sum =0 ;
                            @endphp
                                @foreach( $department as $item )
                                    @php
                                         $_target = 0;
                                         $actualparticipate = 0;
                                         $sum  = 0;
                                         $_readinesssection = $readinesssection->where('department_id', $item->department_id);                                            
                                            foreach($_readinesssection as $sec){
                                                $_target = $_target + $readiness->where('project_id', $sec->project_id)->first()->targetparticipate;
                                                $total_target =  $total_target + $readiness->where('project_id', $sec->project_id)->first()->targetparticipate;
                                                $actualparticipate = $actualparticipate  + $participate->where('readiness_section_id' , $sec->readiness_section_id)->sum('participate_num'); 
                                                $total_actualparticipate = $total_actualparticipate + $participate->where('readiness_section_id' , $sec->readiness_section_id)->sum('participate_num'); 
                                                $sum = $sum + $readinesssection->where('readiness_section_id' , $sec->readiness_section_id)->first()->actualexpense;
                                                $total_sum = $total_sum + $readinesssection->where('readiness_section_id' , $sec->readiness_section_id)->first()->actualexpense;
                                            }
                                        if($_target!=0){
                                            $percent = number_format( ($actualparticipate/ $_target) * 100 , 2);
                                        }else{
                                            $percent=0;
                                        }
                                    @endphp
                                    <tr>
                                        <td >{{ $item->departmentname }}</td>
                                        <td class="text-center">{{ $_readinesssection->count()}}</td>
                                        <td class="text-center">{{ $_target }}</td>
                                        <td class="text-center">{{ $actualparticipate }}</td>
                                        <td class="text-center">{{ $percent }}</td> 
                                        <td class="text-center">{{ $sum }}</td> 
                                    </tr>
                                @endforeach
                            {{-- @endif --}}

                        </tbody>
                        {{-- @if( count($readiness) > 0 ) --}}
                        @php
                            $num = $readiness->count();
                            $_readinesssection = $readinesssection->count();    
                            if($total_target!=0){
                                $percent = number_format(( $total_actualparticipate / $total_target) * 100 , 2);
                            }else{
                                $percent=0;
                            }
                        @endphp
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="1">รวม</td>
                                    <td class="text-center">{{ $_readinesssection }}</td>
                                    <td class="text-center">{{ $total_target }}</td>
                                    <td class="text-center">{{ $total_actualparticipate }}</td>
                                    <td class="text-center">{{ $percent }}</td> 
                                    <td class="text-center">{{ $total_sum }}</td>
                                </tr>
                            </tfoot>
                        {{-- @endif --}}

                    </table>			
	</div>
@stop