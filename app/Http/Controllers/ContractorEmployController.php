<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\SettingYear;
use App\Model\SettingDepartment;
use App\Model\Project;
use App\Model\Department;
use App\Model\ContractorPosition;
use App\Model\Generate;
use App\Model\Allocation;
use App\Model\ContractorEmploy;
use App\Model\Payment;

class ContractorEmployController extends Controller
{


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
