<?php

namespace App\Http\Controllers;

use App\City;
use App\Zipcode;
use Illuminate\Http\Request;

class ZipcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zipcodes = Zipcode::withTrashed()->orderBy('code', 'asc')->paginate(20);
        $cities = City::orderBy('name', 'asc')->get();
        return view('admin.zipcodes.index', [
            'zipcodes' => $zipcodes,
            'cities' => $cities
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
            'code' => 'required|string|max:45|unique:zipcodes,code',
            'city_id' => 'required|integer|exists:cities,id'
        ]);
        $store = Zipcode::create($request->all());
        if($store){
            $request->session()->flash('success', 'Zipcode was added');
        }else{
            $request->session()->flash('error', 'Zipcode was not added!!!');
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
        $zipcode = Zipcode::withTrashed()->findOrFail($id);
        $cities = City::orderBy('name', 'asc')->get();
        return view('admin.zipcodes.edit', [
            'zipcode' => $zipcode,
            'cities' => $cities
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
        $zipcode = Zipcode::withTrashed()->findOrFail($id);
        $request->validate([
            'code' => $request->code != $zipcode->code ? 'required|string|max:45|unique:zipcodes,code' : 'required',
            'city_id' => 'required|integer|exists:cities,id'
        ]);
        $update = $zipcode->update($request->all());
        if($update){
            $request->session()->flash('success', 'Zipcode was updated');
        }else{
            session()->flash('error', 'Zipcode was not updated');
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
        $zipcode = Zipcode::withTrashed()->findOrFail($id);
        $zipcode->delete();
        session()->flash('success', 'Zipcode '.$zipcode->code.' was deleted');
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $zipcode = Zipcode::withTrashed()->findOrFail($id);
        $zipcode->restore();
        session()->flash('success', 'Zipcode '.$zipcode->code.' was restored!!!');
        return back();
    }
}
