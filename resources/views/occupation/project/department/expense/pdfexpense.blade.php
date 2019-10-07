@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container" style="max-width:960px">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปรายการค่าใช้จ่ายฝึกอบรมวิชาชีพ</h1>
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
                    <th >สำนักงาน</th>
                    <th class="text-center">จำนวนโครงการ</th>                                    
                    <th class="text-center">เป้าหมายผู้เข้าร่วม</th>
                    <th class="text-center">ผู้เข้าร่วมจริง</th>
                    <th class="text-center">งบประมาณ</th>
                    <th class="text-center">เบิกจ่ายจริง</th>
                </tr>
                </thead>
                <tbody>
                    @if( count($department) > 0 )
                        @foreach( $department as $item )

                        @php
                            $target = $readiness->where('department_id', $item->department_id)->sum('targetparticipate');
                            $participate = $participategroup->where('department_id', $item->department_id)->count('register_id');                                              
                            $expense = $readinessexpense->where('department_id', $item->department_id)->sum('cost');      
                        @endphp
                            <tr>
                                <td >{{ $item->departmentname }}</td>
                                <td class="text-center">{{ $readiness->count() }}</td>
                                <td class="text-center">{{ $target }}</td>
                                <td class="text-center">{{ $participate }}</td>
                                <td class="text-center">{{ number_format( ($readiness->sum('budget')) , 2 )   }}</td>
                                <td class="text-center">{{ number_format( ($expense) , 2 )  }}</td>                                               
                            </tr> 
                        @endforeach
                    @endif
                </tbody>
        </table>
	</div>
@stop