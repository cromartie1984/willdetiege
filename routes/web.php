<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Authentification Routes*/
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 
 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Categories
Route::resource('categories','CategoryController',['except' => ['create']]);
Route::resource('tags','TagController',['except' => ['create']]);

//Comments
Route::post('comments/{post_id}',['uses' =>'CommentsController@store','as' =>'comments.store']);
Route::get('comments/{id}/edit',['uses' =>'CommentsController@edit','as' =>'comments.edit']);
Route::put('comments/{id}',['uses' =>'CommentsController@update','as' =>'comments.update']);
Route::delete('comments/{id}',['uses' =>'CommentsController@destroy','as' =>'comments.destroy']);
Route::get('comments/{id}/delete',['uses' =>'CommentsController@delete','as' =>'comments.delete']);

Route::get('blog/{slug}',['as'=>'blog.single', 'uses' => 'BlogController@getSingle'])->where('slug','[\w\d\-\_]+');
Route::get('blog', 'BlogController@getIndex')->name('blog.index');
Route::get('blog/category/{slug}', 'BlogController@getCategoryPosts')->name('blog.category')->where('slug','[\w\d\-\_]+');
Route::get('blog/author/{slug}', 'BlogController@getAuthorPosts')->name('blog.author')->where('slug','[\w\d\-\_]+');
Route::get('blog/tag/{slug}', 'BlogController@getTagPosts')->name('blog.tag')->where('slug','[\w\d\-\_]+');
Route::get('blog/{year}/{month}', 'BlogController@getArchivePosts')->name('blog.archive')->where(['year' => '\d{4}', 'month' => '\d{2}']);

Route::get('projects', 'PagesController@getProjects')->name('projects.index');
Route::get('projects/{slug}', 'PagesController@getProject')->name('projects.single')->where('slug','[\w\d\-\_]+');

Route::get('/', 'HomeController@index');

Route::resource('/posts', 'PostController');

Route::group(['middleware' => 'auth'], function () {
	Route::get('admin', 'AdminController@getIndex')->name('admin');
	Route::get('admin/posts', 'AdminController@getPosts')->name('admin.posts');
	Route::get('admin/posts/list', 'AdminController@getPostsList')->name('admin.posts.list');
	Route::get('admin/contacts', 'AdminController@getContacts')->name('admin.contacts');
	Route::get('admin/contacts/list', 'AdminController@getContactsList')->name('admin.contacts.list');
	Route::get('admin/timelines', 'AdminController@getTimelines')->name('admin.timelines');
	Route::get('admin/timelines/list', 'AdminController@getTimelinesList')->name('admin.timelines.list');
	Route::get('admin/categories', 'AdminController@getCategories')->name('admin.categories');
	Route::post('admin/categories', 'AdminController@saveCategory')->name('admin.categories.save');
	Route::delete('admin/categories', 'AdminController@deleteCategory')->name('admin.categories.delete');
	Route::get('admin/categories/list', 'AdminController@getCategoriesList')->name('admin.categories.list');
	Route::get('admin/tags', 'AdminController@getTags')->name('admin.tags');
	Route::get('admin/tags/list', 'AdminController@getTagsList')->name('admin.tags.list');
	Route::get('admin/account', 'AdminController@getAccount')->name('admin.account');
	Route::post('admin/account', 'AdminController@saveAccount')->name('admin.account.save');
	Route::get('admin/users', 'AdminController@getUsers')->name('admin.users');
	Route::get('admin/users/list', 'AdminController@getUsersList')->name('admin.users.list');
});