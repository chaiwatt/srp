@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('setting/position') }}">ตั้งค่า รายการตำแหน่งงาน</a></li>
        <li>เพิ่ม ตำแหน่งงาน</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่ม ตำแหน่งงาน
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header">  เพิ่ม ตำแหน่งงาน</div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md"> <!-- form create project -->
                    {!! Form::open([ 'url' => 'setting/contractorposition/edit' , 'method' => 'post' ]) !!} 
                    <input type="hidden" name="id" value="{{ $position->position_id }}">
                        <div class="form-group">
                            <label>กรมสังกัด</label>
                            <select class="form-control" name="department" id="department"></select>
                        </div>
                        <div class="form-group">
                            <label>ชื่อตำแหน่งงาน</label>
                            <input type="text" name="name" class="form-control" required="" value="{{ $position->position_name }}"/>
                        </div>
                        <div class="form-group">
                            <label>เงินเดือน</label>
                            <input type="number" name="salary" class="form-control" required="" min="0" step="0.01"  value="{{ $position->position_salary }}"/>
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
                department : "{{ $position->department_id }}",
            },
            success : function(data){
                var html = "<option value=''>เลือกหน่วยงาน</option>";
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