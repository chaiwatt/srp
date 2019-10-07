<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use App\Controllers\ApiController;

use App\Model\Project;
use App\Model\Department;
use App\Model\Section;
use App\Model\Budget;
use App\Model\Allocation;
use App\Model\AllocationTransaction;
use App\Model\ProjectBudget;
use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\SettingBudget;
use App\Model\Transfer;
use App\Model\TransferTransaction;
use App\Model\InformationExpense;
use App\Model\Payment;
use App\Model\Refund;
use App\Model\Survey;
use App\Model\ReadinessSection;
use App\Model\ProjectReadiness;
use App\Model\Generate;
use App\Model\Position;
use App\Model\LogFile;
use App\Model\Users;
use App\Model\NotifyMessage;
use App\Model\Linenotify;

class ProjectAllocationDepartmentController extends Controller
{

    public function Index(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        if(Empty($project)){
            return "<center><strong>ยังไม่ได้กำหนดโครงการ โปรดติดต่อผู้บริหารโครงการ</strong></center>";
        }
        $allocation = Allocation::where('year_budget' , $setting->setting_year)
                    ->where('department_id' , $auth->department_id)
                    ->where('allocation_type' , 1)
                    ->where('allocation_price' ,'!=', 0)
                    ->orderBy('budget_id' , 'asc')
                    ->get();
                    

        return view('project.allocation.department.index')
                    ->withAllocation($allocation)
                    ->withProject($project);
    }

    public function Transfer($id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }

        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = DepartmentAllocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('department_allocation_id' , $id);
        $allocation = $q->first();

        $q = TransferDepartment::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('section_id' , $allocation->section_id);
        $q = $q->where('budget_id' , $allocation->budget_id);
        $q = $q->where('transfer_department_status' , 1);
        $transfer = $q->get();

