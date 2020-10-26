@extends('layouts.app')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Service</div>

                <div class="card-body">
                    <edit-post :post="{{$post}}" 
                        user-gender="{{auth()->user()->gender}}"
                        :post-languages="{{$post->languages}}"
                        :post-services="{{$post->services}}"
                        user-referrer="{{auth()->user()->referrer_id}}"
                        action="/posts/{{$post->id}}"
                    >
                        <div slot="top">
                            @csrf   @method('PUT')
                        </div>
                    </edit-post>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection