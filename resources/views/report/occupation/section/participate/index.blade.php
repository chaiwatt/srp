@extends('layout.mains')

@section('pageCss')
@stop

@section('content')

<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>รายงานฝึกอบรมวิชาชีพ</li>    
    </ul>

    <div class="row padding-md">
        <div class="col-sm-9">
            <div class="page-title">
                  รายชื่อผู้ฝึกอบรม : {{$readinesssection->projectreadinessname}} 
            </div>
        </div>
        <div class="col-sm-3">
            <div class="pull-right">
                
                <a href="{{ url('report/occupation/section/participate/excel/'.$readinesssection->readiness_section_id) }}" class="btn btn-info">Excel</a>
                <a href="{{ url('report/occupation/section/participate/pdf/'.$readinesssection->readiness_section_id) }}" class="btn btn-warning">PDF</a>
            </div>
        </div>
    </div> 
{{-- </div> --}}

    <div class="row">
        <div class="col-md-12">
            <div class="smart-widget widget-dark-blue">
                <div class="smart-widget-header">รายชื่อผู้ฝึกอบรม  </div>
                <div class="smart-widget-body">
                    <div class="smart-widget-body padding-md">                       
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th >ชื่อ-สกุล</th>
                                    <th >เลขบัตรประชาชน</th>
                                    <th style="width:350px">ที่อยู่/เบอร์โทรศัพท์</th>
                                    <th  class="text-center">จบหลักสูตร</th>
                                    <th class="text-center">ผลการติดตาม</th>
                                    <th class="text-center">ข้อเสนอแนะ</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach( $participategroup as $key => $item )
                                        @php
                                            $_assessment ="ไม่พบข้อมูล";
                                            $_register = $register->where('register_id',$item->register_id)->first();
                                            $check = $participategroup->where('register_id',$item->register_id)->first();
                                            if(!empty($check)){
                                                $_status = $status->where('trainning_status_id',$check->trainning_status_id)->first();
                                            }
                                            $check2 = $personalassessment->where('register_id',$item->register_id)->first();
                                            if(!empty($check2)){
                                                $suggest = $check2->othernote;
                                                $check3 = $followerstatus->where('follower_status_id',$check2->follower_status_id)->first();
                                                if(!empty($check3)){
                                                    $_assessment = $check3->follower_status_name ;
                                                }
                                            }else{
                                                $suggest="";
                                            }
      
                                        @endphp
                                        @if (!empty($_register))
                                            <tr>
                                                <td >{{ $_register->prefixname . $_register->name . " " . $_register->lastname  }}</td>
                                                <td >{{ $_register->person_id }} </td>
                                                <td >{{ "เลขที่ " . $_register->address .  " หมู่ ". $_register->mood . " ซอย" . $_register->soi . " ตำบล" . $_register->districtname . " อำเภอ" . $_register->amphurname . " จังหวัด" . $_register->provincename . " โทรศัพท์ " . $_register->phone  }} </td>
                                                <td  class="text-center">{{ $_status->trainning_status_name }} </td>
                                                <td  class="text-center">{{ $_assessment }} </td>
                                                <td style="width:200px;word-break:break-all; word-wrap:break-word;" >{{  $suggest }} </td>
                                            </tr>
                                        @endif    
                                @endforeach
                                
                            </tbody>
                            {{-- @if( count($participate) > 0 )
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="3">รวม</td>
                                        <td class="text-center">{{ $readiness->sum('targetparticipate') }}</td>
                                        <td class="text-center">{{ $participate->sum('participate_num') }}</td>
                                    </tr>
                                </tfoot>
                            @endif --}}
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
@stop

@section('pageScript')

@stop