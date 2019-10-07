<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\Position;
use App\Model\LogFile;

class SettingPositionController extends Controller
{

	public function Index(){
    	$department = Request::input('department')==""?"":Request::input('department');

    	$q = Position::query();
    	if( $department != "" ){
    		$q = $q->where('department_id' , $department);
    	}
    	$position = $q->where('position_status' , 1)->orderBy('position_id' , 'desc')->get();

    	return view('setting.position.index')->withPosition($position)->withDepartment($department);
    }
	public function DeleteSave($id){
		$auth = Auth::user();
		$position = Position::where('position_id' , $id )->first();
		$position->position_status = 0;
		$position->save();

		$new = new LogFile;
        $new->loglist_id = 68;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/position')->withSuccess("ลบรายการหน่วยงานเรียบร้อยแล้ว");
	}

	public function EditSave(){
		$auth = Auth::user();
		$position = Position::where('position_id' , Request::input('id') )->first();
		$position->position_name = Request::input('name');
		$position->department_id = Request::input('department');
		$position->position_salary = Request::input('salary');
		$position->save();

		$new = new LogFile;
        $new->loglist_id = 67;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/position')->withSuccess("แก้ไขรายการหน่วยงานเรียบร้อยแล้ว");
	}

	public function Edit($id){
		$position = Position::where('position_id' , $id)->first();
		if( count($position) == 0 ){
			return redirect()->back()->withError("ไม่พบรายการหน่วยงาน");
		}

		return view('setting.position.edit')->withPosition($position);
	}

	public function CreateSave(){
		$auth = Auth::user();
		if( Request::input('name') == "" ){
			return redirect()->back()->withError("กรุณากรอก ตำแหน่งงาน");
		}
		if( Request::input('department') == "" ){
			return redirect()->back()->withError("กรุณาเลือก หน่วยงาน");
		}

		$new = new Position;
		$new->position_name = Request::input('name');
		$new->department_id = Request::input('department');
		$new->position_salary = Request::input('salary');
		$new->save();

		$new = new LogFile;
        $new->loglist_id = 66;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/position');
	}

	public function Create(){
		return view('setting.position.create');
	}

 

}


