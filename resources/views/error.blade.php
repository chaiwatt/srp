<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title>คืนคนดีสู่สังคม</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/ionicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/simplify.css') }}" rel="stylesheet">  
    </head>

    <body class="overflow-hidden light-background">
        <div class="wrapper no-navigation preload">
            <div class="sign-in-wrapper">
                <div class="sign-in-inner">
                    <div class="login-brand text-center" style="font-size:40px">
                        <i class="fa fa-database m-right-xs"></i> คืนคนดีสู่สังคม 
                    </div>

            @if( Session::has('error') )
            <div class="alert alert-danger alert-custom alert-dismissible" role="alert" style="font-size:20px">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <i class="fa fa-times-circle m-right-xs"></i> {{ Session::get('error') }}
            </div>
            @elseif( Session::has('success') )
                <div class="alert alert-success alert-custom alert-dismissible" role="alert" style="font-size:20px">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-check-circle m-right-xs"></i> {{ Session::get('success') }}
                </div>
            @endif
                </div>
            </div>
        </div>

        <a href="#" id="scroll-to-top" class="hidden-print"><i class="icon-chevron-up"></i></a>

        <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}"></script>
        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.popupoverlay.min.js') }}"></script>
        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
        <script src="{{ asset('assets/js/simplify/simplify.js') }}"></script>
    </body>
</html>
