<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use Image;
use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Information;
use App\Model\InformationPicture;
use App\Model\Department;
use App\Model\Transfer;
use App\Model\Allocation;
use App\Model\LogFile;


class InformationController extends Controller{

    public function DeleteSave($id){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $department = Department::where('department_id' , $auth->department_id)->first();

        $information = Information::where('information_id' , $id)->where('department_id' , $auth->department_id)->first();
        if(count($information) == 0){
            return redirect()->back()->withError("ไม่พบข้อมูลประชาสัมพันธ์");
        }

        $picture = InformationPicture::where('information_id' , $id)->get();

        @unlink( $information->information_cover );
        if(count($picture) > 0){
            foreach( $picture as $item ){
                @unlink( $item->information_picture );
            }
        }

        Information::where('information_id' , $id)->delete();
        InformationPicture::where('information_id' , $id)->delete();

        $new = new LogFile;
        $new->loglist_id = 21;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('information')->withSuccess("ลบข่าวประชาสัมพันธ์เรียบร้อยแล้ว");
    }

    public function EditSave(){
        $extension = array('jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'GIF' , 'gif' , 'PNG' , 'png');

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $department = Department::where('department_id' , $auth->department_id)->first();

        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('budget_id' , 2);
        $q = $q->where('transfer_status' , 1);
        $transfer = $q->get();

        if( $transfer->sum('transfer_price') == 0 ){
            return redirect('information')->withError("ไม่สามารถเพิ่มข่าวประชาสัมพันธ์ได้");
        }

        $new = Information::where('information_id' , Request::input('id'))->first();
        $new->information_title = Request::input('title');
        $new->information_description = Request::input('description');
        $new->information_detail = Request::input('detail');

        if(Request::hasFile('cover')){
            $file = Request::file('cover');
            if( in_array($file->getClientOriginalExtension(), $extension) ){
                $new_name = str_random(10).".".$file->getClientOriginalExtension();
                $file->move('storage/uploads/information/cover' , $new_name);
                $new->information_cover = "storage/uploads/information/cover/".$new_name;
            }
        }

        $new->save();
        $information = Information::orderBy('information_id' , 'desc')->first();
        if(Request::file('picture')){   
            $files = request::file('picture');
            foreach($files as $file){
                if( $file != null ){
                    if( in_array($file->getClientOriginalExtension(), $extension) ){
                        $new_name = str_random(10).".".$file->getClientOriginalExtension();
                        $file->move('storage/uploads/information/picture' , $new_name);
                        $new = new InformationPicture;
                        $new->information_id = Request::input('id');
                        $new->information_picture = "storage/uploads/information/picture/".$new_name;
                        $new->save();
                    }
                }
            }
        }

        $new = new LogFile;
        $new->loglist_id = 20;
        $new->user_id = $auth->user_id;
        $new->save();
        return redirect("information")->withSuccess("แก้ไขข่าวประชาสัมพันธ์เรียบร้อยแล้ว");
    }

    public function DeletePictureSave($id,$postid){

        $auth = Auth::user();

        InformationPicture::where('information_picture_id' , $id )->delete();

        return redirect('information/edit/'.$postid)->withSuccess("ลบรูปภาพเรียบร้อยแล้ว");
    }

    public function Edit($id){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $department = Department::where('department_id' , $auth->department_id)->first();

        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('budget_id' , 2);
        $q = $q->where('transfer_status' , 1);
        $transfer = $q->get();

        if( $transfer->sum('transfer_price') == 0 ){
            return redirect('information')->withError("ไม่สามารถเพิ่มข่าวประชาสัมพันธ์ได้");
        }

        $information = Information::where('information_id' , $id)->where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)->first();
        if(count($information) == 0){
            return redirect()->back()->withError("ไม่พบข้อมูลประชาสัมพันธ์");
        }

        $picture = InformationPicture::where('information_id' , $id)->get();

        return view('information.edit')->withInformation($information)->withProject($project)->withPicture($picture)->withDepartment($department)->withTransfer($transfer);
    }

    public function CreateSave(){
        $extension = array('jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'GIF' , 'gif' , 'PNG' , 'png');

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $department = Department::where('department_id' , $auth->department_id)->first();

        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('budget_id' , 2);
        $q = $q->where('transfer_status' , 1);
        $transfer = $q->get();

        if( $transfer->sum('transfer_price') == 0 ){
            return redirect('information')->withError("ไม่สามารถเพิ่มข่าวประชาสัมพันธ์ได้");
        }

        $new = new Information;
        $new->project_id = $project->project_id;
        $new->year_budget = $project->year_budget;
        $new->section_id = $auth->section_id;
        $new->information_title = Request::input('title');
        $new->information_description = Request::input('description');
        $new->information_detail = Request::input('detail');
        $new->budget_id = Request::input('category');

        if(Request::hasFile('cover')){
            $file = Request::file('cover');
            if( in_array($file->getClientOriginalExtension(), $extension) ){
                $new_name = str_random(10).".".$file->getClientOriginalExtension();
                $file->move('storage/uploads/information/cover' , $new_name);
                $new->information_cover = "storage/uploads/information/cover/".$new_name;
            }
        }

        $new->department_id = $auth->department_id;
        $new->user_id = $auth->user_id;
        $new->save();

        $information = Information::orderBy('information_id' , 'desc')->first();

        if(Request::file('picture')){   
            $files = request::file('picture');
            foreach($files as $file){
                if( $file != null ){
                    if( in_array($file->getClientOriginalExtension(), $extension) ){

                        $new_name = str_random(10).".".$file->getClientOriginalExtension();
                        $file->move('storage/uploads/information/picture' , $new_name);

                        $new = new InformationPicture;
                        $new->information_id = $information->information_id;
                        $new->information_picture = "storage/uploads/information/picture/".$new_name;
                        $new->save();
                    }
                }
            }
        }

        $new = new LogFile;
        $new->loglist_id = 19;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect("information")->withSuccess("เพิ่มข่าวประชาสัมพันธ์เรียบร้อยแล้ว");
    }

    public function Create(){
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $department = Department::where('department_id' , $auth->department_id)->first();

        $budget = Allocation::where('department_id', $auth->department_id)->groupBy('budget_id')->get();

        $q = Transfer::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('budget_id' , 1);
        $q = $q->where('transfer_status' , 1);
        $transfer = $q->get();
       
        return view('information.create')->withProject($project)
                                    ->withDepartment($department)
                                    ->withBudget($budget)
                                    ->withTransfer($transfer);
    }

    public function Index(){
    	$auth = Auth::user();
    	$setting = SettingYear::where('setting_status' , 1)->first();
    	$project = Project::where('year_budget' , $setting->setting_year)->first();
        if($auth->permission == 2){
            $information = Information::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->get();
        }elseif($auth->permission == 3){
            $information = Information::where('project_id' , $project->project_id)
                                ->where('department_id' , $auth->department_id)
                                ->where('section_id' , $auth->section_id)
                                ->get();
        }
                
    	return view('information.index')->withInformation($information)->withProject($project);
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


