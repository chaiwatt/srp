<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NotifyMessage extends Model
{
    protected $table = 'tb_notify_message';
    protected $primaryKey = 'notify_message_id';

	public function getMessagedateagoAttribute(){
		$timestamp = strtotime( $this->message_date );	
		$strTime = array("second", "minute", "hour", "day", "month", "year");
		$length = array("60","60","24","30","12","10");
		$currentTime = time();
		if($currentTime >= $timestamp) {
			$diff     = time()- $timestamp;
			for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
				$diff = $diff / $length[$i];
			}
			$diff = round($diff);
			return $diff . " " . $strTime[$i] . "(s) ago ";
		}
	}

	public function getSenddateAttribute(){
        return date('d/m/' , strtotime( $this->created_at ) ).(date('Y',strtotime($this->created_at))+543);
    }


}
