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

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                รายละเอียดรายการสำรวจการจ้างงาน ปีงบประมาณ : {{ $project->year_budget }}
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
                                    <th >ลำดับ</th>
                                    <th class="text-center">หน่วยงาน</th>
                                    <th class="text-center">รวม</th>
                                    @if( count($position) > 0 )
                                    @foreach( $position as $item )
                                        <th class="text-center">{{ $item->position_name }}</th>
                                    @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($surveygroup) > 0 )
                                @foreach( $surveygroup as $key => $item )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->sectionname }}</td>
                                        <td class="text-center">{{ $survey->where('section_id' , $item->section_id)->sum('survey_amount') }}</td>
                                        @if( count($position) > 0 )
                                        @foreach( $position as $value )
                                            @php( $value = $survey->where('position_id' , $value->position_id)->where('section_id' , $item->section_id)->sum('survey_amount') )
                                            <td class="text-center">{{ $value }}</td>
                                        @endforeach
                                        @endif
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
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