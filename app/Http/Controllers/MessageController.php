<?php namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;
use URL;

use App\Model\Message;
use App\Model\System;
use App\Model\Users;
use App\Model\LogFile;

class MessageController extends Controller{

    public function CreateSave($system , $title , $content , $key){
        $user = array();
        if( $system == 1 ){
            $user = Users::where('permission' , 1)->get();
        }

        if( count($user) > 0 ){
            foreach( $user as $item ){
                $new = new Message;
                $new->system_id = $system;
                $new->message_key = $key;
                $new->message_title = $title;
                $new->message_content = $content;
                $new->message_date = date('Y-m-d H:i:s');
                $new->message_read = 0;
                $new->user_id = $item->user_id;
                $new->save();
            }
        } 
    }

    public function ReadMessage($id){

        $auth = Auth::user();

        //return Request::path();

        // MessageController::where('message_id',$id)
        // ->update([ 
        //     'message_read' => 1, 
        // ]);

$mssage = MessageController::all();
return $mssage;

       // return redirect();
    }

}


