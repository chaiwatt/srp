@extends('layout.pdf')

@section('pageCss')
<style type="text/css"> 
    p {
        margin: 30;
        padding: 30;
        border: 30;
        font-size: 100%;
        vertical-align: baseline;
        /*text-align:justify;*/
    }
</style>
@stop

@section('pdfcontent')
<div style="line-height: 140%;">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปผลการจัดโครงการฝึกอบรมและเตรียมความพร้อมผู้พ้นโทษ</h1>
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
    </div>
	<div class="container">
        <p style="padding-bottom: -7px;"><span style="display: inline-block; margin-left: 150px">{{ $readiness->project_readiness_name }}</span> </p>
        <p style="line-height: 20%;">๑. ชื่อโครงการ....................................................................................................................................................................</p>
        <p style="padding-bottom: -7px;"><span style="display: inline-block; margin-left: 150px">{{ $readiness->adddate }}</span> </p>
        <p style="line-height: 20%;">๒. วันที่จัดโครงการ.............................................................................................................................................................</p>
        <p style="padding-bottom: -7px;"><span style="display: inline-block; margin-left: 150px">{{ $readiness->sectionname }}</span>                                                 </p>
        <p style="line-height: 20%;">๓. สถานที่จัดโครงการ........................................................................................................................................................</p>
        <p style="line-height: 200%;">๔. ผู้เข้าร่วมโครงการฯ ประกอบด้วย</p>
                
		 <table style="width:100%; margin-top:15px " class="text-center" >				
            <thead>
                <tr>
                    <th class="text-center" style="width:80%;" >โครงการ</th>
                    <th class="text-center" style="width:20%;" >จำนวนเข้าร่วม</th>

                </tr>
            </thead>
            <tbody>
                @if( count($participate) > 0 )
                    @foreach( $participate as $key => $item )
                        @if ($item->participate_num !=0 )
                            <tr>
                                <td class="text-center" >{{ $item->participatename }}</td>
                                <td class="text-center">{{ $item->participate_num  }}</td>
                            </tr>   
                        @endif
                    @endforeach
                @endif
                @if ($numofficer != 0)
                    <td class="text-center" >เจ้าหน้าที่</td>
                    <td class="text-center">{{ $numofficer }}</td>
                @endif
            </tbody>
        </table>
        
        <p style="line-height: 200%;">๕. ชื่อ ตำแหน่งและหน่วยงานของวิทยากรในแต่ละหัวข้อวิชา พร้อมข้อสังเกตที่ได้รับ</p>

        <table style="width:100%; margin-top:15px " class="text-center" >				
            <thead>
                <tr>
                    <th class="text-center" >ชื่อ-สกุล</th>
                    <th class="text-center" >ตำแหน่ง</th>
                    <th class="text-center" >หน่วยงาน</th>
                    <th class="text-center" >หัวข้อวิชา</th>
                    <th class="text-center" >ข้อสังเกตที่ได้</th>

                </tr>
            </thead>
            <tbody>
                @if( count($trainer) > 0 )
                    @foreach( $trainer as $key => $item )
                        <tr>
                            <td class="text-center" >{{ $item->trainer_name }}</td>
                            <td class="text-center">{{ $item->trainer_position  }}</td>
                            <td class="text-center" >{{ $item->company }}</td>
                            <td class="text-center">{{ $item->course  }}</td>
                            <td class="text-center"></td>
                        </tr>   
                    @endforeach
                @endif
            </tbody>
        </table>

        <p style="line-height: 200%;">๖. รายชื่อสถานประกอบการ</p>

        <table style="width:100%; margin-top:15px " class="text-center" >				
            <thead>
                <tr>
                    <th class="text-center" >ที่</th>
                    <th class="text-center" >ชื่อสถานประกอบการ</th>
                </tr>
            </thead>
            <tbody>
                @if( count($company) > 0 )
                    @foreach( $company as $key => $item )
                        <tr>
                            <td class="text-center" >{{ $key + 1 }}</td>
                            <td class="text-center">{{ $item->company_name }}</td>
                        </tr>   
                    @endforeach
                @endif
            </tbody>
        </table>
        
        <p style="line-height: 150%;">๗. ผู้กระทำผิดได้สมัครเข้าร่วมทำงานในสถานประกอบการหรือไม่ (ถ้ามี ระบุชื่อสถานประกอบการ ตำแหน่งที่สมัคร จำนวนรายที่สมัครงาน) หรือสมัครเข้ารับฝึกอบรมอาชีพอิสระหรือไม่/อาชีพที่ประสงค์จะเข้าร่วมฝึกอบรม / หรือประสงค์ศึกษาต่อ (ถ้ามี ระบุ อาชีพที่ประสงค์จะฝึกอบรม จำนวนราย)</p>
        <p style="line-height: 150%;">............................................................................................................................................................................................</p>
        <p style="line-height: 150%;">............................................................................................................................................................................................</p>
        <p style="line-height: 150%;">............................................................................................................................................................................................</p>
        <p style="padding-bottom: -95px;line-height: 130%;"><span style="display: inline-block; margin-left: 150px">{{ $cost->cost }}</span><span style="display: inline-block; margin-left: 150px">{{ $cost->convertcost }}</span>                                                 </p>
        <p >๘. งบประมาณที่ใช้ ............................. บาท (..............................................................................)</p>
        <p >๙. ปัญหา/อุปสรรค </p>
        <p style="width:95%; word-break:break-all; word-wrap:break-word; padding-right:15px; padding-left:15px">{{ $readiness->problemdesc }}</p>
        <p >๑๐. ข้อเสนอแนะ </p>
        <p style="width:95%; word-break:break-all; word-wrap:break-word; padding-right:15px; padding-left:15px">{{ $readiness->recommenddesc }}</p>
        <p >๑๑. อื่นๆ</p>
        <p >............................................................................................................................................................................................</p>
        <p >............................................................................................................................................................................................</p>
        <p >............................................................................................................................................................................................</p>
        
    </div>
    
@stop