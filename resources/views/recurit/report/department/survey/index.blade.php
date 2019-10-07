@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/survey') }}">รายการสำรวจการจ้างงาน</a></li>
        <li>รายละเอียดรายการสำรวจการจ้างงาน</li>    
    </ul>

    <div class="row ">
        <div class="col-sm-9">
            <div class="page-title">
                รายละเอียดรายการสำรวจการจ้างงาน ปีงบประมาณ : {{ $project->year_budget }}
            </div>
        </div>
        <div class="col-sm-3">
            <div class="pull-right">
                <a href="{{ url('recurit/report/department/survey/pdf') }}" class="btn btn-success btn-sm"><i class="fa fa-save"></i> ไฟล์ PDF</a>
                {{-- <a href="{{ url('recurit/report/department/survey/excel') }}" class="btn btn-warning">Excel</a> --}}
            </div>
        </div>
    </div>

    <div class="row ">

        @if( Session::has('success') )
            <div class="alert alert-success alert-custom alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <i class="fa fa-check-circle m-right-xs"></i> {{ Session::get('success') }}
            </div>
        @elseif( Session::has('error') )
            <div class="alert alert-danger alert-custom alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                 <i class="fa fa-times-circle m-right-xs"></i> {{ Session::get('error') }}
            </div>
        @endif

        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการสำรวจการจ้างงาน </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
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
                                        <td >{{ $surveyname }}</td>
                                        <td>{{ $item->sectionname }}</td>
                                        <td>{{  $note }}</td>
                                        @if( count($position) > 0 )
                                        @foreach( $position as $value )
                                            @php( $value = $surveylist->where('position_id' , $value->position_id)->where('section_id' , $item->section_id)->sum('survey_amount') )
                                            <td class="text-center">{{ $value }}</td>
                                        @endforeach
                                        @endif
                                        <td class="text-center">{{ $surveylist->where('section_id' , $item->section_id)->sum('survey_amount') }}</td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                           
                            <tfoot>
                                @if( count($numsection) > 0 )
                                    <tr>
                                        <td class="text-center" colspan="3"><strong>สรุปรายการ</strong> </td>
                                        @if( count($position) > 0 )
                                        @foreach( $position as $value )
                                            @php( $value = $surveylist->where('position_id' , $value->position_id)->sum('survey_amount') )
                                            <td class="text-center"><strong>{{ $value }}</strong> </td>
                                        @endforeach
                                        @endif
                                        <td class="text-center"><strong>{{ $surveylist->sum('survey_amount') }}</strong> </td>
                                    </tr>
                                @endif
                            </tfoot>
                
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


@stop

@section('pageScript')
<script type="text/javascript">
    
</script>
@stop