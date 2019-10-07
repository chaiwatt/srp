<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;


use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Department;
use App\Model\Section;
use App\Model\ProjectReadiness;
use App\Model\ProjectParticipate;
use App\Model\ParticipateGroup;
use App\Model\Budget;
use App\Model\Allocation;
use App\Model\AllocationTransaction;
use App\Model\AllocationWaiting;
use App\Model\ProjectBudget;
use App\Model\SettingDepartment;
use App\Model\SettingBudget;
use App\Model\Refund;
use App\Model\NotifyMessage;
use App\Model\Users;
use App\Model\TransferTransaction;
use App\Model\Linenotify;
use App\Model\LogFile;
use App\Model\Assessor;
use App\Model\Backuphistory;
use App\Model\Contractor;
use App\Model\Company;
use App\Model\ContractorDocument;
use App\Model\ContractorEducation;
use App\Model\ContractorEmploy;
use App\Model\ContractorExperience;
use App\Model\ContractorSkill;
use App\Model\ContractorSoftware;
use App\Model\ContractorTraining;
use App\Model\DocDownload;
use App\Model\Employ;
use App\Model\FollowupInterview;
use App\Model\FollowupRegister;
use App\Model\FollowupSection;
use App\Model\Generate;
use App\Model\Information;
use App\Model\InformationExpense;
use App\Model\InformationPicture;
use App\Model\Interviewee;
use App\Model\Interviewer;
use App\Model\Linemessage;
use App\Model\Payment;
use App\Model\PersonalAssessment;
use App\Model\ProjectAssesment;
use App\Model\ProjectFollowup;
use App\Model\ProjectFollowupDocument;
use App\Model\ProjectReadinessOfficer;
use App\Model\ProjectSurvey;
use App\Model\ReadinessExpense;
use App\Model\ReadinessSection;
use App\Model\ReadinessSectionDocument;
use App\Model\Register;
use App\Model\RegisterAssesmentFit;
use App\Model\RegisterAssessment;
use App\Model\RegisterDocument;
use App\Model\RegisterEducation;
use App\Model\RegisterExperience;
use App\Model\RegisterSkill;
use App\Model\RegisterSoftware;
use App\Model\RegisterTraining;
use App\Model\Resign;
use App\Model\Survey;
use App\Model\Surveyhost;
use App\Model\Trainer;
use App\Model\Transfer;


class DeleteDbController extends Controller
{
    public function Index(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
        
        return view('deletedb.index');
    }

