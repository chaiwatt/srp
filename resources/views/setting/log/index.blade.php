@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('dashboard') }}">หน้าแรก</a></li>
        <li>ข้อมูลการใช้งานระบบ (Log)</li>    
    </ul>
   

    <div class="row padding-md">
        <div class="col-sm-6">
            <div class="page-title">
                ข้อมูลการใช้งานระบบ (Log)
            </div>
        </div>
    </div>

    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> ข้อมูลการใช้งานระบบ </div>
        <div class="smart-widget-body">
            <div class="smart-widget-body  padding-md">
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width:140px" >วันที่</th>
                            <th >ผู้ใช้</th>
                            <th >ยูสเซอร์</th>
                            <th >กลุ่มผู้ใช้</th>
                            <th >กรมสังกัด</th>
                            <th >หน่วยงานย่อย</th>
                            <th >รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $logs as $item )
                            <tr>
                                <td >{{ $item->logdate }}</td>
                                <td >{{ $item->name }}</td>
                                <td >{{ $item->username }}</td>
                                <td >{{ $item->usertype }}</td>
                                <td >{{ $item->departmentname }}</td>
                                <td >{{ $item->sectionname }}</td>
                                <td >{{ $item->log }}</td> 
                            </tr>
                        @endforeach

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