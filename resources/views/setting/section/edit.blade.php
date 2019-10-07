@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('setting/section') }}">ตั้งค่า รายการหน่วยงานย่อย</a></li>
        <li>แก้ไข รายการหน่วยงานย่อย</li>    
    </ul>
    
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                แก้ไข รายการหน่วยงานย่อย
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header">  แก้ไข รายการหน่วยงานย่อย </div>
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
                    {!! Form::open([ 'url' => 'setting/section/edit' , 'method' => 'post' ]) !!} 
                        <input type="hidden" name="id" value="{{ $section->section_id }}">
                        <div class="form-group">
                            <label>หน่วยงาน</label>
                            <select class="form-control" name="department" id="department"></select>
                        </div>
                        <div class="form-group">
                            <label>รหัสหน่วยงาน</label>
                            <input type="number" name="code" class="form-control" required="" value="{{ $section->section_code }}" />
                        </div>
                        <div class="form-group">
                            <label>ชื่อหน่วยงานย่อย</label>
                            <input type="text" name="name" class="form-control" required="" value="{{ $section->section_name }}" />
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
                department : "{{ $section->department_id }}",
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
@stop