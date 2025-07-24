<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{asset('frontend/css/content.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/css/boxicons.min.css') }}">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @yield('css')
</head>
<body>
<header class="header">
    <a href="index.html" class="logo">Tırnakçı Cafe</a>
</header>

<section class="card" id="card">
    <h2 class="heading">@yield('category')</h2>
    <div class="card-container">
        @yield('content')
    </div>
</section>


<section class="card" id="card">
    <div class="card-container">
        @yield('content')
    </div>
</section>

<script src="{{asset('frontend/js/script.js')}}"></script>
@yield('js')
</body>
</html>
