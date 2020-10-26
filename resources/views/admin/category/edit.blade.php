@extends('layouts.admin')

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Category: {{$category->name}}</h1>
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
                <h3 class="card-title">Edit category</h3>
            </div>
            <div class="card-body">
                <form action="{{route('category.update', $category->id)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <label class="col-sm-4">*Name</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                maxlength="45" required
                                value="{{$category->name}}"
                            >
                            @error('name')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection