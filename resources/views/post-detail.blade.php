@extends('layouts.app')


@section('content')
<div class="profile-detail">
    <div class="user-profile-dashboard">
        <div class="user-profile-left-info">
            <div class="user-profile-img">
                <div class="img-wrapper">
                    <img src="{{$profile_photo}}">
                </div>
            </div>

            <div class="fixed-social-box py-4 d-none d-sm-none d-md-block">
                <social-share-box base-url="{{request()->url()}}"></social-share-box>
            </div>
        </div>

        <div class="user-profile-info">
            <table class="table table-borderless table-sm">
                <tr>
                    <td><span class="font-bold">Name: </span></td>
                    <td>{{$post->user->name}}</td>
                </tr>
                <tr>
                    <td><span class="font-bold">Rating: </span></td>
                    <td>
                        @if($post_rating[0] > 0)
                        @for($i = 1; $i <= $post_rating[0]; $i++) <span class="text-primary"><i class="fas fa-star"></i></span>
                            @endfor
                            @if($post_rating[1] >= 0.5)
                            <span class="text-primary"><i class="fas fa-star-half"></i></span>
                            @endif
                            @else
                            N/A
                            @endif
                    </td>
                </tr>
                @if($post->city)
                <tr>
                    <td><span class="font-bold">Location: </span></td>
                    <td>{{$post->city->name}}</td>
                </tr>
                @endif
                <tr>
                    <td><span class="font-bold">Cost per hour: </span></td>
                    <td>{{$post->hourly_rate}}$</td>
                </tr>
                <tr>
                    <td><span class="font-bold">Experience: </span></td>
                    <td>{{$post->experience}} years</td>
                </tr>
                <tr>
                    <td><span class="font-bold">Onsite service: </span></td>
                    <td>
                        @if($post->onsite_service == null)
                        N/A
                        @else
                        {{$post->onsite_service == 0 ? 'No' : 'Yes'}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><span class="font-bold">Services: </span></td>
                    <td>
                        @for($i = 0; $i < count($post->services); $i++)
                            {{ $post->services[$i]->name }}{{ isset($post->services[$i+1]) ? ', ' : '' }}
                            @endfor
                    </td>
                </tr>
                <tr>
                    <td><span class="font-bold">Languages: </span></td>
                    <td>
                        @for($i = 0; $i < count($post->languages); $i++)
                            {{ $post->languages[$i]->name }}{{ isset($post->languages[$i+1]) ? ', ' : '' }}
                            @endfor
                    </td>
                </tr>
            </table>
            <div class="user-profile-contact text-right mb-2">
                <button class="btn btn-primary btn-sm" @auth v-b-modal.profile-contact-modal @endauth @guest v-b-modal.bv-modal-login @endguest>Contact Me</button>
            </div>
            <div class="description py-1">
                <p class="font-bold mb-0">Description: </p>
                <p class="white-space-pre">
                    {{$post->description}}
                </p>
            </div>
            {{-- <div class="user-profile-gallery py-1">
                <image-gallery></image-gallery>
            </div> --}}
        </div>
        <div class="clearfix"></div>
    </div>

    <!-- profile reviews -->
    <div class="profile-reviews mt-5">
        <div class="">
            <h4 class="h4">{{$reviews->count}} Reviews</h4>
        </div>
        <div class="">
            <div class="row">
                <div class="col-sm-6 col-lg-8"></div>
                @if(auth()->check() && auth()->user()->id != $post->user_id)
                <div class="col-sm-6 col-lg-4">
                    <rate-form>
                        <div slot="top">
                            @csrf
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                        </div>
                    </rate-form>
                </div>
                @endif
            </div>
        </div>
        <div>
            <post-reviews post-id="{{$post->id}}" review-count="{{$reviews->count}}"></post-reviews>
        </div>
    </div>
    <!-- end of profile reviews -->
</div>


<profile-contact from-email="{{auth()->check() ? auth()->user()->email : ''}}" post-id="{{$post->id}}" @if(auth()->check() && auth()->user()->email_verified_at ) :email-verified="true" @endif
    ></profile-contact>
@endsection