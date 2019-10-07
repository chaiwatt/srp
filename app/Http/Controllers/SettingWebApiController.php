<?php

namespace App\Http\Controllers;

use Auth;
use Request;
use Session;
use App\Model\WebApi;

class SettingWebApiController extends Controller
{
    public function Index(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $webapi = WebApi::get();
        return view('setting.webapi.index')->withWebapi($webapi);

    }
    public function Edit($id){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $webapi = WebApi::where('webapi_id',$id)->first();
        return view('setting.webapi.edit')->withWebapi($webapi);
    }

    public function EditSave(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        WebApi::where('webapi_id',Request::input('id'))
                ->update([ 
                    'weburl' =>  Request::input('name'), 
                ]);
        return redirect('setting/webapi')->withSuccess('แก้ไข Web Api สำเร็จ');
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
