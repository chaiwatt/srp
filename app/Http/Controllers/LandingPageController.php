<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use Jenssegers\Agent\Agent;
use App\Model\SettingLandingpicture;
use App\Model\Information;
use App\Model\Youtube;
use App\Model\DocDownload;


class LandingPageController extends Controller
{
    public function Index(){
        $auth = Auth::user();
        $picture = SettingLandingpicture::get();
        $information = Information::take(3)->orderBy('information_id', 'desc')->get();
        $new = Information::orderBy('information_id', 'desc')->paginate(3);
        $docdownload = DocDownload::orderBy('docdownload_id', 'desc')->paginate(5);
        $youtube = Youtube::first();
        $agent = new Agent();

        return view('landing.index')->withPicture($picture)
                                    ->withInformation($information)
                                    ->withNew($new)
                                    ->withDocdownload($docdownload)
                                    ->withYoutube($youtube)
                                    ->withAgent($agent)
                                    ->withAuth($auth);
    }
}
