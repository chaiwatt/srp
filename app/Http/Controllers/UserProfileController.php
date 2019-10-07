<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use Hash;

use App\Model\UserType;
use App\Model\Users;
use App\Model\Department;
use App\Model\ActiveStatus;
use App\Model\Section;
use App\Model\Linenotify;
use App\Model\NotifyMessage;
use App\Model\SettingYear;
use App\Model\Project;

class UserProfileController extends Controller
{
    public function Index(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $location="";
        $linenotify = Linenotify::get();
        if(Empty($project)){
            $notifymessage = NotifyMessage::where('user_id',$auth->user_id)
            ->paginate(10);
        }else{
            $notifymessage = NotifyMessage::where('project_id',$project->project_id )
            ->where('user_id',$auth->user_id)
            ->paginate(10);
        }
                        
        if($auth->permission == 1){
            $location = "ผู้บริหารโครงการ" ;
        }else if($auth->permission == 2){
            $location = Department::where('department_id',$auth->department_id)->first()->department_name;
        }else if($auth->permission == 3){
            $location = Section::where('section_id',$auth->section_id)->first()->section_name;
        }


          return view('setting.user.profile.index')->withLocation($location)
                                            ->withNotifymessage($notifymessage)
                                            ->withLinenotify($linenotify)
                                            ->withAuth($auth);
    }

    public function Edit(){       
        $user = Users::where('user_id' , Request::input('userid') )->first();
        $extension = array('jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'GIF' , 'gif' , 'PNG' , 'png');
        if(Request::hasFile('file')){
            $file = Request::file('file');
            if( in_array($file->getClientOriginalExtension(), $extension) ){
                $new_name = str_random(10).".".$file->getClientOriginalExtension();
                $file->move('storage/uploads/users' , $new_name);
                $user->image = "storage/uploads/users/".$new_name;
            }
        }

        $user->name =Request::input('name');
        $user->position =Request::input('position');
        $user->password = Hash::make(Request::input('pass'));

     //return $user->user_id;
        //if(Request::input('linenotify') != ''){
            Linenotify::where('user_id',$user->user_id)
                        ->update([ 
                            'url' =>  Request::input('linenotify'), 
                            ]);
        //}
        //if(Request::input('linetoken') != ''){
            Linenotify::where('user_id',$user->user_id)
                        ->update([ 
                            'linetoken' =>  Request::input('linetoken'), 
                            ]);
        //}

        $user->save();
        return redirect('setting/user/profile')->withSuccess("แก้ไขข้อมูลสำเร็จ");
    }

    public function Makeread($id){
        NotifyMessage::where('notify_message_id',$id)
                    ->update([ 
                        'message_read' =>  1, 
                        ]);
        return redirect()->back()->withSuccess("มาร์คอ่านแล้ว");
    }

    public function MakereadAll(){
        $auth = Auth::user();
        NotifyMessage::where('user_id',$auth->user_id)
                    ->update([ 
                        'message_read' =>  1, 
                        ]);
        return redirect('setting/user/profile')->withSuccess("มาร์คอ่านทั้งหมดแล้ว");
    }

    
    public function Deletemessage($id){
        NotifyMessage::where('notify_message_id',$id)
                    ->delete();
        return redirect()->back()->withSuccess("ลบข้อความแล้ว");
    }
    public function DeleteAll(){
        $auth = Auth::user();
        NotifyMessage::where('user_id',$auth->user_id)
                    ->delete();
        return redirect('setting/user/profile')->withSuccess("ลบข้อความทั้งหมดแล้ว");
    }

    
}
