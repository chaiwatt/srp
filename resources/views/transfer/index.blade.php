@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการ โครงการ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการ โครงการ
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> รายการ โครงการ </div>
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
                                <th class="text-center">วันที่เพิ่ม</th>
                                <th class="text-center">ปีงบประมาณ</th>
                                <th class="text-center">ชื่อโครงการ</th>
                                <th class="text-center">งบประมาณ</th>
                                <th class="text-center">เริ่มโครงการ</th>
                                <th class="text-center">สิ้นสุดโครงการ</th>
                                <th class="text-center">เพิ่มเติม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( count($project) > 0 )
                            @foreach( $project as $key => $item )
                                <tr>
                                    <td>{{ $item->adddateth }}</td>
                                    <td class="text-center">{{ $item->year_budget }}</td>
                                    <td>{{ $item->project_name }}</td>
                                    <td>{{ number_format($item->totalbudget,2) }}</td>
                                    <td>{{ $item->startdateth }}</td>
                                    <td>{{ $item->enddateth }}</td>
                                    <td>
                                        <a href="{{ url('transfer/list/'.$item->project_id) }}" class="btn btn-info">โอนงบประมาณ</a>
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