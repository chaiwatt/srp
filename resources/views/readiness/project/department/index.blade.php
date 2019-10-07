@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการฝึกอบรมเตรียมความพร้อม</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                    รายการฝึกอบรมเตรียมความพร้อม ปีงบประมาณ : {{ $project->year_budget }}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('readiness/project/department/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มโครงการอบรม</a>
            </div>
        </div>
    </div>
</div>
    <div class="row padding-md">
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
                <div class="smart-widget-header"> รายการฝึกอบรมเตรียมความพร้อม </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >ชื่อโครงการ</th>
                                    <th class="text-center">วันที่</th>
                                    <th class="text-center">เป้าหมายผู้เข้าร่วม</th>
                                    <th class="text-center">งบประมาณ</th>
                                    <th class="text-center">สถานะโครงการ</th>
                                    <th class="text-center">จำนวนต้องการจัด</th>
                                    <th class="text-center">จำนวนอนุมัติ</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totaltargetparticipate=0;
                                    $totalbudget=0;
                                    $totalrequire =0;
                                    $totalapprove=0;
                                @endphp
                                @if( count($readiness) > 0 )
                                    @foreach( $readiness as $item )
                                    @php
                                        $approved = 0;
                                        $num = $readinesssection->where('project_readiness_id',$item->project_readiness_id)->count();
                                        if($num !=0){
                                            $approved = $readinesssection->where('project_readiness_id',$item->project_readiness_id)
                                            ->where('status',1)
                                            ->count();
                                        }
                                    @endphp
                                        <tr>
                                            <td>{{ $item->project_readiness_name }}</td>
                                            <td class="text-center">{{ $item->adddate }}</td>
                                            <td class="text-center">{{ $item->targetparticipate }}</td>
                                            <td class="text-center">{{ $item->budget }}</td>
                                            @if ($item->project_status == 0 )
                                                <td class="text-center">ไม่อนุมัติ</td>
                                            @else
                                                <td class="text-center text-success ">ผ่านการอนุมัติ</td>
                                            @endif
                                            <td class="text-center">{{ $num }}</td>
                                            <td class="text-center">{{ $approved }}</td>
                                            <td class="text-right">
                                                @if ($item->project_status == 0)
                                                    <a href="{{ url('readiness/project/department/edit/'.$item->project_readiness_id) }}" class="btn btn-info btn-xs" >เพิ่มเติม</a>
                                                    <a href="{{ url('readiness/project/department/delete/'.$item->project_readiness_id) }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบโครงการ')" >ลบ</a>
                                                @else
                                                <a href="{{ url('readiness/project/department/sectionlist/'.$item->project_readiness_id) }}" class="btn btn-info btn-xs" >รายละเอียด</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                        $totaltargetparticipate += $item->targetparticipate;
                                        $totalbudget +=$item->budget;
                                        $totalrequire += $num;
                                        $totalapprove += $approved;
                                    @endphp
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>
                                    <td class="text-center"><strong>{{ $totaltargetparticipate }}</strong> </td>                                
                                    <td class="text-center"><strong>{{ number_format( $totalbudget , 2 ) }}</strong> </td>    
                                    <td class="text-center" ><strong></strong> </td>                                
                                    <td class="text-center" ><strong>{{ $totalrequire }}</strong> </td>                                
                                    <td class="text-center"><strong>{{ $totalapprove }}</strong> </td>                                
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



@stop

@section('pageScript')
<script type="text/javascript">
    
</script>
@stop