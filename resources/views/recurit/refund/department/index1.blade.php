@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>คืนงบประมาณจัดจ้าง</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                คืนงบประมาณจัดจ้าง : ปีงบประมาณ {{ $project->year_budget }} 
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
                                    <th class="text-center">เงินตั้งต้น</th>
                                    <th class="text-center">โอนงบประมาณ</th>
                                    <th class="text-center">คืนงบประมาณหน่วยงานย่อย</th>
                                    <th class="text-center">งบประมาณจัดจ้าง</th>
                                    <th class="text-center">คืนงบประมาณจัดจ้าง</th>
                                    <th class="text-center">คงเหลือ</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">{{ number_format( $transfer , 2) }}</td>
                                    <td class="text-center">{{ number_format( $transferdepartment , 2) }}</td>
                                    <td class="text-center">{{ number_format( $refundsection , 2) }}</td>
                                    <td class="text-center">{{ number_format( $payment , 2) }}</td>
                                    <td class="text-center">{{ number_format( $refund , 2) }}</td>
                                    <td class="text-center">{{ number_format( $sum , 2 ) }}</td>
                                    <td class="text-center">
                                        @if( $sum > 0 )
                                            <a href="{{ url('recurit/refund/department/confirm') }}" class="btn btn-info" onclick="return confirm('ยืนยันการคืนงบประมาณ')">คืนงบประมาณ</a>
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
    $(".table").dataTable();
</script>
@stop