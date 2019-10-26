@extends('layout.mains')

@section('pageCss')
<style>
.showvideo {
            width: 100%; 
            width: 100%;
            height:auto;
}

</style>
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ route('videolist.index') }}">วีดีโอสอนใช้งาน</a></li>
    </ul>

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title">
                วีดีโอสอนใช้งาน: {{$video->video_desc}}
            </div>
        </div>
    </div>
</div>

{{-- <div class="row padding-md"> --}}
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header">{{$video->video_desc}} </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">           
                    <video controls class="showvideo">
                        <source src="{{asset($video->video)}}" type="video/mp4">
                        {{-- <source src="http://www.html5rocks.com/en/tutorials/video/basics/Chrome_ImF.ogg" type="video/ogg"> --}}
                      Your browser does not support the video tag.
                      </video>
                </div>
            </div>
        </div>
    </div>
{{-- </div> --}}
@stop

@section('pageScript')
<script type="text/javascript">
    // var $video  = $('video'),
    // $window = $(window); 

    // $(window).resize(function(){
        
    //     var height = $window.height();
    //     $video.css('height', height);
        
    //     var videoWidth = $video.width(),
    //         windowWidth = $window.width(),
    //     marginLeftAdjust =   (windowWidth - videoWidth) / 2;
        
    //     $video.css({
    //         'height': height, 
    //         'marginLeft' : marginLeftAdjust
    //     });
    // }).resize();
</script>
@stop