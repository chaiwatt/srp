@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container" style="max-width:960px">
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
        		
			<table style="width:100%; " >				
                <thead>
                    <tr>
                        <th>รายการสำรวจ</th>
                        <th>หน่วยงาน</th>
                        <th>บันทึกเพิ่มเติม</th>
                        @if( count($position) > 0 )
                        @foreach( $position as $item )
                            <th class="text-center">{{ $item->position_name }}</th>
                        @endforeach
                        @endif
                        <th class="text-center">รวม</th>
                    </tr>
                </thead>
                <tbody>
                    @if( count($numsection) > 0 )
                    @foreach( $numsection as $key => $item )
                    @php
                        $surveyname = $projectsurvey->where('project_survey_id',$item->project_survey_id)->first()->project_survey_name;
                        $note = $projectsurvey->where('project_survey_id',$item->project_survey_id)->first()->note;
                        $numproject = $numsection->where('project_survey_id',$item->project_survey_id)->count();
                    @endphp
                        <tr>
                            @if ($key == 0)
                            <td rowspan="{{ $numproject }}">{{ $surveyname }}</td>
                            @endif
                            <td>{{ $item->sectionname }}</td>
                            <td>{{ $note }}</td>
                            @if( count($position) > 0 )
                            @foreach( $position as $value )
                                @php( $value = $surveylist->where('position_id' , $value->position_id)->where('section_id' , $item->section_id)->sum('survey_amount') )
                                <td class="text-center">{{ $value }}</td>
                            @endforeach
                            @endif
                            <td class="text-center" style="width:100px">{{ $surveylist->where('section_id' , $item->section_id)->sum('survey_amount') }}</td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-center" colspan="3">รวม</td>
                        @if( count($position) > 0 )
                        @foreach( $position as $value )
                            @php( $value = $surveylist->where('position_id' , $value->position_id)->sum('survey_amount') )
                            <td class="text-center">{{ $value }}</td>
                        @endforeach
                        @endif
                        <td class="text-center" style="width:100px">{{ $surveylist->sum('survey_amount') }}</td>
                    </tr>
                </tfoot>
        </table>			
	</div>
@stop