@extends('layouts.admin')

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>City: {{$city->name}}</h1>
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
                <h3 class="card-title">Edit city</h3>
            </div>
            <div class="card-body">
                <cities-store-form
                    action="{{route('cities.update', $city->id)}}"
                    :countries="{{$countries}}"
                    :states="{{$states}}"
                    :city="{{$city}}"
                    @error('name')  error-name="{{$message}}"  @enderror
                    @error('country_id')  error-name="{{$message}}"  @enderror
                    @error('state_id')  error-name="{{$message}}"  @enderror
                >
                    <template slot="form-top">@csrf @method('PUT')</template>
                </cities-store-form>
            </div>
        </div>
    </div>
</div>
@endsection