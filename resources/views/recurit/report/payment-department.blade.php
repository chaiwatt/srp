@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/report/payment') }}">การเบิกจ่ายเงินเดือน</a></li>
        <li>หน่วยงานการเบิกจ่ายเงินเดือน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                หน่วยงานการเบิกจ่ายเงินเดือน : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row padding-md">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> หน่วยงานการเบิกจ่ายเงินเดือน </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">หน่วยงาน</th>
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
                                        <td>{{ $item->sectionname }}</td>
                                        <td class="text-center">{{ str_pad( ($item->payment_month) , 2 ,"0",STR_PAD_LEFT) }}</td>
                                        <td>{{ $item->budgetname }}</td>
                                        <td class="text-right">{{ number_format( $item->paymentsectionabsence , 2) }}</td>
                                        <td class="text-right">{{ number_format( $item->paymentsectionfine , 2) }}</td>
                                        <td class="text-right">{{ number_format( $item->paymentsectionsalary , 2) }}</td>
                                        <td class="text-right">
                                            <a href="{{ url('recurit/report/payment/section/'.$item->section_id.'?month='.$item->payment_month) }}" class="btn btn-info">เพิ่มเติม</a>
                                        </td>
                                    </tr>
                                    @php( $absence += $item->paymentsectionabsence )
                                    @php( $fine += $item->paymentsectionfine )
                                    @php( $salary += $item->paymentsectionsalary )
                                @endforeach
                                @endif
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="3">รวม</td>
                                    <td class="text-right">{{ number_format( $absence , 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $fine , 2 ) }}</td>
                                    <td class="text-right">{{ number_format( $salary , 2 ) }}</td>
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