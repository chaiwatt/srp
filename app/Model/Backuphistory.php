<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Backuphistory extends Model
{
    protected $table = 'tb_backuphistory';
    protected $primaryKey = 'backuphistory_id';

    public function getBackupdateAttribute(){
        return date('d/m/' , strtotime( $this->created_at ) ).(date('Y',strtotime($this->created_at))+543);
    }
}
