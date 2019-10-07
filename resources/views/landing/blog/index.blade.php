@extends('layout.singleblog')
@section('blogcontent')
{{-- Thaishortdate --}}
<div class="row">
        <div class="col-md-9">
            <div class="blog-wrapper">
                <div class="blog-list">
                    <div class="blog-header clearfix m-bottom-md">
                        <div class="blog-date" style="font-size:30px;line-height:90%" >
                            {{$blog->first()->thaiday}}<br/>
                            <div class="blog-month" style="font-size:22px" >{{$blog->first()->thaishortdate}}</div>
                        </div>
                        <div class="blog-title">
                            <div class="text-upper" style="font-size:28px">{{$blog->first()->information_title}}</div>
                            <div class="text-muted font-20">
                                โดย <a href="#">{{$blog->first()->departmentname}}</a>
                                หมวด <a href="#">{{$blog->first()->budgetname}}</a>
                                <span class="m-left-xs m-right-xs">|</span>
                            </div>
                        </div>
                    </div><!-- ./blog-header -->

                    <div class="text-center">
                            <img src="{{ asset($blog->first()->information_cover) }}" with="500" height="350" >
                    </div>

                    <p class="blog-content-lg" style="font-size:22px; margin-top: 20px">
                           {{  $blog->first()->information_detail }}
                    </p>

                    <div class="tz-gallery">
                        <div class="row">
                            @if( count($images) > 0 )
                                @foreach( $images as $item )
                                    <div class="col-sm-12 col-md-4">
                                        <a class="lightbox" href="../../{{ $item->information_picture }}">
                                            <img src="../../{{ $item->information_picture }}" alt="Bridge">
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div><!-- ./blog-list -->
            </div><!-- ./blog-wrapper -->
        </div><!-- ./col -->

        <div class="col-md-3 pull-right">
            {!! Form::open([ 'url' => 'landing/searchblog' , 'method' => 'post' , 'files' => 'true' ]) !!} 
                <div class="form-group">
                    <input type="text" name="search" class="form-control" placeholder="ค้นหา...">
                </div><!-- /form-group -->
                {{-- <div class="form-group text-right">
                        <button type="submit" class="btn btn-xs btn-success">ค้นหา</button>
                </div><!-- /form-group --> --}}
                
            {!! Form::close() !!}
        </div>

        <div class="col-md-3">
            <hr/>
            <h4 style="font-size:24px">ข่าวล่าสุด</h4>
            <ul class="popular-blog-post">
                @foreach( $new as $key => $item )
                    <li class="clearfix" style="line-height:50%">
                        <div class="img-wrapper clearfix">
                            <img src="../../{{ $item->information_cover }}" alt="">
                        </div>
                        <div class="popular-blog-detail" style="line-height:50%">
                                <a href="{{ url('landing/blog/'.$item->first()->information_id) }}" class="h5" style="font-size:20px">{{$item->information_title}}</a>
                            <div class="text-muted m-top-sm">{{$item->first()->thaiday}} {{$item->first()->thaishortdate}}</div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div><!-- ./col -->
    </div>
                
@endsection