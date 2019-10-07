@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/payment/section') }}">การเบิกจ่ายเงินเดือน</a></li>
        <li>ประวัติจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                ประวัติจ้างงาน ตำแหน่ง: @if ( $payment->count() > 0) {{ $payment->first()->generate_code }} @endif 
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
                                    <th >ชื่อ นามสกุล</th>
                                    <th >เลขที่บัตรประชาชน</th>
                                    <th >เลขที่ใบสมัคร</th>
                                    <th >เลขที่สัญญา</th>
                                    <th >วันเริ่มจ้าง</th>
                                    <th >วันสิ้นสุดจ้าง</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if( $payment->count() > 0 )
                                @foreach( $payment as $key => $item )
                                    <tr>                                    
                                        <td>{{ $item->registerprefixname }}{{ $item->registername }} {{ $item->registerlastname }}</td>
                                        <td>{{ $item->registerpersonid }}</td>
                                        <td>{{ $item->registerapplicationno }}</td>
                                        <td>{{ $item->registercontractno }}</td>
                                        <td>{{ $item->registerstarthiredate }}</td>
                                        <td>{{ $item->registerendhiredate }}</td>
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
{{-- <script type="text/javascript">
    $(".table").dataTable();
</script> --}}
@stop