@extends('layouts.app')

@section('header-search')
<!-- header search section -->
<form class="header-search-section d-flex align-items-center" id="header-search-form" >
    <search-any 
        data-value="{{request()->service}}"
        data-name="service"
        data-endpoint="/api/search/service-or-tag"
        data-placeholder="Service"
        data-accessor="name"
    ></search-any>
    <location-search-box data-ltype="{{request()->location_type}}" data-keyword="{{request()->location?request()->location: $settings['city']}}" :request-country-id="{{request()->country_id ? request()->country_id : 1}}"></location-search-box>
    @if(request()->country_id)
    <input type="hidden" name="country_id" value="{{request()->country_id}}">
    @endif
    @if(request()->language_ids)
    @foreach (request()->language_ids as $item)
    @if($item) <input type="hidden" name="language_ids[]" value="{{$item}}"> @endif
    @endforeach
    @endif
    @if(request()->gender)
    <input type="hidden" name="gender" value="{{request()->gender}}">
    @endif
    @if(request()->hourly_rate_min)
    <input type="hidden" name="hourly_rate_min" value="{{request()->hourly_rate_min}}">
    @endif
    @if(request()->hourly_rate_max)
    <input type="hidden" name="hourly_rate_max" value="{{request()->hourly_rate_max}}">
    @endif
    @if(request()->experience_years)
    <input type="hidden" name="experience_years" value="{{request()->experience_years}}">
    @endif
    <div>
        <button class="header-search-button btn btn-primary btn-sm">
            Search
        </button>
    </div>
</form>
<!-- end of header search section -->
@endsection

@section('top-banner')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">asd</div>
        <div class="col-lg-6">asd</div>
        <div class="col-lg-3">asd</div>
    </div>
</div>
@endsection

@section('quick-filters')
<div id="filterFormWrapper" class="quick-filters-wrapper pt-3 d-none d-sm-none d-md-block">
    <div class="container-fluid no-padding-on-mobile">
        <div class="font-bold h5">Filter by:</div>
        <filters-form @if(request()->language_ids) :request-language-ids="{{json_encode(request()->language_ids)}}" @endif
            @if(request()->gender) request-gender="{{request()->gender}}" @endif
            @if(request()->hourly_rate_min) :request-hourly-rate-min="{{request()->hourly_rate_min}}" @endif
            @if(request()->hourly_rate_max) :request-hourly-rate-max="{{request()->hourly_rate_max}}" @endif
            @if(request()->service) request-service="{{request()->service}}" @endif
            @if(request()->location_type) request-location-type="{{request()->location_type}}" @endif
            @if(request()->location) request-location="{{request()->location}}" @endif
            @if(request()->country_id) request-country-id="{{request()->country_id}}" @endif
            @if(request()->sort_by) request-sort-by="{{request()->sort_by}}" @endif
            @if(request()->experience_years) request-experience-years="{{request()->experience_years}}" @endif
            ></filters-form>
    </div>
</div>
@endsection

@section('profile-dropdown')
@auth
@include('partials.profile-dropdown-btn')
@endauth
@endsection


@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div @click="open_filter_form">
                <div class="d-md-none">
                    <span class="font-bold"><i class="fas fa-filter"></i> @{{filterLabel}}</span>
                </div>
            </div>
            <div>
                <div class="d-flex align-items-center">
                    <span class="font-bold pr-2">Sort by</span>
                    <div>
                        <form action="/" id="sort-form">
                            @if(request()->service)
                            <input type="hidden" name="service" value="{{request()->service}}">
                            @endif
                            @if(request()->location_type)
                            <input type="hidden" name="location_type" value="{{request()->location_type}}">
                            @endif
                            @if(request()->location)
                            <input type="hidden" name="location" value="{{request()->location}}">
                            @endif
                            @if(request()->country_id)
                            <input type="hidden" name="country_id" value="{{request()->country_id}}">
                            @endif
                            @if(request()->language_ids)
                            @foreach (request()->language_ids as $item)
                            <input type="hidden" name="language_ids[]" value="{{$item}}">
                            @endforeach
                            @endif
                            @if(request()->gender)
                            <input type="hidden" name="gender" value="{{request()->gender}}">
                            @endif
                            @if(request()->hourly_rate_min)
                            <input type="hidden" name="hourly_rate_min" value="{{request()->hourly_rate_min}}">
                            @endif
                            @if(request()->hourly_rate_max)
                            <input type="hidden" name="hourly_rate_max" value="{{request()->hourly_rate_max}}">
                            @endif
                            @if(request()->experience_years)
                            <input type="hidden" name="experience_years" value="{{request()->experience_years}}">
                            @endif
                            <select class="form-control form-control-sm" onchange="document.getElementById('sort-form').submit()" name="sort_by">
                                <option value="" @if(!request()->sort_by) selected @endif>Featured</option>
                                <option value="cph_l_to_h" @if(request()->sort_by == 'cph_l_to_h') selected @endif>Cost per hour (Low to High)</option>
                                <option value="exp_h_to_l" @if(request()->sort_by == 'exp_h_to_l') selected @endif>Experience (High to Low)</option>
                                <option value="exp_l_to_h" @if(request()->sort_by == 'exp_l_to_h') selected @endif>Experience (Low to High)</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <div class="row">
        <div class="col-12">
            @foreach($posts as $post)
            @include('partials._post-card', $post)
            @endforeach
        </div>
        <div class="col-12">
            {{-- {{$posts->withQueryString()->links()}} --}}
            @if($posts->total() > 10)
            <div>
                <custom-pagination :last-page="{{$posts->lastPage()}}" base-url="{{request()->url()}}" http-params="{{http_build_query(request()->except('page'))}}"></custom-pagination>
            </div>
            @endif
            @if($posts->total() == 0)
            <div>
                <h3>Sorry, no results found!</h3>
                <p>Please check the spelling or try searching for something else</p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(function(){
        $('#header-search-form').on('submit', function(e){
            // validation code here
            const location = $("#header-search-form input[name='location']").val()
            if(location.trim().length < 1) {
                alert('Please enter city')
                e.preventDefault();
            }
        });
    })

</script>
@endsection