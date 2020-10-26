@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">

            <div class="card-body">
                
                <auth-form csrf-token="{{csrf_token()}}" err-login="@error('email') {{$message}}  @enderror"></auth-form>

            </div>
        </div>
    </div>
</div>
@endsection
