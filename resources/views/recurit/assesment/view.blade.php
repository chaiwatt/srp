@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/assesment') }}">การประเมินบุคลิกภาพ</a></li>
        <li>บุคลิกภาพบุคคล</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                    บุคลิกภาพบุคคล : {{$register->name}}  {{$register->lastname}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> บุคลิกภาพบุคคล </div>
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
                                    <th >วันที่</th>
                                    <th >คะแนนบุคลิกภาพ</th>
                                    <th >เหมาะสมอาชีพปัจจุบัน</th>
                                    <th >ความต้องการ:อาชีพ</th>
                                    <th >ความต้องการ:การศึกษา</th>
                                    <th >การให้การอบรม:อาชีพ</th>
                                    <th >การให้การอบรม:การศึกษา</th>
                                    <th >การมอบหมายงาน</th>
                                    <th class="text-right" style="width:80px">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if( count($registerassesmentfit) > 0 )
                                @foreach( $registerassesmentfit as $key => $item )
                                    <tr>
                                        @php
                                            $sumscore = $registerassessment->where('register_assesment_fit_id',$item->register_assesment_fit_id)->sum('register_assessment_point');
                                        @endphp
                                        <td >{{ $item->dateassess }}</td>
                                        <td >{{ $sumscore }}</td>
                                        <td >{{ $item->currentoccupation }}</td>
                                        <td>{{ $item->registeroccupationneed }}</td>
                                        <td>{{ $item->registereducationneed }}</td>
                                        <td>{{ $item->registeroccupationtrain }}</td>
                                        <td>{{ $item->registereducationtrain }}</td>
                                        <td>{{ $item->jobassignment }}</td>

                                        <td class="text-right">
                                                <a href="{{ url('recurit/assesment/edit/'.$item->register_assesment_fit_id) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a href="{{ url('recurit/assesment/delete/'.$item->register_assesment_fit_id) }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบรายการประเมิน')"><i class="fa fa-times"></i></a>  
                                        </td>
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
<script type="text/javascript">
</script>
@stop