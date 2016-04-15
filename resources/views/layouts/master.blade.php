<!DOCTYPE html>
<html>
    <head>
        <title>Portal - @yield('title')</title>
        <link href="/css/img/favicon.png" rel="icon" type="image/x-icon">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="/css/styles.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        @show
        <div class="container">
            <div class="sidebar">
                @yield('sidebar')
            </div>
            <div class="content">
                @yield('content')
            </div>
            <div class="footer">
                &copy; Garan24 2016
            </div>
        </div>

        <div class="overlay"></div>
        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="/js/garan.js"></script>
        @yield('scripts')
        @if(isset($routeback))
        <script>
            window.location = "{{$routeback}}";
        </script>
        @endif
    </body>
</html>
