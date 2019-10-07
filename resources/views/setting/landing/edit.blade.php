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
    {!! Form::open([ 'url' => 'setting/landing/edit' , 'method' => 'post' , 'files' => 'true' ]) !!} 
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                แก้ไขภาพ Landing page
            </div>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> บันทึก</button>
            </div>
        </div>
    </div>
    
    <div class="row ">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> อัพโหลดภาพ ขนาด 1500x450 pixels </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md"> <!-- form create project -->
                            <div class="col-md-12 m-bottom-sm">
                                @if( count($picture) > 0 )
                                    @foreach( $picture as $item )
                                    <div class="col-md-3">
                                        <img src="{{ asset($item->landingpicture) }}" class="img-responsive" />
                                        <center>
                                            <a href="{{ url('setting/landing/delete-picture/'.$item->setting_landingpicture_id ) }}" class="btn btn-danger"><i class="fa fa-remove"></i> ลบ</a>
                                        </center>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="form-group ">
                                <label>รูปข่าว (Slide)</label>
                                <input type="file" name="picture[]" id="picture" class="filestyle" multiple />
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> วีดีโอ Youtube </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body  padding-md"> <!-- form create project -->
                        @php
                        $val ="";
                        $val2 ="";
                            if(count($youtube) !=0){
                                $val = $youtube->youtube_url;
                                $val2 = $youtube->youtube_id;
                            }
                        @endphp
                            <div class="form-group">
                                <label>ลิงค์ Youtube (ต.ย. https://www.youtube.com/watch?v=<span style="color: red">2-ByJ1BllcE</span> ใส่เฉพาะ <span style="color: red">2-ByJ1BllcE</span> )</label>
                                <input type="text" name="youtube" value="{{$val}}" class="form-control" />
                                <input type="hidden" value="{{$val2}}" name ="youtube_id">
                            </div>
                 
                    </div>
                </div>
            </div>
        </div>  
        
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> เอกสารดาวน์โหลด </div>
                <div class="smart-widget-body">
                    <div class="pull-right">
                            <a href="{{ url('setting/landing/create') }}" class="btn btn-default btn-xs" style="margin:5px"><i class="fa fa-plus"></i> เพิ่มเอกสาร</a><br>
                    </div>
                       
                    <div class="smart-widget-body  padding-md"> <!-- form create project -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >คำอธิบาย</th>
                                    <th class="text-right">เพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( count($docdownload) > 0 )
                                    @foreach( $docdownload as $item )
                                        <tr>
                                            <td >{{ $item->docdownload_desc }}</td>
                                            <td class="text-right"><a href="{{ asset($item->docdownload_link) }}" class="btn btn-info text-right btn-xs" target="_blank"> <i class="fa fa-download"></i> ดาวน์โหลด</a>
                                                <a href="{{ url('setting/landing/editdoc/'.$item->docdownload_id) }}" class="btn btn-warning text-right btn-xs"><i class="fa fa-pencil"></i> แก้ไข</a>
                                                <a href="{{ url('setting/landing/delete/'.$item->docdownload_id) }}" class="btn btn-danger text-right btn-xs"><i class="fa fa-remove"></i> ลบ</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>  
                        </table>
                        {{ $docdownload->links() }}  
                    </div>
                </div>
            </div>
        </div> 
    </div>
    {!! Form::close() !!}
</div>


@stop

@section('pageScript')
<script type="text/javascript">

    $('#picture').filestyle({
        buttonName : 'btn-info',
        buttonText : ' เลือกรูป',
        input: false,
        icon: false,
    });

    // $('#doc').filestyle({
    //     buttonName : 'btn-success',
    //     buttonText : ' เลือกไฟล์',
    //     // input: false,
    //     icon: false,
    // });


    // $(".file-input").fileinput({
    //     showUpload: false,
    //     showCaption: false,
    //     browseClass: "btn btn-info",
    //     fileType: "any"
    // })
</script>
@stop