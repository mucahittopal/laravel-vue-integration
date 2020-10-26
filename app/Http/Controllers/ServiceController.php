<?php

namespace App\Http\Controllers;

use App\Category;
use App\Service;
use App\ServiceTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $services = Service::withTrashed()->orderBy('name', 'asc')->paginate(20);
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.services.index', [
            'services' => $services,
            'categories' => $categories
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
            'name' => 'required|max:45|unique:services,name',
            'category_id' => 'required|integer|exists:categories,id',
            'aka_1' => 'sometimes|nullable|string|max:45',
            'aka_2' => 'sometimes|nullable|string|max:45',
            'aka_3' => 'sometimes|nullable|string|max:45'
        ]);

        $request['slug'] = Str::slug($request->name);
        $create = Service::create($request->all());

        if($create){
            $request->session()->flash('success', 'Service was created successfully');
        }else{
            $request->session()->flash('error', 'Service was not able to be created');
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
        $service = Service::withTrashed()->findOrFail($id);
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.services.edit', [
            'service' => $service,
            'categories' => $categories
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $service = Service::withTrashed()->findOrFail($id);
        $request->validate([
            'name' => $request->name != $service->name ? 'required|max:45|unique:services,name' : 'required',
            'category_id' => 'required|integer|exists:categories,id',
            'aka_1' => 'sometimes|nullable|string|max:45',
            'aka_2' => 'sometimes|nullable|string|max:45',
            'aka_3' => 'sometimes|nullable|string|max:45'
        ]);
        $slug = Str::slug($request->name);
        $request['slug'] = $slug;
        $update = $service->update($request->all());
        if($update)
            session()->flash('success', 'Service was updated!');
        else
            session()->flash('error', 'Service was not updated!');

        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $delete = Service::withTrashed()->findOrFail($id)->delete();
        if($delete){
            session()->flash('success', 'Service was deleted!');
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $restore = Service::withTrashed()->where('id', $id)->restore();
        if($restore){
            session()->flash('success', 'Category was restored!');
        }
        return back();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function api_search_service(Request $request)
    {
        $services = Service::where('name', 'like', '%'.$request->keyword.'%')
            ->orWhere('aka_1', '%'.$request->keyword.'%')
            ->orWhere('aka_2', '%'.$request->keyword.'%')
            ->orWhere('aka_3', '%'.$request->keyword.'%')
            ->distinct()
            ->orderBy('name', 'asc')
            ->get();
        return $services;
    }
    public function api_search_service_tag(Request $request)
    {
        $services = ServiceTag::where('name', 'like', '%'.$request->keyword.'%')
            ->distinct()
            ->orderBy('name', 'asc')
            ->get();
        return $services;
    }
    public function api_search_service_or_tag(Request $request)
    {
        $services = Service::where('name', 'like', '%'.$request->keyword.'%')
            ->orWhere('aka_1', '%'.$request->keyword.'%')
            ->orWhere('aka_2', '%'.$request->keyword.'%')
            ->orWhere('aka_3', '%'.$request->keyword.'%')
            ->distinct()
            ->orderBy('name', 'asc')
            ->get()->toArray();
        
        $tags = ServiceTag::where('name', 'like', '%'.$request->keyword.'%')
            ->distinct()
            ->orderBy('name', 'asc')
            ->get()->toArray();

        $result = array_merge($services, $tags);
        return $result;
    }
}
