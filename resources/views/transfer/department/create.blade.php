@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">
    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('transfer/department') }}">รายการโอนงบประมาณ</a></li>
        <li>โอนงบประมาณ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                โอนงบประมาณ ปีงบประมาณ : {{ $project->year_budget }} 
            </div>
        </div>
    </div>
{{-- 
    <div class="row padding-md">
        {!! Form::open([ 'method' => 'get' ]) !!}
            <div class="form-group">
                <label class="control-label padding-10">รายการค่าใช้จ่าย </label>
                <select class="form-control" name="search" id="budget"></select>
            </div>
            <div class="form-group">
                <div class="pull-right">
                    <button class="btn btn-primary">ค้นหา</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div> --}}

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

                {!! Form::open([ 'url' => 'transfer/department/create' , 'method' => 'post' ]) !!} 
                <input type="hidden" name="id" value="{{ $budget->budget_id }}">


                <div class="smart-widget widget-dark-blue">
                    <div class="smart-widget-header"> {{ $budget->budget_name }} ( คงเหลือ = {{ number_format($sum , 2) }} )</div>
                    <div class="smart-widget-body">
                        <div class="smart-widget-body  padding-md">
                            @if( count($section) > 0 )
                            <table class="table table-striped">
                                <thead>
                                        <tr>
                                            <th style="width:70%">สำนักงาน</th>
                                            <th style="width:30%" >จำนวนโอน</th>                                                
                                        </tr>
                                </thead>
                                <tbody>
                                @foreach( $section as $value )
                                    <tr>
                                        @php
                                            $query = $allocation->where('section_id' , $value->section_id)->first(); 
                                        @endphp
                                        @if( count($query) == 0 )
                                            @php($number = 0)
                                        @else
                                            @php($number = $query->transactionbalance)
                                        @endif
                                        <td>
                                         <label>{{ $value->section_name }} ( คงเหลือ = {{ $number }} )</label>   
                                        </td>
                                        <td><input style="width:100%"  type="number" name="number[{{ $value->section_id }}]" class="form-control" step="0.01" autocomplete="off" value=""></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
<script type="text/javascript">
    $(function(){
        $.ajax({
            type:"get",
            url:"{{ url('api/projectallocation') }}",
            dataType:"Json",
            data:{
                budget : 1,
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

       $(".table").dataTable({
        "language": {
        "search": "ค้นหา: "
        },
        "pageLength": 5
    });

</script>
@stop