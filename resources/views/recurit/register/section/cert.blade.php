@extends('layout.pdf')
@section('pdfcontent')
	

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
			margin-top: 0px;
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

		p, table, tr, th, td {
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
			font-size: 22px;
			padding-top: -5px;
		}

		p span{
			font-size: 22px;

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
			max-width: 650px;
			max-height: 960px;
			

            /* box-shadow:0px 0px 0px 5px #808080 inset;
            border: 1px solid #dfdddd; */
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
		

	</style>
</head>

<body>
	<div id="wrapper">
		<div class="container">
			<center><img src="{{ asset('assets/pdf/1.png') }}" width="15%"></center>

			<div class="txt01 txt-center" style="margin: 20px">
				<span  style="font-size:28px"><strong>ใบรับรองการผ่านการปฏิบัติงานโครงการคืนคนดีสู่สังคม</strong></span>
			</div>
			<p style="position: absolute; left: 200px; top: 183px;">{{ $register->sectionname}}</p>
			<p style="position: absolute; left: 520px; top: 183px;">{{ $register->departmentname}}</p>
			<p class="text-indent">สำนักงาน...............................................................................สังกัด...................................................</p>
			<p style="position: absolute; left: 190px; top: 217px;"><strong>{{ $register->prefixname}}{{ $register->name}} {{ $register->lastname }}</strong></p>
			<p>ขอรับรองว่า ............................................................................................ได้ผ่านการปฏิบัติงานจากกระทรวงยุติธรรม</p>
			<p style="position: absolute; left: 400px; top: 250px;">{{ $register->positionname}}</p>
			<p>ตามโครงการ <strong>คืนคนดีสู่สังคม</strong> โดยปฏิบัติงานในตำแหน่ง.............................................................................................</p>
			<p style="position: absolute; left: 150px; top: 284px;">{{ $nummonthwork}}</p>
			@php
				$start = explode("/", $certdatestart);
				$_month = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน.","พฤษภาคม","มิถุนายน","กรฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
				
				$startmonth=$_month[ltrim($start[1], '0')];

				$end = explode("/", $certdateend);
				$endmonth=$_month[ltrim($end[1], '0')];
		
			@endphp
			<p style="position: absolute; left: 300px; top: 284px;">{{ ltrim($start[0], '0') }} {{$startmonth}} {{ $start[2] }}</p>
			<p style="position: absolute; left: 520px; top: 284px;">{{ ltrim($end[0], '0') }} {{$endmonth}} {{ $end[2] }}</p>
			<p>เป็นระยะเวลา..........................เดือน ตั้งแต่.......................................................ถึง.......................................................</p>
			<p class="text-indent" style="margin-top:40px">ทั้งนี้  ตลอดเวลาระยะเวลาปฏิบัติงาน เป็นผู้ที่มีความประพฤติดี มีความตั้งใจและวิริยะ อุตสาหะ</p>
			
			<p>ตลอดจนมีความรับผิดชอบในการปฏิบัติงานให้ประสบความสำเร็จลุล่วงไปได้ด้วยดี</p>
			<p style="position: absolute; left: 460px; top: 518px;">{{ $certername}}</p>
			<p style="position: absolute; left: 480px; top: 603px;">{{ $certerposition}}</p>            
            <p class="txt-right" style="margin-right:138px; margin-top:50px">ลงชื่อผู้รับรอง  </p>
            <p class="txt-right" style="margin-right:50px; margin-top:10px">(..................................................................)  </p>
			<p class="txt-right" style="margin-right:148px; margin-top:10px">ตำแหน่ง </p>
            <p class="txt-right" style="margin-right:50px; margin-top:10px">(..................................................................)  </p>
		</div>
  
	
	</div>

</body>

</html>

@endsection

