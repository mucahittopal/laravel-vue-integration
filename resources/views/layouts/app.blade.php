<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Desi Workforce</title>

    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}" defer></script>

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" /> -->
    <script src="https://kit.fontawesome.com/8dcd4633f1.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">

    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-KBNDZGQ');
    </script>
    <!-- End Google Tag Manager -->

    <meta property="og:url" content="http://desiworkforce.com" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Desiworkforce.com" />
    <meta property="og:description" content="Find a service" />

    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
    {{-- <meta property="og:image"         content="https://www.your-domain.com/path/image.jpg" /> --}}
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KBNDZGQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    {{-- facebook sdk --}}
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/az_AZ/sdk.js#xfbml=1&version=v7.0&appId=255047065821628&autoLogAppEvents=1" nonce="zo6EN22X"></script>



    <div id="app">
        @include('partials._appheader')

        <div id="top-fixed-banner" class="d-none">
            @yield('top-banner')
        </div>

        <div class="sticky-top-banner d-none">
            @yield('top-banner')
        </div>

        <main id="wrapper" class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <!-- --------------------------------------------- -->
                    <div class="col-lg-2 col-md-3">
                        @yield('quick-filters')
                    </div>
                    <!-- --------------------------------------------- -->
                    <div class="col-lg-8 col-md-7">
                        <div class="content py-3">
                            @if(session()->has('success'))
                            <div class="alert alert-success mt-4 mb-4" role="alert">
                                {{session()->get('success')}}
                            </div>
                            @elseif(session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{session()->get('error')}}
                            </div>
                            @endif
                            @yield('content')
                        </div>
                    </div>
                    <!-- --------------------------------------------- -->
                    <div class="col-md-2"></div>
                </div>
            </div>
        </main>

        <footer id="footer">
            <div class="container-fluid">
                <div class="col-lg-8 col-md-7 offset-lg-2 offset-md-3">
                    <ul>
                        <li><a @auth v-b-modal.profile-contact-modal @endauth @guest v-b-modal.bv-modal-login @endguest class="link text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-2"></div>
            </div>
            <div class="container-fluid">
                <div class="col-lg-8 col-md-7 offset-lg-2 offset-md-3">
                    <p class="text-warning">Desi Workforce is not affiliated to any businesses or Individual that are listed or advertised on this site and will not be liable for any products/services aquired from them.</p>
                </div>
            </div>
        </footer>


        <!-- when register first time modal -->
        @if(request()->logged == 'first_time')
        <provide-service-alert></provide-service-alert>
        @endif
        <!-- end ofwhen register first time modal -->


        {{-- logout form --}}
        <form action="{{route('logout')}}" method="post" class="d-none" id="logout-form">@csrf</form>

    </div><!-- end of #app -->


    <script src="/js/jquery.min.js"></script>
    @yield('scripts')
</body>

</html>