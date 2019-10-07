@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>โครงการรอพิจารณา</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                โครงการรอพิจารณา ปีงบประมาณ : {{ $project->year_budget }}
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
                <div class="smart-widget-header"> รายการฝึกอบรมวิชาชีพ รอพิจารณา</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >สังกัดกรม</th>
                                    <th >ชื่อโครงการ</th>
                                    <th class="text-center">วันที่</th>
                                    <th class="text-center">กรอบเป้าหมายผู้เข้าร่วม</th>
                                    <th class="text-center">งบประมาณ</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($readiness) > 0 )
                                    @foreach( $readiness as $item )
                                        @if ($item->project_status == 0)
                                            <tr>
                                                <td>{{ $item->departmentname }}</td>
                                                <td>{{ $item->project_readiness_name }}</td>
                                                <td class="text-center">{{ $item->adddate }}</td>
                                                <td class="text-center">{{ $item->targetparticipate }}</td>
                                                <td class="text-center">{{ $item->budget }}</td>
                                                <td class="text-right">
                                                    @if ($item->project_status == 0)
                                                        <a href="{{ url('occupation/project/main/approve/'.$item->project_readiness_id) }}" class="btn btn-warning btn-xs" >อนุมัติโครงการ</a>
                                                    @endif
                                                    <a href="{{ url('occupation/project/main/edit/'.$item->project_readiness_id) }}" class="btn btn-info btn-xs">เพิ่มเติม</a>
                                                </td>
                                            </tr> 
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
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