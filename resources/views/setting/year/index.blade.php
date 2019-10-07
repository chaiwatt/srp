@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>ตั้งค่าปีงบประมาณ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ตั้งค่าปีงบประมาณ
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('setting/year/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มปีงบประมาณ</a>
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> รายการปีงบประมาณ </div>
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
                                <th width="50">#</th>
                                <th>ปีงบประมาณ</th>
                                <th width="120">เลือกปีงบประมาณ</th>
                                <th width="150" class="text-right">เพิ่มเติม</th>
                                {{-- <th width="100">งบประมาณ</th>
                                <th width="100">หน่วยงาน</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if( count($settingyear) > 0 )
                            @foreach( $settingyear as $key => $item )
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->setting_year }}</td>
                                    <td class="text-center">
                                    	<div class="form-group">
											<div class="custom-checkbox">
												<input type="checkbox" class="select_year" data-pk="{{ $item->setting_year_id }}" id="{{ $item->setting_year_id }}" {{ $item->setting_status==1?'checked':'' }} >
												<label for="{{ $item->setting_year_id }}"></label>
											</div>
										</div>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ url('setting/year/delete/'.$item->setting_year_id) }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันลบปีงบประมาณ')"> ลบปีงบประมาณ</a>
                                        {{-- <a href="{{ url('contractor/refund/confirm/'.$item->generate_id ) }}" class="btn btn-info" onclick="return confirm('ยืนยันการคืนงบประมาณ')">คืนงบประมาณ</a> --}}
                                    </td>
                                    {{-- <td>
                                        <a href="{{ url('setting/year/budget/'.$item->setting_year_id) }}" class="btn btn-default"><i class="fa fa-pencil"></i> แก้ไข</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('setting/year/department/'.$item->setting_year_id) }}" class="btn btn-default"><i class="fa fa-pencil"></i> แก้ไข</a>
                                    </td> --}}
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
                        

@stop

@section('pageScript')
<script type="text/javascript">
    $(".select_year").change(function(){
    	value = $(this).prop("checked");
    	if( value ){
    		$.ajax({
    			type:"post",
    			url:"{{ url('setting/year/selectyear') }}",
    			data:{
    				id : $(this).attr('data-pk'),
    			},
    			success:function(response){
    				window.location.reload();
    			}
    		})
    	}
    	else{
    		alert("กรุณาเลือกปีงบประมาณ");
    		$(this).prop('checked' , true);
    	}
    })
</script>
@stop