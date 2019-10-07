@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('setting/landing') }}">ตั้งค่า Landing Page</a></li>
        <li>เพิ่มเอกสารดาวน์โหลด</li>    
    </ul>
    {!! Form::open([ 'url' => 'setting/landing/create' , 'method' => 'post', 'files' => 'true' ]) !!} 
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่มเอกสารดาวน์โหลด
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> เอกสาร </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>คำอธิบายไฟล์</label>
                                    <input type="text" name="desc" class="form-control" required/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>เลือกไฟล์</label>
                                <input type="file" name="file" id="file" class="filestyle"  required />
                            </div>     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>


@stop

@section('pageScript')
<script type="text/javascript">

    $('#file').filestyle({
        buttonName : 'btn-info',
        buttonText : ' เลือกไฟล์เอกสาร',
        input: false,
        icon: false,
    });
</script>
@stop