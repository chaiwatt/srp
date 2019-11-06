@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>ตั้งค่า ผู้สมัครไม่ Active</li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ตั้งค่า ผู้สมัครไม่ Active
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> รายการ ผู้สมัครไม่ Active </div>
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
                                <th>ชื่อ-สกุล</th>
                                <th>หมายเลขบัรประชาชน</th>
                                <th>กรม</th>
                                <th>สำนักงาน</th>
                                <th>เพิ่มเติม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $registers as $register )
                                <tr>
                                    <td>{{ $register->prefixname }}{{ $register->name }} {{ $register->lastname }}</td>
                                    <td>{{ $register->person_id }}</td>
                                    <td>{{ $register->departmentname }}</td>
                                    <td>{{ $register->sectionname }}</td>
                                    <td>                                        
                                        <a href="{{ url('setting/inactiveregister/delete/'.$register->register_id) }}" class="btn btn-xs btn-danger" onclick="return confirm('ยืนยันการลบผู้สมัคร')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                                </tr>
                            @endforeach
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