<?php

namespace App\Http\Controllers;

use App\PostLike;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{

    public function index()
    {
        //
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
            'photo' => $user->photo->file,
            'owner' => $user->name,
            'like' => 1

        ];
        PostLike::create($data);

        return redirect()->back();
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
        PostLike::findOrFail($id)->update($request->all());
        return redirect()->back();
    }


    public function destroy($id)
    {
        //
    }
}
