@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/hire/section') }}">การจ้างงาน</a></li>
        <li>แก้ไขเดือนจ้างงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                รหัสตำแหน่ง : {{ $generate->generate_code }}  จ้างได้ {{  $generate->generate_allocation / $position->position_salary }} เดือน 
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> กำหนดเดือนจ้างงาน </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">

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
                        
                        {!! Form::open([ 'url' => 'recurit/hire/section/edit/'.$generate->generate_id, 'method' => 'post' ]) !!} 
                            <div class="form-group">
                                <label>จำนวนเดือนที่ต้องการเปลี่ยนแปลง</label>
                                <input type="number" name="number" step="1" min="1" max="9" class="form-control" required="" value="{{$generate->generate_allocation / $position->position_salary}}" />
                            </div>
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
@stop