@extends('layout.landing')

@section('pageCss')

@stop

@section('landingcontent')

    <div class="row" style="margin-top:50px;">
        @if (count($information) > 0)
        @foreach ($information as $item)
        <div class="col-md-4 text-center">
                <div class="how-it-work-list fadeInRight animation-element disabled">
                    <img src="{{ asset($item->information_cover) }}" class="featured">
                    <h3 class="m-top-md text-upper header" style="font-size:25px">{{ $item->information_title}}</h3>
                    <p  class="featuretitle">{{ $item->information_description}}...</p>
                    <a href="{{ url('landing/blog/' . $item->information_id ) }}" class="btn btn-info btn-xs featuretitle"> เพิ่มเติม </a>
                </div>
            </div>
        @endforeach

        @endif

    </div>
@endsection

@section('buttomcontent')
    <div class="section bg-white section-padding " >
        <div class="container" style="margin-top:-80px; height: 315px;" >
            <div class="row" style="height: 315px;">
                <div class="@if (count($youtube) !=0 ) col-md-6  @else col-md-12 @endif"  >                             
                    <div class="smart-widget" style="font-family: THSarabunNew;font-size: 26px">
                        <div class="smart-widget-inner">
                            <ul class="nav nav-tabs tab-style2">
                                <li class="active">
                                    <a href="#style2Tab1" data-toggle="tab">
                                        <span class="icon-wrapper"><i class="fa fa-bullhorn"></i></span>
                                        <span class="text-wrapper">ข่าวประชาสัมพันธ์</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#style2Tab2" data-toggle="tab">
                                        <span class="icon-wrapper"><i class="fa fa-book"></i></span>
                                        <span class="text-wrapper">ดาวน์โหลดเอกสาร</span>
                                    </a>
                                </li>
                            </ul>
   
                            <div class="smart-widget-body" style="font-family: THSarabunNew;font-size: 22px">
                                <div class="tab-content" style="height: 220px;">
                                    <div class="tab-pane fade in active" id="style2Tab1">
                                        <ul class="popular-blog-post">
                                            @foreach( $new as $key => $item )
                                                <li class="clearfix" style="line-height:50%">
                                                    <div class="img-wrapper clearfix">
                                                        <img src="{{ $item->information_cover }}"   style="height:45px" alt="">
                                                    </div>
                                                    <div class="popular-blog-detail" style="line-height:50%">
                                                            <a href="{{ url('landing/blog/'.$item->first()->information_id) }}" class="h5" style="font-size:20px">{{$item->information_title}}</a>
                                                        <div class="text-muted m-top-sm">{{$item->first()->thaiday}} {{$item->first()->thaishortdate}}</div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        {{ $new->links() }}
                                    </div>
                                    <div class="tab-pane fade" id="style2Tab2">
                                        <ul style="margin-left:20px">
                                                @foreach( $docdownload as $key => $item )
                                                    <li >
                                                    <span>{{$item->docdownload_desc}}</span> <a href="{{ asset($item->docdownload_link) }}" class="text-success" target="_blank">ดาวน์โหลด</a>
                                                    </li>
                                                @endforeach
                                        </ul>
                                        {{ $docdownload->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
                @if (count($youtube) != 0)
                <div class="col-md-6 text-center" >   
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$youtube->youtube_url}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>   
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

