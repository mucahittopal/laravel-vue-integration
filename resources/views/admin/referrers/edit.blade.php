@extends('layouts.admin')

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Referrer: {{$referrer->name}}</h1>
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
                <h3 class="card-title">Edit referrer</h3>
            </div>
            <div class="card-body">
                <form action="{{route('referrers.update', $referrer->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-sm-5">* Name</label>
                        <div class="col-sm-7">
                            <input type="text" name="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                maxlength="255" 
                                required
                                value="{{$referrer->name}}"
                            >
                            @error('name')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection