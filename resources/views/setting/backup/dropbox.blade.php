@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('setting/backup') }}">ตั้งค่า สำรองฐานข้อมูล</a></li>
        <li>ข้อมูล Drop Box </li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ข้อมูล Drop Box 
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header">  ข้อมูล Drop Box </div>
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
                    {!! Form::open([ 'url' => 'setting/backup/edit' , 'method' => 'post' ]) !!} 
                        <div class="form-group">
                            <label>Gmail User</label>
                            <input type="text" name="gmailuser" class="form-control" value="{{ $dropbox->gmailuser }}" required="" />
                        </div>
                        <div class="form-group">
                            <label>Gmail Pass</label>
                            <input type="text" name="gmailpass" class="form-control" value="{{ $dropbox->gmailpass }}"  required="" />
                        </div>
                        <div class="form-group">
                            <label>DropBox User</label>
                            <input type="text" name="dropboxuser" class="form-control" value="{{ $dropbox->dropboxuser }}" required="" />
                        </div>
                        <div class="form-group">
                            <label>DropBox Pass</label>
                            <input type="text" name="dropboxpass" class="form-control" value="{{ $dropbox->dropboxpass }}" required=""  />
                        </div>
                        <div class="form-group">
                            <label>DropBox Url <a href="https://www.dropbox.com/h" class="text-danger"> ดาวน์โหลด ฐานข้อมูลจาก DropBox App</a></label>
                            <input type="text" name="dropboxurl" class="form-control" value="{{ $dropbox->dropboxurl }}" required="" />
                        </div>
                        <div class="form-group">
                            <label>DropBox AppKey</label>
                            <input type="text" name="dropboxappkey" class="form-control" value="{{ $dropbox->dropboxappkey }}" required=""  />
                        </div>
                        <div class="form-group">
                            <label>DropBox SecretKey</label>
                            <input type="text" name="dropboxsecretkey" class="form-control" value="{{ $dropbox->dropboxsecretkey }}" required="" />
                        </div>
                        <div class="form-group">
                            <label>DropBox Token</label>
                            <input type="text" name="dropboxtoken" class="form-control" value="{{ $dropbox->dropboxtoken }}" required="" />
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

@stop