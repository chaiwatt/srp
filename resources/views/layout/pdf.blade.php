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
			margin: 0;
			padding: 0;
			line-height: normal;
			background: #FFF;
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
			border: 0;
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
			font-size: 23px;
		}

		p span{
			font-size: 23px;
		}


		.red{
			color: red;
			 text-decoration-line: line-through;
		}

		/* .text-center{
			text-align:center;
		} */
		img {
			vertical-align: middle;
		}
		.clear {
			clear: both;
		}
		#wrapper {
			width: 100%;
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
			font-size: 22px;
			font-weight: bold;
			padding: 0;
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
			/* position: absolute; */
			right: 0;
			top: 0;
		}
		.page-break {
		    page-break-after: always;
		}
		.spacetab { 
			display:inline-block; margin-left: 50px; 
		}

table {
	border: 0.01em solid #000000;
    border-collapse: collapse;
}
table td,
table th,table tr {
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
        @yield('pdfcontent')
</body>

</html>