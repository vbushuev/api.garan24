<!DOCTYPE html>
<html>
<head>

	<title>G24 {{$title or ''}}</title>
	<meta name="robots" content="index, all">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="/css/img/logo_garan24.png" rel="icon" type="image/x-icon">
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="Stylesheet" href="/css/jquery-ui.min.css" type="text/css">
	<link rel="Stylesheet" href="/css/co.css" type="text/css">
	<script src="/js/jquery-2.1.4.min.js"></script>
	<script src="/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="/js/jquery-ui.min.js"></script>
	<script src="/js/jquery.color.js"></script>
	<script src="/js/jquery.redirect.js"></script>
	<script src="/js/jquery.maskedinput.min.js"></script>
	<script src="/js/api/1.0/garan24.core.js"></script>
	<script src="/js/api/1.0/garan24.delivery.js"></script>
	<script src="/js/api/1.0/garan24.customer.js"></script>
	<!-- Google Analytics -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	  ga('create', 'UA-80175137-3', 'auto');
	  ga('send', 'pageview');
	</script>
</head>
<body>
	<div id="wrapper" class="container">
		<div id="header" class="row">
			<ul class="nav">
				<li class="nav-item logo">ГАРАН <code>24</code></li>
			</ul>
		</div>
		<div id="content" class="row">
			<div id="form" class="form col-xs-12 col-sm-12 col-md-12 col-lg-12">
				@yield('content')
			</div>

		</div>
		<div id="footer">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<a href="//garan24.ru/" title="Вернуться на главную страницу">
						Гаран24© 2016
					</a>
				</div>

			</div>
		</div>
	</div>
	<script src="/js/responsibility.js"></script>
</body>
</html>
