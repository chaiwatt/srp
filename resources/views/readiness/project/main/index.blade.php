@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>โครงการฝึกอบรมเตรียมความพร้อม</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                โครงการฝึกอบรมเตรียมความพร้อม ปีงบประมาณ : {{ $project->year_budget }}
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
                <div class="smart-widget-header"> รายการฝึกอบรมเตรียมความพร้อม</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >วันที่</th>
                                    <th >กรมสังกัด</th>
                                    <th >ชื่อโครงการ</th>
                                    <th class="text-center">กรอบเป้าหมายผู้เข้าร่วม</th>
                                    <th class="text-center">งบประมาณ</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totaltargetparticipate=0;
                                    $totalbudget =0;
                                @endphp
                                @if( count($readiness) > 0 )
                                    @foreach( $readiness as $item )
                                        @if ($item->project_status == 1)
                                        @php
                                            $totaltargetparticipate += $item->targetparticipate ;
                                            $totalbudget += $item->budget;
                                        @endphp
                                            <tr>
                                                <td >{{ $item->adddate }}</td>
                                                <td >{{ $item->departmentname }}</td>
                                                <td>{{ $item->project_readiness_name }}</td>                                               
                                                <td class="text-center">{{ $item->targetparticipate }}</td>
                                                <td class="text-center">{{ $item->budget }}</td>
                                                <td class="text-right">
                                                    <a href="{{ url('readiness/project/main/edit/'.$item->project_readiness_id) }}" class="btn btn-info btn-xs">แก้ไขการจัดสรร</a>
                                                </td>
                                            </tr> 
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="3"><strong>สรุปรายการ</strong> </td>
                                    <td class="text-center"><strong>{{$totaltargetparticipate}}</strong></td>
                                    <td class="text-center"><strong>{{number_format(  $totalbudget, 2 )}}</strong></td>
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