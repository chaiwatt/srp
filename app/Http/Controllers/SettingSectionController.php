<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\Department;
use App\Model\Section;
use App\Model\Province;
use App\Model\LogFile;


class SettingSectionController extends Controller{

    public function Index(){
    	if( $this->authsuperadmint() ){
            return redirect('logout');
        }
    	$department = Request::input('department')==""?"":Request::input('department');

    	$q = Section::query();
    	if( $department != "" ){
    		$q = $q->where('department_id' , $department);
    	}
    	$section = $q->where('section_status' , 1)->orderBy( DB::raw( 'ABS(section_code)' ) , 'asc' )->paginate(20);


    	return view('setting.section.index')->withSection($section)->withDepartment($department);
    }
	public function DeleteSave($id){
		if( $this->authsuperadmint() ){
            return redirect('logout');
		}
		$auth = Auth::user();
		$delete = Section::where('section_id' , $id )->first();
		$delete->section_status = 0;
		$delete->save();

		$new = new LogFile;
        $new->loglist_id = 71;
        $new->user_id = $auth->user_id;
		$new->save();

		return redirect('setting/section')->withSuccess("ลบรายการหน่วยงานย่อยเรียบร้อยแล้ว");
	}

	public function EditSave(){

        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
		$auth = Auth::user();
		$edit = Section::where('section_id' , Request::input('id') )->first();
		$edit->section_name = Request::input('name');
		$edit->section_code = Request::input('code');
		$edit->save();

		$new = new LogFile;
        $new->loglist_id = 70;
        $new->user_id = $auth->user_id;
		$new->save();

		return redirect('setting/section')->withSuccess("แก้ไขรายการหน่วยงานย่อยเรียบร้อยแล้ว");
	}

	public function Edit($id){

		if( $this->authsuperadmint() ){
            return redirect('logout');
        }

		$section = Section::where('section_id' , $id)->first();
		if( count($section) == 0 ){
			return redirect()->back()->withError("ไม่พบรายการหน่วยงานย่อย");
		}

		return view('setting.section.edit')->withSection($section);
	}

	public function CreateSave(){
		$auth = Auth::user();
		if( Request::input('name') == "" ){
			return redirect()->back()->withError("กรุณากรอก หน่วยงาน");
		}
		$mapcode = Province::where('province_id',Request::input('province'))->first()->map_code;

		$new = new Section;
		$new->department_id = Request::input('department');
		$new->section_code = Request::input('code');
		$new->map_code = $mapcode;
		$new->section_name = Request::input('name');
		$new->section_status = 1;
		$new->save();

        $new = new LogFile;
        $new->loglist_id = 69;
        $new->user_id = $auth->user_id;
		$new->save();
		
		return redirect('setting/section');
	}

	public function Create(){
		if( $this->authsuperadmint() ){
            return redirect('logout');
		}
		$province = Province::get();
		return view('setting.section.create')->withProvince($province);
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

}


