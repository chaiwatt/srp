@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานผลการจัดทำการประชาสัมพันธ์</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายงานผลการจัดทำการประชาสัมพันธ์ ( {{ $department->department_name }} ) : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('information/expense/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> เพิ่มรายละเอียดค่าใช้จ่าย</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
               
                <div class="smart-widget-header"> รายการค่าใช้จ่ายการจัดทำประชาสัมพันธ์  </div>
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
                                    <th>ที่</th>
                                    <th>ประเภทสื่อ</th>
                                    <th class="text-center">จำนวนที่จัดทำ</th>
                                    <th class="text-center">จำนวนที่ใช้เงิน</th>
                                    <th>ผู้รับจ้าง</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalexpense =0;
                                @endphp
                                @if( count($expense) > 0 )
                                @foreach( $expense as $key => $item )
                                @php
                                    $totalexpense += $item->expense_price;
                                @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->expense_type }}</td>
                                        <td class="text-center">{{ $item->expense_amount }}</td>
                                        <td class="text-center">{{ number_format($item->expense_price,2) }}</td>
                                        <td>{{ $item->expense_outsource }}</td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="3"><strong>สรุปรายการ</strong> </td>
                                    <td class="text-center"><strong>{{ number_format( ($totalexpense) , 2)  }}</strong> </td>
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
@if (count($expense) > 10)
    <script type="text/javascript">
        $(".table").dataTable({
            "language": {
            "search": "ค้นหา "
            }
        });
    </script>
@endif
@stop