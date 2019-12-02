@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/resign/section') }}">ลาออก</a></li>
        <li>บันทึกการลาออก</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                บันทึกการลาออก
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการ </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        {!! Form::open([ 'url' => 'recurit/resign/section/create' , 'method' => 'post' ]) !!} 

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

                            <div class="form-group">
                                <label>รายการจัดจ้าง</label>
                                <select class="form-control" name="generate">
                                    @if(count($generate) > 0)
                                        <option value="">เลือก รายชื่อจัดจ้าง</option>
                                    @foreach( $generate as $item )
                                        <option value="{{ $item->generate_id }}">
                                            {{ $item->registerprefixname }}{{ $item->registername }}
                                            {{ $item->registerlastname }} ( {{ $item->generate_code }} - {{ $item->positionname }} )
                                        </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>วันลาออก</label>
                                <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                                    <input type="text" class="form-control" name="date" autocomplete="off" required>
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>เหตุผล</label>
                                <select class="form-control" name="reason">
                                @if(count($reason) > 0)
                                @foreach( $reason as $item )
                                    <option value="{{ $item->reason_id }}">{{ $item->reason_name }}</option>
                                @endforeach
                                @endif
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                                    </div>
                                </div>
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
    $('.datepicker').datepicker({
        language: 'th',
        format : "dd/mm/yyyy",
        thaiyear: true,
        autoclose:true,
        orientation: "bottom left",
    });
</script>
@stop