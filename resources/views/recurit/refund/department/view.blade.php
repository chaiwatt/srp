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
                                    <th >หน่วยงานย่อย</th>
                                    <th class="text-center">เงินตั้งต้น</th>
                                    <th class="text-center">โอนงบประมาณ</th>
                                    <th class="text-center">เบิกจ่ายจริง</th>
                                    <th class="text-center">คืนงบประมาณจัดจ้าง</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalallocation = 0;
                                    $totaltransfer =0;
                                    $totalpayment =0;
                                    $totalrefund = 0;
                                @endphp
                                @if( count( $section ) > 0 )
                                @foreach( $section as $item )
                                <tr>
                                    <th class="text-center">{{ $item->sectionname }}</th>
                                    
                                    @php
                                        $value = $allocation->where('section_id' , $item->section_id)->sum('allocation_price') ;
                                        $totalallocation += $value;
                                    @endphp
                                    <td class="text-center">{{ number_format( $value , 2) }}</td>

                                    @php
                                        $value = $transfer->where('section_id' , $item->section_id)->sum('transfer_price'); 
                                        $totaltransfer += $value;
                                    @endphp
                                    <td class="text-center">{{ number_format( $value , 2) }}</td>
                                    @php
                                        $value = $payment->where('section_id' , $item->section_id)->sum('payment_salary') ;
                                        $totalpayment += $value;
                                    @endphp
                                    
                                    <td class="text-center">{{ number_format( $value , 2) }}</td>

                                    @php
                                        $value = $refund->where('section_id' , $item->section_id)->sum('refund_price') ;
                                        $totalrefund += $value;
                                    @endphp
                                    <td class="text-center">{{ number_format( $value , 2) }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('recurit/refund/department/view/confirm/'.$item->section_id ) }}" class="btn btn-info" onclick="return confirm('ยืนยันงบประมาณคืน')">ยืนยันงบประมาณคืน</a>
                                    </td>
                                </tr>
                                @php
                                    
                                @endphp
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" ><strong>สรุปรายการ</strong> </td>
                                    <td class="text-center"><strong>{{ number_format( $totalallocation , 2 ) }}</strong> </td>
                                    <td class="text-center"><strong>{{ number_format( $totaltransfer , 2 ) }}</strong> </td>
                                    <td class="text-center"><strong>{{ number_format( $totalpayment , 2 ) }}</strong> </td>
                                    <td class="text-center"><strong>{{ number_format( $totalrefund , 2 ) }}</strong> </td>
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