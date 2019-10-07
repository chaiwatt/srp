@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>การเบิกจ่ายเงินเดือน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                การเบิกจ่ายเงินเดือน : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row padding-md">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> การเบิกจ่ายเงินเดือน </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">กรม</th>
                                    <th class="text-center">เดือน</th>
                                    <th class="text-center">รายการ</th>
                                    <th class="text-center">หักขาดงาน</th>
                                    <th class="text-center">หักค่าปรับ</th>
                                    <th class="text-center">จ่ายจริง</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count( $payment ) > 0 )
                                @php( $absence = 0 )
                                @php( $fine = 0 )
                                @php( $salary = 0 )
                                @foreach( $payment as $item )
                                    <tr>
                                        <td>{{ $item->departmentname }}</td>
                                        <td class="text-center">{{ str_pad( ($item->payment_month) , 2 ,"0",STR_PAD_LEFT) }}</td>
                                        <td>{{ $item->budgetname }}</td>
                                        <td class="text-right">{{ number_format( $item->paymentdepartmentabsence , 2) }}</td>
                                        <td class="text-right">{{ number_format( $item->paymentdepartmentfine , 2) }}</td>
                                        <td class="text-right">{{ number_format( $item->paymentdepartmentsalary , 2) }}</td>
                                        <td class="text-right">
                                            <a href="{{ url('recurit/report/payment/department/'.$item->department_id.'?month='.$item->payment_month) }}" class="btn btn-info">เพิ่มเติม</a>
                                        </td>
                                    </tr>
                                    @php( $absence += $item->paymentdepartmentabsence )
                                    @php( $fine += $item->paymentdepartmentfine )
                                    @php( $salary += $item->paymentdepartmentsalary )
                                @endforeach
                                @endif
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="3"><strong>สรุปรายการ</strong> </td>
                                    <td class="text-right"><strong>{{ number_format( $absence , 2 ) }}</strong> </td>
                                    <td class="text-right"><strong>{{ number_format( $fine , 2 ) }}</strong></td>
                                    <td class="text-right"><strong>{{ number_format( $salary , 2 ) }}</strong></td>
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