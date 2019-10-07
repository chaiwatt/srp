@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>การจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                การจ้างงาน : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการได้รับจัดสรร </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center success">จำนวนจัดสรรรวม</th>
                                    @if( count($position) > 0 )
                                    @foreach( $position as $item )
                                    <th class="text-center">{{ $item->position_name }}</th>
                                    @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @if( count($section) > 0 )
                                @foreach( $section as $key => $item )
                                    <tr> 
                                        <td class="text-center"> <strong>{{ $generate->count() }}</strong> </td>
                                        @if( count($position) > 0 )
                                        @foreach( $position as $value )
                                            @php( $query = $generate->where('position_id' , $value->position_id)->count() )
                                            <th class="text-center">{{ $query }}</th>
                                        @endforeach
                                        @endif
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

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> บันทึกตำแหน่ง </div>
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
                                    <th>รหัสตำแหน่ง</th>
                                    <th>ตำแหน่ง</th>
                                    <th class="text-center">จำนวนเดือนเบิกจ่าย</th>
                                    
                                    <th class="text-center">จำนวนสัญญา</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-right">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($generate) > 0 )
                                @foreach( $generate as $item )
                                    @php
                                        $query = $payment->where('generate_code' , $item->generate_code)->count() ;
                                        $positionsalary = $position->first()->position_salary; // $payment->where('generate_code' , $item->generate_code)->first()->position_salary;
                                        $num = $allgenerate->where('generate_code', $item->generate_code)->count() ;
                                    @endphp
                                    <tr>
                                        <td >{{ $item->generate_code }}</td>
                                        <td>{{ $item->positionname }}</td>
                                        <td class="text-center">{{$query}} / {{$item->generate_allocation / $positionsalary}}</td>
                                        <td class="text-center">{{ $num }}</td>
                                        <td class="text-center">{{ $item->generatestatusname }}</td>
                                        
                                        <td class="text-right">
                                            @if( $item->generate_status == 0 && $item->generate_refund == 0 )
                                                <a href="{{ url('recurit/hire/section/create/'.$item->generate_id) }}" class="btn btn-warning">คัดเลือก</a>
                                                
                                            @else
                                                <a href="{{ url('recurit/hire/section/view/'.$item->generate_id) }}" class="btn btn-primary">รายละเอียด</a>
                                                
                                            @endif
                                            
                                            <a href="{{ url('recurit/hire/section/history/'.$item->generate_id) }}" class="btn btn-success">ประวัติ</a>
                                            <a href="{{ url('recurit/hire/section/editnummonth/'.$item->generate_id) }}" class="btn btn-default">จัดสรรเดือน</a>
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