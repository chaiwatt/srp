<?php

namespace App\Http\Controllers;

use App\Model\VideoList;
use Illuminate\Http\Request;

class VideoListController extends Controller
{
    public  function Index(){
        $videolist = VideoList::paginate(10);
        return view('videolist.index')->withVideolist($videolist);
    }

    public function Play($id){
        $video = VideoList::where('video_id',$id)->first();
        return view('videolist.play')->withVideo($video);
    }
}
