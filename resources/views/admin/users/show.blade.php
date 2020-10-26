@extends('layouts.admin')





@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Users show</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></li>
            <li class="breadcrumb-item active">show</li>
        </ol>
    </div>
</div>
@endsection








@section('content')
<div class="row mb-3">
    <div class="col-sm-12 text-right">
        <a href="{{route('users.edit',$user->id)}}"
            class="btn btn-primary btn-sm"
        >
            <i class="fa fa-edit"></i> Edit
        </a>

        @if(!$user->deleted_at)
        <a href="javascript:;" class="btn btn-danger btn-sm"
            @click="confirm_form_before_submit(
                'userDestroyForm-{{$user->id}}',
                'Remove the user',
                'Do you want to remove {{$user->email}} from the users?',
                'question',
                'Delete'
            )"
        >
            <i class="fa fa-trash"></i> Delete user

            <form action="{{route('users.destroy', $user->id)}}" method="post" id="userDestroyForm-{{$user->id}}">
                @csrf     @method('delete')
            </form>
        </a>
        @endif

        @if($user->deleted_at)
        <a href="javascript:;" class="btn btn-warning btn-sm"
            @click="confirm_form_before_submit(
                'userRestoreForm-{{$user->id}}',
                'Restore the user',
                'Do you want to restore the users?',
                'question',
                'Restore'
            )"
        >
            <i class="fa fa-undo"></i> Restore user

            <form action="{{route('users.restore', $user->id)}}" method="post" id="userRestoreForm-{{$user->id}}">
                @csrf
            </form>
        </a>
        @endif

    
    </div>
</div>

<div class="row">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Profile photo</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div>
                            @if($user->profile_photo && !$user->profile_photo_verified)
                            <a href="javascript:;" 
                                @click="confirm_form_before_submit(
                                    'confirmUserProfilePhoto-{{$user->id}}',
                                    'Confirm the photo',
                                    'Do you want to confirm profile photo of user?',
                                    'question',
                                    'Confirm'
                                )"
                                class="btn btn-primary btn-sm"
                            >
                                Confirm
                                <form action="{{route('users.profile-photo', $user->id)}}" method="post" class="d-none"
                                    id="confirmUserProfilePhoto-{{$user->id}}">@csrf</form>
                            </a> 
                            @endif
                            @if($user->profile_photo)
                            <a href="javascript:;" 
                                @click="confirm_form_before_submit(
                                    'deleteUserProfilePhoto-{{$user->id}}',
                                    'Delete the photo',
                                    'Do you want to delete profile photo of user?',
                                    'question',
                                    'Delete'
                                )"
                                class="btn btn-danger btn-sm"
                            >
                                Delete
                                <form action="{{route('users.delete.profile-photo', $user->id)}}" method="post" class="d-none"
                                    id="deleteUserProfilePhoto-{{$user->id}}">@csrf</form>
                            </a>
                            @endif
                        </div>
                        <div>
                            <img src="{{$user->profile_photo ? get_profile_photo($user->profile_photo)['original'] : '/images/no-user.png'}}" 
                                alt="" width="150" height="150">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-1 border">
                            <update-profile-photo
                                csrf="{{csrf_token()}}"
                                name="profile_photo"
                                route="{{route('users.update.profile-photo', $user->id)}}"
                                @error('profile_photo')
                                    err-msg="{{$message}}"
                                @enderror
                            ></update-profile-photo>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit password</h3>
            </div>
            <div class="card-body">
                <form action="{{route('users.update.password', $user->id)}}" method="post">
                    @csrf   @method('put')
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
                    <div class="text-right">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="card">
            <div class="card-header">Info</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">Id</div>
                    <div class="col-sm-8">{{$user->id}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Name</div>
                    <div class="col-sm-8">{{$user->name}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Email</div>
                    <div class="col-sm-8">{{$user->email}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Created at</div>
                    <div class="col-sm-8">{{$user->created_at}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Verified</div>
                    <div class="col-sm-8">{{$user->verified_at ? '<i class="fas fa-check"></i>' : ''}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Referrer</div>
                    <div class="col-sm-8">{{$user->referrer ? $user->referrer->name : ''}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Gender</div>
                    <div class="col-sm-8">{{$user->gender}}</div>
                </div>
                @if($user->deleted_at)
                <div class="row">
                    <div class="col-sm-4">Deleted</div>
                    <div class="col-sm-8"><i class="fas fa-check"></i></div>
                </div>
                @endif
                @if($user->post)
                <div class="row">
                    <div class="col-sm-4">Post</div>
                    <div class="col-sm-8"><a href="{{route('posts.show', $user->post->id)}}">Provided post</a></div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection