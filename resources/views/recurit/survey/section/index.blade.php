@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการสำรวจการจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการสำรวจการจ้างงาน ปีงบประมาณ : {{ $project->year_budget }}
            </div>
        </div>
    </div>

    <div class="row">
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
                                    <th>เริ่มสำรวจ</th>
                                    <th>สิ้นสุดสำรวจ</th>
                                    <th class="text-right">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if( count($projectsurvey) > 0 )
                                @foreach( $projectsurvey as $item )
                                    <tr>
                                        <td>{{ $item->project_survey_name }}</td>
                                        <td>{{ $item->surveydatestartth }}</td>
                                        <td>{{ $item->surveydateendth }}</td>
                                        <td class="text-right">
                                            @if( $item->project_survey_datestart <= date('Y-m-d') && $item->project_survey_dateend >= date('Y-m-d') )
                                                <a href="{{ url('recurit/survey/section/create/'.$item->project_survey_id) }}" class="btn btn-info">แก้ไขรายการ</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการสำรวจการจ้างงานรวม </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >รายการสำรวจ</th>
                                    <th class="text-center">ยอดรวม</th>
                                    @if( count($position) > 0 )
                                    @foreach( $position as $item )
                                    <th class="text-center">{{ $item->position_name }}</th>
                                    @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalsurveysectionsumamount =0;
                                @endphp
                                @if( count($surveysum) > 0 )
                                @foreach($surveysum as $item)
                                @php
                                     $totalsurveysectionsumamount  += $item->surveysectionsumamount;
                                @endphp
                                    <tr>
                                        <td>{{ $item->project_survey_name }}</td>
                                        <td class="text-center">{{ $item->surveysectionsumamount }}</td>
                                        @if( count($position) > 0 )
                                        @foreach( $position as $value )
                                            @php(   $query = $survey->where('position_id' , $value->position_id)
                                                    ->sum('survey_amount') 
                                                )
                                            <td class="text-center"> {{ $query }}</td>
                                        @endforeach
                                        @endif
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right"  ><strong>สรุปรายการ</strong> </td>
                                    <td class="text-center"><strong>{{ $totalsurveysectionsumamount }}</strong></td>                                       
                                    @foreach( $position as $value )
                                        @php(   $query = $survey->where('project_survey_id' , $item->project_survey_id)
                                                ->where('position_id' , $value->position_id)
                                                ->sum('survey_amount') 
                                            )
                                        <td class="text-center"><strong>{{ $query }}</strong> </td>
                                    @endforeach
                                </tr>
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