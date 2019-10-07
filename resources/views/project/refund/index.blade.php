@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการคืนเงินค่าใช้จ่าย</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการคืนเงินค่าใช้จ่าย : ปีงบประมาณ {{ $project->year_budget }} 
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
                                    <th class="text-center">หน่วยงานย่อย</th>
                                    <th class="text-center">เงินตั้งต้น</th>
                                    <th class="text-center">โอนงบประมาณ</th>
                                    <th class="text-center">เบิกจ่ายจริง</th>
                                    <th class="text-center">คืนงบประมาณจัดจ้าง</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count( $refund ) > 0 )
                                @foreach( $refund as $item )
                                <tr>
                                    <th class="text-center">{{ $item->departmentname }}</th>
                                    @php( $value = $allocation->where('department_id' , $item->department_id)->sum('department_allocation') )
                                    <td class="text-center">{{ number_format( $value , 2) }}</td>
                                    @php( $value = $transfer->where('department_id' , $item->department_id)->sum('transfer_price') )
                                    <td class="text-center">{{ number_format( $value , 2) }}</td>
                                    @if( $item->budget_id == 1 )
                                    @php( $value = $payment->where('department_id' , $item->department_id)->sum('payment_salary') )
                                    @elseif( $value = $expense->where('department_id' , $item->department_id)->sum('expense_price') )
                                    @endif
                                    <td class="text-center">{{ number_format( $value , 2) }}</td>
                                    @php( $value = $refund->where('department_id' , $item->department_id)->sum('refund_price') )
                                    <td class="text-center">{{ number_format( $value , 2) }}</td>
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