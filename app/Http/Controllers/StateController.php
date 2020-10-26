<?php

namespace App\Http\Controllers;

use App\Country;
use App\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::withTrashed()->orderBy('name', 'asc')->paginate(10);
        $countries = Country::orderBy('name', 'asc')->get();

        return view('admin.states.index', [
            'states' => $states,
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|integer|exists:countries,id',
            'name' => 'required|string|max:45',
            'code' => 'sometimes|nullable|max:45|string'
        ]);

        $state = State::withTrashed()->where('name', $request->name)->where('country_id', $request->country_id)->first();

        if(!$state){
            $create = State::create($request->all());
            if($create){
                $request->session()->flash('success', 'State was added');
            }else{
                $request->session()->flash('error', 'Error');
                return back()->withInput();
            }
        }else{
            $request->session()->flash('error', 'State exists!!!');
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
        $state = State::withTrashed()->findOrFail($id);
        $countries = Country::orderBy('name', 'asc')->get();

        return view('admin.states.edit', [
            'state' => $state,
            'countries' => $countries
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
        $state = State::withTrashed()->findOrFail($id);
        // if request data same with database record
        if($state->country_id == $request->country_id && $state->name == $request->name
            && $state->code == $request->code)
        {
            $request->session()->flash('success', 'State was updated');
            return back();
        }
        $request->validate([
            'name' => 'required|string|max:45',
            'country_id' => 'required|integer|exists:countries,id',
            'code' => 'sometimes|nullable|max:45|string'
        ]);

        if($state->country_id == $request->country_id && $state->name == $request->name){
            $update = $state->update(['code' => $request->code]);
            $request->session()->flash('success', 'State was updated');
        }else{
            $check = State::withTrashed()->where('country_id',$request->country_id)->where('name', $request->name)->first();
            if(!$check){
                $update = $state->update($request->all());
                if($update){
                    $request->session()->flash('success', 'State was updated');
                }else{
                    $request->session()->flash('error', 'State was not updated');
                    return back()->withInput();
                }
            }else{
                $request->session()->flash('error', 'State exists');
                return back()->withInput();
            }
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
        $state = State::withTrashed()->findOrFail($id);
        $name = $state->name;
        $state->delete();
        session()->flash('success', $name.' was removed!!!');
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $state = State::withTrashed()->findOrFail($id);
        $name = $state->name;
        $state->restore();
        session()->flash('success', $name.' was restored!!!');
        return back();
    }
}
