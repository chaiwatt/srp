<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;

use App\Model\LogFile;

class LogController extends Controller
{

    public function Index (){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $logs = LogFile::orderBy('logfile_id','desc')->get();
        return view('setting.log.index')->withLogs($logs);
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
