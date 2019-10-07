@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานค่าใช้จ่าย</li>    
    </ul>

    <div class="row padding-md">
        <div class="col-sm-9">
            <div class="page-title">
                    รายงานค่าใช้จ่าย โครงการฝึกอบรมวิชาชีพ
            </div>
        </div>
        <div class="col-sm-3">
            <div class="pull-right">
                <a href="{{ url('report/occupation/department/expense/excel/') }}" class="btn btn-info">Excel</a>
                <a href="{{ url('report/occupation/department/expense/pdf/') }}" class="btn btn-warning">PDF</a>
            </div>
        </div>
    </div>
</div>
    <div>
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการฝึกอบรมวิชาชีพ</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >วันที่</th>
                                    <th >สำนักงาน</th>
                                    <th >ชื่อโครงการ</th>                                    
                                    <th class="text-center">เป้าหมายผู้เข้าร่วม</th>
                                    <th class="text-center">ผู้เข้าร่วมจริง</th>
                                    <th class="text-center">งบประมาณ</th>
                                    <th class="text-center">เบิกจ่ายจริง</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($readiness) > 0 )
                                    @foreach( $readiness as $item )
                                        @if ($item->project_status == 1)
                                            <tr>
                                                <td >{{ $item->adddate }}</td>
                                                <td>{{ $item->sectionname }}</td>
                                                <td>{{ $item->project_readiness_name }}</td>                                                
                                                <td class="text-center">{{ $item->targetparticipate }}</td>
                                                <td class="text-center"> {{ $item->participate }} </td>
                                                <td class="text-center">{{ $item->budget }}</td>
                                                <td class="text-center"> {{ $item->expense }} </td>
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



@stop

@section('pageScript')
<script type="text/javascript">
    
</script>
@stop