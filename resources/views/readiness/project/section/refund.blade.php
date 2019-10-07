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
        <div class="col-sm-9">
            <div class="page-title">
                    รายการคืนเงินฝึกอบรมเตรียมความพร้อม ปีงบประมาณ : {{ $project->year_budget }}
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
                <div class="smart-widget-header"> รายการคืนเงินฝึกอบรมเตรียมความพร้อม</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >วันที่เพิ่ม</th>
                                    <th >ชื่อหลักสูตร</th>
                                    <th  class="text-center">จำนวนที่คืน</th>
                                    <th >สถานะ</th>
                                    <th class="text-right">สถานะคืนเงิน</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalrefund =0;
                                @endphp
                                @if( count($readinesssection) > 0 )
                                    @foreach( $readinesssection as $item )
                                    
                                    @php
                                    $totalrefund +=  $item->refund ;
                                    $waitrefund=0;
                                        if($item->completed == 1){
                                            $waitrefund = $item->budget - ($item->actualexpense + $item->refund);
                                        }
                                    @endphp           
                                    {{-- @if ($item->refund != 0) --}}
                                    <tr>
                                        <td >{{ $item->adddate }}</td>
                                        <td >{{ $item->projectreadinessname }}</td>                                            
                                        <td  class="text-center">{{  $item->refund }}</td>  
                                        <td >{{ $item->projectcomplete }}@if ($waitrefund > 0) <span class="text-danger"><a href="{{ url('readiness/project/section/refund/'.$item->readiness_section_id) }}" class="btn btn-danger btn-xs" >คืนเงิน {{$waitrefund}} บาท </a></span> @endif</td>
                                        <td class="text-right">
                                            @if ($item->completed == 1 && $waitrefund == 0) 
                                                @if ($item->refund == 0)
                                                    ไม่มีการคืนเงิน
                                                @else
                                                    {{$item->refundstatusdept}}
                                                @endif                                              
                                            @endif
                                        </td>
                                    </tr>
                                    {{-- @endif --}}
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>                                        
                                    <td class="text-center"><strong>{{  number_format(  $totalrefund , 2 )  }}</strong> </td>                                             
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