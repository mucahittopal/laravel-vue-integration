<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::withTrashed()->get();

        return view('admin.category.index', [
            'categories' => $categories
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return redirect()->route('category.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:45|unique:categories,name'
        ]);

        $request['slug'] = Str::slug($request->name);
        $create = Category::create($request->all());

        if($create){
            $request->session()->flash('success', 'Category was created successfully');
        }else{
            $request->session()->flash('error', 'Category was not able to be created');
            return back()->withInput();
        }

        return redirect()->back();
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
        $category = Category::withTrashed()->findOrFail($id);
        return view('admin.category.edit', [
            'category' => $category
        ]);
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
        $category = Category::withTrashed()->findOrFail($id);
        $request->validate([
            'name' => $category->name != $request->name
                ? 'required|string|max:45|unique:categories,name' : 'required'
        ]);

        if($category->name != $request->name)
        {
            $slug = Str::slug($request->name);
            $request['slug'] = $slug;
            $update = $category->update($request->all());
            if($update)
                session()->flash('success', 'Category was updated!');
            else
                session()->flash('error', 'Category was not updated!');
        }

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $delete = $category->delete();
        if($delete){
            session()->flash('success', 'Category was deleted!');
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $restore = $category->restore();
        if($restore){
            session()->flash('success', 'Category was restored!');
        }
        return back();
    }
}
