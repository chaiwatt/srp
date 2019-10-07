<?php

namespace App\Http\Controllers;

use Auth;
use Request;
use App\Model\Generalsetting;

class SettingGeneralController extends Controller
{

    public function Index(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $generalsetting = Generalsetting::where('generalsetting_id', 1)->first();

    return view('setting.generalsetting.index')->withGeneralsetting($generalsetting);
    }


    public function SelectOnlineReg(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        Generalsetting::where('generalsetting_id', 1)
        ->update([ 
            'enable_onlinereg' =>  Request::input('data') , 
            ]);
            
  
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
