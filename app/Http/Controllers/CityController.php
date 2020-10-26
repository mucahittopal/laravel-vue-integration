<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get cities
        $cities = City::withTrashed()->orderBy('name', 'asc')->paginate(10);
        $countries = Country::orderBy('name', 'asc')->get();
        $states = State::orderBy('name', 'asc')->get();

        return view('admin.cities.index', [
            'cities' => $cities,
            'countries' => $countries,
            'states' => $states
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
//        dd($request->all());
        $request->validate([
            'name' => 'required|string|max:45|unique:cities,name',
            'country_id' => 'required|integer|exists:countries,id',
            'state_id' => 'sometimes|nullable|integer|exists:states,id'
        ]);
        $store = City::create($request->all());
        if($store){
            $request->session()->flash('success', 'City was added');
        }else{
            $request->session()->flash('error'. 'Error');
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
        $city = City::withTrashed()->findOrFail($id);
        $countries = Country::orderBy('name', 'asc')->get();
        $states = State::orderBy('name', 'asc')->get();

        return view('admin.cities.edit', [
            'city' => $city,
            'countries' => $countries,
            'states' => $states,
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
        $city = City::withTrashed()->findOrFail($id);
        $request->validate([
            'name' => $request->name != $city->name ? 'required|string|max:45|unique:cities,name'
                : 'required',
            'country_id' => 'required|integer|exists:countries,id',
            'state_id' => 'sometimes|nullable|integer|exists:states,id'
        ]);
        $update = $city->update($request->all());
        if($update){
            $request->session()->flash('success', 'City was updated');
        }else{
            $request->session()->flash('error'. 'Error');
            return back()->withInput();
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
        $city = City::withTrashed()->findOrFail($id);
        $name = $city->name;
        $city->delete();
        session()->flash('success', $name.' was removed!!!');
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $city = City::withTrashed()->findOrFail($id);
        $name = $city->name;
        $city->restore();
        session()->flash('success', $name.' was restored!!!');
        return back();
    }
}
