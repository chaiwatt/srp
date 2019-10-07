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
                            <th >ค่าใช้จ่าย</th>
                            <th class="text-center">งบประมาณจัดสรร</th>
                            <th class="text-center">รับโอนแล้ว</th>
                            <th class="text-center">จำนวนครั้งที่รับโอน</th>
                            <th class="text-right">เพิ่มเติม</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalallocation = 0;
                            $totaltransfer =0 ;
                            $totalnumoftransfer =0;
                        @endphp
                        @if( count($allocation) > 0 )
                        @foreach( $allocation as $key => $item )
                        @php
                            $totalallocation += $item->allocation_price ;
                            $totaltransfer += $item->transferallocation  ;
                            $totalnumoftransfer += $item->transfercount ;
                        @endphp
                            <tr>
                                <td>{{ $item->budgetname }}</td>
                                <td class="text-center">{{ number_format( $item->allocation_price , 2 ) }}</td>
                                <td class="text-center">{{ number_format( $item->transferallocation , 2 ) }}</td>
                                <td class="text-center">{{ $item->transfercount  }}</td>
                                <td class="text-right">
                                    <a href="{{ url('project/allocation/section/view/'.$item->allocation_id) }}" class="btn btn-info"><i class="fa fa-eye"></i> เพิ่มเติม</a>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right" ><strong>สรุปรายการ</strong> </td>
                            <td class="text-center"><strong>{{ number_format( ($totalallocation) , 2)  }}</strong> </td>
                            <td class="text-center"><strong>{{ number_format( ($totaltransfer) , 2)  }}</strong> </td>
                            <td class="text-center"><strong>{{ $totalnumoftransfer }}</strong> </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

@section('pageScript')
@if( count($allocation) > 0 )
    <script type="text/javascript">
        // $(document).ready(function() {
        //     $('.table').DataTable( {
        //         dom: 'Bfrtip',
        //         buttons: [
        //             {
        //                 extend: 'copyHtml5',
        //                 exportOptions: {
        //                     columns: [ 0, 1, 2, 3 ],
                            
        //                 }
        //             },
        //             {
        //                 extend: 'excelHtml5',
        //                 exportOptions: {
        //                     columns: [ 0, 1, 2, 3]
        //                 }
        //             },

        //         ],
        //             "language": {
        //             "search": "ค้นหา "
        //             },
        //     } );
        // } );
    </script>
@endif
@stop