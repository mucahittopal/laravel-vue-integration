<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $languages = Language::withTrashed()->orderBy('name', 'asc')->get();
        return view('admin.languages.index', [
            'languages' => $languages,
        ]);
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
        $request->validate([
            'code' => 'required|string|max:45|unique:languages,code',
            'name' => 'required|string|max:45|unique:languages,name',
        ]);
        $store = Language::create($request->all());
        if($store){
            $request->session()->flash('success', 'Language was added');
        }else{
            $request->session()->flash('error', 'Language was not added!!!');
            return back()->withInput();
        }
        return back();
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
        $language = Language::withTrashed()->findOrFail($id);
        return view('admin.languages.edit', [
            'language' => $language,
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
        $language = Language::withTrashed()->findOrFail($id);
        $request->validate([
            'code' => $request->code != $language->code ? 'required|string|max:45|unique:languages,code' : 'required',
            'name' => $request->name != $language->name ? 'required|string|max:45|unique:languages,name' : 'required',
        ]);
        $update = $language->update($request->all());
        if($update){
            $request->session()->flash('success', 'Language was updated');
        }else{
            session()->flash('error', 'Language was not updated');
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
        $language = Language::withTrashed()->findOrFail($id);
        $language->delete();
        session()->flash('success', 'Language '.$language->name.' was deleted');
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $language = Language::withTrashed()->findOrFail($id);
        $language->restore();
        session()->flash('success', 'Language '.$language->name.' was restored!!!');
        return back();
    }
}
