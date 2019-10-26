@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">วีดีโอสอนใช้งาน</a></li>
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                รายการ วีดีโอสอนใช้งาน
            </div>
        </div>
    </div>
</div>

{{-- <div class="row padding-md"> --}}
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> รายการ วีดีโอสอนใช้งาน </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">           
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th >#</th>
                                <th >วีดีโอ</th>
                                <th >หมวด</th>
                                <th >สังกัด</th>
                                <th >เพิ่มเติม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $videolist as $key => $item )
                                <tr>
                                    <td>{{ $key +1}}</td>
                                    <td>{{ $item->video_desc }}</td>
                                    <td>{{ $item->categoty }}</td>
                                    <td>{{ $item->owner }}</td>
                                    <td>
                                        <a href="{{ route('videolist.play',['id' => $item->video_id]) }}" class="btn btn-xs btn-info">เปิดวีดีโอ</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <ul class="pagination pagination-split pull-right">
                        {!! $videolist->render() !!}
                    </ul>

                </div>
            </div>
        </div>
    </div>
{{-- </div> --}}
@stop

@section('pageScript')
<script type="text/javascript">
    
</script>
@stop