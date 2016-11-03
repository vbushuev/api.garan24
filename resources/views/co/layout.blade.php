<!DOCTYPE html>
<!-- saved from url=(0096)https://magnitolkin.ru/catalogue/videoregistratory/Videoregistrator_DataKam_G5-FAMILY_CITY_REAL/ -->
<html>
<head>

	<title>Garan24 Checkout</title>
	<meta name="robots" content="index, all">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="/css/img/logo_garan24.png" rel="icon" type="image/x-icon">
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<!--<link rel="stylesheet" href="/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">-->

	<link rel="Stylesheet" href="/css/jquery-ui.min.css" type="text/css">
	<link rel="Stylesheet" href="/css/co.css" type="text/css">
	<!-- no local use
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	-->

	<script src="/js/jquery-2.1.4.min.js"></script>
	<script src="/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="/js/jquery-ui.min.js"></script>
	<script src="/js/jquery.color.js"></script>
	<script src="/js/jquery.redirect.js"></script>
	<script src="/js/jquery.maskedinput.min.js"></script>
	<script src="/js/api/1.0/garan24.core.js"></script>
	<script src="/js/api/1.0/garan24.delivery.js"></script>
	<script src="/js/api/1.0/garan24.customer.js"></script>
	<script src="/js/api/1.0/garan24.cart.js"></script>
	<!-- Google Analytics -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-84557375-3', 'auto');
	  ga('send', 'pageview');
	  $=jQuery.noConflict();
	</script>
	<!-- boxberry API -->
</head>
<body>
@yield('toper')
<div id="wrapper" class="container">
	<div id="header" class="row">
		<!--<ul class="nav">
			<li class="nav-item logo">ГАРАН <code>24</code></li>
			<li class="nav-item"><a href="{{$shop_url or '#'}}">Вернуться к витрине</a></li>
		</ul>-->
		@include($viewFolder.'.scale')

	</div>
	<div id="content" class="row">
		<!--<h1>
			@if(isset($title))
				{!!$title!!}
			@else
				<i class="first">Оформление</i> заказа
			@endif
		</h1>-->
		@if(isset($deal))
		<div class="cart col-xs-12 col-sm-12 col-md-6 col-lg-6">
			@include($viewFolder.'.goods',['goods'=>$deal->order->getProducts()])
		</div>
		<div id="form" class="form col-xs-12 col-sm-12 col-md-6 col-lg-6">
			@include($viewFolder.'.helper')
		@else
		<div id="form" class="form col-xs-12 col-sm-12 col-md-12 col-lg-12">
		@endif
			@yield('content')
		</div>

	</div>
	<!--
	<div id="footer">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					Гаран24© 2016

			</div>

		</div>
	</div>-->
</div>
<script src="/js/responsibility.js"></script>
</body>
</html>
