@extends('layouts.admin')

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Services</h1>
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
                <h3 class="card-title">Create service</h3>
            </div>
            <div class="card-body">
                <form action="{{route('services.store')}}" method="post">
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
                    <div class="form-group row">
                        <label class="col-sm-4">* Category</label>
                        <div class="col-sm-6">
                            <select name="category_id" 
                                class="form-control @error('category_id') is-invalid @enderror" 
                                required
                                value="{{old('category_id')}}"
                            >
                                <option value=""></option>
                                @foreach ($categories as $item)
                                    <option value="{{$item->id}}" @if(old('category_id') == $item->id) selected @endif>
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
                                    value="{{old('aka_'.$i)}}"
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

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Services</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Category</th>
                        <th>aka 1</th>
                        <th>aka 2</th>
                        <th>aka 3</th>
                        {{-- <th>created at</th> --}}
                        <th>deleted at</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->slug}}</td>
                        <td>{{$item->category ? $item->category->name : ''}}</td>
                        <td>{{$item->aka_1}}</td>
                        <td>{{$item->aka_2}}</td>
                        <td>{{$item->aka_3}}</td>
                        {{-- <td>{{$item->created_at}}</td> --}}
                        <td>{{$item->deleted_at ? $item->deleted_at : ''}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="First group">
                                @if(!$item->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="confirm_form_before_submit(
                                        'servicesDestroyForm-{{$item->id}}',
                                        'Remove the service',
                                        'Do you want to remove {{$item->name}}?',
                                        'question',
                                        'Delete'
                                    )"
                                >
                                    <i class="fas fa-trash"></i>
                                    <form action="{{route('services.destroy', $item->id)}}" method="post"
                                        id="servicesDestroyForm-{{$item->id}}"
                                    >
                                        @csrf @method('delete')
                                    </form>
                                </a>
                                @endif
                                @if($item->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="confirm_form_before_submit(
                                        'servicesRestoreForm-{{$item->id}}',
                                        'Restore the service',
                                        'Do you want to restore {{$item->name}}?',
                                        'question',
                                        'Restore'
                                    )"
                                    title="restore"
                                >
                                    <i class="fas fa-undo"></i>
                                    <form action="{{route('services.restore', $item->id)}}" method="post"
                                        id="servicesRestoreForm-{{$item->id}}"
                                    >@csrf</form>
                                </a>
                                @endif
                                <a href="{{route('services.edit', $item->id)}}" type="button" class="btn btn-outline-secondary btn-sm">
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
            {{$services->links()}}
        </div>
    </div>
</div>
@endsection