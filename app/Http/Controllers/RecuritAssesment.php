<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;

use App\Model\SettingYear;
use App\Model\Register;
use App\Model\Project;
use App\Model\Generate;
use App\Model\Assessment;
use App\Model\FitStatus;
use App\Model\RegisterAssesmentFit;
use App\Model\Assessor;
use App\Model\RegisterAssessment;
use App\Model\LogFile;

class RecuritAssesment extends Controller
{
    public function Index(){
        if( $this->authsection() ){
            return redirect('logout');
        }

        $auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
		$project = Project::where('year_budget' , $setting->setting_year)->first();
		$registerassesmentfit = RegisterAssesmentFit::get();
        $register= Generate::where('project_id' , $project->project_id)
                    ->where('department_id' , $auth->department_id)
                    ->where('section_id' , $auth->section_id)
                    ->where('generate_category' , 1)
                    ->where('generate_status' , 1)
                    ->get();

       return view('recurit.assesment.index')->withProject($project)
       ->withRegisterassesmentfit($registerassesmentfit)
       ->withRegister($register);
    }

    public function View($id){
        if( $this->authsection() ){
            return redirect('logout');
        }

        $auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $registerassesmentfit = RegisterAssesmentFit::where('register_id' ,$id)->get();

        $registerassessment = RegisterAssessment::get();
        $register = Register::where('register_id' ,$id)->first();

        return view('recurit.assesment.view')->withRegister($register)
                                        ->withRegisterassessment($registerassessment)
                                        ->withRegister($register)
                                        ->withRegisterassesmentfit($registerassesmentfit);
    }

    public function Edit($id){
        if( $this->authsection() ){
            return redirect('logout');
        }

        $auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $fitstatus = FitStatus::get();
        $assessment = RegisterAssessment::where('register_assesment_fit_id', $id)->orderBy('assessment_id')->get();
        $assessor = Assessor::where('register_assesment_fit_id', $id)->get();
        $registerassesmentfit = RegisterAssesmentFit::where('register_assesment_fit_id' ,$id)->first();
      
        $register = Register::where('register_id',$registerassesmentfit->register_id)->first();

        return view('recurit.assesment.edit')->withRegister($register)
                                        ->withAssessment($assessment)
                                        ->withRegister($register)
                                        ->withAssessor($assessor)
                                        ->withFitstatus($fitstatus)
                                        ->withRegisterassesmentfit($registerassesmentfit);
    }

    public function DeleteAttachment($id){
        if( $this->authsection() ){
            return redirect('logout');
        }

        @unlink( $document->attachment );

        RegisterAssesmentFit::where('register_assesment_fit_id', $id)
        ->update([ 
            'attachment' =>  "", 
            ]);
        return  redirect('recurit/assesment/edit/'.$id)->withSuccess('ลบไฟล์สำเร็จ');
    }
    public function EditSave(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $assessment = Assessment::get();
        $register_assesment_fit_id = Request::input('register_assesment_fit_id');
        
        $register = Register::where('register_id',Request::input('register_id'))->first();

        $fname = "";
        if(Request::hasFile('attachment')){
            $file = Request::file('attachment');
            $new_name = str_random(10).".".$file->getClientOriginalExtension();
            $file->move('storage/uploads/attachment' , $new_name);
            $fname = "storage/uploads/attachment/".$new_name;
        }

        RegisterAssesmentFit::where('register_assesment_fit_id',$register_assesment_fit_id)
                    ->update([ 
                        'occupationbefore' => Request::input('occupationbefore'), 
                        'currentoccupationfit' => Request::input('currentoccupationfit'), 
                        'registeroccupationneedfit' => Request::input('registeroccupationneedfit'), 
                        'registereducationneedfit' => Request::input('registereducationneedfit'), 
                        'registeroccupationtrainfit' => Request::input('registeroccupationtrainfit'), 
                        'registereducationtrainfit' => Request::input('registereducationtrainfit'), 
                        'jobassignmentfit' => Request::input('jobassignmentfit'), 
                        'needhelp' => Request::input('needhelp'), 
                        'needrecommend' => Request::input('needrecommend'), 
                        'attachment' => $fname, 
                    ]);

        $allassessor = Assessor::where('register_assesment_fit_id', $register_assesment_fit_id)->get();
        if( count( Request::input('assessor') ) > 0 ){
            foreach( Request::input('assessor') as $key => $item ){
                if(count( @$allassessor[$key]) > 0){
                    Assessor::where('register_assesment_fit_id',$register_assesment_fit_id)
                                        ->update([ 
                                            'assessor_name' => Request::input('assessor')[$key], 
                                            'assessor_position' => Request::input('assessorposition')[$key], 
                                        ]);
            
                }else{
                    if( Request::input('assessor')[$key] != "" ){      
                        $new = new Assessor;
                        $new->register_id = $register->register_id;
                        $new->register_assesment_fit_id = $register_assesment_fit_id;
                        $new->assessor_name = Request::input('assessor')[$key];
                        $new->assessor_position = Request::input('assessorposition')[$key];
                        $new->save();
                    }
                }
            }
        }

        if( count($assessment) > 0 ){
            foreach( $assessment as $key => $item ){
                echo Request::input('assessment')[$key+1];
                RegisterAssessment::where('register_assesment_fit_id' , $register_assesment_fit_id)
                                ->where('register_id' , Request::input('register_id'))
                                ->where('assessment_id',$key+1)
                                ->update([ 
                                    'register_assessment_point' =>  Request::input('assessment')[$key+1],
                                ]);               
            }
        }

        $new = new LogFile;
        $new->loglist_id = 37;
        $new->user_id = $auth->user_id;
        $new->save();

        return  redirect('recurit/assesment/view/'.Request::input('register_id'))->withSuccess('แก้ไขการประเมินสำเร็จ');

    }

