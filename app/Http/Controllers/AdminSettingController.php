<?php

namespace App\Http\Controllers;

use Spatie\Valuestore\Valuestore;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{

    public function search()
    {
        $settings = Valuestore::make(storage_path('app/settings.json'));
        $city = $settings->get('city');
        return view('admin.setting.search', ['city' => $city]);
    }
    public function store_city(Request $request)
    {
        $city = $request->location;
        $settings = Valuestore::make(storage_path('app/settings.json'));
        $settings->put('city', $city);
        $request->session()->flash('success', 'Updated!');

        return redirect()->route('setting.search');
    }
}
