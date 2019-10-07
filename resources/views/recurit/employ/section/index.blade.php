@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการจัดสรรการจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการจัดสรรการจ้างงาน : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
         <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('recurit/employ/section/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> จัดสรรจำนวนจ้างงาน</a>
                <a href="{{ url('project/allocation/department/create') }}" class="btn btn-info"> จัดสรรงบประมาณจ้างงาน</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการ ( จำนวนกรอบจ้างงาน : {{ $employ->employ_amount }} ) </div>
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
                                    <th class="text-center">ที่</th>
                                    <th class="text-center">หน่วยงาน</th>
                                    <th class="text-center">รวม</th>
                                    @if( count($position) > 0 )
                                    @foreach( $position as $item )
                                    <th class="text-center">{{ $item->position_name }}</th>
                                    @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalemploy=0;
                                @endphp
                                @if( count($section) > 0 )
                                @foreach( $section as $key => $item )
                                @php
                                     $totalemploy += $generate->where('section_id' , $item->section_id)->count();
                                @endphp
                                    <tr> 
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->sectionname }}</td>
                                        <td class="text-center">{{ $generate->where('section_id' , $item->section_id)->count() }}</td>
                                        @if( count($position) > 0 )
                                        @foreach( $position as $value )
                                            @php( $query = $generate->where('position_id' , $value->position_id)->where('section_id' , $item->section_id)->count() )
                                            <td class="text-center">{{ $query }}</td>
                                        @endforeach
                                        @endif
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>
                                        <td class="text-center" ><strong>{{$totalemploy}}</strong> </td>
                                        @foreach( $position as $value )
                                        @php( $query = $generate->where('position_id' , $value->position_id)->count() )
                                            <td class="text-center"><strong> {{ $query }}</strong></td>
                                        @endforeach
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
<script type="text/javascript">
    $(".table").dataTable();
</script>
@stop