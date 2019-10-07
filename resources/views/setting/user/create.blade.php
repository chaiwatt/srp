@extends('layout.mains')
@section('pageCss')
@stop

@section('content')
@php( $auth = Auth::user() )
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('dashboard') }}">หน้าแรก</a></li>
        <li><a href="{{ url('setting/user') }}">ตั้งค่า ผู้ใช้งานระบบ</a></li>
        <li>เพิ่ม ผู้ใช้งานระบบ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่ม ผู้ใช้งานระบบ
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header">  เพิ่ม ผู้ใช้งานระบบ </div>
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

                <div class="smart-widget-body  padding-md">
                    {!! Form::open([ 'url' => 'setting/user/create' , 'method' => 'post' ]) !!} 
                    <div class="form-group">
                        <label>กลุ่มผู้ใช้งาน</label>
                        <select class="form-control" name="usertype" id="usertype" required>
                            @if ($auth->permission == 1)
                                    <option value="1">superadmin</option>
                                    <option value="2">admin</option>
                                    <option value="3">section</option>
                                @elseif($auth->permission == 2)
                                    <option value="2">admin</option>
                                    <option value="3">section</option>
                            @endif
                        </select>   
                    </div>     
                        <div class="form-group">
                            <label>หน่วยงาน</label>
                            <select class="form-control" name="department" id="department" >
                                @if( count($department) > 0 )
                                <option value="">เลือก หน่วยงาน</option>
                                @foreach( $department as $item )
                                    <option value="{{ $item->department_id }}">{{ $item->department_name }}</option>
                                @endforeach
                                @endif
                            </select>   
                        </div>
                        <div class="form-group">
                            <label>หน่วยงานย่อย</label>
                            <select class="form-control" name="section" id="section" ></select>
                        </div>
 
                        <div class="form-group">
                            <label>ชื่อ-สกุล</label>
                            <input type="text" name="name" class="form-control" required="" />
                        </div>

                        <div class="form-group">
                            <label>หมายเลขบัตรประชาชน</label>
                            <input type="text" name="userpersonid" class="form-control" required="" />
                        </div>

                        <div class="form-group">
                            <label>ยูสเซอร์เนม</label>
                            <input type="text" name="user" class="form-control" required="" />
                        </div>

                        <div class="form-group">
                            <label>รหัสผ่าน</label>
                            <input type="text" name="pass" class="form-control" required="" />
                        </div>
                    <hr>

                    
                    <div class="form-group">
                        <label>จำกัดสิทธ์</label>
                        <select class="form-control" name="timelimit" >
                            @foreach( $userright as $item )
                                <option value="{{ $item->userright_id }}">{{ $item->userright_name }}</option>
                            @endforeach
                        </select>   
                    </div>
                    <div class="form-group">
                            <label>เริ่มต้นใช้งาน</label><small class="text-danger">*</small>
                            <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                                <input type="text" class="form-control" name="limitstart"  autocomplete="off" required="">
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>สิ้นสุดใช้งาน</label><small class="text-danger">*</small>
                            <div class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                                <input type="text" class="form-control" name="limitend" autocomplete="off" required="">
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
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
    $( "#department" ).change(function() {
        var deptid= $("#department").val();  
        $(function(){
            $.ajax({
                type:"get",
                url:"{{ url('api/section') }}",
                dataType:"Json",
                data: {
                    'department' : deptid
                },
                success : function(data){
                    var html = "";
                    if(data.row > 0){
                        for(var i=0;i<data.row;i++){
                            html += "<option value='"+ data.section[i].section_id +"' > " + data.section[i].section_name +"</option>"       
                        }
                    }
                $("#section").html(html);
                }
            })
    })
    });

    $('.datepicker').datepicker({
        language: 'th',
        format : "dd/mm/yyyy",
        thaiyear: true,
        autoclose:false,
    });
    
</script>
@stop