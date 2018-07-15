<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Collection;

class PostCommentsController extends Controller
{

    public function index()
    {
        //
        $comments = Comment::all();
        return view('admin.comments.index', compact('comments'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
        $user = Auth::user();

        $data = [

            'post_id' => $request->post_id,
            'author' => $user->name,
            'email' => $user->email,
            'photo' => $user->photo->file,
//            'is_active' => $user->is_active,
            'body' => $request->body

        ];

        Comment::create($data);

        return redirect()->back();
    }


    public function show($id)
    {
        //
        $post = Post::findOrFail($id);
        $comments = $post->comments;

        return view('admin.comments.show', compact('comments'));
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
        $authUser = Auth::user()->name;

        $comment = Comment::findOrFail($id);
        $post = $comment->post;
        $user = $post->user;
        $letter = collect(['title'=>'Comment ya', 'body'=>$authUser.' commented on your post.', 'post_id'=>$post->id]);
        $user->notify(new DatabaseNotification($letter));

        Comment::findOrFail($id)->update($request->all());
        return redirect()->back();
    }


    public function destroy($id)
    {
        //
        Comment::findOrFail($id)->delete();
        return redirect()->back();
    }
}
