@extends('layouts.admin')

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Search</h1>
    </div>
    {{-- <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
        </ol>
    </div> --}}
</div>
@endsection


@section('content')
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Set Default City</h3>
            </div>
            <div class="card-body">
                <form action="{{route('setting.search.default_city.store')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-5">Default City</label>
                        <div class="col-sm-7">
                            <location-search-box data-ltype="city" 
                                data-keyword="{{$city}}" />

                            @error('name')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group text-right">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection