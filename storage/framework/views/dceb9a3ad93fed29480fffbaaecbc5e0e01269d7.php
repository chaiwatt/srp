<?php $__env->startSection('pdfcontent'); ?>
	

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
	      src: url("<?php echo e(asset('fonts/THSarabunNew.ttf')); ?>") format('truetype');
	    }
	    @font-face {
	      font-family: 'THSarabunNew';
	      font-style: normal;
	      font-weight: bold;
	      src: url("<?php echo e(asset('fonts/THSarabunNew Bold.ttf')); ?>") format('truetype');
	    }
	    @font-face {
	      font-family: 'THSarabunNew';
	      font-style: italic;
	      font-weight: normal;
	      src: url("<?php echo e(asset('fonts/THSarabunNew Italic.ttf')); ?>") format('truetype');
	    }
	    @font-face {
	      font-family: 'THSarabunNew';
	      font-style: italic;
	      font-weight: bold;
	      src: url("<?php echo e(asset('fonts/THSarabunNew BoldItalic.ttf')); ?>") format('truetype');
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
			font-size: 21px;
			padding-top: -5px;
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
			max-height: 960px;
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
		

	</style>
</head>

<body>
	<div id="wrapper">
		<div class="container">
			<center><img src="<?php echo e(asset('assets/pdf/logo.png')); ?>" width="15%"></center>
			<div class="box">
				<div class="border">
					<img src="<?php echo e(asset($register->picture)); ?>" width="100%" height="100%" >
				</div>
			</div>

			<div class="txt01 txt-center">
				<span style="font-size:22px"><strong>ข้อตกลงจ้างงานโครงการคืนคนดีสู่สังคม</strong></span>
			</div>
			<div class="txt01 txt-center">
				<span style="font-size:22px"><strong>ภายใต้แผนปฏิบัติการไทยเข้มแข็ง</strong></span>
			</div>
			<div class="txt01 txt-center">
				<span style="font-size:22px"><strong>ตำแหน่ง <b><?php echo e($register->positionname); ?></b></strong></span>
			</div>
			<p style="position: absolute; left: 610px; top: 208px;"><?php echo e($register->contract_no); ?></p>
			<div class="txt01 txt-right">
				<span style="font-size:22px"><strong>ข้อตกลงจ้างเลขที่ ..................................</strong></span>
			</div>
			<div style="height:20px"></div>
			
			<p style="position: absolute; left: 260px; top: 261px;"><?php echo e($register->sectionname); ?></p>
			<p class="text-indent">ข้อตกลงฉบับนี้ทำขึ้น ณ ...............................................................................................................................................</p>
			
			<p style="position: absolute; left: 420px; top: 293px;"><?php echo e($register->sectionname); ?></p>
			<p>เมื่อวันที่ ..............................................................................ระหว่าง .......................................................................................................</p>
			
			<p style="position: absolute; left: 60px; top: 325px;"><?php echo e($register->representativename); ?></p>
			<p style="position: absolute; left: 420px; top: 325px;"><?php echo e($register->representativeposition); ?></p>
			<p>โดย ..................................................................................... ตำแหน่ง .....................................................................................................</p>
			<p>ผู้รับมอบอำนาจจากปลัดกระทรวงยุติธรรม ตามคำสั่งกระทรวงยุติธรรมที่ 1070/02553 ลงวันที่ 5 เมษายน 2553 </p>
			<p>ซึ่งต่อไปในข้อตกลงนี้เรียกว่า “ผู้ว่าจ้าง” ฝ่ายหนึ่ง กับ <b><?php echo e($register->prefixname); ?><?php echo e($register->name); ?> <?php echo e($register->lastname); ?></b> </p>
			<p>อยู่บ้านเลขที่ <b><?php echo e($register->address); ?></b> ตำบล <b><?php echo e($register->districtname); ?></b> อำเภอ <b><?php echo e($register->amphurname); ?></b> จังหวัด <b><?php echo e($register->provincename); ?></b> ซึ่งต่อไปในข้อตกลงนี้เรียกว่า “ผู้รับจ้าง” อีกฝ่ายหนึ่ง โดยมีข้อตกลงกันดังต่อไปนี้</p>
			<p class="text-indent bold">ข้อ 1. ข้อตกลงว่าจ้าง</p>
			
			<p style="position: absolute; left: 510px; top: 521px;"><?php echo e($register->positionname); ?></p>
			<p class="text-indent">ผู้ว่าจ้างตกลงจ้างและผู้รับจ้างตกลงรับจ้างทำงานให้บริการในตำแหน่ง ................................................................</p>
			
			<p style="position: absolute; left: 150px; top: 553px;"><?php echo e($register->sectionname); ?></p>
			<p>ประจำการ ณ......................................................................................................................................................................................</p>
			
			<p style="position: absolute; left: 150px; top: 584px;"><?php echo e($register->thaistarthiredate); ?></p>
			<p style="position: absolute; left: 350px; top: 584px;"> <?php echo e($register->thaiendhiredate); ?></p>
			<p style="position: absolute; left: 590px; top: 584px;">1</p>
			<p>มีกำหนดตั้งแต่วันที่ ................................................. ถึงวันที่ ...................................................... จำนวน ............................... คน			</p>
			<p class="text-indent bold">ข้อที่ 2. การจ่ายค่าจ้าง</p>
			
			<p style="position: absolute; left: 360px; top: 648px;"><?php echo e($register->thaistarthiredate); ?></p>
			<p style="position: absolute; left: 550px; top: 648px;"> <?php echo e($register->thaiendhiredate); ?></p>
			<p class="text-indent">ผู้ว่าจ้างตกลงจ่ายค่าจ้างให้แก่ผู้รับจ้างตั้งแต่ ................................................. ถึง ................................................. </p>
			
			<p style="position: absolute; left: 100px; top: 679px;"> <?php echo e($register->monthdiff); ?></p>
			<p style="position: absolute; left: 365px; top: 679px;"> <?php echo e(number_format($register->contractpayment,2)); ?></p>
			<p style="position: absolute; left: 490px; top: 679px;"> <?php echo e($register->convertobath); ?>บาทถ้วน</p>
			<p> รวมเป็นเวลา ................................... เดือน เป็นจำนวนเงินทั้งสิ้น ......................... บาท (..................................................................) </p>
			<p> โดยแบ่งจ่ายเป็นรายเดือนตามเดือนแห่งปฏิทิน ในอัตราเดือนละ <?php echo e(number_format($position->position_salary , 2)); ?> บาท และจะจ่ายให้เมื่อผู้รับจ้างได้ให้บริการ ครบในแต่ละเดือนและผู้ว่าจ้างหรือผู้แทนของผู้ว่าจ้างได้ตรวจสอบการให้บริการดังกล่าวเรียบร้อยแล้ว</p>
			<p class="text-indent">กรณีการจ้างในเดือนแรกไม่ครบเดือนแห่งปฏิทินนั้น ให้คำนวณค่าจ้างเริ่มตั้งแต่วันที่ที่ผู้รับจ้างเข้าปฏิบัติ หน้าที่ให้แก่ผู้ว่าจ้างจนถึงวันสุดท้ายแห่งเดือนปฏิทินนั้นการคำนวณค่าจ้างตามวรรคสองให้คำนวณค่าจ้างต่อวันจากอัตรา ค่าจ้างรายเดือนหารด้วย 30 (สามสิบ)</p>
		</div>
		<div class="page-break"></div>

		<div class="container">
			<p class="text-indent bold">ข้อ 3. การปฏิบัติงานของผู้รับจ้าง</p>
			<p class="text-indent">3.1 ผู้รับจ้างจะต้องปฏิบัติตามคำสั่งของผู้ว่าจ้าง เจ้าหน้าที่ของผู้ว่าจ้าง หรือผู้ซึ่งได้รับมอบหมายจาก ผู้ว่าจ้างให้ทำหน้าที่สอดส่องดูแลการปฏิบัติหน้าที่ของผู้รับจ้างโดยเคร่งครัด</p>
			<p class="text-indent">3.2 ผู้รับจ้างต้องปฏิบัติงานด้วยความเข้มแข็ง มีความตั้งใจ และซื่อสัตย์สุจริตให้ความเคารพข้าราชการ และเจ้าหน้าที่ของผู้ว่าจ้างและต้องปฏิบัติกับผู้มาติดต่อราชการหรือใช้บริการของผู้ว่าจ้าง ด้วยความสุภาพเรียบร้อย หากมีการละเว้นการปฏิบัติ ดังกล่าวจนเป็นเหตุให้เกิดความเสียหายแก่ภาพลักษณ์ของผู้ว่าจ้าง เจ้าหน้าที่ของผู้ว่าจ้าง หรือผู้ซึ่งได้รับมอบหมายจากผู้ว่าจ้างที่ปรากฏ ต่อสาธารณชนผู้ว่าจ้างมีสิทธิบอกเลิกข้อตกลงจ้างทันที โดยผู้รับจ้างจะ เรียกร้องค่าเสียหายใด ๆ ไม่ได้ </p>
			<p class="text-indent">3.3 ผู้รับจ้างจะต้องปฏิบัติตามกฎ ระเบียบ ข้อบังคับ เงื่อนไขรายละเอียดการจ้างและคำสั่งต่างๆของ ผู้ว่าจ้าง ตลอดระยะเวลาการจ้างโดยเคร่งครัด </p>
			<p class="text-indent bold">ข้อ 4. ค่าปรับ</p>
			<p class="text-indent">ในกรณีผู้รับจ้างไม่สามารถทำงานบริการตามข้อตกลงได้ ผู้รับจ้างต้องแจ้งเป็นลายลักษณ์อักษรให้ ผู้ว่าจ้าง เจ้าหน้าที่ของผู้ว่าจ้างหรือผู้ซึ่งได้รับมอบหมายจากผู้ว่าจ้างทราบล่วงหน้าไม่น้อยกว่า 2 วันทำการ และหาก ไม่มาปฏิบัติงาน ตามข้อตกลง ผู้รับจ้างจะต้องชำระค่าปรับให้แก่ผู้ว่าจ้างในอัตรา วันละ 100 บาท</p>
			<p class="text-indent bold">ข้อ 5. ความรับผิดในความเสียหายของผู้ว่าจ้าง</p>
			<p class="text-indent">5.1 ในกรณีทรัพย์สินของผู้ว่าจ้างหรือทรัพย์สินที่ผู้รับจ้างมีหน้าที่ดูแลรับผิดชอบได้รับความเสียหาย ถูกทำลาย หรือสูญหายโดยความประมาทเลินเล่อของผู้รับจ้าง ผู้รับจ้างจะต้องรับผิดชอบชดใช้ค่าเสียหายนั้น เว้นแต่ ผู้รับจ้างจะพิสูจน์ได้ว่าความเสียหายหรือสูญหายนั้นเกิดจากเหตุสุดวิสัย</p>
			<p class="text-indent">5.2 หากความเสียหายหรือสูญหายของทรัพย์สินที่ผู้รับจ้างต้องรับผิดชอบเกิดขึ้นเพราะผู้ว่าจ้างหรือ เจ้าหน้าที่ของผู้ว่าจ้าง หรือผู้ซึ่งได้รับมอบหมายจากผู้ว่าจ้างมีส่วนผิดอยู่ด้วย คู่สัญญาทั้งสองฝ่ายจะร่วมกันรับผิด โดยพิจารณาถึงความผิดของแต่ละฝ่ายเป็นเกณฑ์ในการคำนวณค่าเสียหาย</p>
			<p class="text-indent">5.3 ในระหว่างปฏิบัติงาน ถ้าผู้รับจ้างได้กระทำการใดๆ อันเป็นการละเมิดต่อบุคคลหรือทรัพย์สิน ของผู้อื่น ผู้รับจ้างจะต้องรับผิดชอบในบรรดาความเสียหายที่ได้กระทำขึ้นนั้น</p>
			<p class="text-indent">5.4 กรณีที่ผู้รับจ้างไม่มาปฏิบัติงานตามข้อตกลงเป็นเหตุให้เกิดความเสียหายแก่ผู้ว่าจ้าง ผู้รับจ้างต้อง รับผิดในความเสียหายทั้งหมดที่เกิดขึ้น ทั้งนี้ ไม่กระทบต่อสิทธิของผู้ว่าจ้างในการเรียกร้องค่าปรับตามที่กำหนดไว้ในข้อ 4.</p>
			
			
		</div>
		<div class="page-break"></div>

		<div class="container">
			<p class="text-indent bold">ข้อ 6. สิทธิการบอกเลิกข้อตกลง</p>
			<p class="text-indent">หากผู้รับจ้างไม่มาปฏิบัติตามข้อตกลงข้อหนึ่งข้อใดดังต่อไปนี้ ผู้ว่าจ้างมีสิทธิบอกเลิกข้อตกลงได้</p>
			<p class="text-indent">6.1 ขาดงานไปโดยปราศจากเหตุอันควรเกินกว่า 5 วันทำการติดต่อกัน</p>
			<p class="text-indent">6.2 จงใจขัดคำสั่งอันชอบด้วยกฎหมายของผู้ว่าจ้าง</p>
			<p class="text-indent">6.3 ละเลยไม่สนใจที่จะปฏิบัติตามคำสั่งอันชอบด้วยกฎหมายของผู้ว่าจ้าง</p>
			<p class="text-indent">6.4 กระทำความผิดทั้งทางแพ่งและทางอาญาต่อผู้ว่าจ้างอย่างร้ายแรง ปราศจากสิทธิในทางกฎหมาย</p>
			<p>ที่จะพึงกระทำได้และเมื่อผู้ว่าจ้างบอกเลิกข้อตกลงแล้ว ผู้รับจ้างยอมให้ผู้ว่าจ้างดำเนินการต่อไปนี้</p>
			<p class="text-indent">6.5 เรียกเอาค่าจ้างที่เพิ่มขึ้นเพราะต้องจ้างบุคคลอื่นทำงานบริการต่อไปจนครบอายุข้อตกลงที่เหลืออยู่</p>
			<p class="text-indent">6.6 เรียกค่าเสียหายอันพึงมีจากผู้รับจ้าง</p>
			<p class="text-indent">6.7 ผู้รับจ้างยินยอมให้ผู้ว่าจ้างหักเงินค่าจ้างที่ผู้รับจ้างจะได้รับตามข้อ 2. ชำระบรรดาค่าปรับและ ค่าเสียหายที่ผู้รับจ้างจะต้องชำระตามข้อตกลงนี้ หากไม่พอผู้รับจ้างยินยอมชำระส่วนที่ยังขาดอยู่จนครบถ้วนภายใน กำหนด 15 วัน นับตั้งแต่วันที่ได้รับแจ้งจากผู้ว่าจ้าง พร้อมดอกเบี้ย (ถ้ามี)</p>
			<p class="text-indent bold">ข้อ 7. การว่าจ้างตามข้อตกลงฉบับนี้ </p>
			<p>ไม่ทำให้ผู้รับจ้างมีฐานะเป็นลูกจ้างของทางราชการหรือมีความสัมพันธ์ในฐานะเป็นลูกจ้างของผู้ว่าจ้างตามกฎหมายแรงงาน</p>
			<p class="text-indent">ข้อตกลงนี้ทำขึ้นเป็น 2 ฉบับ มีข้อความถูกต้องตรงกัน คู่สัญญาได้อ่านและเข้าใจข้อความโดยละเอียด ตลอดแล้ว จึงได้ลงลายมือชื่อไว้เป็นสำคัญต่อหน้าพยาน และคู่สัญญาต่างยึดถือไว้ฝ่ายละฉบับ</p>
			<p style="margin-top: 60px;"></p>
			
			<p style="padding-bottom: 0px;"><span style="display: inline-block; margin-left: 50px">ลงชื่อ.................................................. ผู้ว่าจ้าง</span> <span style="display: inline-block; margin-left: 100px">ลงชื่อ.................................................. ผู้รับจ้าง</span> </p>
			<p><span style="display: inline-block; margin-left: 65px">(..............................................................)</span> <span style="display: inline-block; margin-left: 130px">(..............................................................)</span>  </p>
			
			<p><span style="display: inline-block; margin-left: 50px">ตำแหน่ง..............................................................</span> </p>
			<br>
			<br>
			<br>
			<p style="padding-bottom: 0px;"><span style="display: inline-block; margin-left: 50px">..........................................................พยาน</span> <span style="display: inline-block; margin-left: 140px">..........................................................พยาน</span> </p>
			
			<p><span style="display: inline-block; margin-left: 60px">(..............................................................)</span> <span style="display: inline-block; margin-left: 150px">(..............................................................)</span>  </p>
			
			
		</div>
		<div class="page-break"></div>

		<div class="container">
			<p style="padding-bottom: -30px; margin-left:-20px"><span style="display: inline-block; margin-left: 450px"><?php echo e($register->position); ?></span> </p>
			<p class="txt-center bold">เงื่อนไขและรายละเอียดการจ้างเหมาบริการตำแหน่ง..........................................</p>
			
			<p class="txt-center bold">แนบท้ายข้อตกลงจ้างเลขที่............./ .............. ลงวันที่...............................</p>
			<hr>
			<p class="bold">ผู้รับจ้างจะต้องจัดให้มีผู้ปฏิบัติงานที่รับจ้างตามเงื่อนไขและข้อกำหนดของผู้ว่าจ้าง ดังนี้</p>
			<p class="text-indent3 bold">1. คุณสมบัติของผู้รับจ้าง</p>
			<p class="text-indent">1.1  ต้องมีอายุไม่ต่ำกว่า 15 ปี บริบูรณ์</p>
			<p class="text-indent">1.2  จบการศึกษาไม่ต่ำกว่าหรือเทียบเท่าชั้นประถามศึกษาปีที่ 6 หรือเป็นผู้มีความรู้ ความสามารถ และเหมาะสมในการปฏิบัติงานในหน้าที่</p>
			<p class="text-indent">1.3  ต้องเป็นผู้มีสุขภาพดี แข็งแรง ไม่มีโรคประจำตัวที่อาจเป็นอุปสรรคต่อการปฏิบัติงานที่รับจ้าง เช่น โรคลมชัก หรือโรคติดต่อชนิดร้ายแรง เป็นต้น</p>
			<p class="text-indent">1.4  ผู้รับจ้าง ต้องส่งหลักฐานสำเนาทะเบียนบ้าน สำเนาบัตรประชาชน ประวัติการศึกษาและเอกสารอื่น ตามที่ผู้ว่าจ้างร้องขอ พร้อมรับรองสำเนาถูกต้อง จำนวน 2 ชุด ให้ผู้ว่าจ้างเก็บไว้เป็นหลักฐาน</p>
			<p class="text-indent">1.5  ในขณะปฏิบัติงาน ผู้รับจ้างต้องแต่งกายตามที่ผู้ว่าจ้างกำหนด</p>
			<p class="text-indent">1.6  ผู้รับจ้าง ต้องปฏิบัติงานได้ทุกสถานที่ ทุกจังหวัด ตามที่ผู้ว่าจ้างกำหนดโดยไม่มีเงื่อนไขใด ๆ ทั้งสิ้น</p>
			<p class="text-indent3 bold">2.  วันและเวลาในการปฏิบัติงาน</p>
			<p class="text-indent">2.1  ผู้รับจ้าง ต้องปฏิบัติงานในวันและเวลาราชการตั้งแต่เวลา 08.30-16.30 น. (ให้แต่ละหน่วยงาน ระบุวันและเวลาในการปฏิบัติงานตามความเหมาะสมของแต่ละตำแหน่งในเอกสารฉบับนี้ หรือเป็นเอกสารแนบท้าย ข้อตกลงอีกฉบับหนึ่งก็ได้)</p>
			<p class="text-indent">2.2  ผู้รับจ้าง ต้องตกลงวัน/เวลาในการปฏิบัติงานในเอกสารที่ผู้ว่าจ้างกำหนด</p>
			<p class="text-indent">2.3  ผู้ว่าจ้างคิดค่าปรับเป็นรายวันตามข้อตกลงจ้างข้อ 4. ในอัตราร้อยละ 0.10 ของราคาค่าจ้างทั้งสิ้น ตามข้อตกลง แต่ถ้าหากเงินค่าปรับน้อยกว่า 100 บาท/วัน ผู้ว่าจ้างจะคิดเป็นวันละ 100 บาท</p>
			<p class="text-indent3 bold">3.  รายละเอียดของงานที่ปฏิบัติ (ให้ระบุหน้าที่ความรับผิดชอบตามตำแหน่งงานที่จะจ้าง)</p>
			<p class="text-indent">3.1 .........................................................................................................................................................................</p>
			<p class="text-indent">3.2 .........................................................................................................................................................................</</p>
			<p class="text-indent">3.3 .........................................................................................................................................................................</</p>
		</div>
	
	</div>

</body>

</html>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.pdf', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>