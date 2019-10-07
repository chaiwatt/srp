<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\SettingYear;
use App\Model\Register;
use App\Model\Project;
use App\Model\Generate;
use App\Model\Payment;
use App\Model\Transfer;
use App\Model\Allocation;
use App\Model\Refund;
use App\Model\Users;
use App\Model\NotifyMessage;
use App\Model\Linenotify;
use App\Model\Department;
use App\Model\Section;

class RecuritRefundSectionController extends Controller{

    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }
    	$auth = Auth::user();

		$setting = SettingYear::where('setting_status' , 1)->first();
		$project = Project::where('year_budget' , $setting->setting_year)->first();
		
        $generate = Generate::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , $auth->section_id)
                    ->where('generate_refund' , 0)
                    ->get();

        return view('recurit.refund.section.index')->withProject($project)->withGenerate($generate);
    }

    public function confirm($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Generate::query();
        $q = $q->where('generate_id' , $id);
        $q = $q->where('generate_refund' , 0);
        $generate = $q->first();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('allocation_type' , 2);
        $allocation = $q->first();

        if( $generate->paymentbalance > $allocation->transferpaymentbalance ){
        	return redirect('recurit/refund/section')->withError("ไม่สามารถคืนงบประมาณได้ เนื่องจากเงินรับโอนไม่เพียงพอ (ต้องการคืน " . $generate->paymentbalance . " คงเหลือ " . $allocation->transferpaymentbalance .")");
        }

        if(count($generate) > 0){
        	if( $generate->generate_status == 1){
        		return redirect('recurit/refund/section')->withError("ไม่สามารถคืนงบประมาณได้ เนื่องจากยังไม่ได้ทำเรื่องลาออกหรือยกเลิกจ้างงาน");
        	}

            $new = new Refund;
            $new->project_id = $project->project_id;
            $new->year_budget = $project->year_budget;
            $new->department_id = $auth->department_id;
            $new->section_id = $auth->section_id;
            $new->budget_id = 1;
            $new->refund_price = $generate->paymentbalance;
            $new->refund_status = 0;
            $new->refund_type = 2;
            $new->generate_id = $id;
            $new->user_id = $auth->user_id;
            $new->save();

            $generate->generate_refund = 1;
            $generate->save();

            $section = Section::where('section_id', $auth->section_id)->first();
            $users = Users::where('department_id' , $auth->department_id)->where('permission',2)->get();
            
            if( $users->count() > 0 ){
                foreach( $users as $user ){
                    $new = new NotifyMessage;
                    $new->system_id = 1;
                    $new->project_id = $project->project_id;
                    $new->message_key = 1;
                    $new->message_title = "คืนเงินจ้างงาน";
                    $new->message_content = "คืนเงินจ้างงาน ".$section->section_name ;
                    $new->message_date = date('Y-m-d H:i:s');
                    $new->user_id = $user->user_id;
                    $new->save();
    
                    $linenotify = Linenotify::where('user_id',$user->user_id)->first();
                    if(!Empty($linenotify)){
                        if ($linenotify->linetoken != ""){
                            $message = "คืนเงินจ้างงาน ". $section->section_name  ." ปีงบประมาณ " . $project->year_budget . " โปรดตรวจสอบความถูกต้องจากเว็บไซต์";
                            $linenotify->notifyme($message);
                        }
                    }
                }
            }

        }

        return redirect('recurit/refund/section')->withSuccess("คืนงบประมาณจัดจ้างเรียบร้อยแล้ว");
    }


    public function confirmanual($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Generate::query();
        $q = $q->where('generate_id' , $id);
        $q = $q->where('generate_refund' , 0);
        $generate = $q->first();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $auth->section_id);
        $q = $q->where('allocation_type' , 2);
        $allocation = $q->first();

        if( $generate->paymentbalance > $allocation->transferpaymentbalance ){
            // return redirect()->back()->withError("ไม่สามารถคืนงบประมาณได้ เนื่องงานไม่มีงบประมาณเพียงพอ");
            return redirect('recurit/refund/section')->withError("ไม่สามารถคืนงบประมาณได้ เนื่องจากเงินรับโอนไม่เพียงพอ (ต้องการคืน " . $generate->paymentbalance . " คงเหลือ " . $allocation->transferpaymentbalance .")");
        }

        if(count($generate) > 0){

            Generate::where('generate_id', $id)
            ->update([ 
                'generate_status' => 0
                ]);

            $new = new Refund;
            $new->project_id = $project->project_id;
            $new->year_budget = $project->year_budget;
            $new->department_id = $auth->department_id;
            $new->section_id = $auth->section_id;
            $new->budget_id = 1;
            $new->refund_price = $generate->paymentbalance;
            $new->refund_status = 0;
            $new->refund_type = 2;
            $new->generate_id = $id;
            $new->user_id = $auth->user_id;
            $new->save();

            $generate->generate_refund = 1;
            $generate->save();
        }

        return redirect('recurit/refund/section')->withSuccess("คืนงบประมาณจัดจ้างเรียบร้อยแล้ว");
    }

    public function authsection(){
        $auth = Auth::user();
        if( $auth->permission != 3 ){
            return true;
        }
        else{
            return false;
        }
    }

}


