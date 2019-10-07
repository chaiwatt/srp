@extends('layout.singleblog')
@section('blogcontent')
{{-- Thaishortdate --}}
<div class="row">
        <div class="col-md-9">
            <div class="blog-wrapper">
                    @if( count($new) > 0 )
                    @foreach( $new as $item )
                        <div class="blog-list">
                                <div class="blog-header clearfix m-bottom-md">
                                    <div class="blog-date" style="font-size:30px;line-height:90%" >
                                        {{$item->thaiday}}<br/>
                                        <div class="blog-month" style="font-size:22px" >{{$item->thaishortdate}}</div>
                                    </div>
                                    <div class="blog-title">
                                        <div class="text-upper" style="font-size:28px">{{$item->information_title}}</div>
                                        <div class="text-muted font-20">
                                            โดย <a href="#">กรมคุมประพฤติ</a>
                                            หมวด <a href="#">ข่าวประชาสัมพันธ์</a>
                                            <span class="m-left-xs m-right-xs">|</span>
                                        </div>
                                    </div>
                                </div><!-- ./blog-header -->
            
                                <div class="text-center">
                                        <img src="{{ asset($item->information_cover) }}" with="400" height="250" >
                                </div>
            
                                <p class="blog-content-lg text-center" style="font-size:22px; margin-top: 20px">
                                       {{  $item->information_description }}
                                </p>

                                <div class="m-top-md text-center">
										<a href="{{ url('landing/blog/'.$item->information_id) }}" class="btn btn-danger text-upper">อ่านต่อ</a>
									</div>
     
                            </div><!-- ./blog-list -->
            
                    @endforeach
                @endif

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
                @foreach( $update as $key => $item )
                    <li class="clearfix" style="line-height:50%">
                        <div class="img-wrapper clearfix">
                            <img src="../{{ $item->information_cover }}" alt="">
                        </div>
                        <div class="popular-blog-detail" style="line-height:50%">
                                <a href="{{ url('landing/blog/'.$item->information_id) }}" class="h5" style="font-size:20px">{{$item->information_title}}</a>
                            <div class="text-muted m-top-sm">{{$item->thaiday}} {{$item->thaishortdate}}</div>
                        </div>
                @endforeach
            </ul>
        </div><!-- ./col -->
    </div>
                
@endsection