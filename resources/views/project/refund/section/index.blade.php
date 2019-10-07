@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานคืนเงินค่าใช้จ่าย</li>    
    </ul>

    <div class="row">
        <div class="col-sm-7">
            <div class="page-title">
                รายงานคืนเงินค่าใช้จ่าย ปีงบประมาณ : {{ $project->year_budget }}
            </div>
        </div>
    </div>

    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> รายงานคืนเงินค่าใช้จ่าย </div>
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
                            <th >ค่าใช้จ่าย</th>
                            <th class="text-center">คืนงบประมาณ</th>
                            <th class="text-center">วันที่คืน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalrefund_price=0;
                        @endphp
                        @if( count($refund) > 0 )
                        @foreach( $refund as $key => $item )
                            @php
                                $totalrefund_price += $item->refund_price;
                            @endphp
                            <tr>
                                <td >{{ $item->budgetname }}</td>
                                <td class="text-center">{{ number_format( $item->refund_price , 2 ) }}</td>
                                <td class="text-center">{{ $item->thaidate }}</td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right"  ><strong>สรุปรายการ</strong> </td>
                            <td class="text-center"><strong>{{ number_format($totalrefund_price ,2)  }}</strong></td>                                       
                            
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

@section('pageScript')
    @if( count($refund) > 10 )
        <script type="text/javascript">
            $(".table").dataTable({
                "language": {
                "search": "ค้นหา "
                }
            });
        </script>
    @endif
@stop