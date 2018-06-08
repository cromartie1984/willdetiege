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

	public function getIndex(){
		# process variable data or params
		# talk to the model
		# receive from the model
		# compile or process data from the model if needed
		# pass that data to the correct view
		# return "Home";
		$posts = Post::orderBy('created_at', 'desc')->limit(4)->get();
		return view('pages.welcome')->withPosts($posts);
	}

	public function getAbout(){
		$first = 'Will';
		$last = 'Detiege';

		$fullname = $first . " " . $last;
		$email = 'me@willdetiege.com';
		$data = [];
		$data['email'] = $email;
		$data['fullname'] = $fullname;
		# return "About Me";
		# return view('about')->with("fullname",$fullname);
		# return view('pages.about')->withFullname($fullname)->withEmail($email);
		return view('pages.about')->withData($data);
	}

	public function getContact(){
		# return "Hello Contact Page";
		return view('pages.contact');
	}

	public function postContact(Request $request){
		$this->validate($request, [
			'email' => 'required|email',
			'subject'=> 'min:3',
			'message' => 'min:10']);

		$data = array(
			'email' => $request->email,
			'subject' => $request->subject,
			'bodyMessage' => $request->message
			);

		Mail::send('emails.contact', $data, function($message) use ($data){
			$message->from($data['email']);
			$message->to('me@willdetiege.com');
			$message->subject('subject');
		});

		$request->session()->flash('success','Your email was sent!!');

		return redirect('/');
	}

	public function getProjects(){
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
		$projects = Project::orderBy('id', 'asc')->get();
		return view('projects.index')->withProjects($projects)->withLanguage($language);
	}

	public function getProject($slug){
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
		$project = Project::where('url', $slug)->get()->first();
		return view('projects.single')->withProject($project)->withLanguage($language);
	}

}