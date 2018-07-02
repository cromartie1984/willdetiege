<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Post;
use App\Http\Requests;
use Mail;
use Session;
use App\Project;
use Cookie;

class PagesController extends Controller {

	public function getProjects(){
		$language = '';
    	if (Cookie::get('app-language') !== false) {
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
		$projects = Project::orderBy('id', 'asc')->get();
		return view('projects.index')->withProjects($projects)->withLanguage($language);
	}

	public function getProject($slug){
		$language = '';
    	if (Cookie::get('app-language') !== false) {
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
		$project = Project::where('url', $slug)->get()->first();
		return view('projects.single')->withProject($project)->withLanguage($language);
	}

}