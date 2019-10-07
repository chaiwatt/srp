@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>ตั้งค่าทั่วไป</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ตั้งค่าทั่วไป
            </div>
        </div>

    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> รายการตั้งค่าทั่วไป </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>รายการ</th>
                                <th class="text-right">เปิดใช้งาน</th>
                            </tr>
                        </thead>
                        <tbody>

                                <tr>
                                    <td>การสมัครจ้างเหมาออนไลน์</td>
                                    <td class="text-right">
                                    	<div class="form-group">
                                            
                                            <div class="custom-checkbox">
                                                {{-- <input type="checkbox" class="select_year"  id="onlinereg" {{ $item->setting_status==1?'checked':'' }} > --}}
                                                <input type="checkbox" class="select_year"  id="onlinereg" @if ($generalsetting->enable_onlinereg == 1) checked @endif>
												<label for="onlinereg"></label>
											</div>
										</div>
                                    </td>
                                </tr>

        
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
        var data =0 ;
        // alert(value);
        if(value == true){
            data =1;
        }
    	// if( value ){
    		$.ajax({
    			type:"get",
    			url:"{{ url('setting/generalsetting/onlinereg') }}",
    			data:{
    				data : data,
    			},
    			success:function(response){
                    //  console.log(response);
    				window.location.reload();
    			}
    		})
    	// }else{
    	// 	alert("กรุณาเลือกปีงบประมาณ");
    	// 	$(this).prop('checked' , true);
    	// }
    })
</script>
@stop