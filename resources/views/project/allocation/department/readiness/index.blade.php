@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">
    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('transfer/department') }}">รายการ รายการโอนงบประมาณ</a></li>
        <li>โอนงบประมาณฝึกอบรมเตรียมความพร้อม</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                โอนงบประมาณฝึกอบรมเตรียมความพร้อม ปีงบประมาณ : {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row padding-md">
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
        {!! Form::open([ 'method' => 'get' ]) !!}
            <div class="form-group">
                <label>เลือกหลักสูตร </label>
                <select class="form-control" name="readiness"  >
                    @if(count($projectreadiness) > 0)                       
                        @foreach( $projectreadiness as $item )
                            <option value="{{$item->project_readiness_id}}"  @if ($readiness == $item->project_readiness_id) selected @endif>{{ $item->project_readiness_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group">
                <div class="pull-right">
                    <button class="btn btn-primary">ค้นหา</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

    @if( $search != "" )
        <div class="row">
            <div class="col-md-12">
                {!! Form::open([ 'url' => 'project/allocation/department/readiness/create' , 'method' => 'post' ]) !!} 
                <input type="hidden" name="readiness_id" value="{{$readiness}}">

                    <div class="smart-widget widget-dark-blue">

                        <div class="smart-widget-header"> งบประมาณฝึกอบรมเตรียมความพร้อม คงเหลือ = {{ number_format($transfer - $payment + $refund,2) }} บาท</div>
                        <div class="smart-widget-body">
                            <div class="smart-widget-body  padding-md">
                                @if( count($readinesssection) > 0 )
                                @foreach( $readinesssection as $value )
                                @php
                                    $query = $allocation->where('section_id' , $value->section_id)->sum('allocation_price');
                                    $waitrefund =0;
                                    if($value->completed == 1){
                                        $waitrefund = $value->budget - ($value->actualexpense + $value->refund);
                                    }
                                @endphp
                            
                                    <div class="form-group">
                                    <label>{{ $value->sectionname }}</label> @if ($value->completed == 1) <span class="text-success">(จบโครงการ@if ($waitrefund > 0) <span class="text-danger"> เงินรอคืน {{$waitrefund}} บาท </span> @endif)</span> @endif
                                       
                                        <input type="number" name="number[{{$value->section_id}}]" class="form-control" step="0.01" autocomplete="off" value="{{ $value->budget }}" @if ($value->completed == 1) readonly @endif>
                                    </div>

                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>


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
    @endif
</div>


@stop

@section('pageScript')
{{-- <script type="text/javascript">
    $(function(){
        $.ajax({
            type:"get",
            url:"{{ url('api/projectallocation') }}",
            dataType:"Json",
            data:{
                budget : "{{ $search }}",
            },
            success : function(data){
                var html = "<option value=''>เลือกค่าใช้จ่าย</option>";
                if(data.row > 0){
                    for(var i=0;i<data.row;i++){
                        if( data.budget[i].budget_id == data.filter_budget ){
                            html += "<option value='"+ data.budget[i].budget_id +"' selected>" + data.budget[i].budget_name +"</option>"
                        }
                        else{
                            html += "<option value='"+ data.budget[i].budget_id +"' > " + data.budget[i].budget_name +"</option>"
                        }
                    }
                }

                $("#budget").html(html);
            }
        })
    })
</script> --}}
@stop