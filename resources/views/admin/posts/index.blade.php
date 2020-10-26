@extends('layouts.admin')

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Posts</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></li>
            <li class="breadcrumb-item active">Posts</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Posts</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Created at</th>
                        <th>Deleted at</th>
                        <th>Verified at</th>
                        <th>Reupdated</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>
                            @if($item->user)
                                <a href="{{route('users.show', $item->user->id)}}">{{$item->user->email}}</a>
                            @endif
                        </td>
                        <td>{{$item->created_at}}</td>
                        <td>{{$item->deleted_at ? $item->deleted_at : ''}}</td>
                        <td>{{$item->verified_at ? $item->verified_at : ''}}</td>
                        <td>{{$item->reupdated_at ? 'yes' : ''}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="First group">
                                @if(!$item->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="confirm_form_before_submit(
                                        'postDestroyForm-{{$item->id}}',
                                        'Remove the post',
                                        'Do you want to remove the post from the posts?',
                                        'question',
                                        'Delete'
                                    )"    
                                >
                                    <i class="fas fa-trash"></i>
                                    <form action="{{route('posts.destroy', $item->id)}}" method="post"
                                        id="postDestroyForm-{{$item->id}}">@csrf @method('delete')</form>
                                </a>
                                @endif
                                @if($item->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="confirm_form_before_submit(
                                        'postRestoreForm-{{$item->id}}',
                                        'Remove the post',
                                        'Do you want to restore the post in the posts?',
                                        'question',
                                        'Restore'
                                    )"
                                    title="restore"
                                >
                                    <i class="fas fa-undo"></i>
                                    <form action="{{route('posts.restore', $item->id)}}" method="post"
                                        id="postRestoreForm-{{$item->id}}">@csrf</form>
                                </a>
                                @endif
                                <a href="{{route('posts.edit', $item->id)}}" type="button" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{route('posts.show', $item->id)}}" type="button" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            {{$posts->appends($_GET)->links()}}
        </div>
    </div>
</div>
@endsection