@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('information') }}">รายการข่าวประชาสัมพันธ์</a></li>
        <li>แก้ไขข่าวประชาสัมพันธ์</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                แก้ไขข่าวประชาสัมพันธ์
            </div>
        </div>
    </div>
    @if( Session::has('success') )
    <div class="alert alert-success alert-custom alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <i class="fa fa-check-circle m-right-xs"></i> {{ Session::get('success') }}
    </div>
    @elseif( Session::has('error') )
        <div class="alert alert-danger alert-custom alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <i class="fa fa-times-circle m-right-xs"></i> {{ Session::get('error') }}
        </div>
    @endif

    <div class="row ">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> แก้ไขข่าวประชาสัมพันธ์ </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md"> <!-- form create project -->
                        {!! Form::open([ 'url' => 'information/edit' , 'method' => 'post' , 'files' => 'true' ]) !!} 
                            <input type="hidden" name="id" value="{{ $information->information_id }}" />
                            {{-- <input type="hidden" name="id" value="{{ $information->information_id }}" /> --}}
                            <div class="form-group">
                                <label>หัวเรื่อง ประชาสัมพันธ์</label>
                                <input type="text" name="title" class="form-control" required="" value="{{ $information->information_title }}" />
                            </div>
                            <div class="form-group">
                                <label>รายละเอียด อย่างย่อ</label>
                                <textarea class="form-control" name="description">{{ $information->information_description }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>รายละเอียด</label>
                                <textarea class="form-control" name="detail" rows="5">{{ $information->information_detail }}</textarea>
                            </div>
                            <hr>
                            <div class="form-group col-md-12">
                                <div class="col-md-3">
                                    <img src="{{ asset($information->information_cover) }}" class="img-responsive" />
                                </div>
                            </div>
                            <div class="form-group" class="text-center">
                                <label>เลือกรูป cover</label>
                                <input type="file" name="cover" id="cover" class="filestyle"  />
                            </div>
                            <div class="col-md-12 m-bottom-sm">
                                @if( count($picture) > 0 )
                                @foreach( $picture as $item )
                                <div class="col-md-3">
                                    <img src="{{ asset($item->information_picture) }}" class="img-responsive" />
                                    <center>
                                        <a href="{{ url('information/delete-picture/'.$item->information_picture_id.'/'.$information->information_id ) }}" class="btn btn-danger"><i class="fa fa-remove"></i> ลบ</a>
                                    </center>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <hr>
                            <div class="form-group ">
                                <label>เลือกรูปข่าว (สไลด์)</label>
                                <input type="file" name="picture[]" id="picture" class="filestyle" multiple />
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop

@section('pageScript')
<script type="text/javascript">

    $('#cover').filestyle({
        buttonName : 'btn-success',
        buttonText : ' เลือกรูป',
        input: false,
        icon: false,
    });

    $('#picture').filestyle({
        buttonName : 'btn-success',
        buttonText : ' เลือกไฟล์',
        input: false,
        icon: false,
    });

    $(".file-input").fileinput({
        showUpload: false,
        showCaption: false,
        browseClass: "btn btn-info",
        fileType: "any"
    })
</script>
@stop