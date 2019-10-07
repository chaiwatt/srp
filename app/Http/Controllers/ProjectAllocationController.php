<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\Project;
use App\Model\Department;
use App\Model\Section;
use App\Model\Budget;
use App\Model\Allocation;
use App\Model\AllocationTransaction;
use App\Model\AllocationWaiting;
use App\Model\ProjectBudget;
use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\SettingBudget;
use App\Model\Refund;
use App\Model\NotifyMessage;
use App\Model\Users;
use App\Model\TransferTransaction;
use App\Model\Linenotify;
use App\Model\LogFile;

class ProjectAllocationController extends Controller{
	public function LocateSave(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $project = Project::where('project_id' , Request::input('id'))->first();
        if( count($project) == 0 ){
            return redirect()->back()->withError("ไม่พบข้อมูลโครงการ");
        }

        $budget = SettingBudget::where('setting_year' , $project->year_budget)->where('setting_budget_status' , 1)->get();
        $sum = array_sum( Request::input('budget') );

        if( $sum > $project->totalbudget ){
            return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูล เนื่องจากเงินจัดสรร " . number_format( $sum  , 2) ." มากกว่างบประมาณ ");
        }

        if( $sum < $project->totalbudget ){
            return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูล เนื่องจากเงินจัดสรร " . number_format( $sum  , 2) ." น้อยกว่างบประมาณ ");
        }

    	if( count($budget) > 0 ){
    		foreach( $budget as $item){

				$budgetlist = ProjectBudget::where('project_id' , Request::input('id'))->where('budget_id',$item->budget_id)->first();
				$budgetlist->allocate = Request::input('budget')[$item->budget_id];
				$budgetlist->save();
    		}
    	}

    	$project = Project::where('project_id' , Request::input('id'))->first();
    	$project->is_setup = 1;
        $project->save();
        
        $user = Users::where('permission' , 1)->get();
        if( count($user) > 0 ){
            foreach( $user as $item ){
                $new = new NotifyMessage;
                $new->system_id = 1;
                $new->project_id = $project->project_id;
                $new->message_key = 1;
                $new->message_title = "จัดสรรงบประมาณตั้งต้น";
                $new->message_content = "จัดสรรงบประมาณตั้งต้น ปีงบประมาณ " . $project->year_budget;
                $new->message_date = date('Y-m-d H:i:s');
                $new->user_id = $item->user_id;
                $new->save();

                $linenotify = Linenotify::where('user_id',$item->user_id)->first();
                if(count($linenotify) !=0 ){
                    if ($linenotify->linetoken != ""){
                        $message = "จัดสรรงบประมาณตั้งต้น ปีงบประมาณ " . $project->year_budget;
                        $linenotify->notifyme($message);
                    }
                }
            }
        }

    	return redirect('project/allocation')->withSuccess("แก้ไขข้อมูลเรียบร้อยแล้ว");
	}

	public function Locate($id){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $project = Project::where('project_id' ,  $id )->first();
    	if( count($project) == 0 ){
    		return redirect()->back()->withError("ไม่พบข้อมูลโครงการ");
    	}

        $budget = SettingBudget::where('setting_year' , $project->year_budget)->where('setting_budget_status' , 1)->orderBy('budget_id')->get();
    	$budgetlist = ProjectBudget::where('project_id' , $id)->orderBy('budget_id')->get();

    	return view('project.allocation.locate')->withBudget($budget)->withProject($project)->withBudgetlist($budgetlist);

	}

