@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงาน ฝึกอบรมวิชาชีพ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                    รายงาน ฝึกอบรมวิชาชีพ ปีงบประมาณ : {{ $project->year_budget }}
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
                <div class="smart-widget-header"> รายการ ฝึกอบรมวิชาชีพ</div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >วันที่</th>
                                    <th >ชื่อหลักสูตร</th>
                                    <th  class="text-center">เป้าหมายเข้าร่วม</th>
                                    <th  class="text-center">เข้าร่วมจริง</th>
                                    <th  class="text-center">งบจัดสรร</th>
                                    <th  class="text-center">เบิกจ่ายจริง</th>
                                    <th class="text-right">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php                                    
                                    $totaltarget = 0;
                                    $totalactualparticipate =0;
                                    $totalbudget =0;
                                    $totalpayment =0;
                                @endphp
                                @if( count($readinesssection) > 0 )
                                    @foreach( $readinesssection as $item )                                    
                                    @php
                                        $_participategroup = $participategroup->where('readiness_section_id',$item->readiness_section_id)->count();
                                        $totaltarget += $item->projectreadinesstarget;
                                        $totalactualparticipate += $_participategroup ;
                                        $totalbudget += $item->projectbudget;
                                        $totalpayment += $item->actualexpense;
                                    @endphp
                                  
                                        <tr>
                                            <td >{{ $item->adddate }}</td>
                                            <td >{{ $item->projectreadinessname }}</td>                                            
                                            <td  class="text-center">{{  $item->projectreadinesstarget }}</td>  
                                            <td  class="text-center"> {{ $_participategroup }}</td>
                                            <td  class="text-center"> {{ $item->projectbudget }}</td>
                                            <td  class="text-center"> {{ $item->actualexpense }}</td>
                                            <td class="text-right">
                                                <a href="{{ url('report/occupation/section/participate/'.$item->readiness_section_id) }}" class="btn btn-success btn-xs" >ผู้เข้าร่วม</a>
                                                <a href="{{ url('report/occupation/section/pdf/'.$item->readiness_section_id) }}" class="btn btn-info btn-xs" >ดาวน์โหลด</a>
                                            </td>                                               
                                        </tr> 
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="2" ><strong>สรุปรายการ</strong> </td>                                        
                                    <td class="text-center"><strong>{{ $totaltarget }}</strong> </td>                                             
                                    <td class="text-center"><strong>{{ $totalactualparticipate }}</strong> </td>   
                                    <td class="text-center"><strong>{{  number_format( $totalbudget , 2 ) }}</strong> </td>   
                                    <td class="text-center"><strong>{{  number_format( $totalpayment , 2 )}}</strong> </td>   
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

@stop