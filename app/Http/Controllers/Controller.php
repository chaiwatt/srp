<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Auth;
use View;
use Session;

use App\Model\NotifyMessage;
use App\Model\SettingYear;
use App\Model\Project;
use App\Model\Allocation;
use App\Model\Generalsetting;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        $generalsetting = Generalsetting::where('generalsetting_id',1)->first();
        View::share ( 'generalsetting', $generalsetting );
		$this->middleware(function ($request, $next) {
            
            if( Auth::check() ){
                $auth = Auth::user();
                $message = NotifyMessage::where('user_id' , $auth->user_id)->where('message_read' , 0)
                                    ->orderBy('notify_message_id', 'desc')
                                    ->get();
                
                $setting = SettingYear::where('setting_status' , 1)->first();
                $project = Project::where('year_budget' , $setting->setting_year)->first();
                $allocationbudget = Allocation::where('year_budget' , $setting->setting_year)
                    ->where('department_id' , $auth->department_id)
                    ->where('allocation_type' , 1)
                    ->where('allocation_price' ,'!=', 0)
                    ->orderBy('budget_id' , 'asc')
                    ->get();

                 View::share ( 'allocationbudget', $allocationbudget );
                 View::share ( 'message', $message );
                 View::share ( 'auth', $auth );
                
			}
            return $next($request);
        });

    } 

}
 