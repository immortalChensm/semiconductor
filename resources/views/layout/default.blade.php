<html>
<head>
    <title>@yield('title', 'App') - L</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/default.css">
    <script type="text/javascript" href="{{asset("js/bootstrap.js")}}"></script>
    <script type="text/javascript" href="/js/app.js"></script>
</head>
<body>
@include('layout._header')

<div class="container">
    @include("shared._message")
    @yield('content')
</div>
@include('layout._footer')
</body>
</html>