@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>คืนงบประมาณประชาสัมพันธ์</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                คืนงบประมาณประชาสัมพันธ์ : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการ </div>
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
                                    <th class="text-center">งบประมาณตั้งต้น</th>
                                    <th class="text-center">งบประมาณประชาสัมพันธ์</th>
                                    <th class="text-center">คืนงบประมาณประชาสัมพันธ์</th>
                                    <th class="text-center">งบประมาณคงเหลือ</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">{{ number_format( $transfer , 2) }}</td>
                                    <td class="text-center">{{ number_format( $expense , 2) }}</td>
                                    <td class="text-center">{{ number_format( $refund , 2) }}</td>
                                    <td class="text-center">{{ number_format( $sum , 2 ) }}</td>
                                    <td class="text-center">
                                        @if( $sum > 0 )
                                            <a href="{{ url('information/refund/confirm') }}" class="btn btn-info" onclick="return confirm('ยืนยันการคืนงบประมาณ')">คืนงบประมาณ</a>
                                        @endif
                                    </td>
                                </tr>
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
        $(".table").dataTable({
            "language": {
            "search": "ค้นหา "
            }
        });
    </script>
@stop