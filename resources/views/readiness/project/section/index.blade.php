@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการฝึกอบรมเตรียมความพร้อม</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                    รายการฝึกอบรมเตรียมความพร้อม ปีงบประมาณ : {{ $project->year_budget }}
            </div>
        </div>
    </div>

    <div class="row">
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
                <div class="smart-widget-header"> รายการฝึกอบรมเตรียมความพร้อม</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >วันที่เพิ่ม</th>
                                    <th >ชื่อหลักสูตร</th>
                                    <th class="text-center">เป้าหมายผู้เข้าร่วม</th>
                                    <th class="text-center">ต้องการจัดกิจกรรม</th>
                                    <th class="text-center">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totaltarget =0;
                                @endphp
                                @if( count($readiness) > 0 )
                                    @foreach( $readiness as $item )
                                        @php
                                             $totaltarget += $item->targetparticipate ;
                                        @endphp
                                        @if ($item->project_status == 1)
                                        @php
                                            $disable = "";
                                            $check = $readinesssection->where('project_readiness_id',$item->project_readiness_id)->first(); 
                                            if(!empty($check)){
                                                if($check->status == 1){
                                                    $disable = "disabled";
                                                }
                                            }                                  
                                        @endphp
                                            <tr>
                                                <td >{{ $item->adddate }}</td>
                                                <td>{{ $item->project_readiness_name }}</td>                                               
                                                <td class="text-center">{{ $item->targetparticipate }}</td>
                                                <td class="text-center">
                                                    <div class="form-group">
                                                        <div class="custom-checkbox">
                                                            <div class="form-group">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" class="readiness_id" data-pk="{{ $item->project_readiness_id }}" id="{{ $item->project_readiness_id }}" {{!empty($check)?'checked':'' }} {{ $disable }} >
                                                                    <label for="{{ $item->project_readiness_id }}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                                <td class="text-center"> @if (!empty($check )){{ $check->projectstatus }} @endif </td> 
                                            </tr> 
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>                                        
                                        <td class="text-center"><strong>{{ $totaltarget }}</strong> </td>                                             
                                    </tr>
                                </tfoot>
                        </table>

                        <ul class="pagination pagination-split pull-right">
                        </ul>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@stop

@section('pageScript')
<script type="text/javascript">
    $(".readiness_id").change(function(){
        $(".readiness_id").prop("disabled", true);
        // alert($(this).prop("checked"));
    		$.ajax({
    			type:"get",
    			url:"{{ url('readiness/project/section/toggle') }}",
    			data:{
    				readiness_id : $(this).attr('data-pk'),
                    status :  $(this).prop("checked"),
                    section :  "{{ $auth->section_id }}",
                    department :  "{{ $auth->department_id }}",
                    project_id :  "{{ $project->project_id }}",
    			},
    			success:function(response){
                    console.log(response);
    				window.location.reload();
    			}
    		})
    })
</script>
@stop