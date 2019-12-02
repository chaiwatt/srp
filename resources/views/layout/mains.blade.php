<!DOCTYPE html>
<html lang="en">
    <head>        
        <title>คืนคนดีสู่สังคม</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="referrer" content="no-referrer" />       
        <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/dataTables.bootstrap.css') }}" rel="stylesheet">    
        <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/ionicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/morris.css') }}" rel="stylesheet"/>  
        <link href="{{ asset('assets/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/owl.theme.default.min.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <link href="{{ asset('assets/css/simplify.css') }}" rel="stylesheet"> 
        <link href="{{ asset('assets/css/extend.css') }}" rel="stylesheet"> 
        @section('pageCss')
        @show
    </head>
    <body>

        @if ($allocationbudget->count() > 0)
            @php
                $contrac_allocated = $allocationbudget->where('budget_id', 6)->first();
                $informaton_allocated = $allocationbudget->where('budget_id', 2)->first();
                $followup_allocated = $allocationbudget->where('budget_id', 3)->first();
                $readiness_allocated = $allocationbudget->where('budget_id', 4)->first();
                $occupation_allocated = $allocationbudget->where('budget_id', 5)->first();
                $deptid = $auth->department_id;
            @endphp
        @endif

        @php( $auth = Auth::user() )
        <div class="wrapper preload">
            <header class="top-nav">
                <div class="top-nav-inner">
                    <div class="nav-header">
                        <button type="button" class="navbar-toggle pull-left sidebar-toggle" id="sidebarToggleSM">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="{{ url('landing') }}" class="brand">
                            <i class="fa fa-database"></i><span class="brand-name" style="font-size:24px">คืนคนดีสู่สังคม</span>
                        </a>
                    </div>
                    <div class="nav-container">
                        <button type="button" class="navbar-toggle pull-left sidebar-toggle" id="sidebarToggleLG">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="pull-right m-right-sm">
                            <div class="user-block hidden-xs">
                                <a href="#" id="userToggle" data-toggle="dropdown">
                                    <img src="{{ asset($auth->image) }}" alt="" class="img-circle inline-block user-profile-pic">
                                    <div class="user-detail inline-block">
                                        {{ $auth->name }}
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                </a>
                                <div class="panel border dropdown-menu user-panel">
                                    <div class="panel-body paddingTB-sm">
                                        <ul>
                                            <li>
                                                <a href="{{ url('setting/user/profile') }}">
                                                    <i class="fa fa-edit fa-lg"></i><span class="m-left-xs">โปรไฟล์ของฉัน</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('logout') }}">
                                                    <i class="fa fa-sign-out fa-lg"></i><span class="m-left-xs">ออกจากระบบ</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav-notification">
                                <li class="">
                                    <a href="#" data-toggle="dropdown"><i class="fa fa-bell fa-lg"></i></a>
                                    <span class="badge badge-danger bounceIn animation-delay6 active">{{ count($message) }}</span>
                                    <ul class="dropdown-menu notification dropdown-3 pull-right">
                                        @if( count($message) > 0 )
                                        @foreach( $message as $item )
                                            <li>
                                                <a class="clearfix" href="{{ url('message/read/'. $item->notify_message_id ) }}">
                                                    <div class="detail">
                                                        <strong>{{ $item->message_title }}</strong>
                                                        <p class="no-margin">
                                                            {{ $item->message_content }}
                                                        </p>
                                                        <small class="text-muted">{{ $item->messagedateago }}</small>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                        @endif
               
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- ./top-nav-inner -->  
            </header>
            <aside class="sidebar-menu fixed">
                <div class="sidebar-inner scrollable-sidebar">
                    <div class="main-menu">
                        <ul class="accordion">
                            <li class="menu-header">
                            	หน้าแรก
                            </li>
                            <li class="bg-palette1 {{ ( Request::path()=='landing')?'active':''  }}">
                                <a href="{{ url('landing') }}">
                                    <span class="menu-content block">
                                        <span class="menu-icon"><i class="block fa fa-home fa-lg"></i></span>
                                        <span class="text m-left-sm thsaraban20" style="font-weight:200">หน้าเว็บไซต์</span>
                                    </span>
                                    <span class="menu-content-hover block">
                                    	<i class="fa fa-home fa-lg"></i>
                                    </span>
                                </a>
                            </li>
                                @if((
                                    ( strpos(\Request::path(),'project/allocation')!==false ) || 
                                    ( strpos(\Request::path(),'transfer/list')!==false ) || 
                                    ( strpos(\Request::path(),'project/refund/main')!==false ) || 
                                    ( strpos(\Request::path(),'project/allocation/department')!==false ) || 
                                    ( strpos(\Request::path(),'transfer/department')!==false ) || 
                                    ( strpos(\Request::path(),'project/refund')!==false ) || 
                                    ( strpos(\Request::path(),'project/summary')!==false ) || 
                                    ( strpos(\Request::path(),'project/allocation')!==false )))
                                    <li class="openable bg-palette1 open" >
                                @else
                                    <li class="openable bg-palette1" >
                                @endif
                                    <a href="#">
                                        <span class="menu-content block">
                                            <span class="menu-icon"><i class="block fa fa-database fa-lg"></i></span>
                                            <span class="text m-left-sm thsaraban20" style="font-weight:200">จัดการงบประมาณ</span>
                                            <span class="submenu-icon"></span>
                                        </span>
                                        <span class="menu-content-hover block">
                                            <i class="fa fa-database fa-lg"></i>
                                        </span>
                                    </a>
                                    <ul class="submenu">
                                        @if( $auth->permission == 1 )
                                            <li class="{{ ( Request::path()=='project/allocation')?'active':''  }}"><a href="{{ url('project/allocation') }}"><span class="submenu-label thsaraban20" >รายการโครงการ</span></a></li>
                                            <li class="{{ ( Request::path()=='transfer/list')?'active':''  }}"><a href="{{ url('transfer/list') }}"><span class="submenu-label thsaraban20" >รายการโอนเงิน</span></a></li>
                                            <li class="{{ ( Request::path()=='project/refund/main')?'active':''  }}"><a href="{{ url('project/refund/main') }}"><span class="submenu-label thsaraban20" >ยืนยันคืนเงิน/จัดสรร</span></a></li>
                                            <li class="{{ ( Request::path()=='project/refund/main/view')?'active':''  }}"><a href="{{ url('project/refund/main/view') }}"><span class="submenu-label thsaraban20" >รายการคืนเงิน</span></a></li>
                                            <li class="{{ ( Request::path()=='project/summary')?'active':''  }}"><a href="{{ url('project/summary') }}"><span class="submenu-label thsaraban20" >รายการสรุปโครงการ</span></a></li>
                                        @elseif( $auth->permission == 2 )
                                            <li class="{{ ( Request::path()=='project/allocation/department')?'active':''  }}"><a href="{{ url('project/allocation/department') }}"><span class="submenu-label thsaraban20" >งบประมาณจัดสรร</span></a></li>
                                            <li class="{{ ( Request::path()=='project/allocation/department/list')?'active':''  }}"><a href="{{ url('project/allocation/department/list') }}"><span class="submenu-label thsaraban20" >รายการงบจัดสรร</span></a></li>
                                            <li class="{{ ( Request::path()=='transfer/department')?'active':''  }}"><a href="{{ url('transfer/department') }}"><span class="submenu-label thsaraban20" >รายการโอนเงิน</span></a></li>
                                            <li class="{{ ( Request::path()=='project/refund/department')?'active':''  }}"><a href="{{ url('project/refund/department') }}"><span class="submenu-label thsaraban20" >รายการคืนเงินค่าใช้จ่าย</span></a></li>
                                        @elseif( $auth->permission == 3 )
                                            <li class="{{ ( Request::path()=='project/allocation/section')?'active':''  }}"><a href="{{ url('project/allocation/section') }}"><span class="submenu-label thsaraban20" >งบประมาณจัดสรร</span></a></li>
                                            <li class="{{ ( Request::path()=='project/refund/section')?'active':''  }}"><a href="{{ url('project/refund/section') }}"><span class="submenu-label thsaraban20" >รายการคืนเงินค่าใช้จ่าย</span></a></li>
                                        @endif
                                    </ul>
                                </li>

                            {{-- จ้างงาน --}}
                            @if( ( strpos(\Request::path(),'recurit/employ')!==false ) || 
                                ( strpos(\Request::path(),'recurit/report')!==false ) || 
                                ( strpos(\Request::path(),'recurit/survey')!==false ) || 
                                ( strpos(\Request::path(),'recurit/refund')!==false ) || 
                                ( strpos(\Request::path(),'recurit/hire')!==false ) || 
                                ( strpos(\Request::path(),'recurit/payment')!==false ) || 
                                ( strpos(\Request::path(),'recurit/resign')!==false ) || 
                                ( strpos(\Request::path(),'recurit/cancel')!==false ) || 
                                ( strpos(\Request::path(),'recurit/report')!==false ) || 
                                ( strpos(\Request::path(),'recurit/report/main')!==false ) || 
                                ( strpos(\Request::path(),'report/refund')!==false ) || 
                                ( strpos(\Request::path(),'report/recurit/main')!==false ) || 
                                ( strpos(\Request::path(),'report/recurit/department')!==false ) ||
                                ( strpos(\Request::path(),'recurit/register')!==false ) ||
                                ( strpos(\Request::path(),'recurit/assesment')!==false ) ||
                                ( strpos(\Request::path(),'project/report')!==false ))
  
                                <li class="openable bg-palette2 open">
                            @else
                                <li class="openable bg-palette2">
                            @endif
                                    <a href="#">
                                        <span class="menu-content block">
                                            <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                            <span class="text m-left-sm thsaraban20" style="font-weight:200">บริหารจัดการจ้างงาน</span>
                                            <span class="submenu-icon"></span>
                                        </span>
                                        <span class="menu-content-hover block">
                                            <i class="fa fa-gear fa-lg"></i>
                                        </span>
                                    </a>
                                    <ul class="submenu">

                                        @if( $auth->permission == 1 )
                                        <li class="{{ ( Request::path()=='recurit/employ')?'active':''  }}"><a href="{{ url('recurit/employ') }}"><span class="submenu-label thsaraban20" >กรอบการจ้างงาน</span></a></li>

                                        @if ( ( strpos(\Request::path(),'recurit/report')!==false ) || 
                                        ( strpos(\Request::path(),'report/refund')!==false ) || 
                                        ( strpos(\Request::path(),'project/report')!==false ) ||                                                                                                             
                                        ( strpos(\Request::path(),'report/recurit')!==false ) )
                                                <li class="openable open">
                                            @else
                                                <li class="openable">
                                        @endif
                            
                                            <a href="{{ url('recurit/report') }}">
                                                <span class="submenu-label thsaraban20">รายงาน</span>
                                            </a>
                                            <ul class="submenu third-level">                    
                                                <li class="{{ ( Request::path()=='recurit/report')?'active':''  }}"><a href="{{ url('recurit/report') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> สรุปรายการจ้างงาน</span></a></li>
                                                <li class="{{ ( Request::path()=='recurit/report/payment')?'active':''  }}"><a href="{{ url('recurit/report/payment') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> สรุปรายการเบิกจ่ายเงินเดือน</span></a></li>
                                                <li class="{{ ( Request::path()=='recurit/report/main/survey')?'active':''  }}"><a href="{{ url('recurit/report/main/survey') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการสำรวจ</span></a></li>
                                                <li class="{{ ( Request::path()=='recurit/report/main/resign')?'active':''  }}"><a href="{{ url('recurit/report/main/resign') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการลาออก</span></a></li>
                                                <li class="{{ ( Request::path()=='recurit/report/main/cancel')?'active':''  }}"><a href="{{ url('recurit/report/main/cancel') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการยกเลิกจ้างงาน</span></a></li>   
                                                <li class="{{ ( Request::path()=='recurit/report/main/assessment')?'active':''  }}"><a href="{{ url('recurit/report/main/assessment') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานประเมิลผลบุคลิกภาพ</span></a></li>                                          
                                                <li class="{{ ( Request::path()=='report/recurit/main/allocation')?'active':''  }}"><a href="{{ url('report/recurit/main/allocation') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการจ้างงาน</span></a></li>
                                                <li class="{{ ( Request::path()=='report/recurit/main/budget')?'active':''  }}"><a href="{{ url('report/recurit/main/budget') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการเบิกจ่ายเงินเดือน</span></a></li>
                                                <li class="{{ ( Request::path()=='report/refund/main')?'active':''  }}"><a href="{{ url('report/refund/main') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานคืนค่าใช้จ่าย</span></a></li>
                                                <li class="{{ ( Request::path()=='project/report/main')?'active':''  }}"><a href="{{ url('project/report/main') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานผลการเบิกจ่าย</span></a></li>

                                            </ul>
                                        </li>

                                        @elseif( $auth->permission == 2 )
                                        <li class="{{ ( Request::path()=='recurit/survey')?'active':''  }}"><a href="{{ url('recurit/survey') }}"><span class="submenu-label thsaraban20" >รายการสำรวจ</span></a></li>
                                        <li class="{{ ( Request::path()=='recurit/employ/section')?'active':'' }}"><a href="{{ url('recurit/employ/section') }}"><span class="submenu-label thsaraban20" >รายการจัดสรรการจ้างงาน</span></a></li>
                                        <li class="{{ ( Request::path()=='recurit/register/department')?'active':''  }}"><a href="{{ url('recurit/register/department') }}"><span class="submenu-label thsaraban20" >รายการผู้เข้าร่วมโครงการ</span></a></li>
                                        <li class="{{ ( Request::path()=='recurit/report/department/payment')?'active':''  }}"><a href="{{ url('recurit/report/department/payment') }}"><span class="submenu-label thsaraban20" >การเบิกจ่ายเงินเดือน</span></a></li>
                                        <li class="{{ ( Request::path()=='recurit/refund/department/view')?'active':''  }}"><a href="{{ url('recurit/refund/department/view') }}"><span class="submenu-label thsaraban20" >ยืนยันงบประมาณคืนที่ได้รับ</span></a></li>
                                        <li class="{{ ( Request::path()=='recurit/refund/department')?'active':''  }}"><a href="{{ url('recurit/refund/department') }}"><span class="submenu-label thsaraban20" >คืนงบประมาณจัดจ้าง</span></a></li>

                                        @if ( ( strpos(\Request::path(),'recurit/report/department')!==false ) || 
                                        ( strpos(\Request::path(),'project/report/department')!==false ) ||
                                        ( strpos(\Request::path(),'recurit/register/department')!==false ) ||
                                        ( strpos(\Request::path(),'report/recurit/department')!==false ) ||
                                        ( strpos(\Request::path(),'report/refund/department')!==false )
                                        )                                                                                                            
 
                                                <li class="openable open">
                                            @else
                                                <li class="openable">
                                        @endif

                                            <a href="{{ url('recurit/report/department') }}">
                                                <span class="submenu-label thsaraban20" >รายงาน</span>
                                            </a>
                                            <ul class="submenu third-level">                                               
                                                <li class="{{ ( Request::path()=='recurit/report/department/survey')?'active':''  }}"><a href="{{ url('recurit/report/department/survey') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการสำรวจ</span></a></li>
                                                <li class="{{ ( Request::path()=='recurit/report/department/resign')?'active':''  }}"><a href="{{ url('recurit/report/department/resign') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการลาออก</span></a></li>
                                                <li class="{{ ( Request::path()=='recurit/report/department/cancel')?'active':''  }}"><a href="{{ url('recurit/report/department/cancel') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการยกเลิกจ้างงาน</span></a></li>
                                                <li class="{{ ( Request::path()=='recurit/report/department/assessment')?'active':''  }}"><a href="{{ url('recurit/report/department/assessment') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานประเมิลผลบุคลิกภาพ</span></a></li>
                                                <li class="{{ ( Request::path()=='project/report/department')?'active':''  }}"><a href="{{ url('project/report/department') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานผลการเบิกจ่าย</span></a></li>
                                                <li class="{{ ( Request::path()=='report/recurit/department/allocation')?'active':''  }}"><a href="{{ url('report/recurit/department/allocation') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการจ้างงาน</span></a></li>
                                                <li class="{{ ( Request::path()=='report/recurit/department/budget')?'active':''  }}"><a href="{{ url('report/recurit/department/budget') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการเบิกจ่ายเงินเดือน</span></a></li>
                                                <li class="{{ ( Request::path()=='report/refund/department')?'active':''  }}"><a href="{{ url('report/refund/department') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานคืนค่าใช้จ่าย</span></a></li>
                                                <li class="{{ ( Request::path()=='recurit/report/department/sum')?'active':''  }}"><a href="{{ url('recurit/report/department/sum') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> สรุปบริหารจัดการจ้างงาน</span></a></li>
                                                
                                            </ul>
                                        </li>

                                        @elseif( $auth->permission == 3 )
                                        <li class="{{ ( Request::path()=='recurit/survey/section')?'active':''  }}"><a href="{{ url('recurit/survey/section') }}"><span class="submenu-label thsaraban20" >รายการสำรวจการจ้างงาน</span></a></li>
                                        <li class="{{ ( Request::path()=='recurit/register/section')?'active':''  }}"><a href="{{ url('recurit/register/section') }}"><span class="submenu-label thsaraban20" >ผู้สมัครร่วมโครงการ</span></a></li>
                                        <li class="{{ ( Request::path()=='recurit/hire/section/view')?'active':''  }}"><a href="{{ url('recurit/hire/section/view') }}"><span class="submenu-label thsaraban20" >รายการจ้างงาน</span></a></li>
                                        <li class="{{ ( Request::path()=='recurit/hire/section')?'active':''  }}"><a href="{{ url('recurit/hire/section') }}"><span class="submenu-label thsaraban20" >บันทึกจ้างงาน</span></a></li>
                                        <li class="{{ ( Request::path()=='recurit/payment/section')?'active':''  }}"><a href="{{ url('recurit/payment/section') }}"><span class="submenu-label thsaraban20" >บันทึกเบิกจ่ายเงินเดือน</span></a></li>
                                        <li class="{{ ( Request::path()=='recurit/payment/section/list')?'active':''  }}"><a href="{{ url('recurit/payment/section/list') }}"><span class="submenu-label thsaraban20" >รายการเบิกจ่าย</span></a></li>
                                        <li class="{{ ( Request::path()=='recurit/resign/section')?'active':''  }}"><a href="{{ url('recurit/resign/section') }}"><span class="submenu-label thsaraban20" >บันทึกลาออก</span></a></li>
                                        <li class="{{ ( Request::path()=='recurit/cancel/section')?'active':''  }}"><a href="{{ url('recurit/cancel/section') }}"><span class="submenu-label thsaraban20" >บันทึกยกเลิกจ้างงาน</span></a></li>
                                        <li class="{{ ( Request::path()=='recurit/refund/section')?'active':''  }}"><a href="{{ url('recurit/refund/section') }}"><span class="submenu-label thsaraban20" >คืนงบประมาณจัดจ้าง</span></a></li>
                                        <li class="{{ ( Request::path()=='recurit/assesment')?'active':''  }}"><a href="{{ url('recurit/assesment') }}"><span class="submenu-label thsaraban20" >การทดสอบบุคลิกภาพ</span></a></li>
                                                                                
                                        @if ( ( strpos(\Request::path(),'recurit/report/section')!==false ) || 
                                        ( strpos(\Request::path(),'recurit/assesment/report')!==false ) 
                                        )                                                                                                            
 
                                                <li class="openable open">
                                            @else
                                                <li class="openable">
                                        @endif

                                                <a href="{{ url('recurit/report/section') }}">
                                                    <span class="submenu-label thsaraban20" >รายงาน</span>
                                                </a>
                                                <ul class="submenu third-level">                    
                                                        <li class="{{ ( Request::path()=='recurit/report/section')?'active':''  }}"><a href="{{ url('recurit/report/section') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> สรุปรายการการจ้างงาน</span></a></li>
                                                        <li class="{{ ( Request::path()=='recurit/report/section/allpayment')?'active':''  }}"><a href="{{ url('recurit/report/section/allpayment') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการเบิกจ่าย</span></a></li>                
                                                        <li class="{{ ( Request::path()=='recurit/report/section/personal')?'active':''  }}"><a href="{{ url('recurit/report/section/personal') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานเบิกจ่ายรายบุคคล</span></a></li>   
                                                        <li class="{{ ( Request::path()=='recurit/report/section/payment')?'active':''  }}"><a href="{{ url('recurit/report/section/payment') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการเบิกจ่ายเงินเดือน</span></a></li>                
                                                        <li class="{{ ( Request::path()=='recurit/report/section/resign')?'active':''  }}"><a href="{{ url('recurit/report/section/resign') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการลาออก</span></a></li>                
                                                        <li class="{{ ( Request::path()=='recurit/report/section/cancel')?'active':''  }}"><a href="{{ url('recurit/report/section/cancel') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการยกเลิกจ้างงาน</span></a></li>                
                                                        <li class="{{ ( Request::path()=='recurit/report/section/recurit')?'active':''  }}"><a href="{{ url('recurit/report/section/recurit') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานผลการจ้างานรายบุคคล</span></a></li>         
                                                        <li class="{{ ( strpos(\Request::path(),'recurit/assesment/report')!==false)?'active':'' }}"><a href="{{ url('recurit/assesment/report') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานประเมินผลบุคลิกภาพ</span></a></li>
                                                </ul>
                                            </li>

                                        @endif
                                    </ul>
                                </li>

                            {{-- จ้างเหมา --}}  
                             @if( $auth->permission == 1 )
                                @if( ( strpos(\Request::path(),'contractor/department')!== false ) || 
                                ( strpos(\Request::path(),'contractor/hire')!== false )  || 
                                ( strpos(\Request::path(),'contractor/payment')!== false )  || 
                                ( strpos(\Request::path(),'contractor/resign')!== false ) || 
                                ( strpos(\Request::path(),'contractor/cancel')!== false ) || 
                                ( strpos(\Request::path(),'contractor/main')!== false ) || 
                                ( strpos(\Request::path(),'contractor/refund')!== false )      
                                )
                                    <li class="openable bg-palette1 open ">
                                @else
                                    <li class="openable bg-palette1">
                                @endif
                                        <a href="#">
                                            <span class="menu-content block">
                                                <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                                <span class="text m-left-sm thsaraban20" style="font-weight:200">จ้างเหมาบุคลากร</span>
                                                <span class="submenu-icon"></span>
                                            </span>
                                            <span class="menu-content-hover block">
                                                <i class="fa fa-gear fa-lg"></i>
                                            </span>
                                        </a>
                                        <ul class="submenu">
                                            @if( $auth->permission == 1 )
                                                <li class="{{ ( strpos(\Request::path(),'contractor/main/employ')!==false)?'active':'' }}"><a href="{{ url('contractor/main/employ') }}"><span class="submenu-label thsaraban20" >จัดสรรตำแหน่ง</span></a></li>      

                                                @if ( ( strpos(\Request::path(),'contractor/main')!==false )
                                                )                                                                                                            
                                                        <li class="openable open">
                                                    @else
                                                        <li class="openable">
                                                @endif

                                                <a href="{{ url('recurit/report/section') }}">
                                                    <span class="submenu-label thsaraban20" >รายงาน</span>
                                                </a>
                                                <ul class="submenu third-level">                    
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/main/resign')!==false)?'active':'' }}"><a href="{{ url('contractor/main/resign') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการลาออก</span></a></li>      
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/main/cancel')!==false)?'active':'' }}"><a href="{{ url('contractor/main/cancel') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการยกเลิกจ้างงาน</span></a></li>      
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/main/recurit')!==false)?'active':'' }}"><a href="{{ url('contractor/main/recurit') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานผลการจ้างเหมา</span></a></li>          
                                                </ul>
                                            </li>
                                                
                                            @endif
                                            @if( $auth->permission == 2 )
                                                @if (!empty($contrac_allocated))
                                                {{$contrac_allocated}}
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/register')!==false)?'active':'' }}"><a href="{{ url('contractor/register') }}"><span class="submenu-label thsaraban20" >ผู้สมัครจ้างเหมา</span></a></li>      
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/hire')!==false)?'active':'' }}"><a href="{{ url('contractor/hire') }}"><span class="submenu-label thsaraban20" >รายการจ้างเหมา</span></a></li>       
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/payment')!==false)?'active':'' }}"><a href="{{ url('contractor/payment') }}"><span class="submenu-label thsaraban20" >เบิกจ่ายเงินเดือน</span></a></li>                                                        
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/resign')!==false)?'active':'' }}"><a href="{{ url('contractor/resign') }}"><span class="submenu-label thsaraban20" >บันทึกลาออก</span></a></li>      
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/cancel')!==false)?'active':'' }}"><a href="{{ url('contractor/cancel') }}"><span class="submenu-label thsaraban20" >บันทึกยกเลิกจ้างงาน</span></a></li>      
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/refund')!==false)?'active':'' }}"><a href="{{ url('contractor/refund') }}"><span class="submenu-label thsaraban20" >คืนเงิน</span></a></li>      
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/department/recurit')!==false)?'active':'' }}"><a href="{{ url('contractor/department/recurit') }}"><span class="submenu-label thsaraban20" >รายงานผลการจ้างเหมา</span></a></li>      
                                                @endif
                                            @endif                    
                                        </ul>
                                    </li>
                                   
                                @elseif($auth->permission == 2 && !empty($contrac_allocated))
                                    @if( ( strpos(\Request::path(),'contractor/department')!== false ) || 
                                    ( strpos(\Request::path(),'contractor/hire')!== false )  || 
                                    ( strpos(\Request::path(),'contractor/payment')!== false )  || 
                                    ( strpos(\Request::path(),'contractor/resign')!== false ) || 
                                    ( strpos(\Request::path(),'contractor/cancel')!== false ) || 
                                    ( strpos(\Request::path(),'contractor/cancel')!== false ) || 
                                    ( strpos(\Request::path(),'contractor/register')!== false ) || 
                                    ( strpos(\Request::path(),'contractor/refund')!== false )     
                                    
                                    )
                                        <li class="openable bg-palette_contractor open ">
                                    @else
                                        <li class="openable bg-palette_contractor">
                                    @endif
                                            <a href="#">
                                                <span class="menu-content block">
                                                    <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                                    <span class="text m-left-sm thsaraban20" style="font-weight:200">จ้างเหมาบุคลากร</span>
                                                    <span class="submenu-icon"></span>
                                                </span>
                                                <span class="menu-content-hover block">
                                                    <i class="fa fa-gear fa-lg"></i>
                                                </span>
                                            </a>
                                            <ul class="submenu">
                                                @if (!empty($contrac_allocated))
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/register')!==false)?'active':'' }}"><a href="{{ url('contractor/register') }}"><span class="submenu-label thsaraban20" >ผู้สมัครจ้างเหมา</span></a></li>      
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/hire')!==false)?'active':'' }}"><a href="{{ url('contractor/hire') }}"><span class="submenu-label thsaraban20" >บันทึกจ้างเหมา</span></a></li>       
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/payment')!==false)?'active':'' }}"><a href="{{ url('contractor/payment') }}"><span class="submenu-label thsaraban20" >เบิกจ่ายเงินเดือน</span></a></li>      
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/payment/list')!==false)?'active':'' }}"><a href="{{ url('contractor/payment/list') }}"><span class="submenu-label thsaraban20" >รายการเบิกจ่าย</span></a></li>     
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/resign')!==false)?'active':'' }}"><a href="{{ url('contractor/resign') }}"><span class="submenu-label thsaraban20" >บันทึกลาออก</span></a></li>      
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/cancel')!==false)?'active':'' }}"><a href="{{ url('contractor/cancel') }}"><span class="submenu-label thsaraban20" >บันทึกยกเลิกจ้างงาน</span></a></li>      
                                                    <li class="{{ ( strpos(\Request::path(),'contractor/refund')!==false)?'active':'' }}"><a href="{{ url('contractor/refund') }}"><span class="submenu-label thsaraban20" >คืนเงินจ้างเหมา</span></a></li>                                                          
                                                    @if ( ( strpos(\Request::path(),'contractor/department')!==false ) 
                                                    )                                                                                                            
                                                            <li class="openable open">
                                                        @else
                                                            <li class="openable">
                                                    @endif
            
                                                            <a href="{{ url('recurit/report/section') }}">
                                                                <span class="submenu-label thsaraban20" >รายงาน</span>
                                                            </a>
                                                            <ul class="submenu third-level">                    
                                                                <li class="{{ ( strpos(\Request::path(),'contractor/department/recurit')!==false)?'active':'' }}"><a href="{{ url('contractor/department/recurit') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานผลการจ้างเหมา</span></a></li>      
                                                                <li class="{{ ( strpos(\Request::path(),'contractor/department/resign')!==false)?'active':'' }}"><a href="{{ url('contractor/department/resign') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการลาออก</span></a></li>      
                                                                <li class="{{ ( strpos(\Request::path(),'contractor/department/cancel')!==false)?'active':'' }}"><a href="{{ url('contractor/department/cancel') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานการยกเลิกจ้างงาน</span></a></li>      
                                                            </ul>
                                                        </li>
                                                @endif                 
                                            </ul>
                                        </li>
                               @endif 

                            {{-- ระบบฝึกอบรมและเตรียมความพร้อม --}}  
                            @if ($auth->permission == 1)
                                @if( ( strpos(\Request::path(),'readiness/project')!==false ) || 
                                ( strpos(\Request::path(),'readiness/report')!==false ) || 
                                ( strpos(\Request::path(),'report/readiness/main')!==false ) || 
                                ( strpos(\Request::path(),'readiness/refund')!==false )   
                                )
                                    <li class="openable bg-palette3 open ">
                                @else
                                    <li class="openable bg-palette3">
                                @endif
                                    <a href="#">
                                        <span class="menu-content block">
                                            <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                            <span class="text m-left-sm thsaraban20" style="font-weight:200">อบรมและเตรียมความพร้อม</span>
                                            <span class="submenu-icon"></span>
                                        </span>
                                        <span class="menu-content-hover block">
                                            <i class="fa fa-gear fa-lg"></i>
                                        </span>
                                    </a>
                                    <ul class="submenu">
                                        <li class="{{ ( Request::path()=='readiness/project/main')?'active':''  }}"><a href="{{ url('readiness/project/main') }}"><span class="submenu-label thsaraban20" > รายการโครงการอบรม</span></a></li>
                                        <li class="{{ ( Request::path()=='readiness/project/main/confirm')?'active':''  }}"><a href="{{ url('readiness/project/main/confirm') }}"><span class="submenu-label thsaraban20" > โครงการรอพิจารณา</span></a></li>
                                        @if ( ( strpos(\Request::path(),'report/readiness/main')!==false  ))                                                                                                            
                                                <li class="openable open">
                                            @else
                                                <li class="openable">
                                        @endif

                                            <a href="{{ url('report/readiness/main') }}">
                                                <span class="submenu-label thsaraban20" >รายงาน</span>
                                            </a>
                                            <ul class="submenu third-level">
                                                <li class="{{ ( Request::path()=='report/readiness/main')?'active':''  }}"><a href="{{ url('report/readiness/main') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานอบรมเตรียมความพร้อม</span></a></li>
                                                <li class="{{ ( Request::path()=='report/readiness/main/readinesschart')?'active':''  }}"><a href="{{ url('report/readiness/main/readinesschart') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> แผนภาพอบรมเตรียมความพร้อม</span></a></li>
                                            </ul>
                                        </li>             
                                    </ul>
                                </li>
                                @elseif($auth->permission == 2)
                                    @if (!empty($readiness_allocated))
                                        @if( ( strpos(\Request::path(),'readiness/project')!==false ) || 
                                        ( strpos(\Request::path(),'readiness/report')!==false ) || 
                                        ( strpos(\Request::path(),'report/readiness/department')!==false ) || 
                                        ( strpos(\Request::path(),'readiness/refund')!==false )   
                                        )
                                        <li class="openable bg-palette_trainingreadiness open ">
                                            @else
                                                <li class="openable bg-palette_trainingreadiness">
                                            @endif
                                                <a href="#">
                                                    <span class="menu-content block">
                                                        <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                                        <span class="text m-left-sm thsaraban20" style="font-weight:200">อบรมและเตรียมความพร้อม</span>
                                                        <span class="submenu-icon"></span>
                                                    </span>
                                                    <span class="menu-content-hover block">
                                                        <i class="fa fa-gear fa-lg"></i>
                                                    </span>
                                                </a>
                                                <ul class="submenu">
                                                    <li class="{{ ( strpos(\Request::path(),'readiness/project/department')!==false)?'active':'' }}"><a href="{{ url('readiness/project/department') }}"><span class="submenu-label thsaraban20" >โครงการฝึกอบรม</span></a></li>          
                                                    <li class="{{ ( strpos(\Request::path(),'readiness/report/department')!==false)?'active':'' }}"><a href="{{ url('readiness/report/department') }}"><span class="submenu-label thsaraban20" >รายงานค่าใช้จ่าย</span></a></li>      
                                                    <li class="{{ ( strpos(\Request::path(),'readiness/refund/department')!==false)?'active':'' }}"><a href="{{ url('readiness/refund/department') }}"><span class="submenu-label thsaraban20" >ยืนยันรับคืนเงิน</span></a></li>      
                                                    <li class="{{ ( strpos(\Request::path(),'readiness/refund')!==false)?'active':'' }}"><a href="{{ url('readiness/refund') }}"><span class="submenu-label thsaraban20" >คืนเงินค่าใช้จ่าย</span></a></li>      
                                                    
                                                    @if ( ( strpos(\Request::path(),'report/readiness/department')!==false  ))                                                                                                            
                                                            <li class="openable open">
                                                        @else
                                                            <li class="openable">
                                                    @endif
                                                        <a href="{{ url('report/readiness/department') }}">
                                                            <span class="submenu-label thsaraban20" >รายงาน</span>
                                                        </a>
                                                        <ul class="submenu third-level">
                                                            <li class="{{ ( Request::path()=='report/readiness/department')?'active':''  }}"><a href="{{ url('report/readiness/department') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานอบรมเตรียมความพร้อม</span></a></li>
                                                            <li class="{{ ( Request::path()=='report/readiness/department/readinesschart')?'active':''  }}"><a href="{{ url('report/readiness/department/readinesschart') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> แผนภาพอบรมเตรียมความพร้อม</span></a></li>                                                        
                                                        </ul>
                                                    </li>                
                                                </ul>
                                            </li>
                                        @endif    
                                    @elseif($auth->permission == 3)
                                    @php
                                        $readiness_allocated = $allocationbudget->where('department_id',$deptid)->where('budget_id',4)->first();
                                    @endphp
                                    @if (!empty($readiness_allocated))
                                    
                                    @if( ( strpos(\Request::path(),'readiness/project')!==false ) ||
                                     ( strpos(\Request::path(),'readiness/report')!==false ) || 
                                     ( strpos(\Request::path(),'report/readiness/section')!==false ) || 
                                     ( strpos(\Request::path(),'readiness/refund')!==false )   
                                     )
                                    <li class="openable bg-palette_trainingreadiness open ">
                                        @else
                                            <li class="openable bg-palette_trainingreadiness">
                                        @endif
                                            <a href="#">
                                                <span class="menu-content block">
                                                    <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                                    <span class="text m-left-sm thsaraban20" style="font-weight:200">อบรมและเตรียมความพร้อม</span>
                                                    <span class="submenu-icon"></span>
                                                </span>
                                                <span class="menu-content-hover block">
                                                    <i class="fa fa-gear fa-lg"></i>
                                                </span>
                                            </a>
                                            <ul class="submenu">
                                                <li class="{{ ( strpos(\Request::path(),'readiness/project/section')!==false)?'active':'' }}"><a href="{{ url('readiness/project/section') }}"><span class="submenu-label thsaraban20" >โครงการฝึกอบรม</span></a></li>      
                                                <li class="{{ ( strpos(\Request::path(),'readiness/project/section/list')!==false)?'active':'' }}"><a href="{{ url('readiness/project/section/list') }}"><span class="submenu-label thsaraban20" >บันทึกข้อมูลโครงการ</span></a></li>                                       
                                                <li class="{{ ( strpos(\Request::path(),'readiness/project/section/refundlist')!==false)?'active':'' }}"><a href="{{ url('readiness/project/section/refundlist') }}"><span class="submenu-label thsaraban20" >การคืนเงิน</span></a></li>      
                                                <li class="{{ ( strpos(\Request::path(),'report/readiness/section')!==false)?'active':'' }}"><a href="{{ url('report/readiness/section') }}"><span class="submenu-label thsaraban20" >รายงานการฝึกอบรม</span></a></li>                     
                                            </ul>
                                        </li>
                                    @endif    
                                @endif  

                            {{-- ระบบฝึกอบรมวิชาชีพ --}}
                            @if ($auth->permission == 1)
                                @if( (( strpos(\Request::path(),'occupation/project')!==false ) || 
                                ( strpos(\Request::path(),'occupation/report')!==false ) || 
                                ( strpos(\Request::path(),'report/occupation/main')!==false ) ||
                                ( strpos(\Request::path(),'report/followup/main')!==false ) ||
                                ( strpos(\Request::path(),'occupation/refund')!==false ) ) && (Request::path()!='report/followup/main/onsite') 
                                )
                                
                                    <li class="openable bg-palette4 open ">
                                @else
                                    <li class="openable bg-palette4">
                                @endif
                                    <a href="#">
                                        <span class="menu-content block">
                                            <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                            <span class="text m-left-sm thsaraban20" style="font-weight:200">การฝึกอบรมวิชาชีพ</span>
                                            <span class="submenu-icon"></span>
                                        </span>
                                        <span class="menu-content-hover block">
                                            <i class="fa fa-gear fa-lg"></i>
                                        </span>
                                    </a>
                                    <ul class="submenu">
                                        <li class="{{ ( Request::path()=='occupation/project/main')?'active':''  }}"><a href="{{ url('occupation/project/main') }}"><span class="submenu-label thsaraban20" > รายการโครงการอบรม</span></a></li>
                                        <li class="{{ ( Request::path()=='occupation/project/main/confirm')?'active':''  }}"><a href="{{ url('occupation/project/main/confirm') }}"><span class="submenu-label thsaraban20" > โครงการรอพิจารณา</span></a></li>
                                        
                                        @if ( ( strpos(\Request::path(),'report/occupation/main')!==false ) ||
                                        ( strpos(\Request::path(),'report/followup/main')!==false )
                                        )                                                                                                            
                                                <li class="openable open">
                                            @else
                                                <li class="openable">
                                        @endif

                                            <a href="{{ url('report/followup/main') }}">
                                                <span class="submenu-label thsaraban20" >รายงาน</span>
                                            </a>
                                            <ul class="submenu third-level">

                                                <li class="{{ ( Request::path()=='report/occupation/main')?'active':''  }}"><a href="{{ url('report/occupation/main') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานอบรมวิชาชีพ</span></a></li>
                                                <li class="{{ ( Request::path()=='report/occupation/main/occupationchart')?'active':''  }}"><a href="{{ url('report/occupation/main/occupationchart') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> แผนภาพอบรมอบรมวิชาชีพ</span></a></li>
                                                <li class="{{ ( Request::path()=='report/followup/main/hasoccupation')?'active':''  }}"><a href="{{ url('report/followup/main/hasoccupation') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> ฝึกอบรมแล้วมีอาชีพ</span></a></li>
                                                <li class="{{ ( Request::path()=='report/followup/main/hasoccupation/hasoccupationchart')?'active':''  }}"><a href="{{ url('report/followup/main/hasoccupation/hasoccupationchart') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> แผนภาพฝึกอบรมแล้วมีอาชีพ</span></a></li>
                                                <li class="{{ ( Request::path()=='report/followup/main/enoughincome')?'active':''  }}"><a href="{{ url('report/followup/main/enoughincome') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> มีอาชีพและรายได้เพียงพอ</span></a></li>
                                                <li class="{{ ( Request::path()=='report/followup/main/enoughincome/enoughincomechart')?'active':''  }}"><a href="{{ url('report/followup/main/enoughincome/enoughincomechart') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> แผนภาพรายได้เพียงพอ</span></a></li>
                                                
                                            </ul>
                                        </li>                  
                                    </ul>
                                </li>

                              
                             @elseif( $auth->permission == 2)
                                @if (!empty($occupation_allocated))
                                    @if( (( strpos(\Request::path(),'occupation/project')!==false ) || 
                                    ( strpos(\Request::path(),'report/occupation/department')!==false ) || 
                                    ( strpos(\Request::path(),'report/followup/department')!==false ) || 
                                    ( strpos(\Request::path(),'occupation/report')!==false ) || 
                                    ( strpos(\Request::path(),'occupation/refund')!==false )) && (Request::path()!='report/followup/department/onsite')   
                                    )
                                    
                                    
                                        <li class="openable bg-palette_trainingreadiness open ">
                                    @else
                                        <li class="openable bg-palette_trainingreadiness">
                                    @endif
                                        <a href="#">
                                            <span class="menu-content block">
                                                <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                                <span class="text m-left-sm thsaraban20" style="font-weight:200">การฝึกอบรมวิชาชีพ</span>
                                                <span class="submenu-icon"></span>
                                            </span>
                                            <span class="menu-content-hover block">
                                                <i class="fa fa-gear fa-lg"></i>
                                            </span>
                                        </a>
                                        <ul class="submenu">
                                            <li class="{{ ( Request::path()=='occupation/project/department')?'active':''  }}"><a href="{{ url('occupation/project/department') }}"><span class="submenu-label thsaraban20" >โครงการฝึกอบรม</span></a></li>
                                            <li class="{{ ( Request::path()=='occupation/report/department')?'active':''  }}"><a href="{{ url('occupation/report/department') }}"><span class="submenu-label thsaraban20" >รายการเบิกจ่าย</span></a></li>
                                            <li class="{{ ( Request::path()=='occupation/refund/department')?'active':''  }}"><a href="{{ url('occupation/refund/department') }}"><span class="submenu-label thsaraban20" >ยืนยันรับคืนเงิน</span></a></li>
                                            <li class="{{ ( Request::path()=='occupation/refund')?'active':''  }}"><a href="{{ url('occupation/refund') }}"><span class="submenu-label thsaraban20" >คืนเงินค่าใช้จ่าย</span></a></li>
                                            @if ( ( strpos(\Request::path(),'report/occupation/department')!==false ) ||
                                            ( strpos(\Request::path(),'report/followup/department')!==false )
                                            )                                                                                                            
                                                    <li class="openable open">
                                                @else
                                                    <li class="openable">
                                            @endif

                                                <a href="{{ url('report/followup/department') }}">
                                                    <span class="submenu-label thsaraban20" >รายงาน</span>
                                                </a>
                                                <ul class="submenu third-level">
                                                    <li class="{{ ( Request::path()=='report/occupation/department')?'active':''  }}"><a href="{{ url('report/occupation/department') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานอบรมวิชาชีพ</span></a></li>
                                                    <li class="{{ ( Request::path()=='report/occupation/department/occupationchart')?'active':''  }}"><a href="{{ url('report/occupation/department/occupationchart') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> แผนภาพอบรมวิชาชีพ</span></a></li>
                                                    <li class="{{ ( Request::path()=='report/followup/department')?'active':''  }}"><a href="{{ url('report/followup/department') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> ฝึกอบรมแล้วมีอาชีพ</span></a></li>
                                                    <li class="{{ ( Request::path()=='report/followup/department/hasoccupationchart')?'active':''  }}"><a href="{{ url('report/followup/department/hasoccupationchart') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> แผนภาพฝึกอบรมแล้วมีอาชีพ</span></a></li>
                                                    <li class="{{ ( Request::path()=='report/followup/department/enoughexpense')?'active':''  }}"><a href="{{ url('report/followup/department/enoughexpense') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> มีอาชีพและรายได้เพียงพอ</span></a></li>
                                                    <li class="{{ ( Request::path()=='report/followup/department/enoughexpense/hasoccupationchart')?'active':''  }}"><a href="{{ url('report/followup/department/enoughexpense/hasoccupationchart') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> แผนภาพรายได้เพียงพอ</span></a></li>
                                                  
                                                </ul>
                                            </li>                 
                                        </ul>
                                    </li>
                                    @endif
                                    
                             @elseif( $auth->permission == 3)
                                @php
                                    $occupation_allocated = $allocationbudget->where('department_id',$deptid)->where('budget_id',5)->first();
                                @endphp
                                @if (!empty($occupation_allocated))
                                    @if( ( strpos(\Request::path(),'occupation/project')!==false ) ||
                                     ( strpos(\Request::path(),'occupation/report')!==false ) ||
                                     ( strpos(\Request::path(),'report/occupation/section')!==false ) ||
                                     ( strpos(\Request::path(),'occupation/refund')!==false )   )
                                        <li class="openable bg-palette_trainingreadiness open ">
                                    @else
                                        <li class="openable bg-palette_trainingreadiness">
                                    @endif
                                        <a href="#">
                                            <span class="menu-content block">
                                                <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                                <span class="text m-left-sm thsaraban20" style="font-weight:200">การฝึกอบรมวิชาชีพ</span>
                                                <span class="submenu-icon"></span>
                                            </span>
                                            <span class="menu-content-hover block">
                                                <i class="fa fa-gear fa-lg"></i>
                                            </span>
                                        </a>
                                        <ul class="submenu">
                                            <li class="{{ ( strpos(\Request::path(),'occupation/project/section')!==false)?'active':'' }}"><a href="{{ url('occupation/project/section') }}"><span class="submenu-label thsaraban20" >โครงการฝึกอบรม</span></a></li>      
                                            <li class="{{ ( strpos(\Request::path(),'occupation/project/section/list')!==false)?'active':'' }}"><a href="{{ url('occupation/project/section/list') }}"><span class="submenu-label thsaraban20" >บันทึกข้อมูลโครงการ</span></a></li>                                       
                                            <li class="{{ ( strpos(\Request::path(),'occupation/project/section/refundlist')!==false)?'active':'' }}"><a href="{{ url('occupation/project/section/refundlist') }}"><span class="submenu-label thsaraban20" >การคืนเงิน</span></a></li>      
                                            <li class="{{ ( strpos(\Request::path(),'report/occupation/section')!==false)?'active':'' }}"><a href="{{ url('report/occupation/section') }}"><span class="submenu-label thsaraban20" >รายงานการฝึกอบรม</span></a></li>                         
                                        </ul>
                                    </li>
                                    @endif
                             @endif   
                            {{-- ระบบประชามสัมพันธ์ --}}

                            @if( ( strpos(\Request::path(),'information')!==false ) )
                            <li class="openable bg-palette1 open ">
                            @else
                            <li class="openable bg-palette1">
                            @endif
                                <a href="#">
                                    <span class="menu-content block">
                                        <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                        <span class="text m-left-sm thsaraban20" style="font-weight:200">ระบบประชาสัมพันธ์</span>
                                        <span class="submenu-icon"></span>
                                    </span>
                                    <span class="menu-content-hover block">
                                        <i class="fa fa-gear fa-lg"></i>
                                    </span>
                                </a>
                                <ul class="submenu">
                                    @if( $auth->permission == 1 ) 
                                        <li class="{{ ( strpos(\Request::path(),'report/information/main')!==false)?'active':'' }}"><a href="{{ url('report/information/main') }}"><span class="submenu-label thsaraban20" >รายงาน</span></a></li>
                                    @endif
                                </ul>
                                <ul class="submenu">
                                    @if( $auth->permission == 2 ) 
                                    <li class="{{ ( strpos(\Request::path(),'information')!==false)?'active':'' }}"><a href="{{ url('information') }}"><span class="submenu-label thsaraban20" >รายการประชาสัมพันธ์</span></a></li>
                                        @if (!empty($informaton_allocated))
                                            <li class="{{ ( strpos(\Request::path(),'information/expense')!==false)?'active':'' }}"><a href="{{ url('information/expense') }}"><span class="submenu-label thsaraban20" >ค่าใช้จ่าย</span></a></li>
                                            <li class="{{ ( strpos(\Request::path(),'information/report/department')!==false)?'active':'' }}"><a href="{{ url('information/report/department') }}"><span class="submenu-label thsaraban20" >รายการเบิกจ่าย</span></a></li>
                                            <li class="{{ ( strpos(\Request::path(),'information/refund')!==false)?'active':'' }}"><a href="{{ url('information/refund') }}"><span class="submenu-label thsaraban20" >คืนงบประมาณประชาสัมพันธ์</span></a></li>
                                            <li class="{{ ( strpos(\Request::path(),'report/information/department')!==false)?'active':'' }}"><a href="{{ url('report/information/department') }}"><span class="submenu-label thsaraban20" >รายงาน</span></a></li>
                                        @endif
                                    @endif
                                </ul>
                                <ul class="submenu">
                                        @if( $auth->permission == 3 ) 
                                        <li class="{{ ( strpos(\Request::path(),'information')!==false)?'active':'' }}"><a href="{{ url('information') }}"><span class="submenu-label thsaraban20" >รายการประชาสัมพันธ์</span></a></li>
                                        @endif
                                </ul>
                            </li>

                           {{-- ระบบติดตามความก้าวหน้า --}}
                           @if( $auth->permission == 1 )
                                @if( ( strpos(\Request::path(),'report/followup/main/onsite')!==false ) )
                                    <li class="openable bg-palette2 open ">
                                @else
                                    <li class="openable bg-palette2">
                                @endif
                                    <a href="#">
                                        <span class="menu-content block">
                                            <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                            <span class="text m-left-sm thsaraban20" style="font-weight:200">ระบบติดตามความก้าวหน้า</span>
                                            <span class="submenu-icon"></span>
                                        </span>
                                        <span class="menu-content-hover block">
                                            <i class="fa fa-gear fa-lg"></i>
                                        </span>
                                    </a>
                                    <ul class="submenu">
                                        <li class="{{ ( strpos(\Request::path(),'report/followup/main/onsite')!==false)?'active':'' }}"><a href="{{ url('report/followup/main/onsite') }}"><span class="submenu-label thsaraban20" >รายงานผลการติดตาม</span></a></li>
                                    </ul>
                                </li>

                            @elseif($auth->permission == 2  && !empty($followup_allocated))
                                @if( ( Request::path()=='followup' ) ||
                                ( Request::path()=='followup/report/department' ) || 
                                ( Request::path()=='followup/refund' ) || 
                                ( Request::path()=='report/followup/department/onsite' ) 
                                )
                                    <li class="openable bg-palette3 open ">
                                @else
                                    <li class="openable bg-palette3">
                                @endif
                                    <a href="#">
                                        <span class="menu-content block">
                                            <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                            <span class="text m-left-sm thsaraban20" style="font-weight:200">ระบบติดตามความก้าวหน้า</span>
                                            <span class="submenu-icon"></span>
                                        </span>
                                        <span class="menu-content-hover block">
                                            <i class="fa fa-gear fa-lg"></i>
                                        </span>
                                    </a>
                                    <ul class="submenu">
                                        <li class="{{ ( Request::path()=='followup')?'active':''  }}"><a href="{{ url('followup') }}"><span class="submenu-label thsaraban20" > รายการติดตามความก้าวหน้า</span></a></li>
                                        <li class="{{ ( Request::path()=='followup/report/department')?'active':''  }}"><a href="{{ url('followup/report/department') }}"><span class="submenu-label thsaraban20" > รายการค่าใช้จ่าย</span></a></li>
                                        <li class="{{ ( Request::path()=='followup/refund')?'active':''  }}"><a href="{{ url('followup/refund') }}"><span class="submenu-label thsaraban20" > คืนงบประมาณ</span></a></li>

                                        @if ( ( strpos(\Request::path(),'report/followup/department/onsite')!==false ) 
                                        )                                                                                                            
                                                <li class="openable open">
                                            @else
                                                <li class="openable">
                                        @endif
                                            <a href="{{ url('report/followup/department') }}">
                                                <span class="submenu-label thsaraban20" >รายงาน</span>
                                            </a>
                                            <ul class="submenu third-level">
                                                <li class="{{ ( strpos(\Request::path(),'report/followup/department/onsite')!==false)?'active':'' }}"><a href="{{ url('report/followup/department/onsite') }}"><span class="submenu-label thsaraban20" ><i class="fa fa-circle-o" style="font-size: 12px;"></i> รายงานผลการติดตาม</span></a></li>
                                                
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            {{-- ระบบติดตามและประเมินผล --}}
                            @if( ( Request::path()=='report/assessment/main' ) || 
                             (Request::path()=='assesment/section' ) ||
                             (Request::path()=='report/assessment/department' ) ||
                             (Request::path()=='report/assessment/section' ) 
                             )

                            <li class="openable bg-palette3 open ">
                            @else
                            <li class="openable bg-palette3">
                            @endif
                                <a href="#">
                                    <span class="menu-content block">
                                        <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                        <span class="text m-left-sm thsaraban20" style="font-weight:200">ระบบติดตามและประเมินผล</span>
                                        <span class="submenu-icon"></span>
                                    </span>
                                    <span class="menu-content-hover block">
                                        <i class="fa fa-gear fa-lg"></i>
                                    </span>
                                </a>
                                <ul class="submenu">
                                        @if( $auth->permission == 1 )                                     
                                        <li class="{{ ( strpos(\Request::path(),'report/assessment/main')!==false)?'active':'' }}"><a href="{{ url('report/assessment/main') }}"><span class="submenu-label thsaraban20" >รายงานประเมินผล</span></a></li>
                                        @endif
                                    </ul>
                                <ul class="submenu">
                                    @if( $auth->permission == 2 )                                     
                                    <li class="{{ ( strpos(\Request::path(),'report/assessment/department')!==false)?'active':'' }}"><a href="{{ url('report/assessment/department') }}"><span class="submenu-label thsaraban20" >รายงานประเมินผล</span></a></li>
                                    @endif
                                </ul>
                                <ul class="submenu">
                                    @if( $auth->permission == 3 ) 
                                    <li class="{{ ( strpos(\Request::path(),'assesment/section')!==false)?'active':'' }}"><a href="{{ url('assesment/section') }}"><span class="submenu-label thsaraban20" >ประเมินผล</span></a></li>
                                    <li class="{{ ( strpos(\Request::path(),'report/assessment/section')!==false)?'active':'' }}"><a href="{{ url('report/assessment/section') }}"><span class="submenu-label thsaraban20" >รายงานประเมินผล</span></a></li>
                                    @endif
                                </ul>
                            </li>

                            {{-- ตั้งค่าระบบ --}}
                            @if( $auth->permission != 3 )
                                @if( ( strpos(\Request::path(),'setting/year')!==false ) || 
                                ( strpos(\Request::path(),'setting/budget')!==false ) || 
                                ( strpos(\Request::path(),'setting/department')!==false ) || 
                                (strpos(\Request::path(),'setting/section')!==false ) || 
                                (strpos(\Request::path(),'setting/position')!==false ) || 
                                (strpos(\Request::path(),'setting/contractorposition')!==false ) || 
                                (strpos(\Request::path(),'setting/landing')!==false ) || 
                                (strpos(\Request::path(),'setting/user')!==false ) || 
                                (strpos(\Request::path(),'setting/backup')!==false ) || 
                                (strpos(\Request::path(),'setting/generalsetting')!==false ) || 
                                (strpos(\Request::path(),'setting/inactiveregister')!==false ) || 
                                strpos(\Request::path(),'setting/log')!==false )
                                    <li class="openable bg-palette4 open ">
                                @else
                                    <li class="openable bg-palette4">
                                @endif
                                    <a href="#">
                                        <span class="menu-content block">
                                            <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                            <span class="text m-left-sm thsaraban20" style="font-weight:200">ตั้งค่าระบบ</span>
                                            <span class="submenu-icon"></span>
                                        </span>
                                        <span class="menu-content-hover block">
                                            <i class="fa fa-gear fa-lg"></i>
                                        </span>
                                    </a>
                                    <ul class="submenu">
                                        @if( $auth->permission == 1 )
                                        <li class="{{ ( strpos(\Request::path(),'setting/year')!==false)?'active':'' }}"><a href="{{ url('setting/year') }}"><span class="submenu-label thsaraban20" >ตั้งค่า ปีงบประมาณ</span></a></li>
                                        <li class="{{ ( strpos(\Request::path(),'setting/budget')!==false)?'active':'' }}"><a href="{{ url('setting/budget') }}"><span class="submenu-label thsaraban20" >ตั้งค่า ค่าใช้จ่าย</span></a></li>
                                        <li class="{{ ( strpos(\Request::path(),'setting/department')!==false)?'active':'' }}"><a href="{{ url('setting/department') }}"><span class="submenu-label thsaraban20" >ตั้งค่า หน่วยงาน</span></a></li>
                                        <li class="{{ ( strpos(\Request::path(),'setting/section')!==false)?'active':'' }}"><a href="{{ url('setting/section') }}"><span class="submenu-label thsaraban20" >ตั้งค่า หน่วยงานย่อย</span></a></li>
                                        <li class="{{ ( strpos(\Request::path(),'setting/position')!==false)?'active':'' }}"><a href="{{ url('setting/position') }}"><span class="submenu-label thsaraban20" >ตั้งค่า ตำแหน่งงาน</span></a></li>
                                        <li class="{{ ( strpos(\Request::path(),'setting/contractorposition')!==false)?'active':'' }}"><a href="{{ url('setting/contractorposition') }}"><span class="submenu-label thsaraban20" >ตั้งค่า ตำแหน่งงานจ้างเหมา</span></a></li>
                                        <li class="{{ ( strpos(\Request::path(),'setting/landing')!==false)?'active':'' }}"><a href="{{ url('setting/landing') }}"><span class="submenu-label thsaraban20" >ตั้งค่า Landing</span></a></li>
                                        <li class="{{ ( strpos(\Request::path(),'setting/user')!==false)?'active':'' }}"><a href="{{ url('setting/user') }}"><span class="submenu-label thsaraban20" >ตั้งค่า ยูสเซอร์</span></a></li>
                                        <li class="{{ ( strpos(\Request::path(),'setting/backup')!==false)?'active':'' }}"><a href="{{ url('setting/backup') }}"><span class="submenu-label thsaraban20" >สำรองฐานข้อมูล</span></a></li>
                                        <li class="{{ ( strpos(\Request::path(),'setting/generalsetting')!==false)?'active':'' }}"><a href="{{ url('setting/generalsetting') }}"><span class="submenu-label thsaraban20" >ตั้งค่าทั่วไป</span></a></li>
                                        <li class="{{ ( strpos(\Request::path(),'setting/log')!==false)?'active':'' }}"><a href="{{ url('setting/log') }}"><span class="submenu-label thsaraban20" >ข้อมูล Log</span></a></li>
                                        <li class="{{ ( strpos(\Request::path(),'setting/inactiveregister')!==false)?'active':'' }}"><a href="{{ url('setting/inactiveregister') }}"><span class="submenu-label thsaraban20" >ผู้สมัครไม่ active</span></a></li>
                                        <li class="{{ ( strpos(\Request::path(),'deletedb')!==false)?'active':'' }}"><a href="{{ url('deletedb') }}"><span class="submenu-label thsaraban20" >ลบฐานข้อมูล</span></a></li>
                                        @endif
                                        @if( $auth->permission == 2 )
                                        <li class="{{ ( strpos(\Request::path(),'setting/section/department')!==false)?'active':'' }}"><a href="{{ url('setting/section/department') }}"><span class="submenu-label thsaraban20" >ตั้งค่า หน่วยงานย่อย</span></a></li>
                                        <li class="{{ ( strpos(\Request::path(),'setting/position/department')!==false)?'active':'' }}"><a href="{{ url('setting/position/department') }}"><span class="submenu-label thsaraban20" >ตั้งค่า ตำแหน่งงาน</span></a></li>
                                        <li class="{{ ( strpos(\Request::path(),'setting/user')!==false)?'active':'' }}"><a href="{{ url('setting/user') }}"><span class="submenu-label thsaraban20" >ตั้งค่า ยูสเซอร์</span></a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            <li class="bg-palette1 {{ ( Request::path()=='landing')?'active':''  }}">
                                <a href="{{ route('videolist.index') }}">
                                    <span class="menu-content block">
                                        <span class="menu-icon"><i class="block fa fa-gear fa-lg"></i></span>
                                        <span class="text m-left-sm thsaraban20" style="font-weight:200">วีดีโอใช้งาน</span>
                                    </span>
                                    <span class="menu-content-hover block">
                                    	<i class="fa fa-gear fa-lg"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>  
                    <div class="sidebar-fix-bottom clearfix">
                        <a href="{{ url('logout') }}" class="pull-right font-18"><i class="ion-log-out"></i></a>
                    </div>
                </div>
            </aside>
            
            <div class="main-container">
                 @yield('content')
            </div>

            <footer class="footer">
                <span class="footer-brand">
                    <strong class="text-danger">โครงการ</strong> คืนคนดีสู่สังคม
                </span>
                <p class="no-margin">
                    &copy; @php
                        echo date("Y")
                    @endphp <strong>ระบบสารสนเทศโครงการคืนคนดีสู่สังคม</strong>.
                </p>    
            </footer>
        </div><!-- /wrapper -->

        <a href="#" class="scroll-to-top hidden-print"><i class="fa fa-chevron-up fa-lg"></i></a>
        <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}"></script>
        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/js/rapheal.min.js') }}"></script>   
        <script src="{{ asset('assets/js/morris.min.js') }}"></script>    
        <script src="{{ asset('assets/js/uncompressed/moment.js') }}"></script>
        <script src="{{ asset('assets/dist/js/bootstrap-datepicker-custom.js') }}"></script>
        <script src="{{ asset('assets/dist/locales/bootstrap-datepicker.th.min.js') }}"  charset="UTF-8"></script>
        <script src="{{ asset('assets/js/sparkline.min.js') }}"></script>
        <script src="{{ asset('assets/js/fileinput/fileinput.min.js') }}"></script>
        <script src="{{ asset('assets/js/uncompressed/skycons.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.popupoverlay.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.easypiechart.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/uncompressed/dataTables.bootstrap.js') }}"></script>
        <script src="{{ asset('assets/js/uncompressed/jquery.sortable.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
        <script src="{{ asset('assets/js/simplify/simplify.js') }}"></script>
        <script src="{{ asset('assets/js/fusioncharts.js') }}"></script>
        <script src="{{ asset('assets/js/themes/fusioncharts.theme.fint.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-filestyle.min.js') }}"></script>
        @section('pageScript')
        @show

        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    <!-- END SCRIPTS -->         
    </body>
</html>