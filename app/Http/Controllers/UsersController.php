<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use Hash;

use App\Model\UserType;
use App\Model\Users;
use App\Model\Department;
use App\Model\ActiveStatus;
use App\Model\Linenotify;
use App\Model\Userright;
use App\Model\LogFile;

class UsersController extends Controller{

    public function Index(){
        $auth = Auth::user();
        if($auth->permission == 1){
            $users = Users::all();
            $department = Department::get();
            return view('setting.user.index')->withUsers($users);
        }else if($auth->permission == 2 ){

            $department = Department::where('department_id',$auth->department_id)->get();
            $users = Users::where('department_id', $auth->department_id )->get();
            return view('setting.user.index')->withUsers($users)
                            ->withDepartment($department);
        }else if($auth->permission == 3){
            $users = Users::where('department_id', $auth->department_id )
                        ->where('section_id', $auth->section_id );
            return view('setting.user.index')->withUsers($users);
        }else{
            return redirect('logout');
        } 	
    }

    public function Edit($id){
        $auth = Auth::user();
        $user = Users::where('user_id', $id )->first();
        if ($auth->permission == 1){
            $department = Department::get();
        }else if($auth->permission == 2){
            $department = Department::where('department_id',$auth->department_id)->get();
        }
        $activestatus = ActiveStatus::get();
        $hashedPassword = Auth::user()->getAuthPassword();
        $userright = Userright::get();
        return view('setting.user.edit')->withUser($user)
                                    ->withAuth($auth)
                                    ->withActivestatus($activestatus)
                                    ->withUserright($userright)
                                    ->withDepartment($department);
    }

    public function Delete($id){
        $auth = Auth::user();
        Users::where('user_id', $id )->delete();

        $new = new LogFile;
        $new->loglist_id = 82;
        $new->user_id = $auth->user_id;
        $new->save();   

        return redirect('setting/user')->withSuccess("ลบผู้ใช้งานสำเร็จ");
    }

    public function EditSave(){
        $auth = Auth::user();

        if( Request::input('limitstart') != "" ){
			$date = explode("/", Request::input('limitstart'));
        	$limitstart = ($date[2]-543)."-".$date[1]."-".$date[0];
        }
        
        if( Request::input('limitend') != "" ){
			$date = explode("/", Request::input('limitend'));
        	$limitend = ($date[2]-543)."-".$date[1]."-".$date[0];
        }
        

        Users::where('user_id',Request::input('userid'))
                        ->update([ 
                            'name' =>  Request::input('name'), 
                            'username' => Request::input('user'),
                            'timelimit' => Request::input('timelimit'),
                            'limitstart' => $limitstart ,
                            'limitend' => $limitend ,
                            'password' => Hash::make(Request::input('pass')) ,
                            'isactive' => Request::input('status') ,
                            ]);

        $new = new LogFile;
        $new->loglist_id = 81;
        $new->user_id = $auth->user_id;
        $new->save();                   
        
        return redirect('setting/user')->withSuccess("แก้ไขข้อมูลสำเร็จ");
    }

    public function Create(){
        $auth = Auth::user();
        
        if ($auth->permission == 1){
            $department = Department::get();
        }else if($auth->permission == 2){
            $department = Department::where('department_id',$auth->department_id)->get();
        }

        $userright = Userright::get();
        return view('setting.user.create')->withDepartment($department)
                                ->withUserright($userright)
                                ->withAuth($auth);
    }

    public function CreateSave(){
        $auth = Auth::user();
        $check = Users::where('username',Request::input('user'))->get();
        if(count($check) !=0 ){
            return redirect('setting/user')->withError("ยูสเซอร์เนมซ้ำในระบบ");
        }

		if( Request::input('limitstart') != "" ){
			$date = explode("/", Request::input('limitstart'));
        	$limitstart = ($date[2]-543)."-".$date[1]."-".$date[0];
        }
        
        if( Request::input('limitend') != "" ){
			$date = explode("/", Request::input('limitend'));
        	$limitend = ($date[2]-543)."-".$date[1]."-".$date[0];
		}

        $usertype = UserType::where('type_id',Request::input('usertype'))->first();
		$new = new Users;
        $new->name = Request::input('name');
        $new->userperson_id = Request::input('userpersonid');
        $new->timelimit = Request::input('timelimit');
        $new->limitstart = $limitstart;
        $new->limitend = $limitend;
		$new->username = Request::input('user');
        $new->password = Hash::make(Request::input('pass'));
        if(Request::input('usertype') == 1){
            $new->department_id = 0;
            $new->section_id = 0;
        }else{
            if(Request::input('department') == '' || Request::input('section')  == '' ){
                return redirect('setting/user')->withError("ไม่ได้เลือกหน่วยงาน");
            }else{
                $new->department_id = Request::input('department');
                $new->section_id = Request::input('section');
            }
        }
        $new->usertype = $usertype->type_name;
        $new->permission = $usertype->permission;
        $new->save();

        $currentuser = Users::orderBy('user_id' , 'desc')->first();
        $new = new Linenotify;
        $new->user_id = $currentuser->user_id;
        $new->save();

        $new = new LogFile;
        $new->loglist_id = 80;
        $new->user_id = $auth->user_id;
        $new->save();

		return redirect('setting/user')->withSuccess("สร้างผู้ใช้สำเร็จ");
    }

    public function CreateUser(){
    	$user = new Users;
    	$user->name = "super admin"; 
    	$user->name = "superadmin";
    	$user->password = Hash::make("1234");
    	$user->dept_id = 1;
    	$user->section_id = 1;
    	$user->usertype = "superadmin";
    	$user->isactive = 1;
    	$user->created_at = date("Y-m-d H:i:s");
    	$user->updated_at = date('Y-m-d H:i:s');
    	$user->rol_id = 1;
    	$user->save();
    }

}


