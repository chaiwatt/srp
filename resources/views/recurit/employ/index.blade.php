@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>กรอบการจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                กรอบการจ้างงาน : ปีงบประมาณ {{ $project->year_budget }} 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการ </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        {!! Form::open([ 'url' => 'recurit/employ' , 'method' => 'post' ]) !!} 

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
                                        <th>ที่</th>
                                        <th>ชื่อกรม</th>
                                        <th>จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if( count($department) > 0 )
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach( $department as $key => $item )
                                        @php
                                            $value = $employ->where('department_id' , $item->department_id)->first() ;
                                        @endphp
                                        <tr> 
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->departmentname }}</td>
                                            @if( count($value) > 0 )
                                            @php
                                                 $total =  $total + $value->employ_amount;
                                            @endphp
                                            <td><input type="text" name="amount[{{$item->department_id}}]" class="form-control" value="{{ $value->employ_amount }}" /></td>
                                            @else
                                            <td><input type="text" name="amount[{{$item->department_id}}]" class="form-control" value="0" /></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                @if( count($department) > 0 )
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="2"><strong>สรุปรายการ</strong> </td>
                                        
                                        <td class="text-left"><strong>{{ $total }}</strong></td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
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