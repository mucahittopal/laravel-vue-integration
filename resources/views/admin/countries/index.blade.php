@extends('layouts.admin')

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Countries</h1>
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
                <h3 class="card-title">Add country</h3>
            </div>
            <div class="card-body">
                <form action="{{route('countries.store')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-5">* Name</label>
                        <div class="col-sm-7">
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
                    <div class="form-group row">
                        <label class="col-sm-5">* Name code (Alpha-2 code)</label>
                        <div class="col-sm-7">
                            <a href="https://countrycode.org/" target="_blank">https://countrycode.org/</a>
                            <input type="text" name="name_code" 
                                class="form-control @error('name_code') is-invalid @enderror" 
                                maxlength="2" required
                                value="{{old('name_code')}}"
                            >
                            @error('name_code')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5">* Dial Code</label>
                        <div class="col-sm-7">
                            <input type="text" name="code" 
                                class="form-control @error('code') is-invalid @enderror" 
                                maxlength="45" required
                                value="{{old('code')}}"
                            >
                            @error('code')
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

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Countries</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Name Code</th>
                        <th>Dial Code</th>
                        <th>Slug</th>
                        {{-- <th>created at</th> --}}
                        <th>deleted at</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($countries as $country)
                    <tr>
                        <td>{{$country->id}}</td>
                        <td>{{$country->name}}</td>
                        <td>{{$country->name_code}}</td>
                        <td>{{$country->code}}</td>
                        <td>{{$country->slug}}</td>
                        {{-- <td>{{$category->created_at}}</td> --}}
                        <td>{{$country->deleted_at ? $country->deleted_at : ''}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="First group">
                                @if(!$country->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="confirm_form_before_submit(
                                        'countryDestroyForm-{{$country->id}}',
                                        'Remove the country',
                                        'Do you want to remove {{$country->name}}?',
                                        'question',
                                        'Delete'
                                    )"
                                >
                                    <i class="fas fa-trash"></i>
                                    <form action="{{route('countries.destroy', $country->id)}}" method="post"
                                        id="countryDestroyForm-{{$country->id}}"
                                    >
                                        @csrf @method('delete')
                                    </form>
                                </a>
                                @endif
                                @if($country->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="confirm_form_before_submit(
                                        'countryRestoreForm-{{$country->id}}',
                                        'Restore the country',
                                        'Do you want to restore the {{$country->name}}?',
                                        'question',
                                        'Restore'
                                    )"
                                    title="restore"
                                >
                                    <i class="fas fa-undo"></i>
                                    <form action="{{route('countries.restore', $country->id)}}" method="post"
                                        id="countryRestoreForm-{{$country->id}}"
                                    >@csrf</form>
                                </a>
                                @endif
                                <a href="{{route('countries.edit', $country->id)}}" type="button" class="btn btn-outline-secondary btn-sm">
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