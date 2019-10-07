@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการ ผู้สมัครจ้างเหมาบุคลากรช่วยปฏิบัติงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการ ผู้สมัครจ้างเหมาบุคลากรช่วยปฏิบัติงาน
            </div>
        </div>
        <div class="col-sm-6">
        	<div class="pull-right">
				<a href="{{ url('contractor/register/create') }}" class="btn btn-info">เพิ่ม ผู้สมัครจ้างเหมา</a>
			</div>
        </div>	
    </div>

    <div class="row">
	    <div class="col-md-12">
	        <div class="smart-widget widget-dark-blue">
	            <div class="smart-widget-header"> 
	            	รายการ ผู้สมัครจ้างเหมาบุคลากรช่วยปฏิบัติงาน 
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
	                               
	                                <th >รหัสบัตรประชาชน</th>
	                                <th >คำนำหน้าชื่อ</th>
	                                <th >ชื่อ</th>
	                                <th >นามสกุล</th>
	                                <th >ตำแหน่ง</th>
                                    <th class="text-center">สถานะ</th>
	                                <th class="text-center" >เพิ่มเติม</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            @if( count($contractor) > 0 )
	                            @foreach( $contractor as $key => $item )
	                                <tr>
	                                    
	                                    <td>{{ $item->person_id }}</td>
	                                    <td>{{ $item->prefixname }}</td>
	                                    <td >{{ $item->name }}</td>
	                                    <td >{{ $item->lastname }}</td>
	                                    <td>{{ $item->positionname }}</td>
                                        <td class="text-center">{{ $item->contractortypename }}</td>
	                                    <td class="text-right">
	                                    	<a href="{{ url('contractor/register/edit/'.$item->contractor_id) }}" class="btn btn-info">เพิ่มเติม</a>
	                                    	<a href="{{ url('contractor/register/delete/'.$item->contractor_id) }}" class="btn btn-danger" onclick="return confirm('ยืนยันการลบ')">ลบ</a>
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
    // $(".table").dataTable();
</script>
@stop