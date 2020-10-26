@extends('layouts.admin')





@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Users</h1>
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
<div class="row mb-3">
    <div class="col-sm-12 text-right">
        <a href="{{route('users.create')}}" class="btn btn-primary">
            Create user
        </a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Users</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Verified at</th>
                                <th scope="col">deleted at</th>
                                <th scope="col">Photo Verified at</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    {{$user->id}}
                                </td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    {!!$user->email_verified_at 
                                        ? '<i class="fas fa-check"></i>' : ''!!}
                                </td>
                                <td>@if($user->deleted_at) <i class="fas fa-check"></i> @endif</td>
                                <td>
                                    {!!$user->profile_photo_verified 
                                        ? '<i class="fas fa-check"></i>' : ''!!}
                                </td>
                                <td>
                                    <a href="{{route('users.show', $user->id)}}" type="button" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{route('users.edit', $user->id)}}" type="button" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    {{$users->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection