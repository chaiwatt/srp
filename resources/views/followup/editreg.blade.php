@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('followup') }}">รายการติดตามความก้าวหน้า</a></li>
        <li>บันทึกข้อมูลการติดตาม</li>    
    </ul>
{!! Form::open([ 'url' => 'assesment/section/followupsave' , 'method' => 'post' ]) !!} 
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                    บันทึกข้อมูลการติดตาม :  {{ $project->year_budget }} 
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                <a href="{{ url('assesment/section/editassessment/'.$assesment->project_assesment_id) }}" class="btn btn-success"><i class="fa fa-pencil"></i> แก้ไขรายการ</a>
            </div>
        </div>
    </div>
</div>
    <div class="padding-md">
    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการประเมิน: {{$assesment->assesment_name}} </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        
                        <input type="hidden" name="assesment_id" value="{{$assesment->project_assesment_id}}" />

                            <div class="form-group">
                                <label>ความพึงพอใจต่อโครงการ</label>
                                <select class="form-control" name="register" id="register" required>
                                    @foreach( $sastify as $item )
                                        <option value="{{ $item->satisfaction_id }}">{{ $item->satisfaction_name }}</option>
                                    @endforeach
                                </select> 
                            </div>

                            <div class="form-group">
                                <div class="form-group" name="familyrelation2" id="familyrelation2" style="display: none;">
                                    <span class="text-danger">หลังครบสัญญาวางแผนทำงานที่</span>
                                    <input type="text" class="form-control" name="workon">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>ปัญหาอุปสรรค และข้อเสนอแนะ</label>
                                <textarea class="form-control" name="problem" ></textarea>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

@stop

@section('pageScript')

@stop