<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=1252">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<style type="text/css">

		@font-face {
	      font-family: 'THSarabunNew';
	      font-style: normal;
	      font-weight: normal;
	      src: url("{{ asset('fonts/THSarabunNew.ttf') }}") format('truetype');
	    }
	    @font-face {
	      font-family: 'THSarabunNew';
	      font-style: normal;
	      font-weight: bold;
	      src: url("{{ asset('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
	    }
	    @font-face {
	      font-family: 'THSarabunNew';
	      font-style: italic;
	      font-weight: normal;
	      src: url("{{ asset('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
	    }
	    @font-face {
	      font-family: 'THSarabunNew';
	      font-style: italic;
	      font-weight: bold;
	      src: url("{{ asset('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
	    }
		body {
			margin-top: -20px;
			padding: 0;
			line-height: normal;
			background: #fff;
			font-family: "THSarabunNew";
		}
		* {
			box-sizing: border-box;
		}
		*:active, *:focus {
			outline: none;
		}

		p, table, tr, th {
			margin: 0;
			padding: 0;
			border: 1;
			font-size: 100%;
			vertical-align: baseline;
			/*text-align:justify;*/
		}

		h1, h2, h3 {
			font-weight: normal;
			margin: 0;
		}
		a th, tr, td {
			color: #000;
		}
		a th, tr, td :hover {
			color: #000;
		}
		form {
		}
		p {
			font-size: 21px;
            padding-top: -5;
		}

		p span{
			font-size: 21px;
		}


		.red{
			color: red;
			 text-decoration-line: line-through;
		}
		img {
			vertical-align: middle;
		}
		.clear {
			clear: both;
		}
		#wrapper {
			width: 100%;
			margin: 0;
			padding: 0;
		}
		#header {
			width: 100%;
			margin: 0;
			padding: 0;
			border-bottom: 1px solid #dfdddd;
		}

		
		.container {
			max-width: 718px;
			max-height: 930px;
			margin: 0 auto;
			padding: 0;
			overflow: hidden;
		}

		.pdr-10rem{
			padding-right: 10rem;
		}
		.txt01 h1{
			font-size: 24px;
			font-weight: bold;
		}

		.txt-center{
			text-align: center;
		}

		.txt-right{
			text-align: right;
		}

		.txt-left{
			text-align: left;
		}

		.text-indent{
			    text-indent: 6rem;
		}

		.text-indent3 {
		    text-indent: 3rem;
		}

		.text-indent8 {
		    text-indent: 8rem;
		}
		.bold{
			font-weight: bold;
		}
		.u{
			text-decoration-line: underline; 
		}

		.box{
			position: relative;
		}
		.border{
			border: 1px solid #000;
			width: 100px;
			height: 120px;
			position: absolute;
			right: 0;
			top: 0;
		}
		.tableborder{
			border: 1px solid #000;
		}
		.page-break {
		    page-break-after: always;
		}

		.spacetab { 
			display:inline-block; margin-left: 50px; 
		}
		.officerbox{
			border: 1px solid #000;
			position: relative;
			width: 100%;
			height: 330px;
			margin-left: 5px;
		}
		table {
			border: 0.01em solid #000000;
			border-collapse: collapse;
		}
		/* table td,
		table th,table tr {
			border: 0.01em solid #000000;
			font-size: 21px;
			padding-bottom: 5px;
			line-height:18px;
			padding-left:5px;
		} */
	
		table td,table th,table tr {
			border: 0.01em solid #000000;
			font-size: 21px;
			padding-bottom: 5px;
			line-height:18px;
			padding-left:5px;
		}
		table th {
			line-height:20px;
		}
	</style>
</head>

<body>
	<div id="wrapper">
		<div class="container">
			<center><img src="{{ asset('assets/pdf/logo.png') }}" width="15%"></center>
			<div class="box">
				<div class="border">
					
					<img src="{{ asset($contractor->picture) }}" width="100%" height="100%" >
				</div>
			</div>

			<div class="txt01 txt-center">
                <span style="font-size:22px"><strong>แบบใบสมัครงานจ้างเหมาบุคลากรช่วยปฏิบัติงานโครงการคืนคนดีสู่สังคม</strong></span>
			</div>
			<div class="txt01 txt-left">
                    <p style="padding-bottom: -80px ; line-height: 130% ;"><span style="display: inline-block; margin-left: 80px">{{$contractor->sectionname}}</span>  </p>
					<span style="font-size:22px"><strong>หน่วยงาน...........................................................................</strong></span>
			</div>
			<div class="txt01 txt-left">
                    <p style="padding-bottom: -80px; line-height: 130% ;"><span style="display: inline-block; margin-left: 80px">{{$contractor->departmentname}}</span>  </p>
					<span style="font-size:22px"><strong>สังกัดกรม...........................................................................</strong></span>
            </div>
            <div class="txt01 txt-right" >
					<p style="position: absolute; left: 580px; top: 210px;">{{$contractor->contract_no}}</p>
                    <span style="font-size:22px"><strong>เลขที่ใบสมัคร...........................................</strong></span>
			</div>
			
			<div style="height:20px"></div>
			
			<p style="position: absolute; left: 70px; top: 262px;">{{$contractor->positionname}}</p>
			{{-- <p style="position: absolute; left: 350px; top: 262px;">{{$contractor->career}}</p>
			<p style="position: absolute; left: 600px; top: 262px;">{{$contractor->career_future}}</p> --}}
			<p>ตำแหน่ง .................................................. ต้องการฝึกอบรม ............................................ อาชีพที่ต้องการ ........................................</p>
            <div class="txt01 txt-left">
                    <span style="font-size:22px"><strong>1.ข้อมูลส่วนตัว</strong></span>
                </div>
            
			<p style="position: absolute; left: 120px; top: 330px;">{{$contractor->prefixname}}{{$contractor->name}} {{$contractor->lastname}}</p>
			<p style="position: absolute; left: 520px; top: 330px;">{{$contractor->person_id}}</p>
			<p>ชื่อ-นามสกุล ........................................................................ เลขบัตรประจำตัวประชาชน....................................................................</p>
			<p style="position: absolute; left: 130px; top: 361px;">{{$contractor->thaibirthdate}}</p>
			<p style="position: absolute; left: 372px; top: 361px;">{{$contractor->ageyear}}</p>
			<p style="position: absolute; left: 450px; top: 361px;">{{$contractor->agemonth}}</p>
			<p style="position: absolute; left: 610px; top: 361px;">{{$contractor->married}}</p>
			<p>วัน/เดือน/ปี เกิด ............................................................ อายุ....................ปี ..................เดือน สถานะภาพ .......................................</p>
			<p style="position: absolute; left: 130px; top: 391px;">{{$contractor->nationality}}</p>
			<p style="position: absolute; left: 350px; top: 391px;">{{$contractor->ethnicity}}</p>
			<p style="position: absolute; left: 580px; top: 391px;">{{$contractor->religion}}</p>
			<p>สัญชาติ ......................................................... เชื้อชาติ .............................................. ศาสนา .............................................................</p>
			<p style="position: absolute; left: 170px; top: 421px;">{{$contractor->father_name}} {{$contractor->father_lastname}}</p>
			<p style="position: absolute; left: 540px; top: 421px;">{{$contractor->father_career}}</p>
			<p>ชื่อ-นามสกุล บิดา ...................................................................................................... อาชีพ ...............................................................</p>
			<p style="position: absolute; left: 170px; top: 450px;">{{$contractor->mother_name}} {{$contractor->mother_lastname}}</p>
			<p style="position: absolute; left: 540px; top: 450px;">{{$contractor->mother_career}}</p>
			<p>ชื่อ-นามสกุล มารดา .................................................................................................. อาชีพ ...............................................................</p>
			<p style="position: absolute; left: 170px; top: 481px;">{{$contractor->spouse_name}} {{$contractor->spouse_lastname}}</p>
			<p style="position: absolute; left: 540px; top: 481px;">{{$contractor->spouse_career}}</p>
			<p>ชื่อ-นามสกุล คู่สมรส ................................................................................................. อาชีพ ...............................................................</p>
            <div class="txt01 txt-left">
                    <span style="font-size:22px"><strong>ที่อยู่ตามสำเนาทะเบียนบ้าน</strong></span>
                </div>
				<p style="position: absolute; left: 120px; top: 550px;">{{$contractor->address}}</p>
				<p style="position: absolute; left: 340px; top: 550px;">{{$contractor->moo}}</p>
				<p style="position: absolute; left: 550px; top: 550px;">{{$contractor->soi}}</p>
                <p>บ้านเลขที่ .................................................... หมู่ที่ ......................................................... ถนน/ซอย ....................................................</p>
				<p style="position: absolute; left: 100px; top: 581px;">{{$contractor->districtname}}</p>
				<p style="position: absolute; left: 330px; top: 581px;">{{$contractor->amphurname}}</p>
				<p style="position: absolute; left: 550px; top: 581px;">{{$contractor->provincename}}</p>
                <p>ตำบล/แขวง ................................................ อำเภอ/เขต ............................................... จังหวัด ........................................................</p>
				<p style="position: absolute; left: 120px; top: 611px;">{{$contractor->postalcode}}</p>
				<p style="position: absolute; left: 270px; top: 611px;">{{$contractor->email}}</p>
				<p style="position: absolute; left: 550px; top: 611px;">{{$contractor->phone}}</p>
                <p>รหัสไปรษณีย์ ..................................... อีเมลล์  ................................................................ มือถือ .........................................................</p>
                <div class="txt01 txt-left">
                    <span style="font-size:22px"><strong>ที่อยู่ปัจจุบันที่ติดต่อสะดวก</strong></span>
				</div>
				<p style="position: absolute; left: 130px; top: 680px;">{{$contractor->address_now}}</p>
				<p style="position: absolute; left: 350px; top: 680px;">{{$contractor->moo_now}}</p>
				<p style="position: absolute; left: 550px; top: 680px;">{{$contractor->soi_now}}</p>
                <p>บ้านเลขที่ .................................................... หมู่ที่ .......................................................... ถนน/ซอย ...................................................</p>
				<p style="position: absolute; left: 100px; top: 710px;">{{$contractor->districtnowname}}</p>
				<p style="position: absolute; left: 330px; top: 710px;">{{$contractor->amphurnowname}}</p>
				<p style="position: absolute; left: 550px; top: 710px;">{{$contractor->provincenowname}}</p>
                <p>ตำบล/แขวง ................................................. อำเภอ/เขต ............................................... จังหวัด ........................................................</p>
                <p style="position: absolute; left: 130px; top: 741px;">{{$contractor->postalcode_now}}</p>
                <p>รหัสไปรษณีย์ .............................................. </p>
            
				<p style="position: absolute; left: 150px; top: 809px;">{{$contractor->urgent_name}} {{$contractor->urgent_lastname}}</p>
				<p style="position: absolute; left: 550px; top: 809px;">{{$contractor->urgent_relationship}}</p>
			
				<div class="txt01 txt-left">
						<span style="font-size:22px"><strong>บุคคลที่ติดต่อได้ในกรณีเร่งด่วน</strong></span>
					</div>
				<p>ชื่อ-นามสกุล ............................................................................................ความสัมพันธ์ .......................................................................</p>
			<p style="position: absolute; left: 150px; top: 839px;">{{$contractor->urgent_phone}}</p>
			<p style="position: absolute; left: 400px; top: 839px;">{{$contractor->urgent_email}}</p>
			<p>โทรศัพท์มือถือ ...................................................................อีเมลล์ .......................................................................................................</p>
			
		</div>

		<div class="page-break"></div>

		{{-- <div class="container">
			<div class="txt01 txt-left">
				<span style="font-size:22px"><strong>2.ประวัติการศึกษา</strong></span>
			</div>	
			<table style="width:100% ; margin-top: 10px;">
				<tr>
					<th>ปี พ.ศ. ตั้งแต่-ถึง</th>
					<th>ระดับการศึกษา</th> 
					<th>สถานศึกษา</th>
				</tr>
				<tr>
					@php
						$studyyear = $education->where('education_id',1)->first()->contractor_education_year;
						$school = $education->where('education_id',1)->first()->contractor_education_name;
					@endphp
					<td style="height: 23px">{{$studyyear}}</td>
					<td style="height: 23px">ประถมศึกษา</td> 
					<td style="height: 23px">{{$school}}</td>
				</tr>
				<tr>
					@php
						$studyyear = $education->where('education_id',2)->first()->contractor_education_year;
						$school = $education->where('education_id',2)->first()->contractor_education_name;
					@endphp
					<td style="height: 23px">{{$studyyear}}</td>
					<td style="height: 23px">มัธยมศึกษาตอนต้น</td> 
					<td style="height: 23px">{{$school}}</td>
				</tr>
				<tr>
					@php
						$studyyear = $education->where('education_id',3)->first()->contractor_education_year;
						$school = $education->where('education_id',3)->first()->contractor_education_name;
					@endphp					
					<td style="height: 23px">{{$studyyear}}</td>
					<td style="height: 23px">มัธยมศึกษาตอนปลาย</td> 
					<td style="height: 23px">{{$school}}</td>
				</tr>
				<tr>
					@php
						$studyyear = $education->where('education_id',4)->first()->contractor_education_year;
						$school = $education->where('education_id',4)->first()->contractor_education_name;
					@endphp	
					<td style="height: 23px">{{$studyyear}}</td>
					<td style="height: 23px">ประกาศนียบัตรวิชาชีพ (ปวช.)</td> 
					<td style="height: 23px">{{$school}}</td>
				</tr>
				<tr>
					@php
						$studyyear = $education->where('education_id',5)->first()->contractor_education_year;
						$school = $education->where('education_id',5)->first()->contractor_education_name;
					@endphp	
					<td style="height: 23px">{{$studyyear}}</td>
					<td style="height: 23px">ประกาศนียบัตรวิชาชีพชั้นสูง (ปวส.)</td> 
					<td style="height: 23px">{{$school}}</td>
				</tr>
				<tr>
					@php
						$studyyear = $education->where('education_id',6)->first()->contractor_education_year;
						$school = $education->where('education_id',6)->first()->contractor_education_name;
					@endphp	
					<td style="height: 23px">{{$studyyear}}</td>
					<td style="height: 23px">ปริญญาตรี</td> 
					<td style="height: 23px">{{$school}}</td>
				</tr>
				<tr>
					@php
						$studyyear = $education->where('education_id',7)->first()->contractor_education_year;
						$school = $education->where('education_id',7)->first()->contractor_education_name;
					@endphp	
					<td style="height: 23px">{{$studyyear}}</td>
					<td style="height: 23px">สูงกว่าปริญญาตรี</td> 
					<td style="height: 23px">{{$school}}</td>
				</tr>
			</table>

		</div> --}}
		
		<div class="container">
				<div class="txt01 txt-left">
					<span style="font-size:22px"><strong>2.ประวัติการศึกษา</strong></span>
				</div>	
				<table style="width:100% ; margin-top: 10px;">
					<tr>
						<th>ปี พ.ศ. ตั้งแต่-ถึง</th>
						<th>ระดับการศึกษา</th> 
						<th>สถานศึกษา</th>
					</tr>
					<tr>
						@php
							
							$studyyear = $education->where('education_id',1)->first();
							$school = $education->where('education_id',1)->first();
						@endphp
						<td style="height: 23px">@if (count($studyyear) !=0 ) {{$studyyear->contractor_education_year}} @endif </td>
						<td style="height: 23px">ประถมศึกษา</td> 
						<td style="height: 23px">@if (count($school) !=0 ) {{$school->contractor_education_name}} @endif</td>
					</tr>
					<tr>
						@php
							$studyyear = $education->where('education_id',2)->first();
							$school = $education->where('education_id',2)->first();
						@endphp
						<td style="height: 23px">@if (count($studyyear) !=0 ) {{$studyyear->contractor_education_year}} @endif </td>
						<td style="height: 23px">มัธยมศึกษาตอนต้น</td> 
						<td style="height: 23px">@if (count($school) !=0 ) {{$school->contractor_education_name}} @endif</td>
					</tr>
					<tr>
						@php
							$studyyear = $education->where('education_id',3)->first();
							$school = $education->where('education_id',3)->first();
						@endphp					
						<td style="height: 23px">@if (count($studyyear) !=0 ) {{$studyyear->contractor_education_year}} @endif </td>
						<td style="height: 23px">มัธยมศึกษาตอนปลาย</td> 
						<td style="height: 23px">@if (count($school) !=0 ) {{$school->contractor_education_name}} @endif</td>
					</tr>
					<tr>
						@php
							$studyyear = $education->where('education_id',4)->first();
							$school = $education->where('education_id',4)->first();
						@endphp	
						<td style="height: 23px">@if (count($studyyear) !=0 ) {{$studyyear->contractor_education_year}} @endif </td>
						<td style="height: 23px">ประกาศนียบัตรวิชาชีพ (ปวช.)</td> 
						<td style="height: 23px">@if (count($school) !=0 ) {{$school->contractor_education_name}} @endif</td>
					</tr>
					<tr>
						@php
							$studyyear = $education->where('education_id',5)->first();
							$school = $education->where('education_id',5)->first();
						@endphp	
						<td style="height: 23px">@if (count($studyyear) !=0 ) {{$studyyear->contractor_education_year}} @endif </td>
						<td style="height: 23px">ประกาศนียบัตรวิชาชีพชั้นสูง (ปวส.)</td> 
						<td style="height: 23px">@if (count($school) !=0 ) {{$school->contractor_education_name}} @endif</td>
					</tr>
					<tr>
						@php
							$studyyear = $education->where('education_id',6)->first();
							$school = $education->where('education_id',6)->first();
						@endphp	
						<td style="height: 23px">@if (count($studyyear) !=0 ) {{$studyyear->contractor_education_year}} @endif </td>
						<td style="height: 23px">ปริญญาตรี</td> 
						<td style="height: 23px">@if (count($school) !=0 ) {{$school->contractor_education_name}} @endif</td>
					</tr>
					<tr>
						@php
							$studyyear = $education->where('education_id',7)->first();
							$school = $education->where('education_id',7)->first();
						@endphp	
						<td style="height: 23px">@if (count($studyyear) !=0 ) {{$studyyear->contractor_education_year}} @endif </td>
						<td style="height: 23px">สูงกว่าปริญญาตรี</td> 
						<td style="height: 23px">@if (count($school) !=0 ) {{$school->contractor_education_name}} @endif</td>
					</tr>
				</table>
			</div>
			
		<div class="container">
			<div class="txt01 txt-left">
					<span style="font-size:22px"><strong>3.ความรู้ ความสามารถ</strong></span>
			</div>	
				@php
					$word = $contractorsoftware->where('software_id',1)->first();
					$excel = $contractorsoftware->where('software_id',2)->first();
					$powerpoint = $contractorsoftware->where('software_id',3)->first();
					$access = $contractorsoftware->where('software_id',4)->first();

					$drivelic = $contractorskill->where('skill_id',1)->first();
					$ridelic = $contractorskill->where('skill_id',2)->first();
					$typing = $contractorskill->where('skill_id',3)->first();
					$englishknow = $contractorskill->where('skill_id',4)->first();

				@endphp
		
				<p style="margin-top:10px">ความรู้ความสามารถด้านคอมพิวเตอร์<input style="margin-top:5px; margin-left:40px" type="checkbox" name="newhire" @if (count($word) !=0 ) checked @endif > Ms-Word <input style="margin-top:5px ; margin-left:10px" type="checkbox" name="newhire" @if (count($excel) !=0 ) checked @endif> Ms-Excel <input style="margin-top:5px ; margin-left:10px" type="checkbox" name="newhire" @if (count($powerpoint) !=0 ) checked @endif > Ms-Power Point <input style="margin-top:5px ; margin-left:10px" type="checkbox" name="newhire" @if (count($access) !=0 ) checked @endif > Ms-Access  </p>
				{{-- <p style="position: absolute; left: 130px; top: 568px;">{{$contractor->software_about}}</p> --}}
				<p style="padding-bottom: -60px;line-height:110%"><span style="display: inline-block; margin-left: 150px">{{$contractor->software_about}}</span>  </p>
                <p>โปรแกรมอื่นๆ .........................................................................................................................................................................................</p>
				<p>ความรู้ความสามารถพิเศษ<input style="margin-top:5px; margin-left:40px" type="checkbox" name="newhire" @if (count($drivelic) !=0 ) checked @endif  >ขับรถยนต์ได้และมีใบขับขี่<input style="margin-top:5px ; margin-left:30px" type="checkbox" name="newhire"  @if (count($ridelic) !=0 ) checked @endif >ขับรถมอเตอร์ไซด์ได้และมีใบขับขี่</p>
				<p> <input style="margin-top:5px; margin-left:182px" type="checkbox" name="newhire" @if (count($typing) !=0 ) checked @endif >พิมพ์ดีด<input style="margin-top:5px ; margin-left:127px" type="checkbox" name="newhire" @if (count($englishknow) !=0 ) checked @endif>มีความรู้ด้านภาษาอังกฤษ</p>
				<p style="padding-bottom: -60px;line-height:110%"><span style="display: inline-block; margin-left: 200px">{{$contractor->skill_about}}</span>  </p>
				<p>ความรู้ความสามารถด้านอื่นๆ.................................................................................................................................................................</p>
				
		</div>
		<div class="container">
				<div class="txt01 txt-left">
				<span style="font-size:22px"><strong>4.ประสบการณ์การทำงาน</strong></span>
				</div>	
					<table style="width:100% ; margin-top: 10px;">
						<tr>
							<th style="width:120px">วดป. ที่เข้า-ออก</th>
							<th>บริษัท/องค์กร</th> 
							<th>ตำแหน่ง</th>
							<th>ลักษณะงาน</th> 
							<th>สาเหตุที่ออก</th>
						</tr>

						@if( count($contractorexperience) > 0 )
							@foreach( $contractorexperience as $item )
								<tr>
									<td style="height: 23px">{{$item->datestartshort}} - {{$item->dateendshort}}</td>
									<td style="height: 23px">{{$item->contractor_experience_company}}</td>
									<td style="height: 23px">{{$item->contractor_experience_position}}</td>
									<td style="height: 23px">{{$item->contractor_experience_description}}</td>
									<td style="height: 23px">{{$item->contractor_experience_resign}}</td>
								</tr>
							@endforeach
						@endif
						@php
							$_count = 5-count($contractorexperience);
							for ($x = 0; $x < $_count ; $x++) {
								echo "<tr><td style='height: 23px'><td style='height: 23px'><td style='height: 23px'></td><td style='height: 23px'></td><td style='height: 23px'></td></tr>";
							}
						@endphp		
		
					</table>
				</div>	
			
				<div class="page-break"></div>

				@if ($contractor->department_id == 1 || $contractor->department_id == 2)
	
					<p>ทั้งนี้ได้แนบหลักฐานต่างๆ ซึ่งได้ลงชื่อรับรองสำเนาถูกต้องแล้วมาพร้อมกับใบสมัคร รวม...................................ฉบับ ประกอบด้วย</p>
					
					<p> <input style="margin-top:5px" type="checkbox" name="newhire" >สำเนาบัตรประจำตัวประชาชน<input style="margin-top:5px ; margin-left:50px" type="checkbox" name="newhire" >สำเนาทะเบียนบ้าน <input style="margin-top:5px ; margin-left:35px" type="checkbox" name="newhire" >สำเนาระเบียนแสดงผลการศึกษา (Transcrip) </p>
					<p> <input style="margin-top:5px" type="checkbox" name="newhire" >รูปถ่าย<input style="margin-top:5px ; margin-left:120px" type="checkbox" name="newhire" >เอกสารที่ผ่านการเกณฑ์ทหาร <input style="margin-top:5px ; margin-left:43px" type="checkbox" name="newhire" >ประกาศนียบัตร <input style="margin-top:5px ; margin-left:45px" type="checkbox" name="newhire" >อื่นๆ โปรดระบุ</p>
					<p>..............................................................................................................................................................................................................</p>
					
					<p>..............................................................................................................................................................................................................</p>	<p style="margin-left: 20px">ข้าพเจ้า ขอให้คำรับรองว่า ข้อความดังกล่าวข้างต้นเป็นจริงทุกประการ</p>
					<p style="position: absolute; left: 520px; top: 209px;">{{$contractor->prefixname}}{{$contractor->name}} {{$contractor->lastname}}</p>
					<p style="margin-left: 450px;">ลงชื่อ..................................................ผู้สมัคร</p>
					<p style="margin-left: 450px;">(....................................................................)</p>
					<p style="margin-left: 450px;">วันที่สมัคร................/..................../...............</p>
					
					<div style="height:25px"></div>
					<div style="border: 1px solid #000;border-collapse: collapse;">
						<p class="bold" style="margin-left: 5px; ">สำหรับเจ้าหน้าที่</p>
						<div style="height:25px"></div>
						<p style="position: absolute; left: 130px; top: 350px;">{{$contractor->sectionname}}</p>
						<p style="position: absolute; left: 480px; top: 350px;">{{$contractor->departmentname}}</p>
						<p style="margin-left: 20px">ชื่อหน่วยงาน ..................................................................................สังกัด .....................................................................</p>
						<p style="position: absolute; left: 480px; top: 380px;">{{$contractor->positionname}}</p>
						<p style="margin-left: 20px">ได้จ้าง .............................................................................................ตำแหน่ง ................................................................</p>
						
						<p style="margin-left: 20px">เริ่มจ้างวันที่ ..................................................................................สถานะการจ้างงาน <input style="margin-top:5px" type="checkbox" name="newhire" > จ้างใหม่ <input style="margin-top:5px ; marggin-left:15px" type="checkbox" name="newhire" > ต่อสัญญา</p>
						<div style="height:15px"></div>
						<p style="margin-left: 20px; margin-buttom:30px">วันที่สิ้นสุดการจ้างงาน ..................................................................................................................................................</p>
					<p style="margin-left: 20px">ได้ตรวจสอบคุณสมบัติและหลักฐานประกอบการสมัครครบถ้วนแล้ว</p>

					<p style="margin-left: 450px;">ลงชื่อ..........................................................</p>
					<p style="margin-left: 450px;">(.................................................................)</p>
					<p style="margin-left: 450px;">ตำแหน่ง......................................................</p>
					</div>
				@elseif($contractor->department_id == 3)
					<div style="height:25px"></div>
					<div style="border: 1px solid #000;border-collapse: collapse;">
						<p class="bold" style="margin-left: 5px; ">สำหรับเจ้าหน้าที่</p>
						<div style="height:25px"></div>
						<p style="padding-bottom: -80px; line-height:110%"><span style="display: inline-block; margin-left: 320px">{{$contractor->sectionname}}</span> </p>
						<p style="margin-left: 20px">ความเห็นของคณะกรรม(ของสถานพินิจ/ศูนย์ฝึก).........................................................................................................</p>
						<p style="padding-bottom: -80px; line-height:110%"><span style="display: inline-block; margin-left: 170px">{{$contractor->positionname}}</span> </p>
						<p> <input style="margin-top:5px;margin-left: 20px" type="checkbox" name="newhire" >เห็นชอบในตำแหน่ง....................................................มอบหมายให้ปฏิบัติหน้าที่......................................................</p>
						<p style="margin-left: 20px">เพราะ ............................................................................................................................................................................</p>
						<p> <input style="margin-top:5px;margin-left: 20px" type="checkbox" name="newhire" >ไม่เห็นชอบ เนื่องจาก.................................................................................................................................................</p>
						<div style="height:25px"></div>
						
						<p style="padding-bottom: 0px;"><span style="display: inline-block; margin-left: 50px">ลงชื่อ..........................................................</span> <span style="display: inline-block; margin-left: 100px">ลงชื่อ..........................................................</span> </p>
						<p><span style="display: inline-block; margin-left: 50px">(.................................................................)</span> <span style="display: inline-block; margin-left: 105px">(................................................................)</span>  </p>
						<p><span style="display: inline-block; margin-left: 50px;margin-top:-3px">ตำแหน่ง......................................................</span> <span style="display: inline-block; margin-left: 102px;margin-top:-3px">ตำแหน่ง......................................................</span></p>
						<div style="height:25px"></div>
						<p style="padding-bottom: 0px;"><span style="display: inline-block; margin-left: 50px">ลงชื่อ..........................................................</span> <span style="display: inline-block; margin-left: 100px">ลงชื่อ..........................................................</span> </p>
						<p><span style="display: inline-block; margin-left: 50px">(.................................................................)</span> <span style="display: inline-block; margin-left: 105px">(................................................................)</span>  </p>
						<p><span style="display: inline-block; margin-left: 50px;margin-top:-3px ">ตำแหน่ง......................................................</span> <span style="display: inline-block; margin-left: 102px;margin-top:-3px">ตำแหน่ง......................................................</span></p>
						<div style="height:15px"></div>
						<p class="bold" style="margin-left: 5px; ">ความเห็นผู้ปกครอง</p>
						
						<p style="margin-left: 20px"> ให้ความยินยอมให้.................................................................เข้ารับการจ้างงานในตำแหน่ง..........................................</p>
						<p style="margin-left: 20px"> ของ(ของสถานพินิจ/ศูนย์ฝึก).........................................................................................................................................</p>
					

						<p style="margin-left: 440px;">ลงชื่อ...............................................ผู้ปกครอง</p>
						<p style="margin-left: 440px;">(....................................................................)</p>
						<p style="margin-left: 440px;">วันที่สมัคร................/..................../...............</p>
					</div>
				@endif
				
	</div>


</body>

</html>