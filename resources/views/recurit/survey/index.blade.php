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
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('recurit/survey/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มรายการสำรวจ</a>
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
                                    <th >รายการสำรวจ</th>
                                    <th >เริ่มสำรวจ</th>
                                    <th >สิ้นสุดสำรวจ</th>
                                    <th class="text-center">หน่วยงานที่ตอบแบบสำรวจ</th>
                                    <th class="text-right">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalsurveydepartmentcount = 0;
                                @endphp
                                @if( count($projectsurvey) > 0 )
                                @foreach( $projectsurvey as $item )
                                @php
                                    $totalsurveydepartmentcount += $item->surveydepartmentcount;
                                @endphp
                                    <tr>
                                        <td>{{ $item->project_survey_name }}</td>
                                        <td>{{ $item->surveydatestartth }}</td>
                                        <td>{{ $item->surveydateendth }}</td>
                                        <td class="text-center">{{ $item->surveydepartmentcount }}</td>
                                        <td class="text-right">
                                            <a href="{{ url('recurit/survey/edit/'.$item->project_survey_id) }}" class="btn btn-warning">แก้ไข</a>
                                            <a href="{{ url('recurit/survey/view/'.$item->project_survey_id) }}" class="btn btn-info">เพิ่มเติม</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="3" ><strong>สรุปรายการ</strong> </td>
                                    <td class="text-center"><strong>{{ $totalsurveydepartmentcount }}</strong></td>                                       
                                    
                                </tr>
                            </tfoot>
                        </table>

                        <ul class="pagination pagination-split pull-right">
                        </ul>

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