@extends('layout.mains')

@section('pageCss')

@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการ ผู้สมัครร่วมโครงการ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการ ผู้สมัครร่วมโครงการ
            </div>
        </div>
        <div class="col-sm-6">
        	<div class="pull-right">
				<a href="{{ url('recurit/register/department/excel') }}" class="btn btn-info">ส่งออก Excel</a>
			</div>
        </div>	
    </div>

    <div class="row">
	    <div class="col-md-12">
	        <div class="smart-widget widget-dark-blue">
	            <div class="smart-widget-header"> 
	            	รายการ ผู้สมัครร่วมโครงการ 
	            </div>
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

	                    <div class="pull-right">
	                    {!! Form::open([ 'method' => 'get' , 'id' => 'myform' ]) !!}
						<div class="form-group">
							<div class="input-group">
								<select class="form-control" name="filter">
									<option value="" {{ $filter==""?'selected':'' }}>ปีงบประมาณปัจจุบัน</option>
									<option value="1 {{ $filter==1?'selected':'' }}">ทั้งหมด</option>
								</select>
								<div class="input-group-btn">
									<button class="btn btn-success no-shadow btn-sm" tabindex="-1">ค้นหา</button>
								</div>
							</div>
						</div>
	            		{!! Form::close() !!}
	            		</div>
	                    
	                    <table class="table table-striped">
	                        <thead>
	                            <tr>
	                                {{-- <th class="text-center">ลำดับ</th> --}}
									{{-- <th class="text-center">บัตรประชาชน</th> --}}
									<th hidden>#</th>
									<th >ชื่อ นามสกุล</th>
									<th >หน่วยงาน</th>
									
									<th >ตำแหน่ง</th>
									
									<th >สถานะ</th>
									<th >ระยะเวลาจ้างงาน</th>
	                                <th class="text-center">เพิ่มเติม</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            @if( count($register) > 0 )
								@foreach( $register as $key => $item )
								@php
									$check = $employ->where('register_id',$item->register_id)->first();
								@endphp
	                                <tr>
											<td hidden>{{ $item->section_id }}</td>
	                                    {{-- <td class="text-center">{{ $key + 1 }}</td> --}}
	                                    {{-- <td class="text-center"> {{ $item->person_id }}</td> --}}
										<td >{{ $item->prefixname }}{{ $item->name }} {{ $item->lastname }}</td>
										<td>{{ $item->sectionname }}</td>
										
										<td>{{ $item->positionname }}</td>
										@if (!empty($check))
											<td >{{ $item->registertypename }} <span class="text-success">(จ้างงาน)</span> </td>
											@else
											<td >{{ $item->registertypename }}</td>
										@endif
										<td>{{ $item->starthiredateinput }} - {{ $item->endhiredateinput }}</td>
	                                    <td class="text-right">
	                                    	<a href="{{ url('recurit/register/department/view/'.$item->register_id) }}" class="btn btn-info btn-xs">เพิ่มเติม</a>
	                                    	{{-- <a href="{{ url('recurit/register/section/delete/'.$item->register_id) }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ')">ลบ</a> --}}
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
		"search": "ค้นหา ",
	
		}
	});
</script>
@stop