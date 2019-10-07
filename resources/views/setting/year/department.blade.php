@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('setting/year') }}">ตั้งค่าปีงบประมาณ</a></li>
        <li>หน่วยงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ปีงบประมาณ หน่วยงาน : ปีงบประมาณ {{ $settingyear->setting_year }}
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> ปีงบประมาณ หน่วยงาน </div>
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
                    {!! Form::open([ 'url' => 'setting/year/department' , 'method' => 'post' ]) !!} 
                        <input type="hidden" name="id" value="{{ $settingyear->setting_year_id }}">
                        <div class="form-group">
                            @if( count($department) > 0 )
                            @foreach( $department as $item )
                                @php( $value = $settingdepartment->where('department_id' , $item->department_id)->where('setting_department_status' , 1)->first() )
                                <div class="checkbox">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="{{ $item->department_id }}" name="department[]" value="{{ $item->department_id }}" {{ count($value)>0?'checked':'' }} />
                                        <label for="{{ $item->department_id }}"></label>
                                    </div>
                                    <div class="inline-block vertical-top">
                                        {{ $item->department_name }}
                                    </div>
                                </div>
                            @endforeach
                            @endif
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
    $('.datepicker').datepicker({
        format : "yyyy-mm-dd",
        autoclose:false,
    });
</script>
@stop