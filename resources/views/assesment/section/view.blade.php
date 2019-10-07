@extends('layout.mains')

@section('pageCss')

@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">เว็บไซต์</a></li>
        <li><a href="{{ url('assesment/section') }}">รายการประเมินผล</a></li>
        <li>การประเมินผล</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                การประเมินผล: {{$assessment->assesment_name}}
            </div>
        </div>
    </div>

    <div class="row ">
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

        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการประเมิน </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >ชื่อ-สกุล</th>
                                    <th >เลบที่บัตรประชาชน</th>
                                    <th >ผลการประเมิน</th>
                                    <th >การติดตาม</th>
                                    <th >ต้องการสนับสนุน</th>
                                    <th >ความสัมพันธ์ในครอบครัว</th>
                                    <th >การมีรายได้</th>
                                    <th >การมีอาชีพ</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($assessee) > 0 )
                                @foreach( $assessee as $item )
                                    <tr>
                                        <td>{{ $item->registername }}</td>
                                        <td >{{ $item->registerpersonid }}</td>
                                        <td >{{ $item->scorename }}</td>
                                        <td >{{ $item->followerstatusname }}</td>
                                        <td >{{ $item->needsupportname }} <small class="text-danger"> {{ $item->needsupport_detail }}</small></td>
                                        <td >{{ $item->familyrelationname }} <small class="text-danger"> {{ $item->familyrelation_detail }}</td>
                                        <td >{{ $item->enoughincomename}}</td>
                                        <td >{{ $item->occupationname}} <small class="text-danger"> {{ $item->occupation_detail }}</td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>

                        <ul class="pagination pagination-split pull-right">
                        </ul>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@stop

@section('pageScript')


<script type="text/javascript">
    // $(document).ready(function() {
    //     $('.table').DataTable( {
    //         dom: 'Bfrtip',
    //         buttons: [
    //             {
    //                 extend: 'copyHtml5',
    //                 exportOptions: {
    //                     columns: [ 0, 1, 2, 3,4,5,6 ],
                        
    //                 }
    //             },
    //             {
    //                 extend: 'excelHtml5',
    //                 exportOptions: {
    //                     columns: [ 0, 1, 2, 3,4,5,6 ]
    //                 }
    //             },

    //         ],
    //             "language": {
    //             "search": "ค้นหา "
    //             },
    //     } );
    // } );
</script>

@stop