    public function DeleteAllocation(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }
       if (Allocation::get()->count() > 0 ){
        Allocation::getQuery()->delete();
        return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลการจัดสรร สำเร็จ');
       }else{
        return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
       }
   
    }

    public function DeleteAllocationTransaction(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (AllocationTransaction::get()->count() > 0 ){
            AllocationTransaction::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลรายการเดินข้อมูลจัดสรร สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }

    public function DeleteAllocationWaiting(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (AllocationWaiting::get()->count() > 0 ){
            AllocationWaiting::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลการคืนเงิน สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }

    
    public function DeleteAssessor(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Assessor::get()->count() > 0 ){
            Assessor::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลรายการผู้ประเมิน สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    
    public function DeleteBackuphistory(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Backuphistory::get()->count() > 0 ){
            Backuphistory::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลประวัติสำรองข้อมูล สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }

    public function DeleteCompany(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Company::get()->count() > 0 ){
            Company::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลสถานประกอบการเข้าร่วม สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }

    public function DeleteContractor(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Contractor::get()->count() > 0 ){
            Contractor::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลผู้จ้างเหมา สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    
    public function DeleteContractorDocument(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ContractorDocument::get()->count() > 0 ){
            ContractorDocument::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลเอกสารแนบผู้จ้างเหมา สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }

    
    public function DeleteContractorEducation(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ContractorEducation::get()->count() > 0 ){
            ContractorEducation::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลการศึกษาผู้จ้างเหมา สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteContractorEmploy(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ContractorEmploy::get()->count() > 0 ){
            ContractorEmploy::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลกรอบจำนวนผู้จ้างเหมา สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    public function DeleteContractorExperience(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ContractorExperience::get()->count() > 0 ){
            ContractorExperience::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลประสบการณ์การทำงานผู้จ้างเหมา สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteContractorSkill(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ContractorSkill::get()->count() > 0 ){
            ContractorSkill::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลความสามารถพิเศษผู้จ้างเหมา สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteContractorSoftware(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ContractorSoftware::get()->count() > 0 ){
            ContractorSoftware::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลความสามารถการใช้โปรแกรมของผู้จ้างเหมา สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }


    public function DeleteContractorTraining(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ContractorTraining::get()->count() > 0 ){
            ContractorTraining::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลการอบรมของผู้จ้างเหมา สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeletedocDownload(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (DocDownload::get()->count() > 0 ){
            DocDownload::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลการเอกสารดาวน์โหลด สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    

    public function DeleteEmploy(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Employ::get()->count() > 0 ){
            Employ::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลจำนวนจัดสรรจ้างงาน สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteFollowupInterview(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (FollowupInterview::get()->count() > 0 ){
            FollowupInterview::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลการสัมภาษณ์ติดตามความก้าวหน้า สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    public function DeleteFollowupRegister(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (FollowupRegister::get()->count() > 0 ){
            FollowupRegister::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลผู้ได้รับติดตามความก้าวหน้า สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
 
    public function DeleteFollowupSection(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (FollowupSection::get()->count() > 0 ){
            FollowupSection::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลสำนักงานที่ติดตามความก้าวหน้า สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }

    
    public function DeleteGenerate(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Generate::get()->count() > 0 ){
            Generate::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลผู้จ้างงาน สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    

    public function DeleteInformation(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Information::get()->count() > 0 ){
            Information::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลข่าวประชาสัมพันธ์ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteInformationExpense(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (InformationExpense::get()->count() > 0 ){
            InformationExpense::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลค่าใช้จ่ายประชาสัมพันธ์ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    public function DeleteInformationPicture(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (InformationPicture::get()->count() > 0 ){
            InformationPicture::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลรูปข่าวประชาสัมพันธ์ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteInterviewee(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Interviewee::get()->count() > 0 ){
            Interviewee::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลผู้ให้สัมภาษณ์ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    

    public function DeleteInterviewer(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Interviewer::get()->count() > 0 ){
            Interviewer::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลผู้สัมภาษณ์ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteLineMessage(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Linemessage::get()->count() > 0 ){
            Linemessage::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลข้อความ Line สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteLogfile(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (LogFile::get()->count() > 0 ){
            LogFile::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูล Log file สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteNotifyMessage(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (NotifyMessage::get()->count() > 0 ){
            NotifyMessage::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลข้อความแจ้งเตือน สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteParticipateGroup(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ParticipateGroup::get()->count() > 0 ){
            ParticipateGroup::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลผู้เข้าร่วมโครงการอบรม สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeletePayment(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Payment::get()->count() > 0 ){
            Payment::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลรายการเบิกจ่ายเงินดือน สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeletePersonalAssessment(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (PersonalAssessment::get()->count() > 0 ){
            PersonalAssessment::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลการประเมินบุคลิกภาพ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteProject(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Project::get()->count() > 0 ){
            Project::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลโครงการ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteProjectAssessment(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ProjectAssesment::get()->count() > 0 ){
            ProjectAssesment::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลรายการประเมิน สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteProjectBudget(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ProjectBudget::get()->count() > 0 ){
            ProjectBudget::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลงบประมาณจัดสรร สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    

    public function DeleteProjectFollowup(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ProjectFollowup::get()->count() > 0 ){
            ProjectFollowup::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลโครงการติดตามความก้าวหน้า สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteProjectFollowupDocument(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ProjectFollowupDocument::get()->count() > 0 ){
            ProjectFollowupDocument::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลเอกสารแนบโครงการติดตามความก้าวหน้า สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteProjectParticipate(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ProjectParticipate::get()->count() > 0 ){
            ProjectParticipate::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลผู้เข้าร่วมโครงการอบรม สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }

    
    public function DeleteProjectReadiness(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ProjectReadiness::get()->count() > 0 ){
            ProjectReadiness::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลโครงการฝึกอบรม สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteProjectReadinessOfficer(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ProjectReadinessOfficer::get()->count() > 0 ){
            ProjectReadinessOfficer::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลเจ้าหน้าที่โครงการฝึกอบรม สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }

    
    public function DeleteProjectSurvey(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ProjectSurvey::get()->count() > 0 ){
            ProjectSurvey::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลรายการสำรวจ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteReadinessExpense(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ReadinessExpense::get()->count() > 0 ){
            ReadinessExpense::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลค่าใช้จ่ายโครงการฝึกอบรม สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }

    public function DeleteReadinesSection(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ReadinessSection::get()->count() > 0 ){
            ReadinessSection::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลสำนักงานที่จัดโครงการฝึกอบรม สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteReadinesSectionDocument(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (ReadinessSectionDocument::get()->count() > 0 ){
            ReadinessSectionDocument::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลเอกสารแนบโครงการฝึกอบรม สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteRefund(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Refund::get()->count() > 0 ){
            Refund::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลการคืนเงิน สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteRegister(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Register::get()->count() > 0 ){
            Register::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลผู้สมัครเข้าร่วมโครงการคืนคนดีสู่สังคม สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteRegisterAssesmentFit(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (RegisterAssesmentFit::get()->count() > 0 ){
            RegisterAssesmentFit::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลการประเมิน สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteRegisterAssesment(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (RegisterAssessment::get()->count() > 0 ){
            RegisterAssessment::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลการติดตาม สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteRegisterDocument(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (RegisterDocument::get()->count() > 0 ){
            RegisterDocument::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลเอกสารแนบผู้สมัครเข้าร่วมโครงการ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteRegisterEducation(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (RegisterEducation::get()->count() > 0 ){
            RegisterEducation::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลการศึกษาผู้สมัครเข้าร่วมโครงการ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteRegisterExperience(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (RegisterExperience::get()->count() > 0 ){
            RegisterExperience::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลประสบการณ์ผู้สมัครเข้าร่วมโครงการ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteRegisterSkill(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (RegisterSkill::get()->count() > 0 ){
            RegisterSkill::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลความสามารถผู้สมัครเข้าร่วมโครงการ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteRegisterSoftware(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (RegisterSoftware::get()->count() > 0 ){
            RegisterSoftware::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลทักษะการใช้โปรแกรมผู้สมัครเข้าร่วมโครงการ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteRegisterTraining(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (RegisterTraining::get()->count() > 0 ){
            RegisterTraining::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลการฝึกอบรมผู้สมัครเข้าร่วมโครงการ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteResign(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Resign::get()->count() > 0 ){
            Resign::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลการลาออก สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
        
    public function DeleteSettingBudget(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (SettingBudget::get()->count() > 0 ){
            SettingBudget::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลตั้งค่างบประมาณ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteSettingDepartment(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (SettingDepartment::get()->count() > 0 ){
            SettingDepartment::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลตั้งค่ากรม สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteSurvey(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Survey::get()->count() > 0 ){
            Survey::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลรายการสำรวจ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteSurveyHost(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Surveyhost::get()->count() > 0 ){
            Surveyhost::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลรายการสำรวจโครงการฝึกอบรม สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteTrainer(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Trainer::get()->count() > 0 ){
            Trainer::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลวิทยากรฝึกอบรม สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteTransfer(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (Transfer::get()->count() > 0 ){
            Transfer::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลโอนเงินงบประมาณ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    
    public function DeleteTransferTransaction(){
        if( $this->authsuperadmin() ){
            return redirect('logout');
        }

        if (TransferTransaction::get()->count() > 0 ){
            TransferTransaction::getQuery()->delete();
            return redirect('deletedb')->withSuccess('ลบ ฐานข้อมูลรายการเดินโอนเงินงบประมาณ สำเร็จ');
           }else{
            return redirect('deletedb')->withError('ฐานข้อมูลว่างเปล่า');
           }
    }
    public function authsuperadmin(){
        $auth = Auth::user();
        if( $auth->permission != 1 ){
            return true;
        }
        else{
            return false;
        }
    }
}


