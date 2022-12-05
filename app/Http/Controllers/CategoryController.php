<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('pages.category.categories', ["categories" => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('category-image') && $request->file('category-image')->isValid()) {
            $image_path = $request->file('category-image')->store('uploads/images/categories', 'public');
            $name = $request->input('name');
            $category = new Category();
            $category->name = $name;
            $category->image_path = '/storage/' . $image_path;
            $category->save();
            return redirect('categories')->with('succes', 'Category added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        if ($request->hasFile('category-image') && $request->file('category-image')->isValid()) {
            $image_path = $request->file('category-image')->store('uploads/images/categories', 'public');
            $category->image_path = '/storage/' . $image_path;
        } else {
            $category->image_path = $request->input('image_path');
        }
        $name = $request->input('name');
        $category->name = $name;
        $category->save();
        return redirect('categories')->with('succes', 'Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect('/categories')->with('succes', 'Category deleted!');
    }
}
