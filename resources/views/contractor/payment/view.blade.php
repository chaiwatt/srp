@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/payment/section') }}">การเบิกจ่ายเงินเดือน</a></li>
        <li>รายการเบิกจ่าย</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการเบิกจ่าย
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
                                    <th class="text-center">รหัสตำแหน่ง</th>
                                    <th class="text-center">เดือน</th>
                                    <th class="text-center">วันที่จ่าย</th>
                                    <th class="text-center">คำขึ้นต้น</th>
                                    <th class="text-center">ชื่อ</th>
                                    <th class="text-center">นามสกุล</th>
                                    <th class="text-center">เลขที่บัตรประชาชน</th>
                                    <th class="text-center">หักขาดเงิน</th>
                                    <th class="text-center">หักค่าปรับ</th>
                                    <th class="text-center">ค่าจ้างที่ได้รับ</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if( count($payment) > 0 )
                                @foreach( $payment as $key => $item )
                                    <tr>
                                        <td class="text-center">{{ $item->generate_code }}</td>
                                        <td class="text-center">{{ str_pad( ($item->payment_month) , 2 ,"0",STR_PAD_LEFT)  }}</td>
                                        <td class="text-center">{{ $item->paymentdateth }}</td>
                                        <td>{{ $item->contractorprefixname }}</td>
                                        <td>{{ $item->contractorname }}</td>
                                        <td>{{ $item->contractorlastname }}</td>
                                        <td class="text-center">{{ $item->contractorpersonid }}</td>
                                        <td class="text-right">{{ number_format($item->payment_absence , 2) }}</td>
                                        <td class="text-right">{{ number_format($item->payment_fine , 2) }}</td>
                                        <td class="text-right">{{ number_format($item->payment_salary , 2) }}</td>
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
    $(".table").dataTable();
</script>
@stop