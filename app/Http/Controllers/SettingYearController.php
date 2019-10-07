<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\Department;
use App\Model\Section;
use App\Model\Budget;
use App\Model\SettingYear;
use App\Model\SettingBudget;
use App\Model\SettingDepartment;
use App\Model\Project;
use App\Model\ProjectAllocation;
use App\Model\ProjectBudget;
use App\Model\LogFile;

class SettingYearController extends Controller{
    
	public function SelectYear(){
		$auth = Auth::user();
		SettingYear::where('setting_status' , 1)->update([ 'setting_status' => 0 ]);

		$setting = SettingYear::where('setting_year_id' , Request::input('id'))->first();
		$setting->setting_status = 1;
		$setting->save();

		$new = new LogFile;
        $new->loglist_id = 75;
        $new->user_id = $auth->user_id;
        $new->save();
		
	}

    public function DepartmentSave(){
		$auth = Auth::user();
    	$setting_year = SettingYear::where('setting_year_id' , Request::input('id'))->first();
		if(count($setting_year) == 0){
			return redirect()->back()->withError("ไม่พบข้อมูลปีงบประมาณ");
		}

		if( count(Request::input('department')) == 0 ){
			return redirect()->back()->withError("กรุณาเลือก อย่างน้อย 1 หน่วยงาน");
		}

		SettingDepartment::where('setting_year_id' , Request::input('id'))->wherenotIn('department_id' , Request::input('department') )->update([ 'setting_department_status' => 0 ]);
		SettingDepartment::where('setting_year_id' , Request::input('id'))->whereIn('department_id' , Request::input('department') )->update([ 'setting_department_status' => 1 ]);

		$new = new LogFile;
        $new->loglist_id = 74;
        $new->user_id = $auth->user_id;
        $new->save();
		
		return redirect('setting/year')->withSuccess("แก้ไขการตั้งค่า ค่าใช้จ่ายเรียบร้อยแล้ว");
    }

	public function Department($id){
		$setting_year = SettingYear::where('setting_year_id' , $id)->first();
		if(count($setting_year) == 0){
			return redirect()->back()->withError("ไม่พบข้อมูลปีงบประมาณ");
		}

		$project = Project::where('year_budget' , $setting_year->setting_year)->first();
		if(count($project) > 0){
			return redirect()->back()->withError("ไม่สามารถตั้งค่าแก้ไขรายการค่าใช้จ่ายได้");
		}

		$department = Department::where('department_status' , 1)->get();
		$setting_department = SettingDepartment::where('setting_year_id' , $id)->get();

		return view('setting.year.department')->withSettingyear($setting_year)->withDepartment($department)->withSettingdepartment($setting_department);
	}

	public function BudgetSave(){
		$auth = Auth::user();
		$setting_year = SettingYear::where('setting_year_id' , Request::input('id'))->first();
		if(count($setting_year) == 0){
			return redirect()->back()->withError("ไม่พบข้อมูลปีงบประมาณ");
		}
		if( count( Request::input('budget')) == 0 ){
			return redirect()->back()->withError("กรุณาเลือกค่าใช้จ่าย อย่างน้อย 1 รายการ");
		}

		SettingBudget::where('setting_year_id' , Request::input('id'))->wherenotin('budget_id' , Request::input('budget') )->update([ 'setting_budget_status' => 0 ]);
		SettingBudget::where('setting_year_id' , Request::input('id'))->wherein('budget_id' , Request::input('budget') )->update([ 'setting_budget_status' => 1 ]);

		$new = new LogFile;
        $new->loglist_id = 73;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/year')->withSuccess("แก้ไขการตั้งค่า ค่าใช้จ่ายเรียบร้อยแล้ว");
	}

	public function Budget($id){
		$setting_year = SettingYear::where('setting_year_id' , $id)->first();
		if(count($setting_year) == 0){
			return redirect()->back()->withError("ไม่พบข้อมูลปีงบประมาณ");
		}

		$project = Project::where('year_budget' , $setting_year->setting_year)->first();
		if(count($project) > 0){
			return redirect()->back()->withError("ไม่สามารถตั้งค่าแก้ไขรายการค่าใช้จ่ายได้");
		}

		$budget = Budget::where('budget_status' , 1)->get();
		$setting_budget = SettingBudget::where('setting_year_id' , $id)->get();
		return view('setting.year.budget')->withSettingyear($setting_year)->withSettingbudget($setting_budget)->withBudget($budget);

	}

	public function CreateSave(){
		$auth = Auth::user();
		$query = SettingYear::where('setting_year' , Request::input('year'))->first();
		if(count($query) > 0){
			return redirect()->back()->withInput()->withError("ปีงบประมาณนี้มีอยู่ในระบบแล้ว");
		}

		$settingyear = new SettingYear;
		$settingyear->setting_year = Request::input('year');
		$settingyear->save();

		$settingyear = SettingYear::orderBy('setting_year_id' , 'desc')->first();

		$budget = Budget::where('budget_status' , 1)->get();
		if(count( $budget ) > 0){
			foreach( $budget as $item ){
				$new = new SettingBudget;							
				$new->setting_year_id = $settingyear->setting_year_id;
				$new->setting_year = $settingyear->setting_year;
				$new->budget_id = $item->budget_id;
				$new->setting_budget_status = 1;
				$new->save();
			}
		}

		$department = Department::where('department_status' , 1)->get();
		if(count( $department ) > 0){
			foreach( $department as $item ){
				$new = new SettingDepartment;							
				$new->setting_year_id = $settingyear->setting_year_id;
				$new->setting_year = $settingyear->setting_year;
				$new->department_id = $item->department_id;
				$new->setting_department_status = 1;
				$new->save();
			}
		}

		$new = new LogFile;
        $new->loglist_id = 72;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/year');

	}

	public function Create(){
		return view('setting.year.create');
	}

	public function Delete($id){
        if( $this->authsuperadmin() ){
            return redirect('logout');
		}
		$setting_year = SettingYear::where('setting_year_id' , $id)->first();
		$project = Project::where('year_budget' , $setting_year->setting_year)->first();
		if(!Empty($project)){
			return redirect('setting/year')->withError("ปีงบประมาณนี้ถูกใช้ในโครงการแล้ว");
		}else{
			$allyear = SettingYear::get();
			// return ($allyear->count());
			if($allyear->count() == 1){
				return redirect('setting/year')->withError("ไม่สามารถลบปีงบประมาณตั้งต้นได้");
			}else{
				SettingYear::where('setting_year_id' , $id)->delete();
				SettingBudget::where('setting_year_id' , $id)->delete();
				SettingDepartment::where('setting_year_id' , $id)->delete();
				return redirect('setting/year')->withSuccess("ลบปีงบประมาณสำเร็จ");
			}
		}
	}

    public function Index(){
    	$settingyear = SettingYear::orderBy('setting_year' , 'desc')->get();
    	return view('setting.year.index')->withSettingyear($settingyear);
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


