@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>ตั้งค่า รายการตำแหน่งงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ตั้งค่า รายการตำแหน่งงาน
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('setting/position/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่ม ตำแหน่งงาน</a>
            </div>
        </div>
    </div>

    <div class="row padding-md">
        {!! Form::open([ 'method' => 'get' ]) !!}
            <div class="form-group">
                <label class="control-label padding-10">กรมสังกัด </label>
                <select class="form-control" name="department" id="department"></select>
            </div>
            <div class="form-group">
                <div class="pull-right">
                    <button class="btn btn-primary">ค้นหา</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

    <div class="row ">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการตำแหน่งงาน </div>
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
                                    <th>#</th>
                                    <th>หน่วยงาน</th>
                                    <th>ตำแหน่งงาน</th>
                                    <th>เงินเดือน</th>
                                    <th width="200">การดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($position) > 0 )
                                @foreach( $position as $key => $item )
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->departmentname }}</td>
                                        <td>{{ $item->position_name }}</td>
                                        <td>{{ number_format( $item->position_salary , 2 ) }}</td>
                                        <td>
                                            <a href="{{ url('setting/position/edit/'.$item->position_id) }}" class="btn btn-warning"><i class="fa fa-pencil"></i> แก้ไข</a>
                                            <a href="{{ url('setting/position/delete/'.$item->position_id) }}" class="btn btn-danger" onclick="return confirm('ยืนยันการลบตำแหน่งงาน')" ><i class="fa fa-ban"></i> ลบ</a>
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
    $(function(){
        $.ajax({
            type:"get",
            url:"{{ url('api/department') }}",
            dataType:"Json",
            data:{
                department : "{{ $department }}",
            },
            success : function(data){
                var html = "<option value=''>เลือก กรมสังกัด</option>";
                if(data.row > 0){
                    for(var i=0;i<data.row;i++){
                        if( data.department[i].department_id == data.filter_department ){
                            html += "<option value='"+ data.department[i].department_id +"' selected>" + data.department[i].department_name +"</option>"
                        }
                        else{
                            html += "<option value='"+ data.department[i].department_id +"' > " + data.department[i].department_name +"</option>"
                        }
                    }
                }

                $("#department").html(html);
                // $("#department").select2();
            }
        })
    })
</script>
@stop