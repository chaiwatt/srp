<?php

namespace App\Http\Controllers;

use Auth;
use Request;
use DB;

use App\Model\SettingYear;
use App\Model\Project;
use App\Model\SettingDepartment;
use App\Model\Department;
use App\Model\ContractorPosition;
use App\Model\Generate;
use App\Model\LogFile;

class SettingContractorPositionController extends Controller
{
    public function Index(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $contractorposition = ContractorPosition::get();
        return view('setting.contractorposition.index')->withContractorposition($contractorposition);
    }
    
    public function Create(){
        return view('setting.contractorposition.create');
    }

    public function authsuperadmint(){
        $auth = Auth::user();
        if( $auth->permission != 1 ){
            return true;
        }
        else{
            return false;
        }
    }
    public function CreateSave(){

		if( Request::input('name') == "" ){
			return redirect()->back()->withError("กรุณากรอก ตำแหน่งงาน");
		}
		if( Request::input('department') == "" ){
			return redirect()->back()->withError("กรุณาเลือก หน่วยงาน");
		}
		$auth = Auth::user();
		$new = new ContractorPosition;
		$new->position_name = Request::input('name');
		$new->department_id = Request::input('department');
		$new->position_salary = Request::input('salary');
		$new->save();

		$new = new LogFile;
        $new->loglist_id = 56;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/contractorposition')->withSuccess('เพิ่มตำแหน่งงานสำเร็จ');
    }
    

    public function Edit($id){
		$position = ContractorPosition::where('position_id' , $id)->first();
		if( count($position) == 0 ){
			return redirect()->back()->withError("ไม่พบรายการหน่วยงาน");
		}
        $department = Department::get();
		return view('setting.contractorposition.edit')->withPosition($position)->withDepartment($department);
    }
    
    public function EditSave(){
		$auth = Auth::user();
		$position = ContractorPosition::where('position_id' , Request::input('id') )->first();
		$position->position_name = Request::input('name');
		$position->department_id = Request::input('department');
		$position->position_salary = Request::input('salary');
		$position->save();

		$new = new LogFile;
        $new->loglist_id = 58;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/contractorposition')->withSuccess("แก้ไขรายการหน่วยงานเรียบร้อยแล้ว");
    }
    
    public function Delete($id){
		$auth = Auth::user();
		$position = ContractorPosition::where('position_id' , $id )->first();
		$position->position_status = 0;
		$position->delete();

		$new = new LogFile;
        $new->loglist_id = 57;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/contractorposition')->withSuccess("ลบรายการหน่วยงานเรียบร้อยแล้ว");
	}
}
