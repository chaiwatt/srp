@extends('layout.pdf')

@section('pageCss')
@stop

@section('pdfcontent')
	<div class="container" style="max-width:960px">
		<div class="txt01 txt-center">
			<h1>แบบรายงานสรุปรายงานฝึกอบรมวิชาชีพ โครงการ{{$readinesssection->projectreadinessname}}</h1>
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
        		
        <table style="table-layout: fixed; width:100%; " >	
                <thead>
                        <tr>
                            <th >ชื่อ-สกุล</th>
                            <th >เลขบัตรประชาชน</th>
                            <th style="width:30%">ที่อยู่/เบอร์โทรศัพท์</th>
                            <th  class="text-center">จบหลักสูตร</th>
                            <th class="text-center">ผลการติดตาม</th>
                            <th  style="width:15%">ข้อเสนอแนะ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach( $participategroup as $key => $item )
                                @php
                                    $_assessment ="ไม่พบข้อมูล";
                                    $_register = $register->where('register_id',$item->register_id)->first();
                                    $check = $participategroup->where('register_id',$item->register_id)->first();
                                    if(!empty($check)){
                                        $_status = $status->where('trainning_status_id',$check->trainning_status_id)->first();
                                    }
                                    $check2 = $personalassessment->where('register_id',$item->register_id)->first();
                                    if(!empty($check2)){
                                        $suggest = $check2->othernote;
                                        $check3 = $followerstatus->where('follower_status_id',$check2->follower_status_id)->first();
                                        if(!empty($check3)){
                                            $_assessment = $check3->follower_status_name ;
                                        }
                                    }else{
                                        $suggest="";
                                    }

                                @endphp
                                @if (!empty($_register))
                                    <tr>
                                        <td >{{ $_register->prefixname . $_register->name . " " . $_register->lastname  }}</td>
                                        <td >{{ $_register->person_id }} </td>
                                        <td >{{ "เลขที่ " . $_register->address .  " หมู่ ". $_register->mood . " ซอย" . $_register->soi . " ตำบล" . $_register->districtname . " อำเภอ" . $_register->amphurname . " จังหวัด" . $_register->provincename . " โทรศัพท์ " . $_register->phone  }} </td>
                                        <td  class="text-center">{{ $_status->trainning_status_name }} </td>
                                        <td  class="text-center">{{ $_assessment }} </td>
                                        <td style="word-break:break-all; word-wrap:break-word;">{{  $suggest }} </td>
                                    </tr>
                                @endif    
                        @endforeach
                        
                    </tbody>
                    {{-- @if( count($participate) > 0 )
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="3">รวม</td>
                                <td class="text-center">{{ $readiness->sum('targetparticipate') }}</td>
                                <td class="text-center">{{ $participate->sum('participate_num') }}</td>
                            </tr>
                        </tfoot>
                    @endif --}}
                </table>
	</div>
@stop