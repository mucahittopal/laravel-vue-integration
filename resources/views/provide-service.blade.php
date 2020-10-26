@extends('layouts.app')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Register Service</div>

                <div class="card-body">
                    @if(!auth()->user()->post)
                    <div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <provide-service csrf-token="{{csrf_token()}}"
                            @if(auth()->user()->profile_photo) :upload-profile-photo="false" @endif
                        ></provide-service>
                    </div>
                    @endif

                    @if(auth()->user()->post)
                        @if(auth()->user()->post->verified_at)
                            You have provided a service and it is active right now.
                        @else
                            You service is in verification period. It will be online after verification. 
                            Please be patient. Thanks.
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="https://www.google.com/recaptcha/api.js?render={{env('RECAPTCHA_V3_SITE_KEY')}}"></script>
@endsection