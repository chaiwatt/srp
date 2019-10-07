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
                เพิ่มรายการจัดสรรการจ้างงาน : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> จำนวนจัดสรรการจ้างงาน (กรอบจ้างงาน {{$employ}} คน) </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        {!! Form::open([ 'url' => 'recurit/employ/section/create' , 'method' => 'post' ]) !!} 

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
                                        <th style="vertical-align: middle; width:30%" class="text-center" rowspan="2">หน่วยงาน</th>
                                        <th style="vertical-align: middle;" class="text-center" rowspan="2">จำนวนที่ขอ</th>
                                        <th class="text-center" colspan="{{ count($position)+1 }}">ตำแหน่งที่ขอ</th>
                                    </tr>
                                    <tr>
                                        @if(count($position) > 0)
                                        @foreach($position as $item)
                                            <th class="text-center">{{ $item->position_name }}</th>
                                        @endforeach
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if( count($section) > 0 )
                                    @foreach( $section as $key => $item)
                                        @php( $query = $survey->where('section_id' , $item->section_id)->sum('survey_amount') )
                                        <tr>
                                        <td >{{ $item->section_name }} 
                                            @if (!empty($item->surveyhostname))
                                            <br> <small class="text-success">({{$item->surveyhostname}})</small> 
                                            @endif
                                           
                                        </td>
                                            <td class="text-center">{{ $query }}</td>
                                            @if( count($position) > 0 )
                                            @foreach( $position as $value )
                                                @php( $query = $survey->where('section_id' , $item->section_id)->where('position_id' , $value->position_id)->last() )
                                                @php( $number = $generate->where('section_id' , $item->section_id)->where('position_id' , $value->position_id)->count() )
                                                <td>
                                                    <div class="form-group text-center">
                                                        <label>ร้องขอ({{ $query->survey_amount }}) / จัดสรรให้</label>
                                                        <input type="number" min="0" name="number[{{$item->section_id}}][{{$value->position_id}}]" class="form-control text-center" step="1" value="{{ $number }}" />
                                                    </div>
                                                </td>
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