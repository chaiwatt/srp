<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\Project;
use App\Model\Department;
use App\Model\Employ;
use App\Model\EmployPosition;
use App\Model\Section;
use App\Model\Position;
use App\Model\Generate;
use App\Model\Survey;
use App\Model\Allocation;
use App\Model\Surveyhost;
use App\Model\LogFile;
use App\Model\Users;
use App\Model\NotifyMessage;
use App\Model\Linenotify;

class RecuritEmploySectionController extends Controller{

    public function CreateSave(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $sumsalary = 0;
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $employ = Employ::where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)->sum('employ_amount');
        $position = Position::where('department_id' , $auth->department_id)->where('position_status' , 1)->get();
        $number = array();

        $q = Survey::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->groupBy('section_id');
        $q = $q->select('section_id');
        $section = $q->get();


        if( $section->count() > 0  ){
        	foreach( $section as $item ){
                $checkfornotify = 0;

        		$q = Generate::query();
        		$q = $q->where('project_id' , $project->project_id);
        		$q = $q->where('department_id' , $auth->department_id);
        		$q = $q->wherenotin('section_id' , [ $item->section_id ] );
                $q = $q->where('generate_category' , 1);
                $employsection = $q->count();
               
        		$q = Allocation::query();
			    $q = $q->where('project_id' , $project->project_id);
			    $q = $q->where('department_id' , $auth->department_id);
                $q = $q->where('section_id' ,  $item->section_id );
			    $q = $q->where('budget_id' , 1);
			    $q = $q->Where('allocation_type' , 2);
			    $allocation = $q->sum('allocation_price');

			    $q = Survey::query();
			    $q = $q->where('project_id' , $project->project_id);
			    $q = $q->where('department_id' , $auth->department_id);
			    $q = $q->where('section_id' , $item->section_id );
			    $survey = $q->get();

		        if( count($survey ) == 0 ){
		            return redirect()->back()->withError("ไม่สามารถบันทึกได้ เนื่องจากหน่วยงานนี้ไม่มีรายการสำรวจ");
                }
  
                $sum = array_sum( @Request::input('number')[$item->section_id] );            
		        $sum += $employsection;

		        if( $sum > $employ ){
		            return redirect()->back()->withError("ไม่สามารถบันทึกได้ เนื่องจากเกินจำนวนตั้งต้น");
		        } /* จำนวนเกิน */
                // dd( $sum . " " . $employ );

			    $section = Section::where('section_id' , $item->section_id )->first();
		        if( count($position) > 0 ){
		            foreach( $position as $value ){
                        
                        $sumsalary = 0;

		                if( Request::input('number')[$item->section_id][$value->position_id] != "" && Request::input('number')[$item->section_id][$value->position_id] != 0 ){
                            
                            unset( $number );
                                for( $i=1; $i <= Request::input('number')[$item->section_id][$value->position_id]; $i++  ){
                                    $yearth = substr ( (date('Y')+543) , 2 , 4 );
                                    $code = $yearth.str_pad( ($auth->department_id) , 2 ,"0",STR_PAD_LEFT).str_pad( ($section->section_code) , 5 ,"0",STR_PAD_LEFT).str_pad( ($value->position_id) , 2 ,"0",STR_PAD_LEFT).str_pad( ($i) , 4 ,"0",STR_PAD_LEFT);

                                    $generate = Generate::where('project_id',$project->project_id)
                                            ->where('department_id' , $auth->department_id)
                                            ->where('section_id' , $item->section_id )
                                            ->where('generate_category' , 1)
                                            ->where('generate_code' , $code)
                                            ->first();
                                    
                                    $number[] = $code;

                                    if( count($generate) == 0 ){
                                        $checkfornotify++ ;
                                        $new = new Generate;
                                        $new->project_id = $project->project_id;
                                        $new->year_budget = $project->year_budget;
                                        $new->department_id = $auth->department_id;
                                        $new->section_id = $item->section_id;
                                        $new->position_id = $value->position_id;
                                        $new->generate_code = $code;
                                        $new->generate_category = 1;
                                        $new->generate_allocation = (($value->position_salary) * 9);
                                        $new->generate_refund = 0;
                                        $new->save();
                                    }
                                }

                                $q = Generate::query();
                                $q = $q->where('project_id',$project->project_id);
                                $q = $q->where('section_id' , $item->section_id );
                                $q = $q->where('generate_category' , 1);
                                $q = $q->where('position_id' , $value->position_id);
                                $generate = $q->count();

                                if( Request::input('number')[$item->section_id][$value->position_id] < $generate  ){
                                    $checkfornotify++ ;
                                    $q = Generate::query();
                                    $q = $q->where('project_id',$project->project_id);
                                    $q = $q->where('generate_category' , 1);
                                    $q = $q->where('section_id' , $item->section_id );
                                    $q = $q->where('position_id' , $value->position_id);
                                    $q = $q->wherenotin( 'generate_code' , $number );
                                    $q = $q->delete();
                                }
		                }
		                else{
		                    $q = Generate::query();
		                    $q = $q->where('project_id',$project->project_id);
		                    $q = $q->where('generate_category' , 1);
		                    $q = $q->where('section_id' , $item->section_id );
		                    $q = $q->where('position_id' , $value->position_id);
		                    $q = $q->delete();
		                }
		            }
                }
                if ($checkfornotify > 0){
                    echo $item->section_name ;
                    $user = Users::where('section_id' , $item->section_id)->get();
                    if( $user->count() > 0 ){
                        foreach( $user as $item ){
                            $new = new NotifyMessage;
                            $new->system_id = 1;
                            $new->project_id = $project->project_id;
                            $new->message_key = 1;
                            $new->message_title = "อนุมัติ/แก้ไข จำนวนจัดสรรจ้างงาน";
                            $new->message_content = "อนุมัติ/แก้ไข จำนวนจัดสรรจ้างงาน ปีงบประมาณ " . $project->year_budget;
                            $new->message_date = date('Y-m-d H:i:s');
                            $new->user_id = $item->user_id;
                            $new->save();
            
                            $linenotify = Linenotify::where('user_id',$item->user_id)->first();
                            if(!Empty($linenotify)){
                                if ($linenotify->linetoken != ""){
                                    $message = "อนุมัติ/แก้ไข จำนวนจัดสรรจ้างงาน ปีงบประมาณ " . $project->year_budget . " โปรดตรวจสอบความถูกต้องจากเว็บไซต์";
                                    $linenotify->notifyme($message);
                                }
                            }
                        }
                    }
                }
        	}
        }

