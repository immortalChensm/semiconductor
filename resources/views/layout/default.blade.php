<html>
<head>
    <title>@yield('title', 'App') - L</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
@include('layout._header')

<div class="container">
    @yield('content')
</div>
@include('layout._footer')
</body>
</html>