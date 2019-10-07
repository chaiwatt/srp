@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/register/section') }}">ผู้สมัครร่วมโครงการ</a></li>
        <li>สร้างใบรับรอง</li>    
    </ul>
    {!! Form::open([ 'url' => 'recurit/register/section/createcert' , 'method' => 'post'  ]) !!} 
    <input type="hidden" name="register_id" value="{{$register->register_id}}">
    <div class="row padding-md">
        <div class="col-sm-6">
            <div class="page-title">
                สร้างใบรับรอง : {{ $register->prefixname}}{{ $register->name}} {{ $register->lastname }}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> ดาวน์โหลด</button>
            </div>
        </div>
    </div>
    
    <div class="row padding-md">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> ข้อมูลใบรับรอง </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">
                    <div class="row">
                        <div class="col-md-6">
                            <label>วันเริ่มงาน</label>
                            <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                <input type="text" class="form-control" name="certdatestart" id ="certdatestart" readonly="" value="" autocomplete="off" required >
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>วันสิิ้นสุด</label>
                            <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th"">
                                <input type="text" class="form-control" name="certdateend" id="certdateend" readonly="" value="" autocomplete="off" required >
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>     
                    <hr>                  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>จำนวนเดือน</label>
                                <input type="text" name="nummonthwork" id ="nummonthwork" class="form-control" value="" required />
                            </div>
                        </div> 
                    </div>  
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ผู้รับรอง</label>
                                <input type="text" name="certername" id="certername" class="form-control" value=""  />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ตำแหน่ง</label>
                                <input type="text" name="certerposition" id="certerposition" class="form-control" value=""  />
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


    $(document).on('click', '#modalcert', function(e){
        e.preventDefault();

        $('#cert').modal('show');

    }); 
    
    $(document).ready(function() {
        $('.select2').select2();
    });

    $('#picture').filestyle({
        buttonName : 'btn-success',
        buttonText : ' เลือกรูป',
        // input: false,
        icon: false,
    });

    $('#doc').filestyle({
        buttonName : 'btn-success',
        buttonText : ' เลือกไฟล์',
        // input: false,
        icon: false,
    });

	$("form").keypress(function(event){
         if(event.keyCode==13){
            return false;
         }
     });
 

    $('.datepicker').datepicker({
        language: 'th',
        format : "dd/mm/yyyy",
        thaiyear: true,
        autoclose:false,
    });



</script>
@stop