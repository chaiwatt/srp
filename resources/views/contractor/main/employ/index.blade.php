@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/employ/section') }}">รายการจัดสรรการจ้างงาน</a></li>
        <li>เพิ่มรายการจัดสรรการจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่มรายการจัดสรรการจ้างเหมา : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการ </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        {!! Form::open([ 'url' => 'contractor/main/employ/create' , 'method' => 'post' ]) !!} 

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
                                        <th style="vertical-align: middle;" class="text-left" rowspan="2">หน่วยงาน</th>
                                        <th class="text-center" colspan="{{ count($position)+1 }}">จำนวนที่จัดสรร</th>
                                    </tr>
                                    <tr>
                                        @if(count($position) > 0)
                                            @foreach($position as $item)
                                                @php
                                                    $val = $deptallocation->where('department_id',$item->department_id)->first();
                                                @endphp
                                                    @if (count($val) > 0 )
                                                        <th class="text-center">{{ $item->position_name }}</th>
                                                    @endif
                                            @endforeach
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if( count($deptallocation) > 0 )
                                        @foreach( $deptallocation as $item)
                                            <tr>
                                                <td>{{ $item->departmentname }}</td>
                                                @if( count($position) > 0 )
                                                    @foreach( $position as $value ) 
                                                        @php
                                                            $val = $deptallocation->where('department_id',$value->department_id)->first();
                                                            $number = $generate->where('department_id' , $item->department_id)->where('position_id' , $value->position_id)->count() ;
                                                        @endphp
                                                        @if (count($val) > 0)
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="number" min="0" name="number[{{$item->department_id}}][{{$value->position_id}}]" class="form-control text-center" step="1" value="{{ $number }}" required />
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td style="display:none;">
                                                                <div class="form-group">
                                                                    <input type="number" min="0" name="number[{{$item->department_id}}][{{$value->position_id}}]" class="form-control" step="1" value="{{ $number }}"  />
                                                                </div>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
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