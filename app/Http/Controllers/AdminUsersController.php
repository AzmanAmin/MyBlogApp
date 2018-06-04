<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersEditRequest;
use App\Http\Requests\UsersRequest;
use App\Photo;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{

    public function index()
    {
        //
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }


    public function create()
    {
        //
        $roles = Role::lists('name', 'id')->all();
        return view('admin.users.create', compact('roles'));
    }


    public function store(UsersRequest $request)
    {
        //
        if (trim($request->password) == '') {
            $input = $request->except('password');
        } else {
            $input = $request->all();
        }

        if ($file = $request->file('photo_id')) {

            $name = time(). $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
        }
        $input['password'] = bcrypt($request->password);

        User::create($input);

        Session::flash('user_created', 'A User has been Created');

        return redirect('/admin/users');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
        $user = User::findOrFail($id);
        $roles = Role::lists('name', 'id')->all();
        return view('admin.users.edit', compact('user', 'roles'));
    }


    public function update(UsersEditRequest $request, $id)
    {
        //
        $user = User::findOrFail($id);

        if (trim($request->password) == '') {
            $input = $request->except('password');
        } else {
            $input = $request->all();
        }

        if ($file = $request->file('photo_id')) {

            $name = time() .$file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
        }
        $input['password'] = bcrypt($request->password);

        $user->update($input);

        Session::flash('updated_user', 'The User has been Updated..!!');

        return redirect('/admin/users');
    }


    public function destroy($id)
    {
        //
        $user = User::findOrFail($id);
        unlink(public_path(). $user->photo->file);
        $user->delete();

        Session::flash('deleted_user', 'The User has been Deleted..!!');

        return redirect('/admin/users');
    }
}
