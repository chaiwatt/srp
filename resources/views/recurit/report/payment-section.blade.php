@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/report/payment/department/'.$department.'?month='.$month ) }}">รายละเอียดการเบิกจ่ายเงินเดือน</a></li>
        <li>รายละเอียดการเบิกจ่ายเงินเดือน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายละเอียดการเบิกจ่ายเงินเดือน : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row padding-md">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายละเอียดการเบิกจ่ายเงินเดือน </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
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
                                        <td>{{ $item->registerprefixname }}</td>
                                        <td>{{ $item->registername }}</td>
                                        <td>{{ $item->registerlastname }}</td>
                                        <td class="text-center">{{ $item->registerpersonid }}</td>
                                        <td class="text-right">{{ number_format($item->payment_absence , 2) }}</td>
                                        <td class="text-right">{{ number_format($item->payment_fine , 2) }}</td>
                                        <td class="text-right">{{ number_format($item->payment_salary , 2) }}</td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="7">รวม</td>
                                    <td class="text-right">{{ number_format( $payment->sum('payment_absence') , 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $payment->sum('payment_fine') , 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $payment->sum('payment_salary') , 2 ) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
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