	public function DeptalllocateSave(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $project = Project::where('project_id' , Request::input('id'))->first();
        if( count($project) == 0 ){
            return redirect()->back()->withError("ไม่พบข้อมูลโครงการ");
        }
        $sum = 0;

        $department = SettingDepartment::where('setting_year' , $project->year_budget)->where('setting_department_status' , 1)->get();
        $budget = SettingBudget::where('setting_year' , $project->year_budget)->where('setting_budget_status' , 1)->get();
        
        if( count($budget) > 0 ){
            foreach( $budget as $item ){
                $sum += array_sum( Request::input('number')[ $item->budget_id ] );
                $number = array_sum( Request::input('number')[ $item->budget_id ] );
                $budgetlist = ProjectBudget::where('project_id' , Request::input('id') )->where('budget_id' , $item->budget_id)->first();
                if( $number > $budgetlist->allocate ){
                    return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลจัดสรรงบได้ เนื่องจากเกินงบประมาณ หมวด:" . $item->budgetname);
                }
            }
        }
        if( $sum > $project->totalbudget ){
            return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูล เนื่องจากเงินจัดสรร " . number_format( $sum  , 2) ." มากกว่างบประมาณ ");
        }

        $waiting = AllocationWaiting::where('project_id' , $project->project_id)
                                ->where('waiting_status' , 1)->sum('waiting_price');

        if( $sum + $waiting < $project->totalbudget ){
            return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูล เนื่องจากเงินจัดสรร " . number_format( $sum  , 2) ." น้อยกว่างบประมาณ ");
        }

    	if( count($budget) > 0 ){
    		foreach( $budget as $item){
    			if( count($department) > 0 ){
    				foreach( $department as $value ){
                        $q = Allocation::query();
                        $q = $q->where('project_id' , $project->project_id);
                        $q = $q->where('budget_id' , $item->budget_id);
                        $q = $q->where('department_id' , $value->department_id);
                        $q = $q->where('allocation_type' , 1);
                        $allocation = $q->first();

                        // echo $allocation;

                        $q = AllocationTransaction::query();
                        $q = $q->where('project_id' , $project->project_id);
                        $q = $q->where('budget_id' , $item->budget_id);
                        $q = $q->where('department_id' , $value->department_id);
                        $q = $q->where('transaction_type' , 1);
                        $q = $q->orderBy('allocation_transaction_id' , 'desc');
                        $transaction = $q->first();

                        // echo $transaction;

                        if( count($transaction) > 0 ){ /* มี transaction หรือยัง */
                            //จำนวนเงินที่กรอกมากกว่าจำนวนเงินจัดสรร
                            // echo Request::input('number')[ $item->budget_id ][ $value->department_id] . "  ". $allocation->allocation_price  . "<br>";
                            
                            if( Request::input('number')[ $item->budget_id ][ $value->department_id] > $allocation->allocation_price ){
                                echo " ขอมากกว่าเดิม" .  " budget: " . $item->budget_id . " dept: " . $value->department_id  . "<br>" ;
                                // จำนวนเงินกรอกใหม่ในรายการค่าใช้จ่ายมากกว่าเดิม
                                $cost = Request::input('number')[$item->budget_id][$value->department_id];
                                // $income = จำนวนเงินที่เพิ่มขึ้นมา
                                $income =  Request::input('number')[$item->budget_id][$value->department_id] - $allocation->allocation_price;
                                $balance = $transaction->transaction_balance + $income;

                                $new = new AllocationTransaction;
                                $new->project_id = $project->project_id;
                                $new->year_budget = $project->year_budget;
                                $new->department_id = $value->department_id;
                                $new->budget_id = $item->budget_id;
                                $new->section_id = 0;
                                $new->transaction_cost = $cost;
                                $new->transaction_income = $income;
                                $new->transaction_outcome = 0;
                                $new->transaction_balance = $balance;
                                $new->transaction_type = 1;
                                $new->save();

                                $q = Allocation::query();
                                $q = $q->where('project_id' , $project->project_id );
                                $q = $q->where('budget_id' , $item->budget_id);
                                $q = $q->where('department_id' , $value->department_id);
                                $q = $q->where('allocation_type' , 1);
                                $update = $q->first();
                                $update->allocation_price = Request::input('number')[ $item->budget_id ][ $value->department_id  ];
                                $update->save();

                                //รายการโอน
                                $q = TransferTransaction::query();
                                $q = $q->where('project_id' , $project->project_id);
                                $q = $q->where('department_id' , $value->department_id);
                                $q = $q->where('budget_id' , $item->budget_id);
                                $q = $q->where('transaction_type' , 1);
                                $q = $q->orderBy('transfer_transaction_id' , 'desc');
                                $transaction = $q->first();

                                if(count($transaction) > 0){
                                    $transfer_balance = $transaction->transaction_balance;
                                    // echo "add transaction income for " . $item->budget_id . " " . $value->department_id;
                                    $new = new TransferTransaction;
                                    $new->project_id = $project->project_id;
                                    $new->year_budget = $project->year_budget;
                                    $new->department_id = $value->department_id;
                                    $new->section_id = 0;
                                    $new->budget_id = $item->budget_id;
                                    $new->transaction_cost = $transfer_balance;
                                    $new->transaction_income = $income;
                                    $new->transaction_outcome = 0 ;
                                    $new->transaction_balance = $transfer_balance + $income;
                                    $new->transaction_type = 1;
                                    $new->save();
                                }


                                //}
                            }elseif( Request::input('number')[ $item->budget_id ][ $value->department_id] < $allocation->allocation_price ){
                                // จำนวนเงินกรอกใหม่ในรายการค่าใช้จ่ายน้อยกว่าเดิม
                                echo " ขอน้อยกว่าเดิม" .  " budget: " . $item->budget_id . " dept: " . $value->department_id . "<br>" ;
                                $cost = Request::input('number')[$item->budget_id][$value->department_id];
                                $outcome =  $allocation->allocation_price - Request::input('number')[$item->budget_id][$value->department_id];
                                $balance = $transaction->transaction_balance - $outcome;

                                $new = new AllocationTransaction;
                                $new->project_id = $project->project_id;
                                $new->year_budget = $project->year_budget;
                                $new->department_id = $value->department_id;
                                $new->budget_id = $item->budget_id;
                                $new->section_id = 0;
                                $new->transaction_cost = $cost;
                                $new->transaction_income = 0;
                                $new->transaction_outcome = $outcome;
                                $new->transaction_balance = $balance;
                                $new->transaction_type = 1;
                                $new->save();

                                $q = Allocation::query();
                                $q = $q->where('project_id' , $project->project_id );
                                $q = $q->where('budget_id' , $item->budget_id);
                                $q = $q->where('department_id' , $value->department_id);
                                $q = $q->where('allocation_type' , 1);
                                $update = $q->first();
                                $update->allocation_price = Request::input('number')[ $item->budget_id ][ $value->department_id  ];
                                $update->save();

                                $q = TransferTransaction::query();
                                $q = $q->where('project_id' , $project->project_id);
                                $q = $q->where('department_id' , $value->department_id);
                                $q = $q->where('budget_id' , $item->budget_id);
                                $q = $q->where('transaction_type' , 1);
                                $q = $q->orderBy('transfer_transaction_id' , 'desc');
                                $transaction = $q->first();

                                //รายการโอน
                                $q = TransferTransaction::query();
                                $q = $q->where('project_id' , $project->project_id);
                                $q = $q->where('department_id' , $value->department_id);
                                $q = $q->where('budget_id' , $item->budget_id);
                                $q = $q->where('transaction_type' , 1);
                                $q = $q->orderBy('transfer_transaction_id' , 'desc');
                                $transaction = $q->first();

                                if(count($transaction) > 0){
                                    $transfer_balance = $transaction->transaction_balance;
                                    echo "subtract transaction outcome for " . $item->budget_id . " " . $value->department_id;
                                    $new = new TransferTransaction;
                                    $new->project_id = $project->project_id;
                                    $new->year_budget = $project->year_budget;
                                    $new->department_id = $value->department_id;
                                    $new->section_id = 0;
                                    $new->budget_id = $item->budget_id;
                                    $new->transaction_cost = $transfer_balance;
                                    $new->transaction_income = 0;
                                    $new->transaction_outcome = $outcome ;
                                    $new->transaction_balance = $transfer_balance - $outcome;
                                    $new->transaction_type = 1;
                                    $new->save();
                                }
                            }
                        }
                        else{
                            
                            if( Request::input('number')[ $item->budget_id ][ $value->department_id  ] != 0 && Request::input('number')[ $item->budget_id ][ $value->department_id  ] != ""  ){
                                    // echo "ไม่มีใน transaction";
                                    $new = new Allocation;
                                    $new->project_id = $project->project_id;
                                    $new->year_budget = $project->year_budget;
                                    $new->department_id = $value->department_id;
                                    $new->section_id = 0;
                                    $new->budget_id = $item->budget_id;
                                    $new->allocation_price = Request::input('number')[$item->budget_id][$value->department_id];
                                    $new->allocation_type = 1;
                                    $new->save();

                                    $new = new AllocationTransaction;
                                    $new->project_id = $project->project_id;
                                    $new->year_budget = $project->year_budget;
                                    $new->department_id = $value->department_id;
                                    $new->budget_id = $item->budget_id;
                                    $new->section_id = 0;
                                    $new->transaction_cost = Request::input('number')[ $item->budget_id ][ $value->department_id  ];
                                    $new->transaction_income = 0;
                                    $new->transaction_outcome = 0;
                                    $new->transaction_balance = Request::input('number')[ $item->budget_id ][ $value->department_id  ];
                                    $new->transaction_type = 1;
                                    $new->save();

                                //}
                            }
                        }
                    }
    			}    
    		}
    	}

    	$project = Project::where('project_id' , $project->project_id )->first();
    	$project->is_allocated = 1;
    	$project->save();

        $user = Users::whereIn('permission' , [1,2])->get();
        if( count($user) > 0 ){
            foreach( $user as $item ){
                $new = new NotifyMessage;
                $new->system_id = 1;
                $new->project_id = $project->project_id;
                $new->message_key = 1;
                $new->message_title = "จัดสรรงบประมาณ";
                $new->message_content = "จัดสรรงบประมาณ ปีงบประมาณ " . $project->year_budget;
                $new->message_date = date('Y-m-d H:i:s');
                $new->user_id = $item->user_id;
                $new->save();

                $linenotify = Linenotify::where('user_id',$item->user_id)->first();
                if(count($linenotify) !=0 ){
                    if ($linenotify->linetoken != ""){
                        $message = "จัดสรรงบประมาณ ปีงบประมาณ " . $project->year_budget . " โปรดตรวจสอบความถูกต้องจากเว็บไซต์";
                        $linenotify->notifyme($message);
                    }
                }
            }
        }

    	return redirect()->back()->withSuccess("แก้ไขข้อมูลเรียบร้อยแล้ว");
	}

