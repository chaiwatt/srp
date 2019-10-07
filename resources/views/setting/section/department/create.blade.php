@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('setting/section') }}">ตั้งค่า รายการหน่วยงานย่อย</a></li>
        <li>เพิ่ม รายการหน่วยงานย่อย</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่ม รายการหน่วยงานย่อย
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header">  เพิ่ม รายการหน่วยงานย่อย </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md"> <!-- form create project -->
                    {!! Form::open([ 'url' => 'setting/section/department/create' , 'method' => 'post' ]) !!} 
                    <div class="form-group">
                        <label>จังหวัด</label>
                        <select class="form-control" name="province">
                            @foreach( $province as $item )
                                <option value="{{ $item->province_id }}">{{ $item->province_name }}</option>
                            @endforeach
                        </select>
                    </div>   
                    <div class="form-group">
                            <label>รหัสหน่วยงาน</label>
                            <input type="number" name="code" class="form-control" required="" />
                        </div>
                        <div class="form-group">
                            <label>ชื่อหน่วยงานย่อย</label>
                            <input type="text" name="name" class="form-control" required="" />
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
    $(".table").dataTable();
</script>
@stop