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
        <div class="col-sm-9">
            <div class="page-title">
                รายการติดตามความก้าวหน้า: ปีงบประมาณ {{ $project->year_budget}}
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
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ชื่อโครงการ</th>
                                <th>วันทีเริ่ม</th>
                                <th>สิ้นสุด</th>
                                <th>งบประมาณ</th>
                                <th>เบิกจ่ายจริง</th>
                                <th class="text-right">เพิ่มเติม</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $totalproject_budget=0;
                            $totalpayment=0;
                        @endphp
                            @if( count($projectfollowup) > 0 )
                            @foreach( $projectfollowup as $key => $item )
                            @php
                                $totalproject_budget += $item->project_budget;
                                $totalpayment += $item->payment;
                            @endphp
                                <tr>
                                    <td>{{ $item->project_followup_name }}</td>
                                    <td>{{ $item->projectstartdate }}</td>
                                    <td>{{ $item->projectenddate }}</td>
                                    <td>{{ number_format($item->project_budget,2) }}</td>
                                    <td>{{ number_format($item->payment,2) }}</td>
                                    
                                    <td class="text-right">
                                        <a href="{{ url('report/followup/main/onsite/view/'.$item->project_followup_id) }}" class="btn btn-info btn-xs"></i> รายละเอียด</a>                                       
                                    </td> 
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-center" colspan="3"><strong>สรุปรายการ</strong> </td>
                                <td ><strong>{{ number_format($totalproject_budget,2) }}</strong></td>                                        
                                <td ><strong>{{ number_format($totalpayment,2) }}</strong></td>                                        
                            </tr>
                        </tfoot>
                    </table>

                    {{-- <ul class="pagination pagination-split pull-right">
                        {!! $project->render() !!}
                    </ul> --}}

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