@extends('layout.mains')
@section('pageCss')
@stop

@section('content')
@php( $auth = Auth::user() )
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('dashboard') }}">หน้าแรก</a></li>
        <li><a href="{{ url('setting/user') }}">ตั้งค่า ผู้ใช้งานระบบ</a></li>
        <li>แก้ไข ผู้ใช้งานระบบ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                แก้ไข ผู้ใช้งานระบบ
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header">  แก้ไข ผู้ใช้งานระบบ </div>
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
                    {!! Form::open([ 'url' => 'setting/user/edit' , 'method' => 'post' ]) !!} 
                    <input type="hidden" value="{{$user->user_id}}" name="userid" >
                        <div class="form-group">
                            <label>ชื่อ-สกุล</label>
                            <input type="text" name="name" class="form-control" required="" value="{{$user->name}}" />
                        </div>

                        <div class="form-group">
                            <label>ยูสเซอร์เนม</label>
                            <input type="text" name="user" class="form-control" required="" value="{{$user->username}}" />
                        </div>

                        <div class="form-group">
                            <label>รหัสผ่าน</label>
                            <input type="text" name="pass" class="form-control" required="" />
                        </div>
                        <div class="form-group">
                            <label>สถานะ</label>
                            <select class="form-control" name="status" >
                                <option value="1">เปิดการใช้งาน</option> 
                                <option value="0">ปิดการใช้งาน</option>
                            </select>
                        </div> 
                        
                        <hr>

                    
                        <div class="form-group">
                        <label>จำกัดสิทธ์</label>
                            <select class="form-control" name="timelimit" >
                                @foreach( $userright as $item )                                
                                    <option value="{{ $item->userright_id }}" @if ($user->timelimit == $item->userright_id) selected @endif>{{ $item->userright_name }}</option>
                                @endforeach
                            </select>   
                        </div>
                        <div class="form-group">
                                <label>เริ่มต้นใช้งาน</label><small class="text-danger">*</small>
                                <div id="limitstart" class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
                                    <input type="text" class="form-control" name="limitstart"  autocomplete="off" required="">
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>สิ้นสุดใช้งาน</label><small class="text-danger">*</small>
                                <div id="limitend" class="input-append date datepicker" data-provide="datepicker" data-date-language="th-th">
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
    $(function(){
        $.ajax({
            type:"get",
            url:"{{ url('api/department') }}",
            dataType:"Json",
            data:{
                department : {{ $auth->department_id }},
                permission : {{ $auth->permission }},
            },
            success : function(data){
                var html = "<option value=''>เลือก หน่วยงาน</option>";
                if(data.row > 0){
                    for(var i=0;i<data.row;i++){
                        if( data.department[i].department_id == data.filter_department ){
                            html += "<option value='"+ data.department[i].department_id +"' selected>" + data.department[i].department_name +"</option>"
                        }
                        else{
                            html += "<option value='"+ data.department[i].department_id +"' > " + data.department[i].department_name +"</option>"
                        }
                    }
                }
                $("#department").html(html);
            }
        })
    })
</script>

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
                    var html = "<option value=''>เลือก หน่วยงานย่อย</option>";
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

    $('#limitstart').datepicker({
        format: 'dd/mm/yyyy',
        language: 'th',  
        autoclose: true,             
        thaiyear: true              
    }).datepicker("setDate", "{{ $user->limitstarteng }}"); 

    $('#limitend').datepicker({
        format: 'dd/mm/yyyy',
        language: 'th',  
        autoclose: true,             
        thaiyear: true              
    }).datepicker("setDate", "{{ $user->limitendeng }}"); 

</script>
@stop