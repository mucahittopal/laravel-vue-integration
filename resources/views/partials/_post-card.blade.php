@php 
    $post_services = $post->services;
    $post_rating = post_rating($post);
    $post_languages = $post->languages;
    $get_profile_photo = $post->profile_photo_verified && $post->profile_photo
        ? get_profile_photo($post->profile_photo) : null;
    $profile_photo = $get_profile_photo && $get_profile_photo['thumbnail'] 
        ? $get_profile_photo['thumbnail'] : '/images/no-user.png';
@endphp


<!-- post card -->
<a href="{{route('post-detail', $post->id)}}" class="post-card-wrapper cbox-l1">
    <div class="post-card-top">
        <div class="post-card-img">
            <img src="{{$profile_photo}}">
        </div>
        <div class="post-card-top-info">
            <div class="post-card-username">{{$post->user_name}}</div>
            <div class="post-card-experience">
                @for($i = 0; $i < count($post_services); $i++)
                    {{ $post_services[$i]->name }}{{ isset($post_services[$i+1]) ? ' / ' : '' }}
                @endfor
            </div>
        </div>
    </div>
    <div class="row py-2">
        <div class="py-1 col-lg-4 col-6 font-bold">
            <span>{{$post->hourly_rate}}$</span> / hourly rate
        </div>
        @if($post->city)
        <div class="py-1 col-lg-4 col-6 font-bold">
            <span>{{$post->city->name}}</span> / Location
        </div>
        @endif
        <div class="py-1 col-lg-4 col-6 font-bold">
            @if($post_rating[0] > 0)
            <span>
                @for($i = 1; $i <= $post_rating[0]; $i++)
                    <span class="text-primary"><i class="fas fa-star"></i></span>
                @endfor
                @if($post_rating[1] >= 0.5)
                    <span class="text-primary"><i class="fas fa-star-half"></i></span>
                @endif
            </span>
            @else
                N/A
            @endif
            / rating
        </div>
        @if(count($post_languages))
        <div class="py-1 col-12 font-bold">
            <span>
            Spoken languages: 
            @for($i = 0; $i < count($post_languages); $i++)
                {{ $post_languages[$i]->name }}{{ isset($post_languages[$i+1]) ? ', ' : '' }}
            @endfor
            </span>
        </div>
        @endif
    </div>
    <div class="post-card-description text-ellipsis">
        {{$post->description}}
    </div>
</a>
<!-- end of post card -->