	public function Deptalllocate($id){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
		$project = Project::where('project_id' ,  $id )->first();
    	if( count($project)==0){
    		return redirect()->back()->withError("ไม่พบข้อมูลโครงการ");
    	}

        $department = SettingDepartment::where('setting_year' , $project->year_budget)->where('setting_department_status' , 1)->orderBy('department_id' , 'asc')->get();
        $budget = SettingBudget::where('setting_year' , $project->year_budget)->where('setting_budget_status' , 1)->orderBy('budget_id' , 'asc')->get();
        $settingyear = SettingYear::where('setting_status' , 1)->first();
    	$allocation = Allocation::where('project_id' , $id)->where('allocation_type' , 1)->orderBy('department_id' , 'asc')->orderBy('budget_id' , 'asc')->get();
        $budgetlist = ProjectBudget::where('project_id' , $id)->orderBy('budget_id' , 'asc')->get();

        $sumbydept = AllocationWaiting::where('waiting_status',1)
                                    ->where('year_budget',$settingyear->setting_year)
                                    ->groupBy('department_id')
                                    ->selectRaw('*, sum(waiting_price) as sum')
                                    ->get();                         

        $q = AllocationWaiting::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('year_budget' , $settingyear->setting_year);
        $q = $q->where('waiting_status' , 1);
        $waiting = $q->get();

        return view('project.allocation.deptalllocate')
                            ->withDepartment($department)
                            ->withBudget($budget)
                            ->withProject($project)
                            ->withAllocation($allocation)
                            ->withBudgetlist($budgetlist)
                            ->withWaiting($waiting)
                            ->withSumbydept($sumbydept);
	}

