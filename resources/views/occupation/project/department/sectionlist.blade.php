@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('occupation/project/department') }}">รายการฝึกอบรมวิชาชีพ</a></li>
        <li>รายการพิจารณา</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                    รายการพิจารณา : {{ $projectreadiness->project_readiness_name }}
            </div>
        </div>
    </div>
</div>
    <div class="row padding-md">
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

        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> รายการฝึกอบรมวิชาชีพ </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >วันที่สำรวจ</th>
                                    <th >สำนักงาน</th>                                    
                                    <th class="text-right">อนุมัติให้จัดกิจกรรม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($readinesssection) > 0 )
                                    @foreach( $readinesssection as $item )

                                        <tr>
                                            <td >{{ $item->surveydate }}</td>
                                            <td>{{ $item->sectionname }}</td>
                                            
                                            <td class="text-right">
                                                <div class="form-group">
                                                    <div class="custom-checkbox">
                                                        <div class="form-group">
                                                            <div class="custom-checkbox">
                                                                <input type="checkbox" class="section_id" data-pk="{{ $item->section_id }},{{ $item->department_id }}" id="{{ $item->section_id }}" {{$item->status==1?'checked':'' }} >
                                                                <label for="{{ $item->section_id }}"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <ul class="pagination pagination-split pull-right">
                        </ul>

                    </div>
                </div>
            </div>
        </div>

    </div>

@stop

@section('pageScript')
<script type="text/javascript">
    $(".section_id").change(function(){
        var array = $(this).attr('data-pk').split(',');
        $('input:checkbox').attr('disabled','true');
    		$.ajax({
    			type:"get",
    			url:"{{ url('readiness/project/department/approve') }}",
    			data:{
    				readiness_id :  "{{ $projectreadiness->project_readiness_id }}",
                    status :  $(this).prop("checked"),
                    department :   array[1],
                    section :  array[0],
    			},
    			success:function(response){
    				window.location.reload();
                    $('input:checkbox').attr('disabled','false');
    			},
                error: function(data) {
                    $('input:checkbox').attr('disabled','false');
                },
                complete: function(data) {
                    $('input:checkbox').attr('disabled','false');
                }
    		})
    })
</script>
@stop