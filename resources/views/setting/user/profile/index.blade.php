@extends('layout.mains')
@section('pageCss')
@stop

@section('content')

<div class="padding-md">
    <h3 class="header-text m-bottom-md">
        โปรไฟล์ของฉัน
    </h3>
    {!! Form::open([ 'url' => 'setting/user/profile/edit' , 'method' => 'post' , 'files' => 'true' ]) !!} 
    <input type="hidden" value="{{$auth->user_id}}" name="userid">
    <input type="hidden" value="@if($auth->linenotify_id !=0){{$auth->linenotify->linenotify_id}}@endif" name="lineid">
    
    <div class="row user-profile-wrapper">
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
        <div class="col-md-3 user-profile-sidebar m-bottom-md">
            <div class="row">
                <div class="col-sm-4 col-md-12">
                    <div class="user-profile-pic">
                        <img src="{{ asset($auth->image) }}" alt="">
                        <div class="ribbon-wrapper">
                            @if ($auth->permission == 1)
                                <div class="ribbon-inner shadow-pulse bg-danger">
                            @endif
                            @if ($auth->permission == 2)
                                <div class="ribbon-inner shadow-pulse bg-info">
                            @endif
                            @if ($auth->permission == 3)
                                <div class="ribbon-inner shadow-pulse bg-success">
                            @endif
                                {{$auth->usertype}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-12">
                    <div class="user-name m-top-sm">{{$auth->name}}<i class="fa fa-circle text-success m-left-xs font-14"></i></div>

                    <div class="m-top-sm">
                        <div>
                            <i class="fa fa-map-marker user-profile-icon"></i>
                            {{$location}}
                        </div>

                        <div class="m-top-xs">
                            <i class="fa fa-briefcase user-profile-icon"></i>
                            {{$auth->usertype}}
                        </div>
                    </div>

                    <div class="form-group" >
                        <input type="file" name="file" id="file" class="filestyle" >
                    </div> 

                </div>
            </div><!-- ./row -->
        </div><!-- ./col -->
        <div class="col-md-9">
            <div class="smart-widget">
                <div class="smart-widget-inner">
                    <ul class="nav nav-tabs tab-style2 tab-right bg-grey">
		
                          <li>
                              <a href="#profileTab2" data-toggle="tab">
                                  <span class="icon-wrapper"><i class="fa fa-book"></i></span>
                                  <span class="text-wrapper" style="font-size:22px">ข้อมูลส่วนตัว</span>
                              </a>
                          </li>
                          <li class="active">
                              <a href="#profileTab1" data-toggle="tab">
                                  <span class="icon-wrapper"><i class="fa fa-trophy"></i></span>
                                  <span class="text-wrapper" style="font-size:22px">ข้อความระบบ</span>
                              </a>
                          </li>
                    </ul>
                    <div class="smart-widget-body">
                        <div class="tab-content ">
                            <div class="tab-pane fade in active" id="profileTab1">
                                <h3 class="header-text m-bottom-md">
                                    ข้อความระบบ
                                </h3>
                                <div class="row">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th >วันที่</th>
                                                <th >ข้อความ</th>
                                                <th >รายละเอียด</th>
                                                <th class="text-center" style="width:100px">สถานะ</th>
                                                <th class="text-center" style="width:200px"><a href="{{ url('setting/user/profile/makereadall/') }}" class="text-success"> <small>อ่านทั้งหมด </small> </a><a href="{{ url('setting/user/profile/deleteall/') }}" class="text-warning"> <small>ลบทั้งหมด</small> </a></th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if( count($notifymessage) > 0 )
                                            @foreach( $notifymessage as $item )
                                            @php
                                               if ($item->message_read == 1  ){
                                                    $status ="อ่านแล้ว";
                                               }else{
                                                    $status ="ยังไม่ได้อ่าน";
                                               }
                                            @endphp
                                                <tr>
                                                    <td>{{ $item->senddate }}</td>
                                                    <td >{{ $item->message_title }}</td>
                                                    <td >{{ $item->message_content }}</td>
                                                    <td class="text-center">                    
                                                        @if ($item->message_read == 1 ) <span>อ่านแล้ว</span> @else <span class="text-warning">ยังไม่ได้อ่าน</span>  @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($item->message_read == 0)
                                                            <a href="{{ url('setting/user/profile/makeread/'.$item->notify_message_id) }}" class="btn btn-xs btn-warning">มาร์คอ่าน</a>
                                                            @else
                                                            <a href="{{ url('setting/user/profile/deletemessage/'.$item->notify_message_id) }}" class="btn btn-xs btn-danger">ลบข้อความ</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                    {{ $notifymessage->links() }}

                                    
                                </div><!-- ./row -->

                                
                            </div><!-- ./tab-pane -->


                            <div class="tab-pane fade" id="profileTab2">
                                <h3 class="header-text m-bottom-md">
                                    ข้อมูลส่วนตัว
                                </h3>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>ชื่อ-สกุล</label>
                                            <input type="text" name="name" class="form-control" value="{{$auth->name}}" required />
                                    
                                            <label>ยูสเซอร์เนม</label>
                                            <input type="text" name="username" class="form-control" value="{{$auth->username}}" required disabled />
                                    
                                            <label>รหัสผ่าน</label>
                                            <input type="text" name="pass" class="form-control" required />

                                            <label>หน่วยงาน</label>
                                            <input type="text" name="section" class="form-control" value="{{$location}}" disabled />
                                    
                                            <label>ตำแหน่ง</label>
                                            <input type="text" name="position" class="form-control" value="{{$auth->position}}"  />
                                    
                                            <label>Line Notify URL</label>
                                            @php
                                                $check = $linenotify->where('user_id',$auth->user_id)->first();
                                                if(!empty($check )){
                                                    $url= $check->url;
                                                    $token = $check->linetoken;
                                                }else{
                                                    $url ="";
                                                    $token="";
                                                }
                                            @endphp
                                            <input type="text" name="linenotify" class="form-control" value="{{ $url }}" />
                                    
                                            <label>Line Token</label>
                                            <input type="text" name="linetoken" class="form-control" value="{{ $token }}" />
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row ">
                                    <div class="col-md-12">
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

</div><!-- ./padding-md -->

@stop

@section('pageScript')

<script type="text/javascript">
    $('#file').filestyle({
    buttonName : 'btn-success',
    buttonText : ' เลือกรูป',
    input: false,
    icon: false,
    });
</script>
@stop