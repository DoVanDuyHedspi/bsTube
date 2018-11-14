<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="https://fonts.gstatic.com"> -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">


    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'user' => [
                'id' => Auth::check() ? Auth::user()->id : null,
                'following' => Auth::check() ? Auth::user()->following()->pluck('users.id') : null
            ],
        ]);

        ?>
    </script>
</head>
<body>
    <div id="wrap" style="background-image: url(images/mu.jpg); background-size: 100% 92%;">
        <div class="bg-mae">
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#nav-collapsible"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                    </button><a class="navbar-brand" href="{{ route('root') }}">HANOI</a>
                </div>
                <div class="collapse navbar-collapse" id="nav-collapsible">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Account<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <!-- Authentication Links -->
                                @guest
                                <li>
                                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                <li>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}">
                                            {{ __('Register') }}
                                        </a>
                                    @endif
                                </li>
                                @else
                                <li>
                                    <a href="#">My Channel</a>
                                    <a href="#">Profile</a>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                                @endguest
                            </ul>
                        </li>
                    </ul>
                    <div class="visible-lg">
                        <div class="navbar-form navbar-right">
                            @guest
                            @else
                                welcome,
                                <a href="{{ route('users', Auth::user()->username) }}">
                                    {{ Auth::user()->username }}
                                </a>
                                <span> | </span>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </nav>
            @yield('content')
        </div>
    </div>
    <footer id="footer">
        <div class="container">
            <p class="text-muted credit">Copyright © 2013-2018 Calvin Montgomery</p>
        </div>
    </footer>
</body>
</html>
