@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/survey/section') }}">รายการสำรวจการจ้างงาน</a></li>
        <li>สำรวจความต้องการ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                สำรวจความต้องการ 
            </div>
        </div>
    </div>

    <div class="row">
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

        {!! Form::open([ 'url' => 'recurit/survey/section/create' , 'method' => 'post' ]) !!}
        <input type="hidden" name="id" value="{{ $projectsurvey->project_survey_id }}">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการสำรวจ ( {{ $projectsurvey->project_survey_name }} ) </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width:40%">ตำแหน่ง</th>
                                    <th style="width:60%">จำนวน</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($position) > 0 )                               
                                 @php
                                       $total = 0;
                                 @endphp
                                @foreach( $position as $item )
                                @php
                                    $num =0;
                                   
                                    $_survey = $survey->where('position_id',$item->position_id)->first();
                                    if (!empty($_survey) ){
                                     $num =  $_survey->survey_amount;
                                     $total =  $total + $num ;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $item->position_name }}</td>
                                    <td>
                                        <input type="number" min="0" step="1" value="{{ $num }}" name="number[{{ $item->position_id }}]" class="form-control" />
                                    </td>
                                </tr>
                                @endforeach                               
                                    <td><label>บันทึกเพิ่มเติม</label> </td>
                                    <td>                                                              
                                        <textarea class="form-control" rows="3" name="note">@if (!empty($surveyhost)){{$surveyhost->surveyhost_detail}} @endif</textarea>                                        
                                    </td>
                                @endif
                            </tbody>
                            @if (count($_survey) > 0)
                            <tfoot>
                                <tr>
                                    <td class="text-center" colspan="1"><strong>สรุปรายการ</strong></td>
                                    <td><strong>{{ $total }}</strong> </td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>


@stop

@section('pageScript')
<script type="text/javascript">
    
</script>
@stop