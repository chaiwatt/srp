@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>การจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                การจ้างงาน : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการจ้างงาน </div>
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
                                    <th>รหัสตำแหน่ง</th>
                                    <th>ตำแหน่ง</th>
                                    <th>ชื่อ-สกุล</th>
                                    <th class="text-center">เลขที่สัญญาจ้าง</th>
                                    <th class="text-center">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($generate) > 0 )
                                @foreach( $generate as $item )
                                    @php( $query = $payment->where('generate_code' , $item->generate_code)->count() )
                                    <tr>
                                        <td >{{ $item->generate_code }}</td>
                                        <td>{{ $item->positionname }}</td>
                                  
                                        <td >{{ $item->registerprefixname }}{{ $item->registername }} {{ $item->registerlastname }}</td>
                                        <td class="text-center">{{ $item->registercontractid }}</td>

                                        <td class="text-right">
                                            @if (!Empty($item->register_id))
                                            <a href="{{ url('recurit/register/section/edit/'.$item->register_id) }}" class="btn btn-info">รายละเอียด</a>
                                            @endif
                                                
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