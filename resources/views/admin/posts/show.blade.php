@extends('layouts.admin')

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Show Post</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></li>
            <li class="breadcrumb-item"><a href="{{route('posts.index')}}">Posts</a></li>
            <li class="breadcrumb-item active">Show Post</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
                <div>
                    @if($post->deleted_at)
                    <a href="javascript:;" type="button" class="btn btn-success btn-sm"
                        @click="confirm_form_before_submit(
                            'postRestoreForm-{{$post->id}}',
                            'Restore the post',
                            'Do you want to restore the post?',
                            'question',
                            'Restore'
                        )"    
                    >
                        <i class="fas fa-undo"></i> Restore
                        <form action="{{route('posts.restore', $post->id)}}" method="post"
                            id="postRestoreForm-{{$post->id}}">@csrf</form>
                    </a>
                    @endif
                    @if(!$post->deleted_at)
                    <a href="javascript:;" type="button" class="btn btn-danger btn-sm"
                        @click="confirm_form_before_submit(
                            'postDeleteForm-{{$post->id}}',
                            'Delete the post',
                            'Do you want to delete the post?',
                            'question',
                            'Delete'
                        )"    
                    >
                        <i class="fas fa-trash"></i> Delete
                        <form action="{{route('posts.destroy', $post->id)}}" method="post"
                            id="postDeleteForm-{{$post->id}}">@csrf  @method('delete')</form>
                    </a>
                    @endif
                    @if(!$post->deleted_at && !$post->verified_at)
                    <a href="javascript:;" type="button" class="btn btn-primary btn-sm"
                        @click="confirm_form_before_submit(
                            'postVerifyForm-{{$post->id}}',
                            'Verify the post',
                            'Do you want to verify the post?',
                            'question',
                            'Verify'
                        )"    
                    >
                        <i class="fas fa-check-circle"></i> Verify
                        <form action="{{route('posts.verify', $post->id)}}" method="post"
                            id="postVerifyForm-{{$post->id}}">@csrf</form>
                    </a>
                    @endif
                    @if(!$post->deleted_at && $post->verified_at)
                    <a href="javascript:;" type="button" class="btn btn-danger btn-sm"
                        @click="confirm_form_before_submit(
                            'postUnverifyForm-{{$post->id}}',
                            'Unverify the post',
                            'Do you want to unverify the post?',
                            'question',
                            'Unverify'
                        )"    
                    >
                        <i class="fas fa-ban"></i> Unverify
                        <form action="{{route('posts.unverify', $post->id)}}" method="post"
                            id="postUnverifyForm-{{$post->id}}">@csrf</form>
                    </a>
                    @endif
                    @if($post->verified_at && $post->reupdated_at)
                    <a href="javascript:;" type="button" class="btn btn-success btn-sm"
                        @click="confirm_form_before_submit(
                            'postReverifyForm-{{$post->id}}',
                            'Re-verify the post',
                            'Do you want to re-verify the post?',
                            'question',
                            'Re-verify'
                        )"    
                    >
                        <i class="fas fa-check"></i> Re-verify
                        <form action="{{route('posts.re-verify', $post->id)}}" method="post"
                            id="postReverifyForm-{{$post->id}}">@csrf</form>
                    </a>
                    @endif
                    @if(!$post->deleted_at)
                    <a href="{{route('posts.edit', $post->id)}}" type="button" class="btn btn-secondary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    @endif
                </div>
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="text-bold">Id</td>
                        <td>{{$post->id}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">User Id</td>
                        <td>{{$post->user ? $post->user->id : ''}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Country</td>
                        <td>{{$post->country ? $post->country->name : ''}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">State</td>
                        <td>{{$post->state ? $post->state->name : ''}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">City</td>
                        <td>{{$post->city ? $post->city->name : ''}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Zipcode</td>
                        <td>{{$post->zipcode ? $post->zipcode->code : ''}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Hourly rate</td>
                        <td>${{$post->hourly_rate}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Experience years</td>
                        <td>{{$post->experience}} years</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Phone</td>
                        <td>{{$post->phone}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Onsite service</td>
                        <td>
                            @if($post->onsite_service == 0)
                                No
                            @elseif($post->onsite_service == 1)
                                Yes
                            @else
                                N\A
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">Reference</td>
                        <td>{{$post->reference}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Hear us from</td>
                        <td>{{$post->user && $post->user->referrer ? $post->user->referrer->name : ''}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Spoken languages</td>
                        <td>
                            @foreach ($post->languages as $language)
                                <span class="d-block">{{$language->name}}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">Services</td>
                        <td>
                            @foreach ($post->services as $service)
                                <span class="d-block">{{$service->name}}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">Tag</td>
                        <td>
                            {{$post->tag}}
                        </td>
                    </tr>
                </table>
                <div>
                    <div class="text-bold">Description</div>
                    <div>{{$post->description}}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td>Created at</td>
                        <td>{{$post->created_at}}</td>
                    </tr>
                    <tr>
                        <td>Verified at</td>
                        <td>{{$post->verified_at}}</td>
                    </tr>
                    <tr>
                        <td>Deleted at</td>
                        <td>{{$post->deleted_at}}</td>
                    </tr>
                    <tr>
                        <td>Reupdated at</td>
                        <td>{{$post->reupdated_at}}</td>
                    </tr>
                    @if($post->featured == 1)
                    <tr>
                        <td>Featured</td>
                        <td><i class="fas fa-check"></i></td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Featured</div>
            <div class="card-body">
                <form action="/admin/posts/{{$post->id}}/featured" method="post">
                    @csrf   @method('put')
                    <div class="form-group row">
                        <div class="col-sm-4"><label>Featured</label></div>
                        <div class="col-sm-8">
                            <select name="featured" class="form-control">
                                <option value="">No</option>
                                <option value="1" @if($post->featured) selected @endif>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection