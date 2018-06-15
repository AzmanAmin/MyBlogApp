<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PostsCreateRequest;
use App\Photo;
use App\Post;
use App\PostLike;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AdminPostsController extends Controller
{

    public function index()
    {
        //
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }


    public function create()
    {
        //
        $categories = Category::lists('name', 'id')->all();
        return view('admin.posts.create', compact('categories'));
    }


    public function store(PostsCreateRequest $request)
    {
        //
        $input = $request->all();
        $user = Auth::user();

        if ($file = $request->file('photo_id')) {

            $name = time(). $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
        }
        $user->post()->create($input);

        return redirect('/admin/posts');
    }


    public function show($id)
    {
        //
        $post = Post::findOrFail($id);

        return view('admin.posts.show', compact('post'));
    }


    public function edit($id)
    {
        //
        if (Auth::check()) {

            if (Auth::user()->isAdmin()) {
//                return $next($request);

                $post = Post::findOrFail($id);
                $categories = Category::lists('name', 'id')->all();

                return view('admin.posts.edit', compact('post', 'categories'));
            } else {
                return redirect('/admin/posts');
            }
        }
        return redirect('/login');
    }


    public function update(Request $request, $id)
    {
        //
        $input = $request->all();
        $user = Auth::user();

        if ($file = $request->file('photo_id')) {

            $name = time(). $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
        }
        $user->post()->where('id', $id)->first()->update($input);

        return redirect('/admin/posts');
    }


    public function destroy($id)
    {
        //
        $post = Post::findOrFail($id);
        unlink(public_path(). $post->photo->file);

        $post->delete();

        return redirect('/admin/posts');
    }


    public function post($id) {

        $post = Post::findOrFail($id);
        $comments = $post->comments()->whereIsActive(1)->get();

        $likes = $post->likes()->get();
        $postLikes = $post->likes()->where('like', 1)->get();

        $likeState = 0;

        if (Auth::check()) {
            $user = Auth::user();
            if (count($likes) > 0) {
                foreach ($likes as $like) {
                    if ($user->name == $like->owner) {
                        if ($like->like == 1)
                            $likeState = 1;
                        else
                            $likeState = 2;

                        $likeId = $like->id;
                    }
                }
            }
        }

        return view('post', compact('post', 'comments', 'likes', 'likeState', 'likeId', 'postLikes'));
    }
}
