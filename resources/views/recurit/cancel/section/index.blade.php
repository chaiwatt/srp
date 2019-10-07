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
                <a href="{{ url('recurit/cancel/section/create') }}" class="btn btn-info">บันทึกยกเลิก</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการยกเลิกจ้างงาน </div>
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
                                    <th >รหัสตำแหน่ง</th>
                                    <th >ชื่อ นามสกุล</th>
                                    <th >ตำแหน่งที่สมัคร</th>
                                    <th >วันที่ยกเลิก</th>
                                    <th >เหตุผล</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($resign) > 0 )
                                @foreach( $resign as $key => $item )
                                    <tr>
                                        <td >{{ $item->generate_code }}</td>
                                        <td>{{ $item->registerprefixname }}{{ $item->registername }} {{ $item->registerlastname }}</td>
                                        <td>{{ $item->positionname }}</td>
                                        <td >{{ $item->resigndateth }}</td>
                                        <td>{{ $item->reasonname }}</td>
                                        <td class="text-center">
                                            <a href="{{ url('recurit/cancel/section/delete/'.$item->resign_id) }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบข้อมูล')"><i class="fa fa-remove"></i> ลบ</a>
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
{{-- <script type="text/javascript">
    $(function(){
        $(".table").dataTable();
    })
</script> --}}
@stop