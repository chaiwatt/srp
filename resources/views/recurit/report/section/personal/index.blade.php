@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานเบิกจ่ายเงินเดือนรายบุคคล</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายงานเบิกจ่ายเงินเดือนรายบุคคล
            </div>
        </div>
    </div>

        <div class="row">
                <div class="col-md-12">
                    <div class="smart-widget widget-dark-blue">
                        <div class="smart-widget-header"> รายงานเบิกจ่ายเงินเดือนรายบุคคล </div>
                        <div class="smart-widget-body">
                            <div class="smart-widget-body  padding-md">                               
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th >คำนำหน้า</th>
                                            <th >ชื่อ</th>
                                            <th >นามสกุล</th>
                                            <th >ตำแหน่ง</th>
                                            <th class="text-right">เพิ่มเติม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if( count($employ) > 0 )
                                        @foreach( $employ as $key => $item )
                                        @php
                                            $check = $payment->where('register_id', $item->register_id);
                                        @endphp
                                        @if (count($check) !=0 )
                                            <tr>
                                                <td >{{ $item->registerprefixname }}</td>
                                                <td >{{ $item->registername }}</td>
                                                <td >{{ $item->registerlastname }}</td>
                                                <td >{{ $item->positionname }}</td>
                                                <td class="text-right">
                                                    <a href="{{ url('recurit/report/section/personal/pdf/'.$item->register_id) }}" class="btn btn-warning btn-xs" > PDF</a>
                                                    <a href="{{ url('recurit/report/section/personal/excel/'.$item->register_id) }}" class="btn btn-success btn-xs" > Excel</a>
                                                </td>
                                            </tr>
                                        @endif
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
    $("#quater").change(function(){
        document.getElementById('month').value=0;
    })

    $("#month").change(function(){
        document.getElementById('quater').value=0;
    })
</script>
@stop