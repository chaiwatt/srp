@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการโครงการ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการติดตามความก้าวหน้า: ปีงบประมาณ {{ $project->year_budget}}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('followup/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มกิจกรรม</a>
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">

    

    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> รายการติดตามความก้าวหน้า </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">

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
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ชื่อโครงการ</th>
                                <th>วันทีเริ่ม</th>
                                <th>สิ้นสุด</th>
                                <th class="text-center">งบประมาณ</th>
                                <th class="text-center">เบิกจ่ายจริง</th>
                                <th class="text-right">เพิ่มเติม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalbudget =0;
                                $totalpayment =0;
                            @endphp
                            @if( count($projectfollowup) > 0 )
                            @foreach( $projectfollowup as $key => $item )
                                @php
                                    $totalbudget += $item->project_budget;
                                    $totalpayment += $item->payment;
                                @endphp
                                <tr>
                                    <td>{{ $item->project_followup_name }}</td>
                                    <td>{{ $item->projectstartdate }}</td>
                                    <td>{{ $item->projectenddate }}</td>
                                    <td class="text-center">{{ number_format($item->project_budget,2) }}</td>
                                    <td class="text-center">{{ number_format($item->payment,2) }}</td>
                                    
                                    <td class="text-right">
                                        <a href="{{ url('followup/manage/'.$item->project_followup_id) }}" class="btn btn-info"></i> บันทึกข้อมูล</a>
                                        <a href="{{ url('followup/edit/'.$item->project_followup_id) }}" class="btn btn-warning"></i> แก้ไข</a>
                                        <a href="{{ url('followup/delete/'.$item->project_followup_id) }}" class="btn btn-danger" onclick="return confirm('ยืนยันการลบโครงการ')"></i> ลบ</a>
                                    </td> 
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="3"><strong>สรุปรายการ</strong> </td>
                                <td class="text-center"><strong>{{ number_format( ($totalbudget) , 2)  }}</strong> </td>
                                <td class="text-center"><strong>{{ number_format( ($totalpayment) , 2)  }}</strong> </td>
                            </tr>
                        </tfoot>
                    </table>

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