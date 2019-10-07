<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\NotifyMessage;
use App\Model\LogFile;

class NotifyMessagesController extends Controller
{
    public function CreateSave($system , $title , $content , $key){
        $user = array();
        if( $system == 1 ){
            $user = Users::where('permission' , 1)->get();
        }

        if( count($user) > 0 ){
            foreach( $user as $item ){
                $new = new NotifyMessage;
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
        NotifyMessage::where('notify_message_id',$id)
        ->update([ 
            'message_read' => 1, 
        ]);
        return redirect()->back();
    }
}
