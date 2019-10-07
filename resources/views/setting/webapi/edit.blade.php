@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('setting/webapi') }}">ตั้งค่า Web API</a></li>
        <li>แก้ไข Web API</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                แก้ไข Web API
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header">  แก้ไข Web API</div>
            <div class="smart-widget-body">

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

                <div class="smart-widget-body  padding-md"> <!-- form create project -->
                    {!! Form::open([ 'url' => 'setting/webapi/edit' , 'method' => 'post' ]) !!} 
                        <input type="hidden" name="id" value="{{ $webapi->webapi_id }}">
                        <div class="form-group">
                            <label>Web Api</label>
                            <input type="text" name="name" class="form-control" required="" value="{{ $webapi->weburl }}" />
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
@stop

@section('pageScript')
<script type="text/javascript">
</script>
@stop