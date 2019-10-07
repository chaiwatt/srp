@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายการโครงการ</li>    
    </ul>

    <div class="row">
        <div class="col-sm-9">
            <div class="page-title">
                รายการติดตามความก้าวหน้า: ปีงบประมาณ {{ $project->year_budget}}
            </div>
        </div>
        <div class="col-sm-3">
            <div class="pull-right">
                <a href="{{ url('report/followup/department/onsite/excel/'.$projectfollowup->project_followup_id) }}" class="btn btn-info">Excel</a>
                <a href="{{ url('report/followup/department/onsite/pdf/'.$projectfollowup->project_followup_id) }}" class="btn btn-warning">PDF</a>
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">   

    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> รายการติดตามความก้าวหน้า </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ชื่อกิจกรรม</th>
                                <th>จังหวัดที่ติดตาม</th>
                                <th style="width:300px">หน่วยงาน</th>
                                <th style="width:300px">จำนวนผู้ได้รับจ้างงาน</th>
                                <th class="text-center">จำนวนผู้สอนงาน</th>
                                <th class="text-center">จำนวนผู้บริหาร</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $province="";
                                foreach ($selectedprovince as $p){
                                    $province = $province . $p->province_name . " ,";
                                }
                                $section="";
                                $_employ="";
                                $_readiness="";
                                foreach ($followupsection as $p){
                                    $section = $section . $p->section_name . " ,";
                                    $_employ = $_employ .  $p->section_name ." (". $generate->where('section_id',$p->section_id )->count('register_id') . "คน),";                                    
                                }
                            @endphp
                                <tr>
                                    <td>{{ $projectfollowup->project_followup_name }}</td>
                                    <td>{{ substr_replace($province, "", -1) }}</td>
                                    <td>{{ substr_replace($section, "", -1) }}</td>
                                    <td>{{ substr_replace($_employ, "", -1) }}</td>
                                    <td class="text-center">{{ $followupinterview->where('interviewee_type',1)->count() }}</td>
                                    <td class="text-center">{{ $followupinterview->where('interviewee_type',2)->count() }}</td>
                                </tr>
                        </tbody>
                    </table>

                    {{-- <ul class="pagination pagination-split pull-right">
                        {!! $project->render() !!}
                    </ul> --}}

                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <h3>ข้อมูลการติดตาม</h3>                                       
        <table class="table table-bordered" style="background-color:white;" >
                <thead>
                    <tr>
                        <th rowspan="2">จังหวัด</th>
                        <th rowspan="2">หน่วยงาน</th>
                        <th rowspan="2">ชื่อ-สกุล</th>
                        <th rowspan="2" class="text-center">เลขบัตรประชาชน</th>
                        <th colspan="3" class="text-center">การติดตาม</th>
                    </tr>
                    <tr>
                        <th class="text-center">พึงพอใจในโครงการ</th>
                        <th class="text-center">สถานที่ต้องการทำงาน</th>
                        <th class="text-center">ปัญหาและข้อเสนอแนะ</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($selectedprovince as $key => $item)
                    @php
                        $f=0;
                    @endphp
                        @php
                            $sec = $followupsection->where('map_code', $item->map_code)->pluck('section_id')->toArray();   
                            $num = count($followupregister->whereIn('sectionid',$sec)->all());
                        @endphp
                        @foreach ($followupsection as $t => $v)
                            @php
                                $j=0;
                            $num2 = count($followupregister->where('sectionid',$v->section_id)->all());
                            @endphp
                            @if ($v->map_code == $item->map_code)
                               @php
                                   $check = $followupregister->where('sectionid',$v->section_id)->all();
                               @endphp
                               @foreach ($check as $k => $c)
                                <tr>
                                    @if($f  == 0)
                                        <td  rowspan="{{ $num }}">{{$item->province_name}} </td>  
                                    @endif
                                   
                                    @if($j  == 0)
                                        <td  rowspan="{{ $num2 }}">
                                            {{$v->sectionname}} 
                                            @php
                                                $teacher = $followupinterview->where('interviewee_section',$v->section_id)->where('interviewee_type',1);
                                                $manager = $followupinterview->where('interviewee_section',$v->section_id)->where('interviewee_type',2);
                                            @endphp
                                            <p><small>จำนวนผู้สอนงาน {{ count($teacher)}} คน</small></p>
                                            <p><small>จำนวนผู้บริหาร {{ count($manager)}} คน</small></p>                                                                                     
                                        </td>  
                                    @endif
                                                                
                                    <td >{{$c->registerprefixname}}{{$c->registername}} {{$c->registerlastname}}</td>
                                    <td class="text-center">{{$c->registerpersonid}}</td>
                                    <td class="text-center">{{$c->registersatisfaction}}</td>
                                    <td >{{$c->workon}}</td>
                                    <td >{{$c->problem}}</td>                                                                      
                                </tr>  
                                @php
                                    $f++;
                                    $j++;
                                @endphp  
                               @endforeach
                            @endif
                        @endforeach
                    @endforeach
            </tbody>
        </table> 
    </div>
</div>
@stop

@section('pageScript')
<script type="text/javascript">
    
</script>
@stop