@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>ตั้งค่า รายการสำนักงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ตั้งค่า รายการสำนักงาน
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('setting/section/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่ม สำนักงานใหม่</a>
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

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการสำนักงาน </div>
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
                                    <th>กรมสังกัด</th>
                                    <th>รหัสสำนักงาน</th>
                                    <th>ชื่อสำนักงาน</th>
                                    <th width="200">การดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($section) > 0 )
                                @foreach( $section as $key => $item )
                                    <tr>
                                        <td>{{ $key + $section->firstItem() }}</td>
                                        <td>{{ $item->departmentname }}</td>
                                        <td>{{ $item->section_code }}</td>
                                        <td>{{ $item->section_name }}</td>
                                        <td>
                                            <a href="{{ url('setting/section/edit/'.$item->section_id) }}" class="btn btn-warning"><i class="fa fa-pencil"></i> แก้ไข</a>
                                            <a href="{{ url('setting/section/delete/'.$item->section_id) }}" class="btn btn-danger" onclick="return confirm('ยืนยันลบหน่วยงานย่อย')" ><i class="fa fa-ban"></i> ลบ</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div>
                            <ul class="pagination pagination-sm pull-right">
                                 {!! $section->appends([ 'department' => $department ])->render() !!}
                            </ul>
                        </div>
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
            }
        })
    })
</script>
@stop