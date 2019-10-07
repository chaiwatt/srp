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
			margin-top: -10px;
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

        .font18{
            font-size: 18px;
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
			max-width: 1000px;
			/* max-height: 930px;  */
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
			<div class="box">
				<div class="border">
					<img src="{{ asset($register->picture) }}" width="100%" height="100%" >
				</div>
			</div>

			<div class="txt01 txt-center">
                <span style="font-size:22px"><strong>รายงานประเมินบุคลิกภาพรายบุคคล</strong></span>
			</div>
			<div class="txt01 txt-left">
                    {{-- <p style="padding-bottom: -30px ; line-height: 180% ;"><span style="display: inline-block; margin-left: 80px">{{$register->prefixname}}{{$register->name}} {{$register->lastname}}</span> <span style="display: inline-block; margin-left: 150px">{{$register->ageyear}}</span>  </p> --}}
                    <p style="position: absolute; left: 80px; top: 42px;">{{$register->prefixname}}{{$register->name}} {{$register->lastname}}</p>
                    <p style="position: absolute; left: 340px; top: 42px;">{{$register->ageyear}}</p>
					<span style="font-size:22px"><strong>ชื่อ-สกุล.......................................................อายุ............................</strong></span>
			</div>
			<div class="txt01 txt-left">
                    <p style="padding-bottom: -80px; line-height: 130% ;"><span style="display: inline-block; margin-left: 80px">{{$register->sectionname}}</span>  </p>
					<span style="font-size:22px"><strong>หน่วยงาน.......................................................................................</strong></span>
            </div>
            <div class="txt01 txt-left">
                    <p style="padding-bottom: -80px; line-height: 130% ;"><span style="display: inline-block; margin-left: 80px">{{$register->departmentname}}</span>  </p>
					<span style="font-size:22px; display:inline-block"><strong>สังกัดกรม.......................................................................................</strong></span>
            </div>
            <div class="txt01 txt-right" >
                    <p style="position: absolute; left: 850px; top: 124px;">{{$register->positionname}}</p>    
                <p style="position: absolute; left: 750px; top: 130px;"><strong>ตำแหน่งงาน...................................................................</strong></p>

			</div>
			
			<div style="height:10px"></div>
			
			<div class="txt01 txt-left">
				<span style="font-size:22px"><strong>รายการประเมินบุคลิกภาพ</strong></span>
			</div>	
			<table style="width:100% ; margin-top: 10px;" class="font18">
				
				<tr>
                    <th class="font18">วันที่</th>
					<th class="font18">อาชีพก่อนร่วมโครงการ</th>
					<th class="font18 " >คะแนนบุคลิกภาพ</th> 
                    <th class="font18">ความเหมาะสมอาชีพ</th>
                    <th class="font18">ความต้องการอาชีพ</th>
                    <th class="font18">ความต้องการการศึกษา</th>
                    <th class="font18">การให้การอบรมอาชีพ</th>
                    <th class="font18">การให้การอบรมการศึกษา</th>
                    <th class="font18">การมอบหมายงาน</th>
				</tr>
				@if( count($registerassesmentfit) > 0 )
                    @foreach( $registerassesmentfit as $item )
                    
                    @php
                        $sumscore = $registerassessment->where('register_assesment_fit_id',$item->register_assesment_fit_id)->sum('register_assessment_point');
                        $val = $assessor->where('register_assesment_fit_id',$item->register_assesment_fit_id)->all();
                        $assessorlist="";
                        if(count($val) !=0 ){
                            // echo $assessor_app
                            foreach($val as $key => $_item){
                                $assessorlist .= " ผู้ประเมิน#". ($key) . ":" . $_item->assessor_name . "   ตำแหน่ง:" . $_item->assessor_position ; 
                            }    
                        }
                    @endphp

						<tr>
                            <td class="font18" rowspan="2" >{{$item->dateassess}}</td>
                            <td class="font18" >{{$item->occupationbefore}}</td>
                            <td class="font18 txt-center" >{{$sumscore}}</td>
                            <td class="font18 txt-center" >{{$item->currentoccupation}}</td>
                            <td class="font18 txt-center" >{{$item->registeroccupationneed}}</td>
                            <td class="font18 txt-center" >{{$item->registereducationneed}}</td>
                            <td class="font18 txt-center" >{{$item->registeroccupationtrain}}</td>
                            <td class="font18 txt-center" >{{$item->registereducationtrain}}</td>
                            <td class="font18 txt-center" >{{$item->jobassignment}}</td>
                        </tr>
                        <tr>
                            <td class="font18" colspan="8" >การให้การช่วยเหลือ: {{$item->needhelp}} <br>
                                การให้คำปรึกษา: {{$item->needrecommend}} 
                            </td>
                        </tr>
                        <tr>
                            <td class="font18" colspan="9" >{{$assessorlist}} ddd</td>
                        </tr>
                        
					@endforeach
				@endif					
			</table>
		</div>

		
	
	</div>


</body>

</html>