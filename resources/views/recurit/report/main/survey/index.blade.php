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
                <a href="{{ url('recurit/report/main/survey/pdf') }}" class="btn btn-success btn-sm"><i class="fa fa-save"></i> ไฟล์ PDF</a>
                {{-- <a href="{{ url('recurit/report/department/survey/excel') }}" class="btn btn-warning">Excel</a> --}}
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-md-12">
            @if( count($numdepartment) > 0 )
                @foreach( $numdepartment as $key => $item )
                    <div class="smart-widget widget-dark-blue">
                        <div class="smart-widget-header"> {{$item->department_name}} </div>
                        <div class="smart-widget-body">
                            <div class="smart-widget-body  padding-md">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            @if( count($position) > 0 )
                                                @foreach( $position as $_item )
                                                    @if ($item->department_id == $_item->department_id )
                                                        <th class="text-center">{{ $_item->position_name }}</th>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <th class="text-center">รวม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sumposition=0;
                                        @endphp
                                        @foreach( $position as $value )
                                            @if ($item->department_id == $value->department_id )
                                                @php
                                                    $value = $surveylist->where('position_id' , $value->position_id)->where('department_id' , $item->department_id)->sum('survey_amount');
                                                    $sumposition = $sumposition +   $value ;
                                                @endphp
                                                <td class="text-center">{{ $value }}</td>
                                            @endif
                                        @endforeach
                                        <td class="text-center"><strong>{{ $sumposition }}</strong> </td>
                                    </tbody>                     
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>


@stop
@section('pageScript')
<script type="text/javascript">
    
</script>
@stop