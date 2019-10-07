<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\Department;
use App\Model\Section;
use App\Model\Province;
use App\Model\LogFile;

class SettingSectionDepartmentController extends Controller
{
    public function Index(){
    	if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $section = Section::where('section_status' , 1)->where('department_id',$auth->department_id)->get();
   

    	return view('setting.section.department.index')->withSection($section);
    }
    public function CreateSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

		if( Request::input('name') == "" ){
			return redirect()->back()->withError("กรุณากรอก หน่วยงาน");
		}
       
        $mapcode = Province::where('province_id',Request::input('province'))->first()->map_code;

        $auth = Auth::user();
		$new = new Section;
		$new->department_id = $auth->department_id;
        $new->section_code = Request::input('code');
        $new->map_code = $mapcode;
		$new->section_name = Request::input('name');
		$new->section_status = 1;
		$new->save();

		$new = new LogFile;
        $new->loglist_id = 69;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/section/department')->withSuccess('เพิ่มหน่วยงานเรียบร้อย');
	}

	public function Create(){
		if( $this->authdepartment() ){
            return redirect('logout');
        }
        $province = Province::get();
		return view('setting.section.department.create')->withProvince($province);
	}
	public function EditSave(){
		$auth = Auth::user();

        if( $this->authdepartment() ){
            return redirect('logout');
        }

		$edit = Section::where('section_id' , Request::input('id') )->first();
		$edit->section_name = Request::input('name');
		$edit->section_code = Request::input('code');
		$edit->save();

		$new = new LogFile;
        $new->loglist_id = 70;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/section/department')->withSuccess("แก้ไขรายการหน่วยงานย่อยเรียบร้อยแล้ว");
	}

	public function Edit($id){

		if( $this->authdepartment() ){
            return redirect('logout');
        }

		$section = Section::where('section_id' , $id)->first();
		if( count($section) == 0 ){
			return redirect()->back()->withError("ไม่พบรายการหน่วยงานย่อย");
		}

		return view('setting.section.department.edit')->withSection($section);
	}
    
    public function DeleteSave($id){
		$auth = Auth::user();
		if( $this->authdepartment() ){
            return redirect('logout');
        }
		$delete = Section::where('section_id' , $id )->first();
		$delete->section_status = 0;
		$delete->save();

		$new = new LogFile;
        $new->loglist_id = 71;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/section/department')->withSuccess("ลบรายการหน่วยงานย่อยเรียบร้อยแล้ว");
	}
    public function authdepartment(){
        $auth = Auth::user();
        if( $auth->permission != 2 ){
            return true;
        }
        else{
            return false;
        }
    }
}
