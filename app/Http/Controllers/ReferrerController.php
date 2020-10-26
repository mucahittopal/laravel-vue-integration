<?php

namespace App\Http\Controllers;

use App\Referrer;
use Illuminate\Http\Request;

class ReferrerController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $referrers = Referrer::withTrashed()->get();
        return view('admin.referrers.index', [
            'referrers' => $referrers,
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:referrers,name',
        ]);
        $store = Referrer::create($request->all());
        if($store){
            $request->session()->flash('success', 'Referrer was added');
        }else{
            $request->session()->flash('error', 'Referrer was not added!!!');
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
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $referrer = Referrer::withTrashed()->findOrFail($id);
        return view('admin.referrers.edit', [
            'referrer' => $referrer,
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
        $referrer = Referrer::withTrashed()->findOrFail($id);
        $request->validate([
            'name' => $request->name != $referrer->name ? 'required|string|max:255|unique:referrers,name' : 'required',
        ]);
        $update = $referrer->update($request->all());
        if($update){
            $request->session()->flash('success', 'Referrer was updated');
        }else{
            session()->flash('error', 'Referrer was not updated');
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
        $referrer = Referrer::withTrashed()->findOrFail($id);
        $referrer->delete();
        session()->flash('success', 'Referrer '.$referrer->name.' was deleted');
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $referrer = Referrer::withTrashed()->findOrFail($id);
        $referrer->restore();
        session()->flash('success', 'Referrer '.$referrer->name.' was restored!!!');
        return back();
    }
}
