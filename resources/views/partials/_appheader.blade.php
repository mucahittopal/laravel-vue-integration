<!-- sidebar -->
<menu-sidebar :countries="{{$countries}}" :country-change-links="{{json_encode($country_change_links_in_url)}}" @if(request()->country_id) :request-country-id="{{request()->country_id}}" @endif
    @auth
    :auth="true" auth-name="{{auth()->user()->name}}"
    @if(auth()->user()->post) :auth-provide-service="false" @endif
    @endauth
    ></menu-sidebar>

<!-- login modal -->
<b-modal id="bv-modal-login" hide-footer hide-header header-class="modal-custom-header">
  
    <auth-form csrf-token="{{csrf_token()}}" err-login="@error('email') {{$message}}  @enderror"></auth-form>
</b-modal>

<header id="main-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <!-- logo -->
            <div class="col-lg-4">
                <div class="row align-items-center">
                    <div class="col-lg-12 col-8 col-sm-5">
                        <a href="/" class="header-logo">DESI WORKFORCE</a>
                    </div>
                    <div class="col-4 col-sm-7 d-sm-block d-md-block d-lg-none text-right">
                        <ul class="nav header-nav justify-content-end align-items-center">
                            @guest
                            <li class="nav-item d-none d-sm-none d-md-block">
                                <a href="javascript:;" class="nav-link" v-b-modal.bv-modal-login>Sign in / Sign Up</a>
                            </li>

                            @endguest
                            @auth
                            <li class="nav-item d-none d-sm-none d-md-block">
                                @include('partials.profile-dropdown-btn')
                            </li>
                            <li class="nav-item d-none d-sm-none d-md-block">
                                <a href="/provide-service" class="nav-link"><i class="fas fa-plus"></i> provide service</a>
                            </li>
                            <li class="nav-item d-none d-sm-none d-md-block">
                                <a href="javascript:;" class="nav-link" onclick="document.getElementById('logout-form').submit()">Logout</a>
                            </li>
                            @endauth
                            <li class="nav-item d-none d-sm-none d-md-block">
                                <div class="btn-group header-nav-dropdown">
                                    <button type="button" class="btn btn-outline-primary dropdown-toggle nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @if($countries->find(request()->country_id))
                                        {{$countries->find(request()->country_id)->name}}
                                        @else
                                        USA
                                        @endif
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @for($i = 0; $i < count($country_change_links_in_url); $i++) <a href="/?{{$country_change_links_in_url[$i]}}" class="dropdown-item" type="button">
                                            {{$countries[$i]->name}}
                                            </a>
                                            @endfor
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <a href="javascript:;" class="mobile-menu-bars d-md-none" v-b-toggle.menu-sidebar>
                            <i class="fas fa-bars"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- center -->
            <div class="col-lg-6">
                <div class="row align-items-center">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8 col-sm-8">
                        @yield('header-search')
                    </div>
                    <div class="col-lg-2 text-right d-none d-md-none d-lg-block">
                        <div>
                            @yield('profile-dropdown')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 d-none d-md-none d-lg-block">
                <ul class="nav header-nav justify-content-end">
                    @guest
                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link" v-b-modal.bv-modal-login>Sign In / Sign Up</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="/provide-service" class="nav-link"><i class="fas fa-plus"></i> provide service</a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link" onclick="document.getElementById('logout-form').submit()">Logout</a>
                    </li>
                    @endif
                </ul>
                <div class="text-right">
                    <div class="btn-group dropdown-link btn-text-light no-box-shadow">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if($countries->find(request()->country_id))
                            {{$countries->find(request()->country_id)->name}}
                            @else
                            USA
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            @for($i = 0; $i < count($country_change_links_in_url); $i++) <a href="/?{{$country_change_links_in_url[$i]}}" class="dropdown-item" type="button">
                                {{$countries[$i]->name}}
                                </a>
                                @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>