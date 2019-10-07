<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\Department;
use App\Model\LogFile;

class SettingDepartmentController extends Controller{

	public function DeleteSave($id){
		$auth = Auth::user();
		$department = Department::where('department_id' , $id )->first();
		$department->department_status = 0;
		$department->save();

		$new = new LogFile;
        $new->loglist_id = 61;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/department')->withSuccess("ลบรายการหน่วยงานเรียบร้อยแล้ว");
	}

	public function EditSave(){
		$auth = Auth::user();
		$department = Department::where('department_id' , Request::input('id') )->first();
		$department->department_name = Request::input('name');
		$department->save();

		$new = new LogFile;
        $new->loglist_id = 60;
        $new->user_id = $auth->user_id;
        $new->save();


		return redirect('setting/department')->withSuccess("แก้ไขรายการหน่วยงานเรียบร้อยแล้ว");
	}

	public function Edit($id){
		$department = Department::where('department_id' , $id)->first();
		if( count($department) == 0 ){
			return redirect()->back()->withError("ไม่พบรายการหน่วยงาน");
		}

		return view('setting.department.edit')->withDepartment($department);
	}

	public function CreateSave(){

		if( Request::input('name') == "" ){
			return redirect()->back()->withError("กรุณากรอก หน่วยงาน");
		}
		$auth = Auth::user();
		$new = new Department;
		$new->department_name = Request::input('name');
		$new->save();

		$new = new LogFile;
        $new->loglist_id = 59;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/department');
	}

	public function Create(){
		return view('setting.department.create');
	}

    public function Index(){
    	$department = Department::where('department_status' , 1)->get();
    	return view('setting.department.index')->withDepartment($department);
    }

}


