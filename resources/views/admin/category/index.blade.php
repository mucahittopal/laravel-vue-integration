@extends('layouts.admin')

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Category</h1>
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
                <h3 class="card-title">Create category</h3>
            </div>
            <div class="card-body">
                <form action="{{route('category.store')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-4">*Name</label>
                        <div class="col-sm-6">
                            <input type="text" name="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                maxlength="45" required
                                value="{{old('name')}}"
                            >
                            @error('name')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Categories</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        {{-- <th>created at</th> --}}
                        <th>deleted at</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->slug}}</td>
                        {{-- <td>{{$category->created_at}}</td> --}}
                        <td>{{$category->deleted_at ? $category->deleted_at : ''}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="First group">
                                @if(!$category->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="delete_category({{$category->id}}, '{{$category->name}}')"
                                >
                                    <i class="fas fa-trash"></i>
                                    <form action="{{route('category.destroy', $category->id)}}" method="post"
                                        id="category-destroy-form-{{$category->id}}"
                                    >
                                        @csrf @method('delete')
                                    </form>
                                </a>
                                @endif
                                @if($category->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="restore_category({{$category->id}}, '{{$category->name}}')"
                                    title="restore"
                                >
                                    <i class="fas fa-undo"></i>
                                    <form action="{{route('category.restore', $category->id)}}" method="post"
                                        id="category-restore-form-{{$category->id}}"
                                    >@csrf</form>
                                </a>
                                @endif
                                <a href="{{route('category.edit', $category->id)}}" type="button" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection