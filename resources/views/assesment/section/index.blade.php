@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการประเมินผล</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการประเมินผล ปีงบประมาณ : {{ $project->year_budget }}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('assesment/section/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มรายการประเมิน</a>
            </div>
        </div>
    </div>
</div>
    <div class="padding-md">
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
                <div class="smart-widget-header"> รายการประเมิน </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >ชื่อรายการประเมิน</th>
                                    <th class="text-center">วันที่ประเมิน</th>
                                    <th class="text-center">จำนวนผู้ประเมิน</th>
                                    <th class="text-center">ผู้ประเมิน</th>
                                    <th class="text-center">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalassessment =0;
                                @endphp
                                @if( count($assesment) > 0 )
                                @foreach( $assesment as $item )
                                @php
                                    $count = $personalassesment->where('project_assesment_id',$item->project_assesment_id )->count();
                                    $totalassessment += $count;
                                @endphp
                                    <tr>
                                        <td>{{ $item->assesment_name }}</td>
                                        <td class="text-center">{{ $item->assigndate }}</td>
                                        <td class="text-center">{{ $count }}</td>
                                        <td class="text-center">{{ $item->assesor }}</td>
                                        <td class="text-right">
                                            <a href="{{ url('assesment/section/assessmentedit/'.$item->project_assesment_id) }}" class="btn btn-info btn-xs">ประเมิน</a>
                                            <a href="{{ url('assesment/section/followupedit/'.$item->project_assesment_id) }}" class="btn btn-warning btn-xs">ติดตาม</a>
                                            <a href="{{ url('assesment/section/view/'.$item->project_assesment_id) }}" class="btn btn-success btn-xs">รายละเอียด</a>
                                            <a href="{{ url('assesment/section/delete/'.$item->project_assesment_id) }}" class="btn btn-danger btn-xs">ลบ</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>                                        
                                    <td class="text-center"><strong>{{ $totalassessment }}</strong> </td>                                             
                                    
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