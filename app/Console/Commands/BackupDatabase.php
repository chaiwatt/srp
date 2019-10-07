<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Request;
use Log;
use Storage;
use Artisan;
use Auth;

use App\Model\Backuphistory;
use App\Model\Dropboxinfo;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:backupdatabase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $auth = Auth::user();
        Artisan::call('backup:run',['--only-db'=>true]);
        $output = Artisan::output();
        $new = new Backuphistory;
        $new->backupby = "สำรองอัตโนมัติ";
        $new->save();
        
    }
}
