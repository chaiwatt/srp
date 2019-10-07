@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานการประเมินบุคลิกภาพ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                    รายงานการประเมินบุคลิกภาพ : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> การประเมินบุคลิกภาพ </div>
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
                                    <th >คำนำหน้า</th>
                                    <th >ชื่อ</th>
                                    <th >นามสกุล</th>
                                    <th >ตำแหน่งงาน</th>
                                    <th class="text-right">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if( count($register) > 0 )
                                    @foreach( $register as $key => $item )
                                        @php
                                        $check = $registerassesmentfit->where('register_id', $item->register_id)->first()
                                        @endphp
                                        @if (count($check) !=0 )
                                            <tr>
                                                <td >{{ $item->registerprefixname }}</td>
                                                <td >{{ $item->registername }}</td>
                                                <td>{{ $item->registerlastname }}</td>
                                                <td>{{ $item->positionname }}</td>
                                                <td class="text-right">
                                                    <a href="{{ url('recurit/assesment/report/download/'.$item->register_id) }}" class="btn btn-info btn-xs">ดาวน์โหลด</a>
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
</script>
@stop