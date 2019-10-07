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
                
                <a href="{{ url('report/occupation/main/expense/excel/') }}" class="btn btn-info">Excel</a>
                <a href="{{ url('report/occupation/main/expense/pdf/') }}" class="btn btn-warning">PDF</a>
            </div>
        </div>
    </div>
</div>
    <div>
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายงานค่าใช้จ่าย ฝึกอบรมวิชาชีพ</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>                                    
                                    <th >สำนักงาน</th>
                                    <th class="text-center">จำนวนโครงการ</th>                                    
                                    <th class="text-center">เป้าหมายผู้เข้าร่วม</th>
                                    <th class="text-center">ผู้เข้าร่วมจริง</th>
                                    <th class="text-center">งบประมาณ</th>
                                    <th class="text-center">เบิกจ่ายจริง</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($department) > 0 )
                                    @foreach( $department as $item )

                                    @php
                                        $target = $readiness->where('department_id', $item->department_id)->sum('targetparticipate');
                                        $participate = $participategroup->where('department_id', $item->department_id)->count('register_id');                                              
                                        $expense = $readinessexpense->where('department_id', $item->department_id)->sum('cost');      
                                    @endphp
                                            <tr>
                                                <td >{{ $item->departmentname }}</td>
                                                <td class="text-center">{{ $readiness->count() }}</td>
                                                <td class="text-center">{{ $target }}</td>
                                                <td class="text-center">{{ $participate }}</td>
                                                <td class="text-center">{{ number_format( ($readiness->sum('budget')) , 2 )   }}</td>
                                                <td class="text-center">{{ number_format( ($expense) , 2 )  }}</td>                                               
                                            </tr> 
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