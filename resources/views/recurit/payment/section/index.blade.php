@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>การเบิกจ่ายเงินเดือน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                การเบิกจ่ายเงินเดือน : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการอัตราจ้าง </div>
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
                                    <th >รหัสตำแหน่งงาน</th>
                                    <th >รหัสบัตรประชาชน</th>
                                    <th >คำนำหน้า</th>
                                    <th >ชื่อ</th>
                                    <th >นามสกุล</th>
                                    <th >ตำแหน่งาน</th>
                                    <th class="text-center">เบิกจ่าย</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if( count($generate) > 0 )
                                @foreach( $generate as $key => $item )
                                    <tr>
                                        <td >{{ $item->generate_code }}</td>
                                        <td >{{ $item->registerpersonid }}</td>
                                        <td>{{ $item->registerprefixname }}</td>
                                        <td>{{ $item->registername }}</td>
                                        <td>{{ $item->registerlastname }}</td>
                                        <td>{{ $item->positionname }}</td>
                                        <td class="text-center">
                                            <a href="{{ url('recurit/payment/section/create/'.$item->generate_id) }}" class="btn btn-warning ">เบิกจ่าย</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('recurit/payment/section/view/'.$item->generate_id) }}" class="btn btn-info">เพิ่มเติม</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop

@section('pageScript')
<script type="text/javascript">
	$(".table").dataTable({
		"language": {
		"search": "ค้นหา "
		}
	});
</script>
@stop