        return view('project.allocation.department.transfer')->withProject($project)->withAllocation($allocation)->withTransfer($transfer);

    }

    public function Lists(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('allocation_type' , 2);
        $allocation = $q->get();

        return view('project.allocation.department.list')->withProject($project)->withAllocation($allocation);
    }

    public function CreateSave(){

        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $sum = 0;
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $budget = Budget::where('budget_id' , Request::input('id') )->first();

        $q = Survey::query();
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('project_id' , $project->project_id);
        $section = $q->groupBy('section_id')->get();

        if( count( $budget ) > 0 ){ /*  ตรวจสอบว่า ค่าใช้จ่าย เกิน งบประมาณที่โอนมาให้หรือไม่*/
            if( $budget->budget_id == 1 ){

            	$q = Allocation::query();
		        $q = $q->where('project_id' , $project->project_id);
		        $q = $q->where('department_id' , $auth->department_id);
		        $q = $q->where('budget_id' , $budget->budget_id);
		        $q = $q->where('allocation_type' , 1);
		        $allocation = $q->first();
               
                $sum = array_sum( Request::input('number') );
            }
            
            if( $sum > $allocation->allocation_price ){
                return redirect()->back()->withError("ไม่สามารถบันทึกข้อมูลรายการงบประมาณได้ เนื่องจากเกินวงเงินตั้งต้น");
            }

            if( $budget->budget_id == 1 ){
                if( count($section) > 0 ){
                    foreach( $section as $value ){
                        // echo $value->section_id ."<br>" ;
                        $checkalloate = 0;
                        $q = AllocationTransaction::query();
                        $q = $q->where('project_id' , $project->project_id);
                        $q = $q->where('department_id' , $auth->department_id);
                        $q = $q->where('section_id' , $value->section_id);
                        $q = $q->where('budget_id' , $budget->budget_id);
                        $q = $q->where('transaction_type' , 2);
                        $transaction = $q->first();

                        $q = Allocation::query();
                        $q = $q->where('project_id' , $project->project_id);
                        $q = $q->where('department_id' , $auth->department_id);
                        $q = $q->where('section_id' , $value->section_id);
                        $q = $q->where('budget_id' , $budget->budget_id);
                        $q = $q->where('allocation_type' , 2);
                        $allocation = $q->first();

                        if( count($transaction) > 0 ){
                            if( Request::input('number')[$value->section_id] > $allocation->allocation_price ){
                                /* เงินที่ key มากกว่าเงินตั้งต้น */
                                $checkalloate++ ;
                                $q = AllocationTransaction::query();
                                $q = $q->where('project_id' , $project->project_id);
                                $q = $q->where('department_id' , $auth->department_id);
                                $q = $q->where('budget_id' , $budget->budget_id);
                                $q = $q->where('transaction_type' , 1);
                                $q = $q->orderBy('allocation_transaction_id' , 'desc');
                                $transaction = $q->first();

                                $q = AllocationTransaction::query();
                                $q = $q->where('project_id' , $project->project_id);
                                $q = $q->where('department_id' , $auth->department_id);
                                $q = $q->where('budget_id' , $budget->budget_id);
                                $q = $q->where('section_id' , $value->section_id);
                                $q = $q->where('transaction_type' , 2);
                                $q = $q->orderBy('allocation_transaction_id' , 'desc');
                                $transaction2 = $q->first();

                                $cost = $transaction2->transaction_balance;
                                $income =  Request::input('number')[$value->section_id] - $allocation->allocation_price;
                                $balance = $transaction2->transaction_balance + $income;

                                $new = new AllocationTransaction;
                                $new->project_id = $project->project_id;
                                $new->year_budget = $project->year_budget;
                                $new->department_id = $auth->department_id;
                                $new->budget_id = $budget->budget_id;
                                $new->section_id = $value->section_id;
                                $new->transaction_cost = $cost;
                                $new->transaction_income = $income;
                                $new->transaction_outcome = 0;
                                $new->transaction_balance = $balance;
                                $new->transaction_type = 2;
                                $new->save(); 

                                $cost = $transaction->transaction_balance;
                                $outcome = $income;
                                $balance = $transaction->transaction_balance - $outcome;

                                $new = new AllocationTransaction;
                                $new->project_id = $project->project_id;
                                $new->year_budget = $project->year_budget;
                                $new->department_id = $auth->department_id;
                                $new->budget_id = $budget->budget_id;
                                $new->section_id = 0;
                                $new->transaction_cost = $cost;
                                $new->transaction_income = 0;
                                $new->transaction_outcome = $outcome;
                                $new->transaction_balance = $balance;
                                $new->transaction_type = 1;
                                $new->save();

                                $q = Allocation::query();
                                $q = $q->where('project_id' , $project->project_id );
                                $q = $q->where('budget_id' , $budget->budget_id);
                                $q = $q->where('department_id' , $auth->department_id);
                                $q = $q->where('section_id' , $value->section_id);
                                $q = $q->where('allocation_type' , 2);
                                $update = $q->first();
                                $update->allocation_price = Request::input('number')[$value->section_id];
                                $update->save();

                                $transaction  = TransferTransaction::where('project_id' , $project->project_id)
                                ->where('budget_id' , $budget->budget_id)
                                ->where('department_id', $auth->department_id)
                                ->where('section_id' , $value->section_id)
                                ->orderBy('transfer_transaction_id' , 'desc')
                                ->first();

                                // return  Request::input('number')[$value->section_id]  ." " .$income ;

                                $new = new TransferTransaction;
                                $new->project_id = $project->project_id;
                                $new->year_budget = $project->year_budget;
                                $new->department_id = $auth->department_id;
                                $new->section_id = $value->section_id;
                                $new->budget_id = $budget->budget_id;
                                $new->transaction_income = $income;
                                $new->transaction_outcome = 0;

                                if(!Empty($transaction)){
                                    $new->transaction_cost = $transaction->transaction_balance;
                                    $new->transaction_balance = $transaction->transaction_balance + $income;
                                }else{
                                    $new->transaction_cost = Request::input('number')[$value->section_id];
                                    $new->transaction_balance = Request::input('number')[$value->section_id];
                                }

                                $new->transaction_type = 2;
                                $new->save();
                                
                            }
                            elseif( Request::input('number')[$value->section_id] < $allocation->allocation_price ){
                                /* เงินที่ key น้อยกว่าเงินตั้งต้น */
                                $q = TransferTransaction::query();
                                $q = $q->where('project_id' , $project->project_id);
                                $q = $q->where('budget_id' , $budget->budget_id);
                                $q = $q->where('department_id' , $auth->department_id);
                                $q = $q->where('section_id' , $value->section_id);
                                $q = $q->where('transaction_type' , 2);
                                $transfer = $q->first(); /* มีการ transfer เงินไปให้ section หีือยัง */
                                if( count($transfer) == 0 ){
                                    $checkalloate++ ;
                                    $q = AllocationTransaction::query();
                                    $q = $q->where('project_id' , $project->project_id);
                                    $q = $q->where('budget_id' , $budget->budget_id);
                                    $q = $q->where('department_id' , $auth->department_id);
                                    $q = $q->where('transaction_type' , 1);
                                    $q = $q->orderBy('allocation_transaction_id' , 'desc');
                                    $transaction = $q->first();

                                    $q = AllocationTransaction::query();
                                    $q = $q->where('project_id' , $project->project_id);
                                    $q = $q->where('budget_id' , $budget->budget_id);
                                    $q = $q->where('department_id' , $auth->department_id);
                                    $q = $q->where('section_id' , $value->section_id);
                                    $q = $q->where('transaction_type' , 2);
                                    $q = $q->orderBy('allocation_transaction_id' , 'desc');
                                    $transaction2 = $q->first();

                                    $cost = $transaction2->transaction_balance;
                                    $outcome = $transaction2->transaction_balance - Request::input('number')[$value->section_id];
                                    $balance = $transaction2->transaction_balance - $outcome;

                                    $new = new AllocationTransaction;
                                    $new->project_id = $project->project_id;
                                    $new->year_budget = $project->year_budget;
                                    $new->department_id = $auth->department_id;
                                    $new->budget_id = $budget->budget_id;
                                    $new->section_id = $value->section_id;
                                    $new->transaction_cost = $cost;
                                    $new->transaction_income = 0;
                                    $new->transaction_outcome = $outcome;
                                    $new->transaction_balance = $balance;
                                    $new->transaction_type = 2;
                                    $new->save(); 

                                    $cost = $transaction->transaction_balance;
                                    $income = $outcome;
                                    $balance = $transaction->transaction_balance + $income;

                                    $new = new AllocationTransaction;
                                    $new->project_id = $project->project_id;
                                    $new->year_budget = $project->year_budget;
                                    $new->department_id = $auth->department_id;
                                    $new->budget_id = $budget->budget_id;
                                    $new->section_id = 0;
                                    $new->transaction_cost = $cost;
                                    $new->transaction_income = $income;
                                    $new->transaction_outcome = 0;
                                    $new->transaction_balance = $balance;
                                    $new->transaction_type = 1;
                                    $new->save(); 

                                    $q = Allocation::query();
                                    $q = $q->where('project_id' , $project->project_id );
                                    $q = $q->where('budget_id' , $budget->budget_id);
                                    $q = $q->where('department_id' , $auth->department_id);
                                    $q = $q->where('section_id' , $value->section_id);
                                    $q = $q->where('allocation_type' , 2);
                                    $update = $q->first();
                                    $update->allocation_price = Request::input('number')[$value->section_id];
                                    $update->save();
                                }
                            }
                        }
                        else{
                            if( Request::input('number')[$value->section_id] != 0 && Request::input('number')[$value->section_id] != ""  ){
                                $checkalloate++ ;
                                $q = AllocationTransaction::query();
                                $q = $q->where('project_id' , $project->project_id);
                                $q = $q->where('budget_id' , $budget->budget_id);
                                $q = $q->where('department_id' , $auth->department_id);
                                $q = $q->where('transaction_type' , 1);
                                $q = $q->orderBy('allocation_transaction_id' , 'desc');
                                $transaction = $q->first();

                                $new = new Allocation;
                                $new->project_id = $project->project_id;
                                $new->year_budget = $project->year_budget;
                                $new->department_id = $auth->department_id;
                                $new->section_id = $value->section_id;
                                $new->budget_id = $budget->budget_id;
                                $new->allocation_price = Request::input('number')[$value->section_id];
                                $new->allocation_type = 2;
                                $new->save();

                                $new = new AllocationTransaction;
                                $new->project_id = $project->project_id;
                                $new->year_budget = $project->year_budget;
                                $new->department_id = $auth->department_id;
                                $new->budget_id = $budget->budget_id;
                                $new->section_id = $value->section_id;
                                $new->transaction_cost = Request::input('number')[$value->section_id];
                                $new->transaction_income = 0;
                                $new->transaction_outcome = 0;
                                $new->transaction_balance = Request::input('number')[$value->section_id];
                                $new->transaction_type = 2;
                                $new->save();

                                $balance = $transaction->transaction_balance - Request::input('number')[$value->section_id];

                                $new = new AllocationTransaction;
                                $new->project_id = $project->project_id;
                                $new->year_budget = $project->year_budget;
                                $new->department_id = $auth->department_id;
                                $new->budget_id = $budget->budget_id;
                                $new->section_id = 0;
                                $new->transaction_cost = $transaction->transaction_balance;
                                $new->transaction_income = 0;
                                $new->transaction_outcome = Request::input('number')[$value->section_id];
                                $new->transaction_balance = $balance;
                                $new->transaction_type = 1;
                                $new->save();
                            }
                        }
                        if ($checkalloate > 0){
                            // echo $value->section_name ;
                            $users = Users::where('section_id' , $value->section_id)->get();
                            if( $users->count() > 0 ){
                                foreach( $users as $user ){
                                    $new = new NotifyMessage;
                                    $new->system_id = 1;
                                    $new->project_id = $project->project_id;
                                    $new->message_key = 1;
                                    $new->message_title = "อนุมัติ/แก้ไข งบประมาณจ้างงาน";
                                    $new->message_content = "อนุมัติ/แก้ไข งบประมาณจ้างงาน ปีงบประมาณ " . $project->year_budget;
                                    $new->message_date = date('Y-m-d H:i:s');
                                    $new->user_id = $user->user_id;
                                    $new->save();
                    
                                    $linenotify = Linenotify::where('user_id',$user->user_id)->first();
                                    if(!Empty($linenotify)){
                                        if ($linenotify->linetoken != ""){
                                            $message = "อนุมัติ/แก้ไข งบประมาณจ้างงาน ปีงบประมาณ " . $project->year_budget . " โปรดตรวจสอบความถูกต้องจากเว็บไซต์";
                                            $linenotify->notifyme($message);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }
        
        $new = new LogFile;
        $new->loglist_id = 23;
        $new->user_id = $auth->user_id;
        $new->save();
// return "";
        return redirect('recurit/employ/section')->withSuccess("บันทึกข้อมูลเรียบร้อยแล้ว");
    }

    public function Create(){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $search = Request::input('search')==""?"":Request::input('search');
        // if($search == 4){
        //     $readiness = Request::input('readiness')==""?"":Request::input('readiness');
        //         return $readiness;
        // }
        $search =1;
        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $budget = Budget::where('budget_id' , $search)->where('budget_status' , 1)->first();

        $q = Allocation::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('allocation_type' , 2);
        $q = $q->where('budget_id' , 1);
        $allocation = $q->get();

        $q = Survey::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->groupBy('section_id');
        $section = $q->get();

        $q = AllocationTransaction::query();
        $q = $q->where('project_id' , $project->project_id);
        $q = $q->where('department_id' , $auth->department_id);
        $q = $q->where('budget_id' , $search);
        $q = $q->where('transaction_type' , 1);
        $q = $q->orderBy('allocation_transaction_id' , 'desc');
        $transaction = $q->first();

        $generate = Generate::where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)->where('generate_category' , 1)->get();
        $salary = Position::where('department_id',$auth->department_id)->first()->position_salary;
        return view('project.allocation.department.create')->withSearch($search)
        ->withSection($section)
        ->withBudget($budget)
        ->withSalary($salary)
        ->withProject($project)
        ->withGenerate($generate)
        ->withAllocation($allocation)
        ->withTransaction($transaction);
    }

    public function View($budget_id){
        if( $this->authdepartment() ){
            return redirect('logout');
        }
        $auth = Auth::user();

        $setting = SettingYear::where('setting_status' , 1)->first();
        $project = Project::where('year_budget' , $setting->setting_year)->first();
        $transfer = Transfer::where('project_id' , $project->project_id)->where('department_id' , $auth->department_id)->where('budget_id' , $budget_id)->where('transfer_status' , 1)->where('transfer_type' , 1)->get();

        return view('project.allocation.department.view')->withTransfer($transfer)->withProject($project);
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


