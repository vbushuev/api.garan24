<!DOCTYPE html>
<html>
    <head>
        <title>Garan24 - @yield('title')</title>
        <link href="css/img/logo_garan24.png" rel="icon" type="image/x-icon">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <link href="css/styles.css" rel="stylesheet" type="text/css">
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
        <script src="js/jquery-ui.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

        <script src="js/jquery.color.js"></script>
        <script src="js/jquery.redirect.js"></script>
        <script src="js/jquery.maskedinput.min.js"></script>
        <!--<script src="js/garan.js"></script>-->
        <script src="js/responsibility.js"></script>
        @yield('scripts')
        @if(isset($routeback))
        <script>
            document.location.href = "{{$routeback}}";
        </script>
        @endif
    </body>
</html>
