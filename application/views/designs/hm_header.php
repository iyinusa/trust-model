<!DOCTYPE html>
<html>
	
<head>
        <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.ico">
		
        <title><?php echo $title; ?></title>
		
		<!-- Maniac stylesheets -->
        <!--<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/animate/animate.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrapValidator/bootstrapValidator.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/iCheck/all.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" />-->
        
        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
    
        <!-- Custom styles for this template -->
        <link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet">
    
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
    
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <script src="<?php echo base_url(); ?>assets/js/modernizr.custom.js"></script>
	</head>
	
    <body>
    
    <div id="fb-root"></div>
	<script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=289455051150681&version=v2.0";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

	<!-- Menu -->
	<nav class="menu" id="theMenu">
		<div class="menu-wrap">
			<h1 class="logo"><a href="<?php echo base_url(); ?>#home">BD</a></h1>
			<i class="fa fa-arrow-right menu-close"></i>
			<a href="<?php echo base_url(); ?>">Welcome</a>
			<!--<a href="services.html">Services</a>-->
			<a href="<?php echo base_url('ourvalues'); ?>">Our Values</a>
            <a href="#services">Services</a>
            <a href="<?php echo base_url('blog'); ?>">Blogs</a>
			<a href="<?php echo base_url('meetus'); ?>">Meet Us</a>
			<a href="#contact">Contact</a>
			<a href="https://www.facebook.com/Brandszevous" target="_blank"><i class="fa fa-facebook"></i></a>
			<a href="https://www.twitter.com/brandszevous" target="_blank"><i class="fa fa-twitter"></i></a>
            <a href="http://instagram.com/brandszevous" target="_blank"><i class="fa fa-instagram"></i></a>
			<a href="mailto:info@brandszevous.com"><i class="fa fa-envelope"></i></a>
		</div>
		
		<!-- Menu button -->
		<div id="menuToggle"><i class="fa fa-bars"></i></div>
	</nav>