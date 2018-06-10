<?php

namespace App\Http\Controllers;
use App\Post;
use App\Contact;
use App\Timeline;
use App\Category;
use App\Tag;
use App\User;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class AdminController extends Controller{
    /*------------------Views---*/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(){
      $pagetitle = 'Dashboard';
      return view('pages.admin')->withPagetitle($pagetitle);
    } 

    public function getPosts(){
      $pagetitle = 'Blog - Posts';
        return view('posts.show')->withPagetitle($pagetitle);
    } 

    public function getContacts(){
      $pagetitle = 'Contacts';
      return view('contact.index')->withPagetitle($pagetitle);
    } 

    public function getTimelines(){
      $pagetitle = 'Timeline';
      return view('timeline.show')->withPagetitle($pagetitle);
    }

    public function getCategories(){
      $pagetitle = 'Categories';
      return view('categories.index')->withPagetitle($pagetitle);
    }  

    public function getTags(){
      $pagetitle = 'Tags';
      return view('tags.show')->withPagetitle($pagetitle);
    }

    public function getAccount(){
      $pagetitle = 'Account';
      $user = User::find(Auth::user()->id);
      return view('users.index')->withUser($user)->withPagetitle($pagetitle);
    }

    public function getUsers(){
      $pagetitle = 'Users';
      return view('users.show')->withPagetitle($pagetitle);
    }

    public function getPostsList(Datatables $datatables){

        $query = Post::leftJoin('categories', 'posts.category_id', '=', 'categories.id')->leftJoin('users', 'posts.user_id', '=', 'users.id')->orderBy('created_at', 'desc')->select('posts.*', 'categories.name_fr', 'categories.name_eng', 'users.first_name', 'users.last_name');

        if(!Auth::user()) $query->where('visibility', true);

        return $datatables->eloquent($query)
                          ->addColumn('DT_RowId', function ($post) {
                            return 'contact-'. $post->id;
                          })
                          ->addColumn('identification', function ($post) {
                          		$tags_content = '';
                          		foreach($post->tags as $tag){
                                    $tags_content .=  '<li class="list-inline-item">
                                    	<span class="badge badge-primary">'.$tag->name.'</span>
                                    </li>';
                                }

                                return '<div class="container-fluid "><div class="row">
                                <div class="col-lg-2 col-xs-12">
                                	<div class="view overlay hm-white-slight">
                                		<img width="125" src="' . $post["thumbnail"] . '" class="img-fluid"/>
                                		<a>
                                			<div class="mask waves-effect waves-light"></div>
                                		</a>
                                	</div>
                                </div>
                                <div class="col-xs-12 col-lg-9">
                                	<div class="row">
                                		<div class="col-xs-12 col-lg-9 text-success"><h4><strong>' . $post["title"] . '</strong></h4></div>
                                		<div class="col-xs-12 col-lg-2"><strong class="pull-right">' . date("d/m/Y", strtotime($post["created_at"])) . '</strong></div>
                                	</div>
                                	<div class="row">
                                		<div class="col-xs-12">' . ($post["excerpt"] ? $post["excerpt"] : substr(strip_tags($post["body"]), 0, 150) . (strlen(strip_tags($post["body"])) > 150 ? "..." : "")) . '</div>
                                	</div>
                                	<div class="row">
                                		<div class="col-xs-12"><em>' . $post["name_fr"] . '</em></div>
                                	</div>
                                	<div class="row">
                                		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                			<ul>'.$tags_content.'</ul>
                                		</div>
                                	</div>
                                </div>
                            </div></div>';

                          })
                          ->editColumn('reply', function ($post) {
                              return $post->reply ? $post->reply . 'r' : '';
                          })
                          ->editColumn('author_id', function ($post) {
                              return $post["first_name"] . ' ' . $post["last_name"];
                          })
                          ->editColumn('category', function ($post) {
                              return $post["name_fr"];
                          })
                          ->editColumn('tags', function ($post) {
                              return 'tag';
                          })
                          ->editColumn('cover_image', function ($post) {
                              return $post["thumbnail"];
                          })
                          ->editColumn('excerpt', function ($post) {
                              return $post["excerpt"] ? $post["excerpt"] : substr(strip_tags($post["body"]), 0, 150) . (strlen(strip_tags($post["body"])) > 150 ? "..." : "");
                          })
                          ->editColumn('actions', function ($post) {
                          	return '<a type="button" data-toggle="tooltip" data-placement="left" title="View Post" class="btn btn-info btn-simple btn-icon" href="/blog/' . $post["slug"] . '" target="_blank">
                          	<i class="fa fa-image"></i>
                          </a>
                          <button type="button" data-toggle="tooltip"  data-placement="left" title="Edit Post" class="btn btn-success btn-simple btn-icon action_article" data-type-action="edit">
                          	<i class="fa fa-edit"></i>
                          </button>
                          <button type="button" data-toggle="tooltip" data-placement="left" title="Remove Post" class="btn btn-danger btn-simple btn-icon action_article" data-type-action="delete">
                          	<i class="fa fa-times"></i>
                          </button>';
                          })
                          ->rawColumns(['identification', 'actions'])
                          ->make(true);
    }

     public function getContactsList(Datatables $datatables){

        $query = Contact::orderBy('created_at','desc');

        return $datatables->eloquent($query)
                          ->addColumn('DT_RowId', function ($contact) {
                            return 'contact-'. $contact->id;
                          })
                          ->addColumn('identification', function ($contact) {

                          	return '<h3>Nom : <strong>' . $contact["last_name"] . '</strong></h3>
                          	<p>Email : <strong>' . $contact["email"] . '</strong></p>';

                          })
                          ->editColumn('name', function ($contact) {
                              return $contact["last_name"];
                          })
                          ->editColumn('actions', function ($contact) {
                          	return '<a type="button" data-toggle="tooltip" data-placement="left" title="History" class="btn btn-info btn-simple btn-icon action_contact" data-type-action="info">
                          	<i class="fa fa-info-circle"></i>
                          </a>
                          <button type="button" data-toggle="tooltip"  data-placement="left" title="Edit Contact" class="btn btn-success btn-simple btn-icon action_contact" data-type-action="edit">
                          	<i class="fa fa-edit"></i>
                          </button>
                          <button type="button" data-toggle="tooltip" data-placement="left" title="Remove Contact" class="btn btn-danger btn-simple btn-icon action_contact" data-type-action="delete">
                          	<i class="fa fa-times"></i>
                          </button>';
                          })
                          ->rawColumns(['identification', 'actions'])
                          ->make(true);
    }

    public function getTimelinesList(Datatables $datatables){

        $query = Timeline::orderBy('created_at','desc');

        return $datatables->eloquent($query)
                          ->addColumn('DT_RowId', function ($timeline) {
                            return 'timeline-'. $timeline->id;
                          })
                          ->addColumn('identification', function ($timeline) {

                          	return '<h3><strong>' . $timeline["title"] . '</strong></h3>
                          	<p><i>'.substr(strip_tags($timeline["content"]), 0, 250) . (strlen(strip_tags($timeline["content"])) > 250 ? "..." : "") .'</i></p>';

                          })
                          ->editColumn('actions', function ($timeline) {
                          	return '<button type="button" data-toggle="tooltip"  data-placement="left" title="Edit Item" class="btn btn-success btn-simple btn-icon action_timeline" data-type-action="edit">
                          	<i class="fa fa-edit"></i>
                          </button><br/>
                          <button type="button" data-toggle="tooltip" data-placement="left" title="Remove Item" class="btn btn-danger btn-simple btn-icon action_timeline" data-type-action="delete">
                          	<i class="fa fa-times"></i>
                          </button>';
                          })
                          ->rawColumns(['identification', 'actions'])
                          ->make(true);
    }

    public function getTagsList(Datatables $datatables){

        $query = Tag::orderBy('created_at','desc');

        return $datatables->eloquent($query)
                          ->addColumn('DT_RowId', function ($tag) {
                            return 'tag-'. $tag->id;
                          })
                          ->editColumn('actions', function ($tag) {
                            return '<button type="button" data-toggle="tooltip"  data-placement="left" title="Edit tag" class="btn btn-success btn-simple btn-icon action_tag" data-type-action="edit">
                            <i class="fa fa-edit"></i>
                          </button><br/>
                          <button type="button" data-toggle="tooltip" data-placement="left" title="Delete tag" class="btn btn-danger btn-simple btn-icon action_tag" data-type-action="delete">
                            <i class="fa fa-times"></i>
                          </button>';
                          })
                          ->rawColumns(['actions'])
                          ->make(true);
    }

    public function getCategoriesList(Datatables $datatables){

        $query = Category::query();

        return $datatables->eloquent($query)
                          ->addColumn('DT_RowId', function ($category) {
                            return 'category-'. $category->id;
                          })
                          ->editColumn('actions', function ($category) {
                            return '<button type="button" data-toggle="tooltip"  data-placement="left" title="Edit category" class="btn btn-success btn-simple btn-icon action_tag" data-type-action="edit">
                            <i class="fa fa-edit"></i>
                          </button><br/>
                          <button type="button" data-toggle="tooltip" data-placement="left" title="Delete category" class="btn btn-danger btn-simple btn-icon action_tag" data-type-action="delete">
                            <i class="fa fa-times"></i>
                          </button>';
                          })
                          ->filter(function ($query) {
                            if (request()->has('name_fr')) {
                              $query->where('name_fr', 'like', "%" . request('name_fr') . "%");
                            }
                          })
                          ->order(function ($query) {
                            if (request()->has('name_fr')) {
                              $query->orderBy('name_fr', 'asc');
                            }

                            if (request()->has('created_at')) {
                              $query->orderBy('created_at', 'asc');
                            }
                          })
                          ->rawColumns(['actions'])
                          ->make(true);
    }

    public function getUsersList(Datatables $datatables){

        $query = User::orderBy('created_at','desc');

        return $datatables->eloquent($query)
                          ->addColumn('DT_RowId', function ($user) {
                            return 'user-'. $user->id;
                          })
                          ->addColumn('identification', function ($user) {

                            return '<div class="container-fluid"><div class="row">
                            <div class="col-lg-2 col-xs-12">
                             <div class="view overlay hm-white-slight">
                              <img width="125" src="' . ($user["avatar"] ? '/blog_ressources/avatar/' . $user["avatar"] : '/img/default_avatar_male.jpg') . '" class="img-fluid"/>
                              <a>
                               <div class="mask waves-effect waves-light"></div>
                             </a>
                           </div>
                         </div>
                         <div class="col-xs-12 col-lg-9">
                           <h4 class="text-success"><strong>' . ucfirst($user["first_name"]) . ' ' . strtoupper($user["last_name"]) . '</strong></h4>
                           <p><strong>' . $user["email"] . '</strong></p>
                           ' . ($user["description"] ? '<p>'. $user["description"] . '</p>' : '') . '
                           ' . ($user["website"] ? '<p><a href="' . $user["website"]. '" target="_blank">'. $user["website"] . '</a></p>' : '') . '
                           ' . ($user["linkedin"] ? '<a class="btn btn-just-icon btn-linkedin" href="' . $user["linkedin"] . '" target="_blank" type="button"><i class="fa fa-linkedin" aria-hidden="true"></i></a>' : '') . '
                           ' . ($user["facebook"] ? '<a class="btn btn-just-icon btn-facebook" href="' . $user["facebook"] . '" target="_blank" type="button"><i class="fa fa-facebook" aria-hidden="true"></i></a>' : '') . '
                           ' . ($user["twitter"] ? '<a class="btn btn-just-icon btn-twitter" href="' . $user["twitter"] . '" target="_blank" type="button"><i class="fa fa-twitter" aria-hidden="true"></i></a>' : '') . '
                           ' . ($user["google"] ? '<a class="btn btn-just-icon btn-google" href="' . $user["google"] . '" target="_blank" type="button"><i class="fa fa-google-plus" aria-hidden="true"></i></a>' : '') . '
                         </div>
                       </div></div>';

                          })
                          ->editColumn('actions', function ($user) {
                            return '<button type="button" class="btn btn-info action_author" data-type-action="edit">
                            <i class="fa fa-edit fa-4x" aria-hidden="true"></i>
                          </button><button type="button" class="btn btn-danger action_author" data-type-action="delete">
                          <i class="fa fa-trash fa-4x" aria-hidden="true"></i>
                        </button>';
                          })
                          ->rawColumns(['identification','actions'])
                          ->make(true);
    }

    public function saveCategory(Request $request){
      $name = $request->name;
      $category_id = null;

      if($request->id != ''){
        $category_id = $request->id;
        $categories = Category::find($category_id);
        $date = date("Y-m-d H:i:s", strtotime($categories->created_at));
        $toast_message = 'The category <strong>' . $name . '</strong> has been successfully updated.';  
      }else{
        $categories = new Category;
        $date = date("Y-m-d H:i:s");
        $toast_message = 'The new category <strong>' . $name . '</strong> has been successfully created.';
      }

      $categories->name = $name;

      $categories->save();

      $category_id = $categories->id;

      return response()->json([
        'id' => 'category-' . $category_id,
        'name' => $name,
        'created_at' => $date,
        'actions' => '<div class="display-type float-left text-center item_action" data-table="#categories-list" data-toggle="modal" data-type-action="edit" data-backdrop="static" data-target="#category-dialog" data-content="Edit category">
        <i class="fa fa-edit" aria-hidden="true"></i>
      </div>
      <div class="display-type float-left text-center item_action" data-table="#categories-list" data-type-action="delete" data-toggle="modal" data-backdrop="static" data-target="#delete-dialog" data-type="the category <strong>' . $name . '</strong>" data-message="The category <strong>' . $name . '</strong> has been successfully removed." data-delete-item="/category">
        <div class="delete-icon"></div>
      </div>',
      'title' => 'Blog Posts - Category',             
      'message' => $toast_message
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCategory(Request $request){
        $categories = Category::find($request->id);

        $category_name = $categories->name;

        $categories->delete();

        return response()->json([
            'title' => 'Blog Posts - Category',
            'message' => $request->message
        ]);
    }


}