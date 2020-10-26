@extends('layouts.admin')





@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Create users</h1>
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
                <form action="{{route('users.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-4">* Name</label>
                        <div class="col-sm-8">
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                required    
                                maxlength="45"
                                value="{{old('name')}}"
                            >
                            @error('name')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">* Email</label>
                        <div class="col-sm-8">
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                required    
                                maxlength="255"
                                value="{{old('email')}}"
                            >
                            @error('email')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">* Password</label>
                        <div class="col-sm-8">
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required    
                                maxlength="15"
                                minlength="8"
                            >
                            @error('password')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">* Confirm password</label>
                        <div class="col-sm-8">
                            <input type="password" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                required    
                                maxlength="15"
                                minlength="8"
                            >
                            @error('password_confirmation')
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
                                <option value="male" @if(old('gender') == 'male') selected @endif>Male</option>
                                <option value="female" @if(old('gender') == 'female') selected @endif>Female</option>
                            </select>
                            @error('gender')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Profile photo</label>
                        <div class="col-sm-8">
                            <input type="file" class="@error('profile_photo') is-invalid @enderror" name="profile_photo">
                            @error('profile_photo')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                            <ul>
                                <li>- Max file size can be 15mb</li>
                                <li>- Allowed extension are jpeg,jpg,png</li>
                                <li>- Upload square image which same height and same width. for example 500x500</li>
                                <li>- Minimum image dimesion is 250x250</li>
                                <li>- New uploaded profile photo will be visible after admin verification</li>
                            </ul>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label class="col-sm-4">Phone</label>
                        <div class="col-sm-8">
                            <phone-input name="phone_number" value="{{old('phone_number')}}"></phone-input>
                            @error('phone_number')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection