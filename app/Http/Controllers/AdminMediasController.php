<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminMediasController extends Controller
{

    public function index()
    {
        //
        $photos = Photo::all();
        return view('admin.medias.index', compact('photos'));
    }


    public function create()
    {
        //
        return view('admin.medias.create');
    }


    public function store(Request $request)
    {
        //
        $file = $request->file('file');
        $name = time(). $file->getClientOriginalName();
        $file->move('images', $name);
        Photo::create(['file'=>$name]);
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
    }


    public function destroy($id)
    {
        //
        $photo = Photo::findOrFail($id);
        unlink(public_path(). $photo->file);
        $photo->delete();

        return redirect('/admin/medias');
    }
}
