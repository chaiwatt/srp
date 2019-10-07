<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;

use App\Model\SettingLandingpicture;
use App\Model\DocDownload;
use App\Model\Youtube;
use App\Model\LogFile;

class SettingLandingpictureController extends Controller
{
    public function Index(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }

        $picture = SettingLandingpicture::get();
        $docdownload = DocDownload::paginate(10);
        $youtube = Youtube::first();

        return view('setting.landing.edit')->withPicture($picture)
                                        ->withYoutube($youtube)
                                        ->withDocdownload($docdownload);
    }

    public function Edit(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $extension = array('jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'GIF' , 'gif' , 'PNG' , 'png');
        if(Request::file('picture')){   
            $files = request::file('picture');
            foreach($files as $file){
                if( $file != null ){
                    if( in_array($file->getClientOriginalExtension(), $extension) ){
                        $new_name = str_random(10).".".$file->getClientOriginalExtension();
                        $file->move('storage/uploads/landing' , $new_name);
                        $new = new SettingLandingpicture;
                        $new->landingpicture = "storage/uploads/landing/".$new_name;
                        $new->save();
                    }
                }
            }
        }
        
        $youtube = Youtube::first();
        if(count($youtube) != 0){
            if(Request::input('youtube') != ""){
                Youtube::where('youtube_id',Request::input('youtube_id'))
                ->update([ 
                   'youtube_url' => preg_replace('/\s/', '', Request::input('youtube') ) , 
                   ]);
            }else{
                Youtube::where('youtube_id',Request::input('youtube_id'))
                ->delete();
            }
        }else{
            $new = new Youtube;
            $new->youtube_url = Request::input('youtube');
            $new->save();
        }

        $new = new LogFile;
        $new->loglist_id = 65;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('setting/landing')->withSuccess("แก้ไขเรียบร้อย");
    }

    public function DeletePicture($id){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
 
        $auth = Auth::user();
        $docdownload = DocDownload::paginate(10);
        $youtube = Youtube::first();

        SettingLandingpicture::where('setting_landingpicture_id' , $id )->delete();
        $picture = SettingLandingpicture::get();

        $new = new LogFile;
        $new->loglist_id = 64;
        $new->user_id = $auth->user_id;
        $new->save();

        return view('setting.landing.edit')->withPicture($picture)
                ->withYoutube($youtube)
                ->withDocdownload($docdownload);
    }  

    public function Create(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        return view('setting.landing.create');
    }

    public function CreateSave(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $new = new DocDownload;
        $new->docdownload_desc = Request::input('desc');

        if(Request::hasFile('file')){
            $file = Request::file('file');
            $new_name = str_random(10).".".$file->getClientOriginalExtension();
            // $file->move('storage/uploads/download' , $new_name);

            if (!$file->move('storage/uploads/download' , $new_name)) {
                return 'Error saving the file.';
            }

            $new->docdownload_link = "storage/uploads/download/".$new_name;
        }
        $new->save();

        $new = new LogFile;
        $new->loglist_id = 62;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect('setting/landing')->withSuccess("เพิ่มเอกสารเรียบร้อยแล้ว");
    }

    public function DeleteDoc($id){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $document = DocDownload::where('docdownload_id' , $id)->first();


        if( count($document) == 0 ){
            return redirect()->back();
        }

        @unlink( $document->docdownload_link );

        DocDownload::where('docdownload_id' , $id)->delete();

        $new = new LogFile;
        $new->loglist_id = 63;
        $new->user_id = $auth->user_id;
        $new->save();

        return redirect()->back()->withSuccess("ลบเอกสารเรียบร้อยแล้ว");
    }

    public function EditDoc($id){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $document = DocDownload::where('docdownload_id' , $id)->first();

        return view('setting.landing.editdoc')->withDocument($document);
    }

    public function EditDocSave(){
        if( $this->authsuperadmint() ){
            return redirect('logout');
        }
        $auth = Auth::user();
        $id = Request::input('id');
 
        $document = DocDownload::where('docdownload_id' , $id)->first();

        DocDownload::where('docdownload_id' , $id)
        ->update([ 
            'docdownload_desc' =>  Request::input('desc'), 
            ]);

        return redirect('setting/landing')->withSuccess("แก้ไขชื่อเรียบร้อยแล้ว");
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
