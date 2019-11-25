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
                โครงการคืนคนดีสู่สังคม: ปีงบประมาณ {{ $settingyear->setting_year}}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('project/allocation/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มโครงการ</a>
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">

    

    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> รายการโครงการ </div>
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
                                <th>วันที่เพิ่ม</th>
                                <th>ปีงบประมาณ</th>
                                <th>ชื่อโครงการ</th>
                                <th>งบประมาณ</th>
                                <th>เริ่มโครงการ</th>
                                <th>สิ้นสุดโครงการ</th>
                                <th>งบตั้งต้น</th>
                                <th>จัดสรร</th>
                                <th>เพิ่มเติม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( count($project) > 0 )
                            @foreach( $project as $key => $item )
                                <tr>
                                    <td>{{ $item->adddateth }}</td>
                                    <td>{{ $item->year_budget }}</td>
                                    <td>{{ $item->project_name }}</td>
                                    <td>{{ number_format($item->totalbudget,2) }}</td>
                                    <td>{{ $item->startdateth }}</td>
                                    <td>{{ $item->enddateth }}</td>
                                    <td>
                                        <a href="{{ url('project/allocation/locate/'.$item->project_id) }}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> แก้ไข</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('project/allocation/deptalllocate/'.$item->project_id) }}" class="btn btn-default  btn-xs"><i class="fa fa-pencil"></i> แก้ไข</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('project/allocation/edit/'.$item->project_id) }}" class="btn btn-warning  btn-xs"><i class="fa fa-pencil"></i> แก้ไข</a>
                                        <a href="{{ url('project/allocation/delete/'.$item->project_id) }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบโครงการ')"><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>

                    <ul class="pagination pagination-split pull-right">
                        {!! $project->render() !!}
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