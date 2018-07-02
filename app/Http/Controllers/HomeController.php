<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Project;
use App\Timeline;
use App\Contact;
use Cookie;
use Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
    	$language = 'fr';

    	if ($request->hasCookie('app-language')) {
    		$language = Cookie::get('app-language');
    		if ($language !== 'fr'){
    			setlocale(LC_TIME, 'en_US.UTF8');
    		}else{
    			setlocale(LC_TIME, 'fr_FR.UTF8');
    		}
    	}else{
    		setlocale(LC_TIME, 'fr_FR.UTF8');
    	}

        $attributes = [
        'data-theme' => 'light',
        'data-type' => 'audio',
        ];
    	$posts = Post::leftJoin('categories', 'posts.category_id', '=', 'categories.id')->where('visibility', true)->orderBy('created_at', 'desc')->limit(6)->select('posts.*', 'categories.name_fr', 'categories.name_eng')->get();
    	$projects = Project::orderBy('id', 'asc')->get();
		$timelines = Timeline::orderBy('id', 'asc')->get();
        return view('pages.home')->withLanguage($language)->withPosts($posts)->withProjects($projects)->withTimelines($timelines)->withAttributes($attributes);
    }

    public function Contact(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|string|email|not_throw_away|max:200',
            'g-recaptcha-response' => 'required|captcha'
        ],[
            'g-recaptcha-response.required' => Cookie::get('app-language') !== false ? 'Veuillez cocher le reCaptcha.' : '
Please check the reCaptcha'
        ]
        );
        
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }

        $settings = (object)[];

        $name = $request->name;
        $email = $request->email;
        $message = $request->message;

        $settings->name = $name;
        $settings->email = $email;
        $settings->message = $message;

        $contact = new Contact;
        $contact->settings = json_encode($settings);

        $contact->save();

        $data = array(
            'email' => $email,
            'subject' => 'Nouveau_contact via willdetiege.com :' . $name,
            'bodyMessage' => $message
        );

        Mail::send('emails.contact', $data, function($message) use ($data){
            $message->from($data['email']);
            $message->to('guillaumedetiege@gmail.com');
            $message->subject('subject');
        });

       /* $email_client_title = 'Votre demande de contact';
        $email_client_text = 'Bonjour ' . $identification_prospect . ', 
        Vous r&eacute;pondre dans les plus brefs d&eacute;lais fait partie de mes priorit&eacute;s.
        Je vous dis &agrave; tr&egrave;s bient&ocirc;t,
        Bien &agrave; vous,
        Clarisse.';
        $email_client_html = 'Bonjour ' . $identification_prospect . ',<br/><br/> 
        Vous r&eacute;pondre dans les plus brefs d&eacute;lais fait partie de mes priorit&eacute;s.<br/>
        Je vous dis &agrave; tr&egrave;s bient&ocirc;t,<br/><br/>
        Bien &agrave; vous,<br/><br/>
        Clarisse.';*/

        return response()->json([
            'title' => 'Contact',
            'message' => 'Votre message a bien été envoyé'
        ]);
    }
}