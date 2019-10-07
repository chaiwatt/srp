@extends('layout.mains')

@section('pageCss')
@stop

@section('content')
<div class="padding-md">

    <ul class="breadcrumb">
        <li><a href="{{ url('landing') }}">หน้าเว็บไซต์</a></li>
        <li>ลบฐานข้อมูล</li>    
    </ul>

    <div class="row">
        <div class="col-sm-6">
            <div class="page-title">
                ลบฐานข้อมูล
            </div>
        </div>
    </div>
</div>

<div class="row padding-md">
    <div class="col-md-12">
        <div class="smart-widget widget-dark-blue">
            <div class="smart-widget-header"> รายการฐานข้อมูล </div>
            <div class="smart-widget-body">
                <div class="smart-widget-body  padding-md">

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
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>รายการ</th>
                                <th width="200">ลบฐานข้อมูล</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ฐานข้อมูลการจัดสรรงบประมาณ</td>
                                <td>
                                    <a href="{{ url('deletedb/deleteallocation') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลรายการจัดสรรงบประมาณ')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลการเดินข้อมูลจัดสรรงบประมาณ</td>
                                <td>
                                    <a href="{{ url('deletedb/deleteallocationtransaction') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบรายการ ฐานข้อมูลการเดินข้อมูลจัดสรรงบประมาณ')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลการคืนเงิน</td>
                                <td>
                                    <a href="{{ url('deletedb/deleteallocationwaiting') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลการคืนเงิน')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลรายการผู้ประเมิน</td>
                                <td>
                                    <a href="{{ url('deletedb/deleteassessor') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลรายการผู้ประเมิน')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลประวัติสำรองข้อมูล</td>
                                <td>
                                    <a href="{{ url('deletedb/deletebackuphistory') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลประวัติสำรองข้อมูล')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลสถานประกอบการเข้าร่วม</td>
                                <td>
                                    <a href="{{ url('deletedb/deletecompany') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลสถานประกอบการเข้าร่วม')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลผู้จ้างเหมา</td>
                                <td>
                                    <a href="{{ url('deletedb/deletecontractor') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลผู้จ้างเหมา')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลเอกสารแนบผู้จ้างเหมา</td>
                                <td>
                                    <a href="{{ url('deletedb/deletecontractordocument') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลเอกสารแนบผู้จ้างเหมา')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>  
                            <tr>
                                <td>ฐานข้อมูลการศึกษาผู้จ้างเหมา</td>
                                <td>
                                    <a href="{{ url('deletedb/deletecontractoreducation') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลการศึกษาผู้จ้างเหมา')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>   
                            <tr>
                                <td>ฐานข้อมูลกรอบจำนวนผู้จ้างเหมา</td>
                                <td>
                                    <a href="{{ url('deletedb/deletecontractoremploy') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลกรอบจำนวนผู้จ้างเหมา')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>  
                            <tr>
                                <td>ฐานข้อมูลประสบการณ์การทำงานผู้จ้างเหมา</td>
                                <td>
                                    <a href="{{ url('deletedb/deletecontractorexperience') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลประสบการณ์การทำงานผู้จ้างเหมา')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>     
                            <tr>
                                <td>ฐานข้อมูลความสามารถพิเศษผู้จ้างเหมา</td>
                                <td>
                                    <a href="{{ url('deletedb/deletecontractorskill') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลความสามารถพิเศษผู้จ้างเหมา')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>    
                            <tr>
                                <td>ฐานข้อมูลความสามารถการใช้โปรแกรมของผู้จ้างเหมา</td>
                                <td>
                                    <a href="{{ url('deletedb/deletecontractorsoftware') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลความสามารถการใช้โปรแกรมของผู้จ้างเหมา')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>  
                            <tr>
                                <td>ฐานข้อมูลการอบรมของผู้จ้างเหมา</td>
                                <td>
                                    <a href="{{ url('deletedb/deletecontractortraining') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลการอบรมของผู้จ้างเหมา')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>    
                            <tr>
                                <td>ฐานข้อมูลการเอกสารดาวน์โหลด</td>
                                <td>
                                    <a href="{{ url('deletedb/deletedocdownload') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลการเอกสารดาวน์โหลด')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>  
                            <tr>
                                <td>ฐานข้อมูลจำนวนจัดสรรจ้างงาน</td>
                                <td>
                                    <a href="{{ url('deletedb/deleteemploy') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลจำนวนจัดสรรจ้างงาน')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>  
                            <tr>
                            <td>ฐานข้อมูลการสัมภาษณ์ติดตามความก้าวหน้า</td>
                                <td>
                                    <a href="{{ url('deletedb/deletefollowupinterview') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลการสัมภาษณ์ติดตามความก้าวหน้า')" ><i class="fa fa-ban"></i> ลบ</a>
                                </td>
                            </tr>   
                            <tr>
                                <td>ฐานข้อมูลผู้ได้รับติดตามความก้าวหน้า</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletefollowupregister') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลผู้ได้รับติดตามความก้าวหน้า')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>  
                            <tr>
                                <td>ฐานข้อมูลสำนักงานที่ติดตามความก้าวหน้า</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletefollowupsection') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลสำนักงานที่ติดตามความก้าวหน้า')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                            <td>ฐานข้อมูลผู้จ้างงาน</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletegenerate') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลผู้จ้างาน')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>  
                            <tr>
                                <td>ฐานข้อมูลข่าวประชาสัมพันธ์</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteinformation') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลข่าวประชาสัมพันธ์')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลค่าใช้จ่ายประชาสัมพันธ์</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteinformationexpense') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลค่าใช้จ่ายประชาสัมพันธ์')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>    
                            <tr>
                                <td>ฐานข้อมูลรูปข่าวประชาสัมพันธ์</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteinformationpicture') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลค่าใช้จ่ายประชาสัมพันธ์')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>  
                            <tr>
                                <td>ฐานข้อมูลผู้ให้สัมภาษณ์</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteinterviewee') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลผู้ให้สัมภาษณ์')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>   
                            <tr>
                                <td>ฐานข้อมูลผู้สัมภาษณ์</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteinterviewer') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลผู้สัมภาษณ์')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>       
                            <tr>
                            <td>ฐานข้อมูลข้อความ Line</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletelinemessage') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลข้อความ Line')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>   
                            <tr>
                                <td>ฐานข้อมูล Log file</td>
                                        <td>
                                            <a href="{{ url('deletedb/deletelogfile') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูล Log file')" ><i class="fa fa-ban"></i> ลบ</a>
                                        </td>
                                </tr>    
                            <tr>
                                <td>ฐานข้อมูลข้อความแจ้งเตือน</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletenotifymessage') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลข้อความแจ้งเตือน')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>  
                            <tr>
                                <td>ฐานข้อมูลผู้เข้าร่วมโครงการอบรม</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteparticipategroup') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลผู้เข้าร่วมโครงการอบรม')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>  
                            <tr>
                                <td>ฐานข้อมูลรายการเบิกจ่ายเงินดือน</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletepayment') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลรายการเบิกจ่ายเงินดือน')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลการประเมินบุคลิกภาพ</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletepersonalassessment') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลการประเมินบุคลิกภาพ')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>   
                            <tr>
                                <td>ฐานข้อมูลโครงการ</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteproject') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลโครงการ')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลรายการประเมิน</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteprojectassessment') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลรายการประเมิน')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลงบประมาณจัดสรร</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteprojectbudget') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลงบประมาณจัดสรร')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลโครงการติดตามความก้าวหน้า</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteprojectfollowup') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลโครงการติดตามความก้าวหน้า')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลเอกสารแนบโครงการติดตามความก้าวหน้า</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteprojectfollowupdocument') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลเอกสารแนบโครงการติดตามความก้าวหน้า')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>      
                            
                            <tr>
                                <td>ฐานข้อมูลผู้เข้าร่วมโครงการอบรม</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteprojectparticipate') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลผู้เข้าร่วมโครงการอบรม')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>                          
                            <tr>
                                <td>ฐานข้อมูลโครงการฝึกอบรม</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteprojectreadiness') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลโครงการฝึกอบรม')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลเจ้าหน้าที่โครงการฝึกอบรม</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteprojectreadinessofficer') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลเจ้าหน้าที่โครงการฝึกอบรม')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลรายการสำรวจ</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteprojectsurvey') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลรายการสำรวจ')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลค่าใช้จ่ายโครงการฝึกอบรม</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletereadinessexpense') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลค่าใช้จ่ายโครงการฝึกอบรม')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลสำนักงานที่จัดโครงการฝึกอบรม</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletereadinessection') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลสำนักงานที่จัดโครงการฝึกอบรม')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลเอกสารแนบโครงการฝึกอบรม</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletereadinessectiondocument') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลเอกสารแนบโครงการฝึกอบรม')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลการคืนเงิน</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleterefund') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลการคืนเงิน')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลผู้สมัครเข้าร่วมโครงการคืนคนดีสู่สังคม</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteregister') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลผู้สมัครเข้าร่วมโครงการคืนคนดีสู่สังคม')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลการประเมิน</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteregisterassesmentfit') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลการประเมิน')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลการติดตาม</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteregisterassesment') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลการติดตาม')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลเอกสารแนบผู้สมัครเข้าร่วมโครงการ</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteregisterdocument') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลเอกสารแนบผู้สมัครเข้าร่วมโครงการ')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลการศึกษาผู้สมัครเข้าร่วมโครงการ</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteregistereducation') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลการศึกษาผู้สมัครเข้าร่วมโครงการ')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลประสบการณ์ผู้สมัครเข้าร่วมโครงการ</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteregisterexperience') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลประสบการณ์ผู้สมัครเข้าร่วมโครงการ')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                            <tr>
                                <td>ฐานข้อมูลความสามารถผู้สมัครเข้าร่วมโครงการ</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteregisterskill') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลความสามารถผู้สมัครเข้าร่วมโครงการ')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr> 
                                <tr>
                                <td>ฐานข้อมูลทักษะการใช้โปรแกรมผู้สมัครเข้าร่วมโครงการ</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteregistersoftware') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลทักษะการใช้โปรแกรมผู้สมัครเข้าร่วมโครงการ')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลการฝึกอบรมผู้สมัครเข้าร่วมโครงการ</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteregistertraining') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลการฝึกอบรมผู้สมัครเข้าร่วมโครงการ')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลการลาออก</td>
                                    <td>
                                        <a href="{{ url('deletedb/deleteresign') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลการลาออก')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลตั้งค่างบประมาณ</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletesettingbudget') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลตั้งค่างบประมาณ')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลตั้งค่ากรม</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletesettingdepartment') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลตั้งค่ากรม')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลรายการสำรวจ</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletesurvey') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลรายการสำรวจ')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลรายการสำรวจโครงการฝึกอบรม</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletesurveyhost') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลรายการสำรวจโครงการฝึกอบรม')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลวิทยากรฝึกอบรม</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletetrainer') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลวิทยากรฝึกอบรม')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลโอนเงินงบประมาณ</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletetransfer') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลโอนเงินงบประมาณ')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>
                            <tr>
                                <td>ฐานข้อมูลรายการเดินโอนเงินงบประมาณ</td>
                                    <td>
                                        <a href="{{ url('deletedb/deletetransfertransaction') }}" class="btn btn-danger btn-xs" onclick="return confirm('ยืนยันการลบ ฐานข้อมูลรายการเดินโอนเงินงบประมาณ')" ><i class="fa fa-ban"></i> ลบ</a>
                                    </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('pageScript')
<script type="text/javascript">
    
</script>
@stop