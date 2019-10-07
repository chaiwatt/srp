@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการจัดสรร</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                รายการจัดสรร ปีงบประมาณ : {{ $project->year_budget }}
            </div>
        </div>
    </div>



    <div class="smart-widget widget-dark-blue">
        <div class="smart-widget-header"> รายการจัดสรร </div>
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
                            <th >รายการค่าใช้จ่าย</th>
                            <th class="text-center">งบประมาณจัดสรร</th>
                            <th class="text-center">โอนไปแล้ว</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalallocation_price =0;
                            $totaltransferallocation=0;
                        @endphp
                        @if( count($allocation) > 0 )
                        @foreach( $allocation as $key => $item )
                        @php
                            $totalallocation_price += $item->allocation_price ;
                            $totaltransferallocation += $item->transferallocation ;
                        @endphp
                            <tr>
                                <td>{{ $item->section_name }}</td>
                                <td>{{ $item->budget_name }}</td>
                                <td class="text-center">{{ number_format( $item->allocation_price , 2 ) }}</td>
                                <td class="text-center">{{ number_format( $item->transferallocation , 2 ) }}</td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-center" colspan="2" ><strong>สรุปรายการ</strong> </td>
                            <td class="text-center"><strong>{{ number_format($totalallocation_price,2)  }}</strong></td>                                        
                            <td class="text-center"><strong>{{  number_format($totaltransferallocation,2) }}</strong></td>                                        
                        </tr>
                    </tfoot>
                </table>
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