        $new = new LogFile;
        $new->loglist_id = 40;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('recurit/employ/section')->withSuccess("บันทึกรายการจัดสรรการจ้างงานเรียบร้อยแล้ว");
    }

    public function Create(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $search = Request::input('search')==""?"":Request::input('search');

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Employ::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $employ = $q->sum('employ_amount');

        $q = Generate::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('generate_category' , 1);
        $generate = $q->get();

        $q = Survey::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->groupBy('section_id');
        $section = $q->get();// ->paginate(10);

        $q = Survey::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $survey = $q->get();

        $position = Position::where('department_id' , $auth->department_id)->get();

        return view('recurit.employ.section.create')->withProject($project)
        ->withEmploy($employ)
        ->withGenerate($generate)
        ->withPosition($position)
        ->withSection($section)
        ->withSurvey($survey)
        ->withSearch($search);
    }

    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

    	$auth = Auth::user();
    	$setting = SettingYear::where('setting_status' , 1)->first();
    	$project = Project::where('year_budget' , $setting->setting_year)->first();
        $employ = Employ::where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)->first();
        if( count($employ) == 0 ){
            return redirect()->back();
        }

        $generate = Generate::where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)->where('generate_category' , 1)->get();
        $section = Generate::where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)->where('generate_category' , 1)->groupBy('section_id')->get();

        $position = Position::where('department_id' , $auth->department_id)->get();

        return view('recurit.employ.section.index')->withProject($project)->withSection($section)->withPosition($position)->withGenerate($generate)->withEmploy($employ);
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


