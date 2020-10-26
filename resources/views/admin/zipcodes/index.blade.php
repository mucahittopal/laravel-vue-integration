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
                <h3 class="card-title">Add zipcode</h3>
            </div>
            <div class="card-body">
                <form action="{{route('zipcodes.store')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-5">* Code</label>
                        <div class="col-sm-7">
                            <input type="text" name="code" 
                                class="form-control @error('code') is-invalid @enderror" 
                                maxlength="45" 
                                required
                                value="{{old('code')}}"
                            >
                            @error('code')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5">* City</label>
                        <div class="col-sm-7">
                            <select name="city_id" 
                                class="form-control @error('city_id') is-invalid @enderror" 
                                maxlength="45" 
                                required
                            >
                                <option value="">Please select</option>
                                @foreach ($cities as $city)
                                    <option value="{{$city->id}}" {{old('city_id') == $city->id ? 'selected' : ''}}>
                                        {{$city->name}}
                                    </option>
                                @endforeach
                            </select>
                            @error('city_id')
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
        <h3 class="card-title">Zipcodes</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>City</th>
                        {{-- <th>created at</th> --}}
                        <th>deleted at</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($zipcodes as $zipcode)
                    <tr>
                        <td>{{$zipcode->id}}</td>
                        <td>{{$zipcode->code}}</td>
                        <td>{{$zipcode->city ? $zipcode->city->name : ''}}</td>
                        {{-- <td>{{$category->created_at}}</td> --}}
                        <td>{{$zipcode->deleted_at ? $zipcode->deleted_at : ''}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="First group">
                                @if(!$zipcode->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="confirm_form_before_submit(
                                        'zipcodeDestroyForm-{{$zipcode->id}}',
                                        'Remove the zipcode',
                                        'Do you want to remove {{$zipcode->code}}?',
                                        'question',
                                        'Delete'
                                    )"
                                >
                                    <i class="fas fa-trash"></i>
                                    <form action="{{route('zipcodes.destroy', $zipcode->id)}}" method="post"
                                        id="zipcodeDestroyForm-{{$zipcode->id}}"
                                    >
                                        @csrf @method('delete')
                                    </form>
                                </a>
                                @endif
                                @if($zipcode->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="confirm_form_before_submit(
                                        'zipcodeRestoreForm-{{$zipcode->id}}',
                                        'Restore the zipcode',
                                        'Do you want to restore the {{$zipcode->code}}?',
                                        'question',
                                        'Restore'
                                    )"
                                    title="restore"
                                >
                                    <i class="fas fa-undo"></i>
                                    <form action="{{route('zipcodes.restore', $zipcode->id)}}" method="post"
                                        id="zipcodeRestoreForm-{{$zipcode->id}}"
                                    >@csrf</form>
                                </a>
                                @endif
                                <a href="{{route('zipcodes.edit', $zipcode->id)}}" type="button" class="btn btn-outline-secondary btn-sm">
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
            {{$zipcodes->links()}}
        </div>
    </div>
</div>
@endsection