<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('index') }}">
                    <i class="fas fa-hotel"></i>&nbsp;{{config('app.name')}}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="navbar-nav mr-auto">
                        @if (Auth::user()->admin)
                        <li class="nav-item"><a class="nav-link" href="{{ route('getPendingUsers') }}"><i class="fas fa-user-plus"></i>&nbsp;Pending Registration Requests <span class="adge badge-pill badge-primary">{{ $pending_registration_requests_count ?? '' }}</span></a></li>
                        @elseif (Auth::user()->admin==0)
                        @if (Auth::user()->approved_at!=null)
                        <li class="nav-item"><a class="nav-link" href="{{ route('getBookingRequests') }}"><i class="fas fa-star"></i>&nbsp;Booking Requests <span class="badge badge-pill badge-secondary">{{ $booking_requests_count ?? '' }}</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('newHostel') }}"><i class="fas fa-plus"></i>&nbsp;Add new hostel</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('listHostel') }}"><i class="fas fa-bars"></i>&nbsp;View my hostels</a></li>
                        @endif
                        @endif
                    </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <span class="p-1 border border-secondary border-left-0 border-top-0 border-bottom-0 text-right">Account Section<br>(Admin & Manager)</span>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="disabled nav-link">Logged In As: </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}&nbsp;<i class="fas fa-sign-out-alt"></i>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 container">
            @if (session('status'))
            <div class="alert alert-dark alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>{{ session('status') }}</h3>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(1000, 0).slideUp(1000, function() {
            $(this).remove();
        });
    }, 5000);
</script>
@yield('script')

<footer>
    Copyright&copy; 2020 - {{ date('Y') }} | NITESH SAH
</footer>

</html>