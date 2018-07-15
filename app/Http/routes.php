<?php

use App\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\User;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');


//Single Post
Route::get('/post/{id}', ['as'=>'home.post', 'uses'=>'AdminPostsController@post']);


Route::get('/admin', function () {

    return view('admin.index');

});

Route::group(['middleware'=>'admin'], function () {

    Route::resource('admin/users', 'AdminUsersController');
    Route::resource('admin/posts', 'AdminPostsController');
    Route::resource('admin/categories', 'AdminCategoriesController');
    Route::resource('admin/medias', 'AdminMediasController');
    Route::resource('admin/comments', 'PostCommentsController');
    Route::resource('admin/comment/replies', 'CommentRepliesController');

});


Route::group(['middleware'=>'auth'], function () {

    Route::post('comment/reply', 'CommentRepliesController@createReply');
//    Route::post('comment/likes', 'LikesController@store');
    Route::resource('comment/likes', 'LikesController');
//    Route::post('comment/likes/edit', 'LikesController@update');
});


Route::get('markasread', function() {
    Auth::user()->notifications->markAsRead();
    return redirect()->back();
})->name('markAsRead');


Route::get('notifications', function() {
    $myNotification = Auth::user()->notifications->all();
    // $myNotification = 'baal;
    return view('notifications', compact('myNotification'));
})->name('allNotifications');











