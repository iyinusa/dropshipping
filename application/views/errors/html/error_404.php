<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$root = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
?><!DOCTYPE html>
<html class="no-js" lang="en">

	<head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <meta name="description" content="">
	  <meta name="author" content="">
	  <link rel="shortcut icon" href="<?php echo $root; ?>assets/img/favicon.png">
	  <title>404 Page Not Found | CIS Portal</title>
	  
	  <!-- Bootstrap core CSS -->
	  <link href="<?php echo $root; ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	  
	  <!-- Custom fonts for this template -->
	  <link href="<?php echo $root; ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	  
	  <!-- Custom fonts for this template -->
	  <link href="<?php echo $root; ?>assets/plugins/themify/css/themify.css" rel="stylesheet" type="text/css">
	  
	  <!-- Page level plugin CSS -->
	  <link href="<?php echo $root; ?>assets/css/animate.css" rel="stylesheet">
	  
	  <!-- Custom styles for this template -->
	  <link href="<?php echo $root; ?>assets/css/glovia.css" rel="stylesheet">
	  <link href="<?php echo $root; ?>assets/css/glovia-responsive.css" rel="stylesheet">
	  
	  <!-- Custom styles for Color -->
	  <link id="jssDefault" rel="stylesheet" href="<?php echo $root; ?>assets/css/skins/default.css">
	</head>

	<body>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<section class="error-page text-center">
					<h1 class="gredient-cl">404</h1>
					<h3 class="theme-cl">Opps! Page Not Found</h3>
					<p>The page you are looking for can't be found.</p>
					<a href="<?php echo $root; ?>" class="btn cl-white no-br gredient-bg">Go To Portal</a>
				</section>
			</div> 
		</div>

		<script src="<?php echo $root; ?>assets/plugins/jquery/jquery.min.js"></script>
	</body>
</html>