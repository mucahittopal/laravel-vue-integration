@extends('layouts.admin')

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Cities</h1>
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
                <h3 class="card-title">Add city</h3>
            </div>
            <div class="card-body">
                <cities-store-form action="{{route('cities.store')}}"
                    @error('name') error-name="{{$message}}" @enderror
                    @error('country_id') error-country="{{$message}}" @enderror
                    @error('state_id') error-state="{{$message}}" @enderror
                    :countries="{{$countries}}"
                    :states="{{$states}}"
                >
                    <template slot="form-top">
                        @csrf
                    </template>
                </cities-store-form>
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <h3 class="card-title">Cities</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>State</th>
                        {{-- <th>created at</th> --}}
                        <th>deleted at</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cities as $city)
                    <tr>
                        <td>{{$city->id}}</td>
                        <td>{{$city->name}}</td>
                        <td>{{$city->country ? $city->country->name : ''}}</td>
                        <td>{{$city->state ? $city->state->name : ''}}</td>
                        {{-- <td>{{$category->created_at}}</td> --}}
                        <td>{{$city->deleted_at ? $city->deleted_at : ''}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="First group">
                                @if(!$city->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="confirm_form_before_submit(
                                        'cityDestroyForm-{{$city->id}}',
                                        'Remove the city',
                                        'Do you want to remove {{$city->name}}?',
                                        'question',
                                        'Delete'
                                    )"
                                >
                                    <i class="fas fa-trash"></i>
                                    <form action="{{route('cities.destroy', $city->id)}}" method="post"
                                        id="cityDestroyForm-{{$city->id}}"
                                    >
                                        @csrf @method('delete')
                                    </form>
                                </a>
                                @endif
                                @if($city->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="confirm_form_before_submit(
                                        'cityRestoreForm-{{$city->id}}',
                                        'Restore the city',
                                        'Do you want to restore the {{$city->name}}?',
                                        'question',
                                        'Restore'
                                    )"
                                    title="restore"
                                >
                                    <i class="fas fa-undo"></i>
                                    <form action="{{route('cities.restore', $city->id)}}" method="post"
                                        id="cityRestoreForm-{{$city->id}}"
                                    >@csrf</form>
                                </a>
                                @endif
                                <a href="{{route('cities.edit', $city->id)}}" type="button" class="btn btn-outline-secondary btn-sm">
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
            {{$cities->links()}}
        </div>
    </div>
</div>
@endsection