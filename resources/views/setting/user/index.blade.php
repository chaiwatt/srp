@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('dashboard') }}">หน้าแรก</a></li>
        <li><a href="{{ url('setting/user') }}">ผู้ใช้งานระบบ</a></li>
        <li>ผู้ใช้งานระบบ</li>    
    </ul>
   

    <div class="row padding-md">
        <div class="col-sm-6">
            <div class="page-title">
                ตั้งค่า ผู้ใช้งานระบบ 
            </div>
        </div>
        <div class="col-sm-6">
                <div class="pull-right">
                    <a href="{{ url('setting/user/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่ม ผู้ใช้งาน</a>
                </div>
        </div>
    </div>

    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> ผู้ใช้งานระบบ </div>
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
                            <th >ชื่อ</th>
                            <th style="width:100px">บัตรประชาชน</th>
                            <th >รหัสผู้ใช้</th>
                            <th >กลุ่มผู้ใช้</th>
                            <th style="width:150px">กรม</th>
                            <th style="width:180px">สำนักงาน</th>
                            <th class="text-center" style="width:80px">จำกัดสิทธิ์</th>
                            <th >สถานะ</th>
                            <th class="text-right" style="width:100px">เพิ่มเติม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( count($users) > 0 )
                        @foreach( $users as $key => $item )
                            <tr>
                                <td >{{ $item->name }}</td>
                                <td >{{ $item->userperson_id }}</td>
                                <td >{{ $item->username }}</td>
                                <td >{{ $item->usertype }}</td>
                                <td >{{ $item->departmentname }}</td>
                                <td >{{ $item->sectionname }}</td> 
                                @if ($item->timelimit == 0)
                                        <td class="text-center">-</td> 
                                    @elseif($item->timelimit == 1)
                                        <td class="text-danger text-center">จำกัด</td> 
                                @endif
                                <td >{{ $item->userstatus }}</td>
                                <td class="text-right">
                                    <a href="{{ url('setting/user/edit/'.$item->user_id) }}" class="btn btn-warning btn-xs"> แก้ไข</a>
                                    <a href="{{ url('setting/user/delete/'.$item->user_id) }}" class="btn btn-danger  btn-xs" onclick="return confirm('ยืนยันการลบผู้ใช้')" > ลบ</a>
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

@stop

@section('pageScript')
<script type="text/javascript">
    $(".table").dataTable();
</script>
@stop