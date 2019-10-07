@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li><a href="{{ url('information') }}">รายการข่าวประชาสัมพันธ์</a></li>
        <li>เพิ่มข่าวประชาสัมพันธ์</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                เพิ่มข่าวประชาสัมพันธ์
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header"> เพิ่มข่าวประชาสัมพันธ์ </div>
                <div class="smart-widget-body">

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

                    <div class="smart-widget-body  padding-md"> <!-- form create project -->
                        {!! Form::open([ 'url' => 'information/create' , 'method' => 'post' , 'files' => 'true' ]) !!} 
                            <div class="form-group">
                            <label>เลือกหมวด </label>
                                <select class="form-control" name="category"  required="" >
                                    @if(count($budget) > 0)
                                        @foreach( $budget as $item )
                                            <option value="{{$item->budget_id}}" >
                                                {{ $item->budgetcategoryname }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label>หัวเรื่อง ประชาสัมพันธ์</label>
                                <input type="text" name="title" class="form-control" required="" />
                            </div>
                            <div class="form-group">
                                <label>รายละเอียด อย่างย่อ</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>รายละเอียด</label>
                                <textarea class="form-control" name="detail" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label>รูป cover (ขนาด 800x600พิกเซล)</label>
                                <input type="file" name="cover" id="cover" class="filestyle"  />
                            </div>
                            <div class="form-group">
                                <label>รูปข่าวสไลด์ (ขนาด 800x600พิกเซล)*เลือกหลายรูป</label>
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

    // $(".file-input").fileinput({
    //     showUpload: false,
    //     showCaption: false,
    //     browseClass: "btn btn-info",
    //     fileType: "any"
    // })
</script>
@stop