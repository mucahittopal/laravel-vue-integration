<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get countries
        $countries = Country::withTrashed()->get();

        return view('admin.countries.index', [
            'countries' => $countries
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
            'name' => 'required|string|max:45|unique:countries,name',
            'code' => 'required|string|max:45',
            'name_code' => 'required|string|max:2|unique:countries,name_code'
        ]);
        $request['slug'] = Str::slug($request->name);
        $create = Country::create($request->all());
        if($create){
            $request->session()->flash('success', 'Country was added');
        }else{
            $request->session()->flash('error', 'Error!!!');
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
        $country = Country::withTrashed()->findOrFail($id);

        return view('admin.countries.edit', [
            'country' => $country
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $country = Country::withTrashed()->findOrFail($id);
        $request->validate([
            'name' => $request->name != $country->name ? 'required|string|max:45|unique:countries,name' : 'required',
            'code' => 'required|string|max:45',
            'name_code' => $request->name_code != $country->name_code ? 'required|string|max:2|unique:countries,name_code'
                : 'required'
        ]);
        $request['slug'] = Str::slug($request->name);
        $update = $country->update($request->all());
        if($update){
            $request->session()->flash('success', 'Updated');
        }else{
            $request->session()->flash('error', 'Not Updated!!!');
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
        $country = Country::withTrashed()->findOrFail($id);
        $name = $country->name;
        $country->delete();
        session()->flash('success', $name.' was removed!!!');
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $country = Country::withTrashed()->findOrFail($id);
        $name = $country->name;
        $country->restore();
        session()->flash('success', $name.' was restored!!!');
        return back();
    }

    /**
     * @return mixed
     */
    public function api_countries()
    {
        $countries = Country::orderBy('name', 'asc')->get();
        return $countries;
    }
}