    public function Delete($id){
        $auth = Auth::user();
        RegisterAssesmentFit::where('register_assesment_fit_id',$id)->delete();
        Assessor::where('register_assesment_fit_id', $id)->delete();
        RegisterAssessment::where('register_assesment_fit_id' , $id)->delete();

        $new = new LogFile;
        $new->loglist_id = 35;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('recurit/assesment')->withSuccess('ลบการประเมินสำเร็จ');
    }

    public function DeleteAll($id){
        $auth = Auth::user();
        RegisterAssesmentFit::where('register_id',$id)->delete();
        Assessor::where('register_id', $id)->delete();
        RegisterAssessment::where('register_id' , $id)->delete();

        $new = new LogFile;
        $new->loglist_id = 36;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('recurit/assesment')->withSuccess('ลบการประเมินทั้งหมดสำเร็จ');
    }

    public function Create($id){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $assessment = Assessment::get();
        $register = Register::where('register_id',$id)->first();
        $fitstatus = FitStatus::get();

        return view('recurit.assesment.create')->withProject($project)
                                        ->withAssessment($assessment)
                                        ->withFitstatus($fitstatus)
                                        ->withRegister($register);
    }


    public function CreateSave(){
        if( $this->authsection() ){
            return redirect('logout');
        }
        $auth = Auth::user();
		$setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $assessment = Assessment::get();
        $register = Register::where('register_id',Request::input('register_id'))->first();

		$new = new RegisterAssesmentFit;
        $new->project_id = $project->project_id;
        $new->department_id = $auth->department_id;
        $new->section_id = $auth->section_id;
        $new->register_id = $register->register_id;
		$new->occupationbefore = Request::input('occupationbefore');
		$new->currentoccupationfit = Request::input('currentoccupationfit');
		$new->registeroccupationneedfit = Request::input('registeroccupationneedfit');
		$new->registereducationneedfit = Request::input('registereducationneedfit');
		$new->registeroccupationtrainfit = Request::input('registeroccupationtrainfit');
		$new->registereducationtrainfit = Request::input('registereducationtrainfit');
        $new->jobassignmentfit = Request::input('jobassignmentfit');
        $new->needhelp = Request::input('needhelp');
        $new->needrecommend = Request::input('needrecommend');
        $new->save();
        
        $registerassesmentfit = RegisterAssesmentFit::orderBy('register_assesment_fit_id','DESC')->first();

        if(Request::hasFile('attachment')){
            $file = Request::file('attachment');
            $new_name = str_random(10).".".$file->getClientOriginalExtension();
            $file->move('storage/uploads/attachment' , $new_name);
            $new->attachment = "storage/uploads/attachment/".$new_name;
        }
        $new->save();

        if( Request::input('submit') == "autoget" ){
            //get from api
        }else{
            if( count($assessment) > 0 ){
                foreach( $assessment as $item ){
                    if( Request::input('assessment')[ $item->assessment_id ] != "" ){
                        $new = new RegisterAssessment;
                        $new->register_id = $register->register_id;
                        $new->project_id = $project->project_id;
                        $new->department_id = $auth->department_id;
                        $new->section_id = $auth->section_id;
                        $new->assessment_id = $item->assessment_id;
                        $new->register_assesment_fit_id = $registerassesmentfit->register_assesment_fit_id;
                        $new->register_assessment_point = Request::input('assessment')[ $item->assessment_id ];
                        $new->save();
                    }
                }
            }       
        }

        $allassessor = Assessor::where('register_assesment_fit_id', $registerassesmentfit->register_assesment_fit_id)->get();
        if( count( Request::input('assessor') ) > 0 ){
            foreach( Request::input('assessor') as $key => $item ){
                if(count( @$allassessor[$key]) > 0){
                    Assessor::where('register_assesment_fit_id',$registerassesmentfit->register_assesment_fit_id)
                                        ->update([ 
                                            'assessor_name' => Request::input('assessor')[$key], 
                                            'assessor_position' => Request::input('assessorposition')[$key], 
                                        ]);
            
                }else{
                    if( Request::input('assessor')[$key] != "" ){      
                        $new = new Assessor;
                        $new->register_assesment_fit_id = $registerassesmentfit->register_assesment_fit_id;
                        $new->register_id = $register->register_id;
                        $new->assessor_name = Request::input('assessor')[$key];
                        $new->assessor_position = Request::input('assessorposition')[$key];
                        $new->save();
                    }
                }
            }
        }
        $new = new LogFile;
        $new->loglist_id = 34;
        $new->user_id = $auth->user_id;
        $new->save();   

    return redirect('recurit/assesment')->withSuccess('เพิ่มการประเมินสำเร็จ');

    }

    public function authsection(){
        $auth = Auth::user();
        if( $auth->permission != 3 ){
            return true;
        }
        else{
            return false;
        }
    }
}
