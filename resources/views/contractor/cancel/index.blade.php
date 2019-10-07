@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>ยกเลิก</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ยกเลิก : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('contractor/cancel/create') }}" class="btn btn-info">บันทึกยกเลิก</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการอัตราจ้าง </div>
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
                                    <th class="text-center">รหัสตำแหน่ง</th>
                                    <th class="text-center">คำนำหน้า</th>
                                    <th class="text-center">ชื่อ</th>
                                    <th class="text-center">นามสกุล</th>
                                    <th class="text-center">ตำแหน่งที่สมัคร</th>
                                    <th class="text-center">วันที่ยกเลิก</th>
                                    <th class="text-center">เหตุผล</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($resign) > 0 )
                                @foreach( $resign as $key => $item )
                                    <tr>
                                        <td class="text-center">{{ $item->generate_code }}</td>
                                        <td>{{ $item->contractorprefixname }}</td>
                                        <td>{{ $item->contractorname }}</td>
                                        <td>{{ $item->contractorlastname }}</td>
                                        <td>{{ $item->contractorpositionname }}</td>
                                        <td class="text-center">{{ $item->resigndateth }}</td>
                                        <td>{{ $item->reasonname }}</td>
                                        <td class="text-center">
                                            <a href="{{ url('contractor/cancel/delete/'.$item->resign_id) }}" class="btn btn-danger" onclick="return confirm('ยืนยันการลบข้อมูล')"><i class="fa fa-remove"></i> ลบ</a>
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
        $(".table").dataTable();
    })
</script>
@stop