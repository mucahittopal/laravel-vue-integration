@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-4 col-md-5 col-lg-4">
        <div class="profile-images-wrapper">
            <div class="profile-img">
                <div class="img-wrapper">
                    <img src="{{$profile_photo}}">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8 col-md-7 col-lg-8">
        @if(!Auth::user()->email_verified_at)
        <div class="alert alert-warning" role="alert">
            Please verify your email address.
            if you haven't got verification link please click
            <a href="javascript:;" onclick="document.getElementById('rv-form').submit()">
                resend
                <form action="{{route('verification.resend')}}" method="post" class="d-none" id="rv-form">@csrf</form>
            </a>
        </div>
        @endif
        <div class="mb-4">
            <div class="table-responsive">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="font-bold">Name: </td>
                        <td>{{Auth::user()->name}}</td>
                    </tr>
                    <tr>
                        <td class="font-bold">Email address: </td>
                        <td>{{Auth::user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="font-bold">Gender: </td>
                        <td>{{Auth::user()->gender}}</td>
                    </tr>
                    <tr>
                        <td class="font-bold">Created at: </td>
                        <td>{{Auth::user()->created_at}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="mb-4">
            <div class="panel">
                <div class="panel-header">
                    <div class="font-bold">Update account</div>
                </div>
                <div class="panel-body">
                    <form action="{{route('update.profile')}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-4 font-bold">* Name</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required maxlength="45">

                                @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <div class="panel">
                <div class="panel-header">
                    <div class="font-bold">Update Gender</div>
                </div>
                <div class="panel-body">
                    <form action="{{route('update.gender')}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-4 font-bold">Gender</label>
                            <div class="col-lg-8">
                                <select class="form-control @error('gender') is-invalid @enderror" required name="gender">
                                    <option value="">ANY</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Others</option>
                                </select>
                                @error('gender')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <div class="panel">
                <div class="panel-header">
                    <div class="font-bold">Update password</div>
                </div>
                <div class="panel-body">
                    <form action="{{route('update.profile.password')}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-6 font-bold">* Current password</label>
                            <div class="col-lg-6">
                                <input type="password" class="form-control" name="current">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-6 font-bold">* New password</label>
                            <div class="col-lg-6">
                                <input type="password" name="password" minlength="8" maxlength="15" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-6 font-bold">* Confirm password</label>
                            <div class="col-lg-6">
                                <input type="password" class="form-control" name="password_confirmation" minlength="8" maxlength="15">
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <div class="panel">
                <div class="panel-header">
                    <div class="font-bold">Update profile photo</div>
                </div>
                <div class="panel-body">
                    @if(auth()->user()->profile_photo && !auth()->user()->profile_photo_verified)
                    <div class="alert alert-info" role="alert">
                        Your new profile photo is in verification period after admin verification it will be visible.
                    </div>
                    @else
                    <update-profile-photo csrf="{{csrf_token()}}" route="{{route('update.profile.photo')}}" @error('image') err-msg="{{$message}}" @enderror></update-profile-photo>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection