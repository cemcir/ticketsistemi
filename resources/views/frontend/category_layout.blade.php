<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/boxicons.min.css') }}">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @yield('css')
</head>
<body>
    <header class="header">
        <a href="index.html" style="text-align: center" class="logo">Tırnakçı Cafe</a>
    </header>

    <section class="card" id="card">
        <div class="card-container">
            <h2 class="heading">@yield('category')</h2>
            @yield('content')
        </div>
    </section>

    <script src="{{asset('frontend/js/script.js')}}"></script>
    @yield('js')
</body>
</html>


