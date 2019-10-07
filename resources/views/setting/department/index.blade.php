@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>ตั้งค่า รายการหน่วยงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ตั้งค่า รายการหน่วยงาน
            </div>
        </div>
        {{-- <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('setting/department/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่ม หน่วยงาน</a>
            </div>
        </div> --}}
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> รายการหน่วยงาน </div>
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
                                <th width="200">การดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( count($department) > 0 )
                            @foreach( $department as $key => $item )
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->department_name }}</td>
                                    <td>
                                        <a href="{{ url('setting/department/edit/'.$item->department_id) }}" class="btn btn-warning"><i class="fa fa-pencil"></i> แก้ไข</a>
                                        <a href="{{ url('setting/department/delete/'.$item->department_id) }}" class="btn btn-danger" onclick="return confirm('ยืนยันการลบค่าใช้จ่าย')" ><i class="fa fa-ban"></i> ลบ</a>
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
@stop

@section('pageScript')
<script type="text/javascript">
    
</script>
@stop