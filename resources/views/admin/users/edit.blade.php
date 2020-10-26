@extends('layouts.admin')





@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Edit user: {{$user->email}}</h1>
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
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('users.update', $user->id)}}" method="post" enctype="multipart/form-data">
                    @csrf   @method('PUT')
                    <div class="form-group row">
                        <label class="col-sm-4">* Name</label>
                        <div class="col-sm-8">
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                required    
                                maxlength="45"
                                value="{{$user->name}}"
                            >
                            @error('name')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Gender</label>
                        <div class="col-sm-8">
                            <select name="gender"
                                class="form-control @error('gender') is-invalid @enderror"
                            >
                                <option value=""></option>
                                <option value="male" @if($user->gender == 'male') selected @endif>Male</option>
                                <option value="female" @if($user->gender == 'female') selected @endif>Female</option>
                            </select>
                            @error('gender')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection