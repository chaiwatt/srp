@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('recurit/assesment') }}">ผลการประเมินบุคลิกภาพ</a></li>
        <li>ผลการประเมินบุคลิกภาพ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                    ผลการประเมินบุคลิกภาพ : 
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <a href="{{ url('recurit/report/main/assessment/excel') }}" class="btn btn-info">Excel</a>
                <a href="{{ url('recurit/report/main/assessment/pdf') }}" class="btn btn-warning">PDF</a>
                {{-- <a href="{{ url('recurit/report/department/assessment/word') }}" class="btn btn-success">WORD</a> --}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> ผลการประเมินบุคลิกภาพ </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md">
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
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th  style="font-size:20px " rowspan="2" >หน่วยงาน</th>
                                    <th  style="font-size:20px " rowspan="2" >จำนวนผู้ทดสอบ</th>
                                    <th  style="font-size:20px " rowspan="2" >คะแนนเฉลี่ย</th>
                                    <th  style="font-size:20px " colspan="2" class="text-center">ความต้องการ</th>
                                    <th  style="font-size:20px " colspan="2" class="text-center">การให้การอบรม</th>
                                    <th  style="font-size:20px " rowspan="2" class="text-center">การมอบหมายงาน</th>
                                </tr>
                                <tr>
                                    <th  style="font-size:20px " >อาชีพ</th>
                                    <th  style="font-size:20px " >การศึกษา</th>
                                    <th  style="font-size:20px " >อาชีพ</th>
                                    <th  style="font-size:20px " >การศึกษา</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $totalnum=0;
                                $totaloccupationneedfit=0;
                                $totaleducationneedfit=0;
                                $totaloccupationtrainfit=0;
                                $totaleducationtrainfit=0;
                                $totaljobassignmentfit=0;
                                $totalavgscore=0;
                            @endphp
                                @if( count($department) > 0 )
                                @foreach( $department as $key => $item )
                                    <tr>
                                        <td>{{ $item->departmentname }}</td>
                                         @php
                                            $num = $uniquessesmentfit->where('department_id',$item->department_id)
                                            ->count();
                                            $allscore = $uniquessesment->where('department_id',$item->department_id)
                                            ->sum('register_assessment_point');
                                            $total = $uniquessesment->where('department_id',$item->department_id)->count();
                                            $scoreavg = number_format( ($allscore / $total) , 2);
                                            $occupationneedfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('registeroccupationneedfit',1)
                                            ->count();
                                            $educationneedfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('registereducationneedfit',1)
                                            ->count();

                                            $occupationtrainfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('registeroccupationtrainfit',1)
                                            ->count();
                                            $educationtrainfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('registereducationtrainfit',1)
                                            ->count();
                                            $jobassignmentfit = $uniquessesmentfit->where('department_id',$item->department_id)->where('jobassignmentfit',1)
                                            ->count();
                                            $totalnum +=$num;
                                            $totaloccupationneedfit += $occupationneedfit;
                                            $totaleducationneedfit += $educationneedfit ;
                                            $totaloccupationtrainfit += $occupationtrainfit ;
                                            $totaleducationtrainfit += $educationtrainfit;
                                            $totaljobassignmentfit +=$jobassignmentfit;
                                            $totalavgscore += $scoreavg;
                                        @endphp
                                        <td >{{ $num }}</td>
                                        <td >{{ $scoreavg }}</td>
                                       <td >{{ $occupationneedfit }}</td>
                                        <td >{{ $educationneedfit }}</td>
                                        <td >{{ $occupationtrainfit }}</td>
                                        <td >{{ $educationtrainfit }}</td>
                                        <td class="text-center">{{ $jobassignmentfit }}</td> 
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" ><strong>สรุปรายการ</strong> </td>
                                    <td ><strong>{{ $totalnum }}</strong> </td>
                                    @if (count($department) > 0 )
                                    <td ><strong>{{ number_format( $totalavgscore/count($department), 2 ) }}</strong> </td>
                                        @else
                                    <td ><strong>0</strong> </td>
                                    @endif
                                    <td ><strong>{{ $totaloccupationneedfit }}</strong> </td>
                                    <td><strong>{{ $totaleducationneedfit }}</strong></td>
                                    <td><strong>{{ $totaloccupationtrainfit }}</strong></td>
                                    <td><strong>{{ $totaleducationtrainfit }}</strong></td>
                                    <td class="text-center"><strong>{{ $totaljobassignmentfit }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('pageScript')
<script type="text/javascript">
</script>
@stop