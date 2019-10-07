@extends('layout.pdf')

@section('pageCss')
<style>
   .newfontsize {font-size:19px} ;
</style>
@stop

@section('pdfcontent')
	<div class="container" style="max-width:1000px">
		<div class="txt01 txt-center">
			<h1>แบบรายงานรายการประเมิน </h1>
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
            <table class="table table-bordered" style="background-color:white;">
                <thead>
                    <tr>
                        <th rowspan="2" style="font-size:19px; width:150px">สังกัด</th>
                        <th rowspan="2" style="font-size:19px">จำนวนผู้ประเมิน</th>
                        <th colspan="3" style="font-size:19px; width:120px; text-align:center">ผลการประเมิน</th>
                        <th rowspan="2" style="font-size:19px">จำนวนผู้ติดตาม</th>
                        <th colspan="6" style="font-size:19px; width:270px; text-align:center">สถานะผู้ประเมิน</th>
                        <th colspan="2" style="font-size:19px">ต้องการสนับสนุน</th>
                        <th colspan="2" style="font-size:19px">สัมพันธ์ในครอบครัว</th>
                    </tr>
                    <tr>                                   
                        <th style="font-size:18px; text-align:center">ดีเด่น</th>
                        <th style="font-size:18px; text-align:center">ดี</th>
                        <th style="font-size:18px; text-align:center">ปรับปรุง</th>
                        <th style="font-size:18px; text-align:center">มีงาน</th>
                        <th style="font-size:18px; text-align:center">ไม่มีงาน</th>
                        <th style="font-size:18px; text-align:center">ศึกษาต่อ</th>
                        <th style="font-size:18px; text-align:center">ตาย</th>
                        <th style="font-size:18px; text-align:center">ถูกจับ</th>
                        <th style="font-size:18px; text-align:center">ติดตามไม่ได้</th>
                        <th style="font-size:18px; text-align:center">ต้องการ</th>
                        <th style="font-size:18px; text-align:center">ไม่ต้องการ</th>
                        <th style="font-size:18px; text-align:center">ดี</th>
                        <th style="font-size:18px; text-align:center">มีปัญหา</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($department as $item)
                        <td style="font-size:19px">{{$item->departmentname}}</td>
                        <td style="font-size:19px">{{$assessee->count()}}</td>
                        <td style="font-size:19px">{{$assessee->where('score_id',1)->count()}}</td>
                        <td style="font-size:19px">{{$assessee->where('score_id',2)->count()}}</td>
                        <td style="font-size:19px">{{$assessee->where('score_id',3)->count()}}</td>
                        <td style="font-size:19px">{{$assessee->where('follower_status_id','!=',0)->count()}}</td>
                        <td style="font-size:19px">{{$assessee->where('follower_status_id',2)->count()}}</td>
                        <td style="font-size:19px">{{$assessee->where('follower_status_id',3)->count()}}</td>
                        <td style="font-size:19px">{{$assessee->where('follower_status_id',4)->count()}}</td>
                        <td style="font-size:19px">{{$assessee->where('follower_status_id',5)->count()}}</td>
                        <td style="font-size:19px">{{$assessee->where('follower_status_id',6)->count()}}</td>
                        <td style="font-size:19px">{{$assessee->where('follower_status_id',7)->count()}}</td>
                        <td style="font-size:19px">{{$assessee->where('needsupport_id',2)->count()}}</td>
                        <td style="font-size:19px">{{$assessee->where('needsupport_id',3)->count()}}</td>
                        <td style="font-size:19px">{{$assessee->where('familyrelation_id',2)->count()}}</td>
                        <td style="font-size:19px">{{$assessee->where('familyrelation_id',3)->count()}}</td>
                    @endforeach
                </tbody>
            </table>   
	</div>
@stop