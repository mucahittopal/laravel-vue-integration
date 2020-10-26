@extends('layouts.admin')

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Service: {{$service->name}}</h1>
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
                <h3 class="card-title">Edit service</h3>
            </div>
            <div class="card-body">
                <form action="{{route('services.update', $service->id)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <label class="col-sm-4">*Name</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                maxlength="45" required
                                value="{{$service->name}}"
                            >
                            @error('name')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">* Category</label>
                        <div class="col-sm-6">
                            <select name="category_id" 
                                class="form-control @error('category_id') is-invalid @enderror" 
                                required
                            >
                                <option value=""></option>
                                @foreach ($categories as $item)
                                    <option value="{{$item->id}}" @if($service->category_id == $item->id) selected @endif>
                                        {{$item->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- aka --}}
                    @for($i = 1; $i <= 3; $i++)
                        <div class="form-group row">
                            <label class="col-sm-4">* Aka {{$i}}</label>
                            <div class="col-sm-6">
                                <input type="text" name="aka_{{$i}}" 
                                    class="form-control @error('aka_'.$i) is-invalid @enderror" 
                                    maxlength="45" 
                                    value="{{$service->{'aka_'.$i} }}"
                                >
                                @error('aka_'.$i)
                                <div class="invalid-feedback d-block">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    @endfor
                    <div class="text-right">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection