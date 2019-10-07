@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li> 
        <li>สรุปจัดสรรงบประมาณ</li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                สรุปจัดสรรงบประมาณ ปีงบประมาณ {{$project->year_budget}}
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> 
                จัดสรรงบประมาณ ({{  number_format( $project->totalbudget  , 2) }} บาท) 
               <small >
                @if(count($sumbydept) > 0)
                    @php(
                        $header=""
                    )
                    @foreach( $sumbydept as $dept )
                        @if($dept->sum !=0)
                            @php($header .= $dept->departmentname . " " . number_format( $dept->sum  , 2) . " บาท " )
                        @endif
                    @endforeach  
                    @if($sumbydept->sum('sum') > 0)
                        คืนงบประมาณ {{ $header }} 
                    @endif

                @endif
               </small>
        
            </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">
                {!! Form::open([ 'method' => 'post' , 'url' => 'project/allocation/deptalllocate' ]) !!} 
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

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th >รายการ</th>
                                <th class="text-right">เงินตั้งต้น</th>
                                @if( count( $department ) > 0 )
                                @foreach( $department as $item ) 
                                    <th class="text-right">{{ $item->departmentname }}</th>
                                @endforeach
                                @endif
                                <th class="text-right">เงินคืน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sumrefund = 0;
                            @endphp
                            @if( count($budget) > 0 )
                            @foreach( $budget as $key => $item )
                                <tr>
                                    <td>{{ $item->budget_name }}</td>
                                    @php( $value = $budgetlist->where('budget_id' , $item->budget_id)->first() )
                                    @if( count($value) > 0 )
                                        <td class="text-right">{{ number_format( $value->allocate  , 2) }}</td>
                                    @else
                                        <td class="text-right">{{ number_format( 0 , 2 ) }}</td>
                                    @endif

                                    @if( count( $department ) > 0 )
                                    @foreach( $department as $key1 => $value )
                                        @php( $query = $allocation->where('budget_id' , $item->budget_id )->where('department_id' , $value->department_id )->sum('allocation_price')  )
                                        <td  class="text-right"> {{ number_format( $query , 2 ) }}</td>
                                    @endforeach
                                    @endif
                                    @php
                                         $query = $waiting->where('budget_id' , $item->budget_id)->sum('waiting_price') ;
                                         $sumrefund +=  $query ;
                                    @endphp
                                    <td class="text-right"> {{ number_format( $query , 2 ) }}</td>
                                </tr>
                            @endforeach
                            @endif
                                <tr>
                                    <td class="text-right"><b>รวม</b></td>
                                    <td class="text-right"> <strong>{{ number_format($budgetlist->sum('allocate'),2) }}</strong> </td>
                                    @if( count( $department ) > 0 )
                                    @foreach( $department as $key1 => $value )
                                        @php( $number = $allocation->where('department_id' , $value->department_id )->sum('allocation_price')  )
                                        <td class="text-right"><strong> {{ number_format( $number , 2 ) }}</strong></td>
                                    @endforeach
                                    @endif
                                    <td class="text-right"><strong> {{ number_format( $sumrefund , 2 ) }}</strong></td>
                                </tr>
                        </tbody>
                    </table>

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