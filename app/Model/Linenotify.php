<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Request;
use Session;
use Auth;
use App\Model\Linenotify;
use App\Model\Linemessage;

class Linenotify extends Model
{
    protected $table = 'tb_linenotify';
    protected $primaryKey = 'linenotify_id';

    // public function getNotifymeAttribute(){
    public function scopeNotifyme($query,$message){
        $auth = Auth::user();

        $lineapi = $this->linetoken ;
        $mms =  $message ;// trim($message); // ข้อความที่ต้องการส่ง
        date_default_timezone_set("Asia/Bangkok");
        $chOne = curl_init(); 
        curl_setopt( $chOne, CURLOPT_URL, $this->url); 
        // SSL USE 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
        //POST 
        curl_setopt( $chOne, CURLOPT_POST, 1); 
        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$mms"); 
        curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1); 
        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$lineapi.'', ); 
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
        $result = curl_exec( $chOne ); 
        //Check error 
        if(curl_error($chOne)) 
            { 
            echo 'error:' . curl_error($chOne); 
        } 
        else { 
            $result_ = json_decode($result, true); 
            echo "status : ".$result_['status']; echo "message : ". $result_['message'];
            //return view('information.report.department.index')
        } 
        curl_close( $chOne );   
        return "kk";
    }
}
