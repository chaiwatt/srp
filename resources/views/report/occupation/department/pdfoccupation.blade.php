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
                        <th >วันที่</th>
                        <th >โครงการ</th>                                    
                        <th class="text-center">จำนวนหน่วยงาน</th>
                        <th class="text-center">เป้าหมายเข้าร่วม</th>
                        <th class="text-center">เข้าร่วม</th>
                        <th class="text-center">งบประมาณใช้จริง</th>
                        
                    </tr>
                </thead>

                <tbody>
                    @if( count($projectreadiness) > 0 )
                    @foreach( $projectreadiness as $key => $item )
                            
                            @php
                                // $actualparticipate = $participate->where('readiness_section_id' , $item->readiness_section_id)->sum('participate_num');                                            
                                $actualparticipate = $participategroup->where('project_readiness_id' , $item->project_readiness_id)->count();                                            
                                $num = $readinesssection->where('project_readiness_id' , $item->project_readiness_id)->groupBy('section_id')->count();
                                $_target = $readiness->where('project_readiness_id',$item->project_readiness_id)->first()->targetparticipate * $num ;
                                $sum = $readinesssection->where('project_readiness_id' , $item->project_readiness_id)->sum('actualexpense');
                            @endphp
                            <tr>
                                <td >{{ $item->adddate  }}</td>
                                <td >{{ $item->project_readiness_name }}</td>                                            
                                <td class="text-center">{{ $num }}</td>
                                <td class="text-center">{{$_target}}</td>
                                <td class="text-center">{{ $actualparticipate }}</td>   
                                <td class="text-center">{{ $sum }}</td>                                             
                            </tr>
                    @endforeach
                    
                    @endif
                </tbody>
                @if( count($participate) > 0 )
                    {{-- <tfoot>
                        <tr>
                            <td class="text-right" colspan="3">รวม</td>
                            <td class="text-center">{{ $readiness->sum('targetparticipate') }}</td>
                            <td class="text-center">{{ $participate->sum('participate_num') }}</td>
                        </tr>
                    </tfoot> --}}
                @endif
            </table>				
	</div>
@stop