    public function Index(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
    	$project = Project::orderBy('year_budget' , 'desc')->paginate(10);
        $settingyear = SettingYear::where('setting_status' , 1)->first();
    	return view('project.allocation.list')->withProject($project)->withSettingyear($settingyear);
    }

    public function Create(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $project = Project::where('project_id' , Request::input('id'))->first();
        $settingyear = SettingYear::where('setting_status' , 1)->first();
    	return view('project.allocation.create')->withSettingyear($settingyear)->withProject($project);
    }

    public function CreateSave(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
   
    	$auth = Auth::user();

        $setting_year = SettingYear::where('setting_year' , Request::input('year'))->first();
        if(count($setting_year) == 0){
            return redirect()->back()->withError("ไม่พบข้อมูลการตั้งค่า ปีงบประมาณ : " . Request::input('year'));
        }

        $project = Project::where('year_budget' , Request::input('year'))->first();
        if(count($project) > 0){
            return redirect()->back()->withError("ไม่สามารถเพิ่มโครงการได้ เนื่องจากได้เพิ่มโครงการเรียบร้อยแล้ว");
        }

        if( Request::input('date_start') == "" ){
            return redirect()->back()->withError("ไม่สามารถเพิ่มโครงการได้ กรุณาใส่วันเริ่มโครงการ");
        }
        if( Request::input('date_end') == "" ){
            return redirect()->back()->withError("ไม่สามารถเพิ่มโครงการได้ กรุณาใส่วันสิ้นสุดโครงการ");
        }

        $date = explode("/", Request::input('date_start'));
        $date_start = ($date[2]-543)."-".$date[1]."-".$date[0];
        $date = explode("/", Request::input('date_end'));
        $date_end = ($date[2]-543)."-".$date[1]."-".$date[0];

    	$project = new Project;
    	$project->adddate = date('Y-m-d H:i:s');
    	$project->year_budget = Request::input('year');
    	$project->project_name = "โครงการคืนความดีสู่สังคม";
        $project->project_description = Request::input('description');
    	$project->totalbudget = Request::input('budget');
    	$project->startdate = $date_start;
    	$project->enddate = $date_end;
    	$project->user_id = $auth->user_id;
    	$project->is_allocated = 0;
    	$project->is_setup = 0;
    	$project->save();

    	$project = Project::orderBy('project_id' , 'desc')->first();

    	$department = SettingDepartment::where('setting_year' , Request::input('year'))->where('setting_department_status' , 1)->get();
    	$budget = SettingBudget::where('setting_year' , Request::input('year'))->where('setting_budget_status' , 1)->get();

    	if( count( $budget ) > 0 ){
    		foreach( $budget as $item ){
    			$new = new ProjectBudget;
    			$new->project_id = $project->project_id;
    			$new->year_budget = $project->year_budget;
    			$new->budget_id = $item->budget_id;
    			$new->allocate = null;
    			$new->save();
    		}
    	}

        $new = new LogFile;
        $new->loglist_id = 1;
        $new->user_id = $auth->user_id;
        $new->save();
       
    	return redirect('project/allocation')->withSuccess("เพิ่มข้อมูลเรียบร้อยแล้ว");
    }

