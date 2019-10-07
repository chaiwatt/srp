<?php namespace App\Http\Controllers;

use Request;
use Session;
use DB;
use Auth;
use Hash;
use DateTime;

use App\Http\Controllers\ApiController;
use App\Model\Users;
use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Allocation;

class AuthController extends Controller{

	public function Dashboard(){
		return view('landing');
	}

	public function LoginPage(){
	    $auth = Auth::user();
        
		if( Auth::check() ){
			if( $auth->permission == 1 ){
	        	return redirect("project/allocation");
	        }
	        elseif( $auth->permission == 2 ){
	        	return redirect("project/allocation/department");
	        }
	        elseif( $auth->permission == 3 ){
	        	return redirect("project/allocation/section");
	        }
		}
		else{
        	return view('auth.login');
    	}
	}

	public function Login(){
	    $user = Users::where('username', Request::input('username'))->where('isactive' , 1)->first(); 
	    if(!empty($user)){
			if($user->timelimit == 0){
				if (  Hash::check( Request::input('password') , $user->password  ) ) {
					Auth::login($user);
					$auth = Auth::user();
					if( $auth->permission == 1 ){
						return redirect("project/allocation");
					}
					elseif( $auth->permission == 2 ){
						$setting = SettingYear::where('setting_status' , 1)->first();
						$project = Project::where('year_budget' , $setting->setting_year)->first();
						return redirect("project/allocation/department");
					}
					elseif( $auth->permission == 3 ){
						return redirect("project/allocation/section");
					}
				} 
				else{
					return redirect()->back()->withError('ไม่พบชื่อผู้ใช้งานในระบบหรือรหัสผ่านไม่ถูกต้อง');
				}
			}else{
				
				$date = new DateTime("now");
				$limitstart = new DateTime($user->limitstart);
				$limitend = new DateTime($user->limitend);

				if( $date >= $limitstart && $date <= $limitend){
					if (  Hash::check( Request::input('password') , $user->password  ) ) {
						Auth::login($user);
						$auth = Auth::user();
						if( $auth->permission == 1 ){
							return redirect("project/allocation");
						}
						elseif( $auth->permission == 2 ){
							$setting = SettingYear::where('setting_status' , 1)->first();
							$project = Project::where('year_budget' , $setting->setting_year)->first();
							return redirect("project/allocation/department");
						}
						elseif( $auth->permission == 3 ){
							return redirect("project/allocation/section");
						}
					} 
					else{
						return redirect()->back()->withError('ไม่พบชื่อผู้ใช้งานในระบบ หรือรหัสผ่านไม่ถูกต้อง');
					}
				}else{
					return redirect()->back()->withError('ไม่สามารถเข้าสู่ในระบบเนื่องจากไม่อยู่ในช่วงเวลาใช้งาน');
				}
				
			}
		}else{
	        return redirect()->back()->withError('ไม่พบชื่อผู้ใช้งานในระบบ หรือรหัสผ่านไม่ถูกต้อง');
		}
}

	public function Logout(){
    	Session::flush();
        return redirect('/');
    }

    public function CreateUser(){
    	// $user = new Users;
    	// $user->name = "super admin"; 
    	// $user->name = "superadmin";
    	// $user->password = Hash::make("1234");
    	// $user->dept_id = 1;
    	// $user->section_id = 1;
    	// $user->usertype = "superadmin";
    	// $user->isactive = 1;
    	// $user->created_at = date("Y-m-d H:i:s");
    	// $user->updated_at = date('Y-m-d H:i:s');
    	// $user->rol_id = 1;
    	// $user->save();
    }



}

