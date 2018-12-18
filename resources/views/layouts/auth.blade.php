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
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

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
    <div id="app">
        @include('layouts._header')
        <main class="py-4" style="background-color: rgb(26, 26, 26); height: 90vh">
            @yield('content')
        </main>
        @include('layouts._footer')
        @yield('customjsson')
    </div>
</body>
</html>
