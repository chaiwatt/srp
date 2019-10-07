<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\Position;
use App\Model\Department;
use App\Model\Section;
use App\Model\LogFile;

class SettingPositionDepartmentController extends Controller
{
    public function Index(){
        $auth = Auth::user();
        if( $this->authdepartment() ){
            return redirect('logout');
        }
    	$position = Position::where('position_status' , 1)->orderBy('position_id' , 'desc')->where('department_id',$auth->department_id)->get();

    	return view('setting.position.department.index')->withPosition($position);
    }

    public function Create(){
		return view('setting.position.department.create');
	}
	public function CreateSave(){

        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();
		$new = new Position;
		$new->position_name = Request::input('name');
		$new->department_id = $auth->department_id;
		$new->position_salary = Request::input('salary');
        $new->save();
        
        $new = new LogFile;
        $new->loglist_id = 66;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/position/department')->withSuccess("เพิ่มตำแหน่งงานเรียบร้อยแล้ว");
    }
    
    public function DeleteSave($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
		$position = Position::where('position_id' , $id )->first();
		$position->position_status = 0;
        $position->save();
        
        $new = new LogFile;
        $new->loglist_id = 68;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/position/department')->withSuccess("ลบตำแหน่งงานเรียบร้อยแล้ว");
    }
	public function Edit($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
		$position = Position::where('position_id' , $id)->first();
		if( count($position) == 0 ){
			return redirect()->back()->withError("ไม่พบตำแหน่งงาน");
		}

		return view('setting.position.department.edit')->withPosition($position);
    }

    public function EditSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
		$position = Position::where('position_id' , Request::input('id') )->first();
		$position->position_name = Request::input('name');
		$position->department_id = $auth->department_id;
		$position->position_salary = Request::input('salary');
        $position->save();
        
        $new = new LogFile;
        $new->loglist_id = 67;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/position/department')->withSuccess("แก้ไขตำแหน่งงานเรียบร้อยแล้ว");
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
