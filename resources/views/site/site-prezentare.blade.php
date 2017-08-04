<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>GeoImage IO</title>

<!-- Bootstrap Core CSS -->
<link href="{{URL::asset('design/site/css/bootstrap.min.css')}}" rel="stylesheet">

<!-- Custom CSS -->
<link href="{{URL::asset('design/site/css/logo-nav.css')}}" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

	<!-- Navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<h2 style="color: red; cursor: pointer;" onclick= "window.location='/'">GeoImage IO</h2>
				</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse"
				id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="/admin/learn">Learn AI</a></li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container -->
	</nav>

	<!-- Page Content -->
	<div class="container" style="min-height: 400px;">
		<div class="row">
			<div class="col-lg-6" style="float: none; margin: auto;">
				<h1 style="text-align: center;">Welcome on our website</h1>
<br><br>
				<h4 style="text-align: center;">Enter pictures to check if was made at Galaciuc</h4>

				<form action="/check-pictures" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{csrf_token()}}"> 
					<input type="file" name="pictures[]" multiple class="form-control"><br>
					<br> <input type="submit" value="Trimite!" class="btn btn-danger form-control">
				</form>
			</div>
		</div>
	</div>
	<!-- /.container -->
	<br><br><br><br><br><br>
<footer class="footer">
		<p style="text-align: center">Made with <i style="color: red" class="glyphicon glyphicon-heart"></i> by Burcovschi David and Cosarca Tudor</p>
</footer>
	<!-- jQuery -->
	<script src="{{URL::asset('design/site/js/jquery.js')}}"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="{{URL::asset('design/site/js/bootstrap.min.js')}}"></script>

</body>

</html>




