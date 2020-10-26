<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Zipcode;
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
        //
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
        //
    }

    /**
     * @param $id
     * @return CityResource
     */
    public function show($id)
    {
        return new CityResource(City::findOrFail($id));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @return array
     */
    public function api_search_cityorzipcode(Request $request)
    {
        $cities = City::where('name', 'like', $request->keyword.'%')
            // ->where('country_id', $request->country_id)
            ->orderBy('name', 'asc')->distinct()->get();
        $zipcodes = Zipcode::where('zipcodes.code', 'like', '%'.$request->keyword.'%')
            ->join('cities', 'cities.id', '=', 'zipcodes.id')
            ->join('countries', 'cities.country_id', '=', 'countries.id')
            ->where('countries.id', $request->country_id)
            ->select('zipcodes.*')
            ->distinct()
            ->orderBy('zipcodes.code', 'asc')->distinct()->get();
        return [
            'cities' => $cities,
            'zipcodes' => $zipcodes
        ];
    }
}
