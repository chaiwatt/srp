@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">
    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('project/allocation/department') }}">รายการ งบประมาณที่ได้รับการจัดสรร</a></li>
        <li>จัดสรรงบประมาณจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                จัดสรรงบประมาณจ้างงาน ปีงบประมาณ : {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    @if( $search != "" )
        <div class="row">
            <div class="col-md-12">
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

                {!! Form::open([ 'url' => 'project/allocation/department/create' , 'method' => 'post' ]) !!} 
                <input type="hidden" name="id" value="{{ $budget->budget_id }}">

                @if( $budget->budget_id == 1 )
                    <div class="smart-widget widget-dark-blue">

                        <div class="smart-widget-header"> {{ $budget->budget_name }} ( งบประมาณคงเหลือ = {{ number_format($transaction->transaction_balance,2) }} ) </div>
                        <div class="smart-widget-body">
                            <div class="smart-widget-body  padding-md">
                                @if( count($section) > 0 )
                                @foreach( $section as $value )
                                    @php
                                        $query = $allocation->where('section_id' , $value->section_id)->sum('allocation_price') ;
                                        $num =count($generate->where('section_id', $value->section_id));
                                        $allocate =  $num * $salary * 9;
                                    @endphp                                                   
                                    <div class="form-group">
                                        <label>{{ $value->section_name }} (จ้างงาน {{ $num }} คน, งบประมาณ {{ $allocate }} บาท) </label>@if ($allocate == 0) <label class="text-danger">!! ยังไม่ได้จัดสรรจำนวนจ้างงาน</label>@endif
                                        <input type="number" name="number[{{$value->section_id}}]" class="form-control" step="0.01" autocomplete="off" value="{{ $query }}" @if ($allocate == 0) readonly @endif>
                                    </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

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