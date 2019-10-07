@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('project/allocation') }}">รายการโครงการ</a></li>    
        <li>กำหนดงบประมาณ</li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการงบประมาณ ปีงบประมาณ : {{ $project->year_budget }}
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">

    

    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> งบประมาณ ( {{ number_format( $project->totalbudget , 2) }} บาท ) </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">
                {!! Form::open([ 'method' => 'post' , 'url' => 'project/allocation/locate' ]) !!} 

                    <input type="hidden" name="id" value="{{ $project->project_id }}" />

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
                    
                    @if( count($budget) > 0 )
                    @foreach( $budget as $item )
                        @php( $allocate =  $budgetlist->where('budget_id' , $item->budget_id)->first() )
                        @if( count($allocate) > 0 )
                            @php( $number = $allocate->allocate )
                        @else
                            @php( $number = "" )
                        @endif
                        <div class="form-group">
                            <label>{{ $item->budgetname }}</label>
                            <input type="number" name="budget[{{ $item->budget_id }}]" class="form-control" min="0.00" step="0.01" value="{{ $number }}">
                        </div>
                    @endforeach
                    @endif

                    <div class="text-right">
                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึกรายการ</button>
                    </div>
                {!! Form::close() !!}
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