<!DOCTYPE html>
<html lang="en">
  	
<head>
	<meta charset="utf-8">
	<title>คืนคนดีสู่สังคม</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	    <!-- Bootstrap core CSS -->
	    <!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
	<link href="{{ asset('assets/css/fluid-gallery.css') }}" rel="stylesheet"> 
	<link href="{{ asset('assets/js/uncompressed/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}" rel="stylesheet"/>  
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
	<link href="{{ asset('assets/css/morris.css') }}" rel="stylesheet"/>  
    <link href="{{ asset('assets/css/simplify.css') }}" rel="stylesheet">   

	<style type="text/css">
		.d-inline-block{
		width:50%;
		float:left;
    }
	</style>


  	</head>

  	<body class="overflow-hidden">

			<header class="navbar front-end-navbar" data-spy="affix" data-offset-top="1">
					<div class="container">
					<div class="navbar-header">
						<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
						<a href="{{ url('landing') }}" class="navbar-brand"><strong><span class="text-success" style="font-family: THSarabunNew;font-size: 32px">คืนคนดีสู่สังคม</span></strong></a>
					</div>
					<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
						<ul class="nav navbar-nav">
						<li>
							<a href="{{ url('landing/blog') }}" style="font-family: THSarabunNew;font-size: 26px">ข่าวประชาสัมพันธ์</a>
						</li>
						<li>
							<a href="{{ url('publicreport/report') }}" style="font-family: THSarabunNew;font-size: 26px">รายงานโครงการ</a>
						</li>
						@if ( !empty($generalsetting))
							@if ($generalsetting->enable_onlinereg == 1)
							<li>
								<a href="{{ url('landing/register') }}" style="font-family: THSarabunNew;font-size: 26px">สมัครงาน</a>
							</li>
							@endif 
                    	@endif
	
						</ul>
						<ul class="nav navbar-nav navbar-right  m-right-sm">

							@if (count($auth) > 0)
							  <li>
								  <a href="{{ url('/') }}">
									  <i class="fa fa-edit fa-lg"></i><span class="m-left-xs">{{$auth->name}}</span>
								  </a>
							  </li>  
								  <li class="btn-link"><a href="{{ url('/') }}" class="btn btn-sm btn-danger" style="font-family: THSarabunNew;font-size: 22px">แดชบอร์ด</a></li>
							  @else
								  <li class="btn-link"><a href="{{ url('/') }}" class="btn btn-sm btn-success" style="font-family: THSarabunNew;font-size: 22px">เข้าสู่ระบบ</a></li>
							@endif
	  
						  </ul>
					</nav>
					</div>
				</header>
	


		<div class="padding-md" style="margin-left:20px; margin-right:20px">

        @yield('blogcontent')

		</div><!-- ./padding-md -->
		
        <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
		<script>
		    baguetteBox.run('.tz-gallery');
		</script>
		        
        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
        {{-- <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.localScroll.min.js') }}"></script>       --}}

		<script src="{{ asset('assets/js/bootstrap-filestyle.min.js') }}"></script>

        <script src="{{ asset('assets/js/uncompressed/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('assets/js/uncompressed/bootstrap-datepicker/js/bootstrap-datepicker-custom.js') }}"></script>
        <script src="{{ asset('assets/js/uncompressed/bootstrap-datepicker/locales/bootstrap-datepicker.th.min.js') }}"></script>

		<script src="{{ asset('assets/js/rapheal.min.js') }}"></script>   
        <script src="{{ asset('assets/js/morris.min.js') }}"></script>    
		{{-- <script src="{{ asset('assets/js/select2.min.js') }}"></script> --}}
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
		<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
		<script src="{{ asset('assets/js/simplify/simplify.js') }}"></script>

		<script src="{{ asset('assets/js/fusioncharts.js') }}"></script>
        <script src="{{ asset('assets/js/themes/fusioncharts.theme.fint.js') }}"></script>

        @section('pageScript')
        @show

        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>


  	</body>
</html>
