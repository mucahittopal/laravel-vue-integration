@php
    $profile_photo = auth()->user()->profile_photo && auth()->user()->profile_photo_verified ?
        get_profile_photo(auth()->user()->profile_photo) : null;
    $profile_photo = $profile_photo ? get_profile_photo(auth()->user()->profile_photo)['thumbnail'] 
        : '/images/no-user.png';
@endphp

<div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle custom-dropdown-toggle profile-dropdown-btn" 
        type="button" 
        data-toggle="dropdown" 
        aria-haspopup="true" aria-expanded="false"
    >
        <div class="placeholder">
            <div class="placeholder-text">
                <span class="d-block">Hello</span>
                <span>{{auth()->user()->name}}</span>
            </div>
            <div class="placeholder-img">
                <div class="img-wrapper">
                    <img src="{{$profile_photo}}" alt="">
                </div>
            </div>
        </div>
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        <a href="{{route('home')}}" class="dropdown-item" type="button">Account</a>
        @if(!auth()->user()->post)
        <a href="{{route('provide-service')}}" class="dropdown-item" type="button">Provide service</a>
        @endif
        @if(auth()->user()->post)
        <a href="/edit-service" class="dropdown-item" type="button">Edit service</a>
        @endif
        <a href="javascript:;" class="dropdown-item" type="button"
            onclick="document.getElementById('logout-form').submit()"
        >Logout</a>
    </div>
</div>  