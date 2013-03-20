<!DOCTYPE html>
<html>
<head>
<title>Bootstrap 101 Template</title>
<!-- Bootstrap -->
<link href="<?php echo base_url(); ?>/assets/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet">

</head>
<body>
<h1>Hello, world!</h1>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>
<div class="navbar">
	<div class="navbar-inner">
	<ul class="nav">
		<li><a href="#">Home</a></li>
		<li class="active"><a href="#">Login</a></li>
		<li><a href="#">Contact</a></li>
		<li><a href="#">Help</a></li>
	</ul>
	</div>
</div>
<div class="row-fluid">
<div class="span4">Hi, this a left</div>
<div class="span8">Hi, this a right</div>
</div>
</body>
</html>