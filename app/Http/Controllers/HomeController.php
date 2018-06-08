<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Project;
use App\Timeline;
use Cookie;

class HomeController extends Controller{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
    	$language = '';
    	if (Cookie::get('app-language')) {
    		$language = Cookie::get('app-language');
    		if ($language !== 'fr'){
    			setlocale(LC_TIME, 'en_US.UTF8');
    		}else{
    			setlocale(LC_TIME, 'fr_FR.UTF8');
    		}
    	}else{
    		$language = 'fr';
    		setlocale(LC_TIME, 'fr_FR.UTF8');
    	}

    	$posts = Post::leftJoin('categories', 'posts.category_id', '=', 'categories.id')->where('visibility', true)->orderBy('created_at', 'desc')->limit(6)->select('posts.*', 'categories.name_fr', 'categories.name_eng')->get();
    	$projects = Project::orderBy('id', 'asc')->get();
		$timelines = Timeline::orderBy('id', 'asc')->get();
        return view('pages.home')->withPosts($posts)->withProjects($projects)->withTimelines($timelines)->withLanguage($language);
    }
}