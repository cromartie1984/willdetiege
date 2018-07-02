<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Post;
use App\Tag;
use Cookie;

class BlogController extends Controller{
	public function getIndex($type = null, $slug = null, $month = null){
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

    	$tags = Tag::orderBy('created_at', 'desc')->get();
    	
    	$posts_raw = Post::leftJoin('categories', 'posts.category_id', '=', 'categories.id')->leftJoin('users', 'posts.user_id', '=', 'users.id')->orderBy('created_at', 'desc')->select('posts.*', 'categories.name_fr', 'categories.name_eng', 'users.first_name', 'users.last_name');

        if(!Auth::user()) $posts_raw->where('visibility', true);

        $posts_sidebar = $posts_raw->get();

    	$filter = null;

    	if($type == 'author'){
    		$posts_raw->where('users.last_name', $slug);
    		$filter = $language === 'fr' ? 'Auteur ' . $slug : 'Author ' . $slug;
    	} else if($type == 'category'){
    		$category_search = $language === 'fr' ? 'categories.name_fr' : 'categories.name_eng';
    		$filter = $language === 'fr' ? 'Catégorie ' . str_replace("-", " ", $slug) : 'Category ' . str_replace("-", " ", $slug);
    		$posts_raw->where($category_search, str_replace("-", " ", $slug));
    	} else if($type == 'tag'){
            $tag_search = $language === 'fr' ? 'tags.name' : 'tags.name_eng';
    		$posts_raw->leftJoin('post_tag', 'posts.id', '=', 'post_tag.post_id')->leftJoin('tags', 'post_tag.tag_id', '=', 'tags.id')->where($tag_search,'=', str_replace("-", " ", $slug));
    		$filter = $language === 'fr' ? 'Mot clé - ' . str_replace("-", " ", $slug) : 'Tag - ' . str_replace("-", " ", $slug);
    	} else if($type == 'archive'){
    		$posts_raw->whereMonth('posts.created_at','=', $month)->whereYear('posts.created_at','=', $slug);
    		$filter = strftime('%B %Y',strtotime($slug . '-'. $month . '-01'));
    	}
		
		$posts = $posts_raw->paginate(5);

        if(!$posts) abort(404);

		return view('blog.index')->withPosts($posts)->with('posts_sidebar', $posts_sidebar)->withTags($tags)->withLanguage($language)->with('filter', $filter);
	}

	public function getAuthorPosts($slug){
		return $this->getIndex('author', $slug);
	}

	public function getCategoryPosts($slug){
		return $this->getIndex('category', $slug);
	}

	public function getTagPosts($slug){
		return $this->getIndex('tag', $slug);
	}

	public function getArchivePosts($year, $month = null){
		
		return $this->getIndex('archive',$year, $month);
	}

    public function getSingle($slug){
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
		// fetch from the DB based on slug
    	$post = Post::leftJoin('categories', 'posts.category_id', '=', 'categories.id')->leftJoin('users', 'posts.user_id', '=', 'users.id')->where('slug','=', $slug)->select('posts.*', 'categories.name_fr', 'categories.name_eng', 'users.first_name', 'users.last_name', 'users.email', 'users.description', 'users.description_eng', 'users.avatar', 'users.website', 'users.google', 'users.linkedin', 'users.facebook', 'users.twitter','users.show_email')->first();
        if(!$post) abort(404);
    	$next_post = Post::where('id', '>', $post->id)->where('visibility', true)->orderBy('id','asc')->select('slug', 'thumbnail', 'title', 'title_eng')->first();
        $previous_post = Post::where('id', '<', $post->id)->where('visibility', true)->orderBy('id','desc')->select('slug', 'thumbnail', 'title', 'title_eng')->first();
        $similar_posts = Post::where('posts.id','!=', $post->id)->where('posts.visibility', true)->where('posts.category_id', '=', $post->category_id)->get();

		// return the view and pass in the post object
		return view('blog.single')->withPost($post)->with('previous_post',$previous_post)->with('next_post', $next_post)->with('similar_posts',$similar_posts)->withLanguage($language);
    }
}