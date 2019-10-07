<?php

namespace App\Http\Controllers;

use Request;
use Session;
use Auth;
use DB;

use App\Model\Information;
use App\Model\InformationPicture;

class SingleBlogController extends Controller
{
    public function Index($id){
        $blog = Information::where('information_id',$id)->orderBy('information_id', 'desc')->get();;
        $new = Information::take(10)->orderBy('information_id', 'desc')->get();
        $images = InformationPicture::where('information_id',$id)->get();
        $auth = Auth::user();
        
        return view('landing.blog.index')->withBlog($blog)
                                    ->withImages($images)
                                    ->withNew($new)
                                    ->withAuth($auth);
    }

    public function Search(){

        $update = Information::get()->take(10)->orderBy('information_id', 'desc')->get();;
        $new = Information::get()->take(5)->orderBy('information_id', 'desc')->get();
        $search = Request::input('search');
        $blogs = Information::where('information_title', 'LIKE', '%'.$search.'%')->paginate(10);
        return view('landing.blog.result')->withNew($new)
                        ->withUpdate($update)
                        ->withBlogs($blogs);
    }

    public function Blog(){
        $auth = Auth::user();
        $update = Information::take(10)->orderBy('information_id', 'desc')->get();
        $new = Information::take(5)->orderBy('information_id', 'desc')->get();
        return view('landing.blog.result')
                        ->withUpdate($update)
                        ->withAuth($auth)
                        ->withNew($new);
    }


}
