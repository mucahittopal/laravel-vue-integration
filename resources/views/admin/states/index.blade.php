@extends('layouts.admin')

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>States</h1>
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
                <h3 class="card-title">Add state</h3>
            </div>
            <div class="card-body">
                <form action="{{route('states.store')}}" method="post">
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
                        <label class="col-sm-5">* Country</label>
                        <div class="col-sm-7">
                            <select name="country_id" 
                                class="form-control @error('country_id') is-invalid @enderror" 
                                required
                            >
                                <option value="">Please select</option>
                                @foreach ($countries as $country)
                                    <option value="{{$country->id}}" 
                                        @if(old('country_id') == $country->id) selected @endif
                                    >
                                        {{$country->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('name')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5">Code</label>
                        <div class="col-sm-7">
                            <input type="text" name="code" 
                                class="form-control @error('code') is-invalid @enderror" 
                                maxlength="45"
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
        <h3 class="card-title">States</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Code</th>
                        {{-- <th>created at</th> --}}
                        <th>deleted at</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($states as $state)
                    <tr>
                        <td>{{$state->id}}</td>
                        <td>{{$state->name}}</td>
                        <td>{{$state->country ? $state->country->name : ''}}</td>
                        <td>{{$state->code}}</td>
                        {{-- <td>{{$category->created_at}}</td> --}}
                        <td>{{$state->deleted_at ? $state->deleted_at : ''}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="First group">
                                @if(!$state->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="confirm_form_before_submit(
                                        'stateDestroyForm-{{$state->id}}',
                                        'Remove the state',
                                        'Do you want to remove {{$state->name}}?',
                                        'question',
                                        'Delete'
                                    )"
                                >
                                    <i class="fas fa-trash"></i>
                                    <form action="{{route('states.destroy', $state->id)}}" method="post"
                                        id="stateDestroyForm-{{$state->id}}"
                                    >
                                        @csrf @method('delete')
                                    </form>
                                </a>
                                @endif
                                @if($state->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="confirm_form_before_submit(
                                        'stateRestoreForm-{{$state->id}}',
                                        'Restore the state',
                                        'Do you want to restore the {{$state->name}}?',
                                        'question',
                                        'Restore'
                                    )"
                                    title="restore"
                                >
                                    <i class="fas fa-undo"></i>
                                    <form action="{{route('states.restore', $state->id)}}" method="post"
                                        id="stateRestoreForm-{{$state->id}}"
                                    >@csrf</form>
                                </a>
                                @endif
                                <a href="{{route('states.edit', $state->id)}}" type="button" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            {{$states->links()}}
        </div>
    </div>
</div>
@endsection