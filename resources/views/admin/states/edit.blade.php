@extends('layouts.admin')

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>State: {{$state->name}}</h1>
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
                <h3 class="card-title">Edit state</h3>
            </div>
            <div class="card-body">
                <form action="{{route('states.update', $state->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-sm-5">* Name</label>
                        <div class="col-sm-7">
                            <input type="text" name="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                maxlength="45" required
                                value="{{$state->name}}"
                            >
                            @error('name')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5">* Country</label>
                        <div class="col-sm-7">
                            <select name="country_id" 
                                class="form-control @error('country_id') is-invalid @enderror" 
                                required
                            >
                                <option value="">Please select</option>
                                @foreach ($countries as $country)
                                    <option value="{{$country->id}}" 
                                        @if($state->country_id == $country->id) selected @endif
                                    >
                                        {{$country->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('name')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5">Code</label>
                        <div class="col-sm-7">
                            <input type="text" name="code" 
                                class="form-control @error('code') is-invalid @enderror" 
                                maxlength="45"
                                value="{{$state->code}}"
                            >
                            @error('code')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection