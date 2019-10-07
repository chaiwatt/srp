<?php

namespace App\Http\Controllers;

use Request;
use Log;
use Storage;
use Artisan;
use Auth;

use App\Model\Backuphistory;
use App\Model\Dropboxinfo;


class BackupController extends Controller
{

    public function Index(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $backup = Backuphistory::get();
        return view('setting.backup.index')->withBackup($backup);
    }
    public function Backup(){
        $auth = Auth::user();
        Artisan::call('backup:run',['--only-db'=>true]);
        $output = Artisan::output();
        $new = new Backuphistory;
        $new->backupby = $auth->name;
        $new->save();
        return redirect('setting/backup')->withSuccess('สำรองฐานข้อมูลเรียบร้อย');
    }

    public function Edit(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $dropbox = Dropboxinfo::get()->first();
        return view('setting.backup.dropbox')->withDropbox($dropbox);
    }

    public function EditSave(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        Dropboxinfo::where('dropboxinfo_id',1)
                ->update([ 
                    'gmailuser' =>  Request::input('gmailuser'), 
                    'gmailpass' =>  Request::input('gmailpass'), 
                    'dropboxuser' =>  Request::input('dropboxuser'), 
                    'dropboxpass' =>  Request::input('dropboxpass'), 
                    'dropboxurl' =>  Request::input('dropboxurl'), 
                    'dropboxappkey' =>  Request::input('dropboxappkey'), 
                    'dropboxsecretkey' =>  Request::input('dropboxsecretkey'), 
                    'dropboxtoken' =>  Request::input('dropboxtoken'), 
                ]);
                
        return redirect('setting/backup/edit')->withSuccess('แก้ไขข้อมูล Dropbox สำเร็จ');
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
