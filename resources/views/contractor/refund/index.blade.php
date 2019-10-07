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
                คืนงบประมาณจ้างเหมา : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการคืนงบประมาณ </div>
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
                                    <th class="text-center">ตำแหน่ง</th>
                                    <th class="text-center">จำนวนเงินคงเหลือ</th>
                                    <th class="text-center">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalremain =0;
                                @endphp
                                @if(count($generate) > 0)
                                @foreach( $generate as $item )
                                @php
                                    $totalremain +=$item->paymentbalance;
                                @endphp
                                <tr>
                                    <td >{{ $item->generate_code }}</td>
                                    <td class="text-center">{{ $item->contractorpositionname }}</td>
                                    <td class="text-center">{{ number_format( $item->paymentbalance , 2 )  }}</td>
                                    <td class="text-center">
                                        {{-- <a href="{{ url('contractor/refund/confirm/'.$item->generate_id ) }}" class="btn btn-info" onclick="return confirm('ยืนยันการคืนงบประมาณ')">คืนงบประมาณ</a> --}}
                                        @if ($item->paymentbalance > 0)
                                        <div class="btn-group marginTB-xs">
                                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                                    คืนเงินงบประมาณ <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu" role="menu">
                                                    <li><a href="{{ url('contractor/refund/confirm/'.$item->generate_id ) }}" onclick="return confirm('ยืนยันการคืนงบประมาณ')">คืนงบประมาณ</a></li>
                                                    <li><a href="{{ url('contractor/refund/confirmanual/'.$item->generate_id ) }}" onclick="return confirm('คืนเงินงบประมาณประจำปี')">คืนเงินงบประมาณประจำปี</a></li>
                                                  </ul>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>
                                    <td class="text-center"><strong>{{ number_format( $totalremain , 2 ) }}</strong> </td>                                
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
{{-- <script type="text/javascript">
    $(".table").dataTable();
</script> --}}
@stop