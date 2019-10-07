@extends('layout.pdf')

@section('pageCss')
{{-- <style>
		a th, tr, td {
			color: #000;
            font-size: 14px;
		}
		a th, tr, td :hover {
			color: #000;
		}
		form {
		}
		p {
			font-size: 14px;
		}

		p span{
			font-size: 14px;
		}
</style> --}}
@stop

@section('pdfcontent')
	<div class="container" style="max-width:1000px; ">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปรายการติดตามความก้าวหน้า</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>ภายใต้งบประมาณโครงการคืนคนดีสู่สังคม ประจำปีงบประมาณ พ.ศ. {{ $setting->setting_year }}</h1>
		</div>
		<div class="txt01 txt-center">
			<h1>{{ $header }}</h1>
        </div>
        <div class="txt01 txt-center">
            <h1>************************************</h1>
        </div>
        	
        <table style="table-layout:fixed; width:100%;page-break-inside: auto; " >	
            <thead>
                <tr>
                    <th style="width:21%;">ชื่อกิจกรรม</th>
                    <th style="width:10%;">จังหวัดที่ติดตาม</th>
                    <th style="width:25%;">หน่วยงาน</th>
                    <th style="width:30%">จำนวนผู้ได้รับจ้างงาน</th>
                    <th style="width:7%" class="text-center">ผู้สอนงาน</th>
                    <th style="width:7%" class="text-center">ผู้บริหาร</th>
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
                        <td style="word-break:break-all; word-wrap:break-word;">{{ $projectfollowup->project_followup_name }}</td>
                        <td style="word-break:break-all; word-wrap:break-word;">{{ substr_replace($province, "", -1) }}</td>
                        <td style="word-break:break-all; word-wrap:break-word;">{{ substr_replace($section, "", -1) }}</td>
                        <td style="word-break:break-all; word-wrap:break-word;">{{ substr_replace($_employ, "", -1) }}</td>
                        <td class="text-center">{{ $followupinterview->where('interviewee_type',1)->count() }}</td>
                        <td class="text-center">{{ $followupinterview->where('interviewee_type',2)->count() }}</td>
                    </tr>
            </tbody>
        </table>


        <div style="page-break-before: always;" class="txt01">  
            <h1> ข้อมูลการติดตาม </h1>             
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