    public function Edit($id){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

    	$project = Project::find( $id );
    	if( count($project) == 0 ){
    		return redirect()->back()->withError("ไม่พบข้อมูลโครงการ");
    	}

        $query = Project::where('project_id' , $id)->where('is_allocated' , 1)->first();
        if(count($query) > 0){
            return redirect('project/allocation')->withError("ไม่สามารถแก้ไขโครงการได้ เนื่องจากได้ทำรายการจัดสรรงบแล้ว");
        }

    	return view('project.allocation.edit')->withProject($project);
    }
	
    public function EditSave(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        
    	$project = Project::where('project_id' , Request::input('id'))->first();
        if( $project->startdateinput != Request::input('date_start') ){
            $date = explode("/", Request::input('date_start'));
            $date_start = ($date[2]-543)."-".$date[1]."-".$date[0];
            $project->startdate = $date_start;
        }
        if( $project->enddateinput != Request::input('date_end') ){
            $date = explode("/", Request::input('date_end'));
            $date_end = ($date[2]-543)."-".$date[1]."-".$date[0];
            $project->enddate = $date_end;
        }

    	$project->year_budget = Request::input('year');
        $project->project_description = Request::input('description');
    	$project->totalbudget = Request::input('budget');
        $project->save();
        
        $new = new LogFile;
        $new->loglist_id = 2;
        $new->user_id = $auth->user_id;
        $new->save();

    	return redirect('project/allocation')->withSuccess("แก้ไขข้อมูลเรียบร้อยแล้ว");
    }

    public function DeleteSave($id){

        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $project = Project::find( $id );
        if( count($project) == 0 ){
            return redirect()->back()->withError("ไม่พบข้อมูลโครงการ");
        }

        $query = Project::where('project_id' , $id)->where('is_allocated' , 1)->first();
        if(count($query) > 0){
            return redirect('project/allocation')->withError("ไม่สามารถลบโครงการได้ เนื่องจากได้ทำรายการจัดสรรงบแล้ว");
        }

    	// Project::where('project_id' ,$id)->delete();
		// ProjectAllocation::where('project_id' ,$id)->delete();
        // ProjectBudget::where('project_id' ,$id)->delete();

        $allocation = Allocation::where('project_id' ,$id);
    	Project::where('project_id' ,$id)->delete();
        ProjectBudget::where('project_id' ,$id)->delete();
        if(!Empty($allocation)){
            $allocation->delete();
        }
        
        $new = new LogFile;
        $new->loglist_id = 3;
        $new->user_id = Auth::user()->user_id;
        $new->save();

    	return redirect()->back()->withSuccess("ลบข้อมูลเรียบร้อยแล้ว");
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


