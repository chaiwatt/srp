@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('setting') }}">ตั้งค่า</a></li>
        <li>สำรองฐานข้อมูล</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                สำรองฐานข้อมูล (อัตโนมัติทุกวัน เวลา 23:00 น.)
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('setting/backup/backup') }}" class="btn btn-success"> สำรองฐานข้อมูล</a>
                <a href="{{ url('setting/backup/edit') }}" class="btn btn-info"> ข้อมูล DrobBox</a>
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header">  รายการ สำรองฐานข้อมูล </div>
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
                            <th>วันที่สำรอง</th>
                            <th class="text-center">โดย</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @if( $backup->count() > 0 )
                        @foreach( $backup as $key => $item )
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->backupdate }}</td>
                                <td class="text-center">{{ $item->backupby }}</td>
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
    $(".table").dataTable({
        "language": {
        "search": "ค้นหา "
        }
    });
</script>
@stop