@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container" style="max-width: 918px;">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปการประเมินบุคลิกภาพ รายบุคคล</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>ภายใต้งบประมาณโครงการคืนคนดีสู่สังคม ประจำปีงบประมาณ พ.ศ. {{ $project->year_budget }}</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>{{ $header }}</h1>
        </div>
        <div class="txt01 txt-center">
            <h1>************************************</h1>
        </div>
        		
        <table style="width:100%; font-size:14px " >	
            <thead>
                <tr>
                    <th  style="font-size:20px " rowspan="2" >หน่วยงาน</th>
                    <th  style="font-size:20px " rowspan="2" >จำนวนผู้ทดสอบ</th>
                    <th  style="font-size:20px " rowspan="2" >คะแนนเฉลี่ย</th>
                    <th  style="font-size:20px " colspan="2" class="text-center">ความต้องการ</th>
                    <th  style="font-size:20px " colspan="2" class="text-center">การให้การอบรม</th>
                    <th  style="font-size:20px " rowspan="2" class="text-center">การมอบหมายงาน</th>
                </tr>
                <tr>
                    <th  style="font-size:20px " >อาชีพ</th>
                    <th  style="font-size:20px " >การศึกษา</th>
                    <th  style="font-size:20px " >อาชีพ</th>
                    <th  style="font-size:20px " >การศึกษา</th>
                </tr>
            </thead>
            <tbody>

                @if( count($department) > 0 )
                @foreach( $department as $key => $item )
                    <tr>
                        <td>{{ $item->departmentname }}</td>
                         @php
                            $num = $uniquessesmentfit->where('department_id',$item->department_id)
                            ->count();
                            $allscore = $uniquessesment->where('department_id',$item->department_id)
                            ->sum('register_assessment_point');
                            $total = $uniquessesment->where('department_id',$item->department_id)->count();
                            $scoreavg = number_format( ($allscore / $total) , 2);
                            $occupationneedfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('registeroccupationneedfit',1)
                            ->count();
                            $educationneedfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('registereducationneedfit',1)
                            ->count();

                            $occupationtrainfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('registeroccupationtrainfit',1)
                            ->count();
                            $educationtrainfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('registereducationtrainfit',1)
                            ->count();
                            $jobassignmentfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('jobassignmentfit',1)
                            ->count();
                        @endphp
                        <td >{{ $num }}</td>
                        <td >{{ $scoreavg }}</td>
                       <td >{{ $occupationneedfit }}</td>
                        <td >{{ $educationneedfit }}</td>
                        <td >{{ $occupationtrainfit }}</td>
                        <td >{{ $educationtrainfit }}</td>
                        <td class="text-center">{{ $jobassignmentfit }}</td> 
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
	</div>
@stop