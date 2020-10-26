@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
@endsection

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Post edit</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></li>
            <li class="breadcrumb-item"><a href="{{route('posts.index')}}">Posts</a></li>
            <li class="breadcrumb-item"><a href="{{route('posts.show', $post->id)}}">Show post</a></li>
            <li class="breadcrumb-item active">Post edit</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
                <edit-post :post="{{$post}}" user-gender="{{$post->user ? $post->user->gender : ''}}"
                    :post-languages="{{$post->languages}}"
                    :post-services="{{$post->services}}"
                    user-referrer="{{$post->user && $post->user->referrer ? $post->user->referrer_id : ''}}"
                    action="{{route('posts.update', $post->id)}}"
                >
                    <div slot="top">
                        @csrf   @method('PUT')
                    </div>
                </edit-post>
            </div>
        </div>
    </div>
</div>
@endsection