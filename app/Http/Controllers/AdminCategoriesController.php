<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminCategoriesController extends Controller
{

    public function index()
    {
        //
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
        $categories = $request->all();
        Category::create($categories);

        return redirect('/admin/categories');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }


    public function update(Request $request, $id)
    {
        //
        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect('/admin/categories');
    }


    public function destroy($id)
    {
        //
        $category = Category::findOrFail($id);
        $category->delete($category);

        return redirect('/admin/categories');
    }
}
