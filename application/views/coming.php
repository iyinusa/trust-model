<!DOCTYPE html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en-gb" xml:lang="en-gb" class="no-js"> <!--<![endif]-->

<head>
	<meta charset="utf-8">
    <!--[if lt IE 9]> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <![endif]-->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="SoccerFanHub">
	<meta name="viewport" content="width=device-width, initial-scale=1">   
    
    <link rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.png"> 
    
	<!-- Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="<?php echo base_url(); ?>coming/styles/reset_css.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>coming/styles/basic.css" type="text/css">
    
    <!-- Icon-Font -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>coming/font-awesome/font-awesome/css/font-awesome.min.css" type="text/css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="font-awesome/font-awesome/css/font-awesome-ie7.min.css" type="text/css">
    <![endif]-->
 
 	<link rel="stylesheet" href="<?php echo base_url(); ?>coming/swiper/idangerous.swiper.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>coming/styles/main.css" type="text/css">
    
    <!--[if IE 8]>
        <link rel="stylesheet" href="styles/ie8.css" type="text/css">
    <![endif]-->
    
	<script src="<?php echo base_url(); ?>coming/js/modernizr-custom.js" type="text/javascript"></script>
        
	<title><?php echo $title; ?></title>
</head>

<body>
<!--[if (gt IE 9)|!(IE)]><!-->
<script type="text/javascript">
//IE11 issue - in modernizr it looks like transitions 3d are supported, but "transform-style: preserve-3d;" is not - https://github.com/Modernizr/Modernizr/issues/762
(function getPerspective(){
  var element = document.createElement('p'),
      html = document.getElementsByTagName('HTML')[0],
      body = document.getElementsByTagName('BODY')[0],
      propertys = {
        'webkitTransformStyle':'-webkit-transform-style',
        'MozTransformStyle':'-moz-transform-style',
        'msTransformStyle':'-ms-transform-style',
        'transformStyle':'transform-style'
      };

    body.insertBefore(element, null);

    for (var i in propertys) {
        if (element.style[i] !== undefined) {
            element.style[i] = "preserve-3d";
        }
    }

    var st = window.getComputedStyle(element, null),
        transform = st.getPropertyValue("-webkit-transform-style") ||
                    st.getPropertyValue("-moz-transform-style") ||
                    st.getPropertyValue("-ms-transform-style") ||
                    st.getPropertyValue("transform-style");

    if(transform!=='preserve-3d'){
      html.className += ' no-preserve-3d';
    }
    document.body.removeChild(element);
})();
</script>
<!--<![endif]-->

    <div id="main-content">
        <div id="page-loader"></div>
    	<div id="background">
        	<div id="background-image"></div>
        </div><!-- background -->
        
        <div class="content">
            <div id="swiper" class="swiper-container">
                <!-- Slides -->
                <div class="swiper-wrapper">
                    <!--Slide-->
                    <div class="swiper-slide">
                    	<div class="slide-content">
                            <div class="wrapper">
                                <div class="slide-head">
                                    <h1>
                                    	<img src="<?php echo base_url('img/logo.png'); ?>" alt="SFH"><br />
                                        SoccerFanHub
                                    </h1>
                                    <p>World's No 1 Soccer Club Fans Network</p>
                                    <p>Join Network. Stay Connected With Fans. Let Your Voice Be Heard.</p>
                                </div><!-- slide-head -->
                                <div class="counter-placeholder"></div>
                                <div class="slide-bottom">
                                    <p>Email me when it's live</p>
                                    <div class="form-email-container no-border">
                                        <div id="cube">
                                            <a href="#"><div class="cube-slide cube-slide-1"></div></a>
                                            <div class="cube-slide cube-slide-2 cube-form-slide">
                                                <form id="notice-me" action="<?php echo base_url(); ?>" method="post" data-opening-error-msg="Thank you" data-success-msg="Thanks for your interest" data-ajax-fail-msg="Ajax could not contact the script." data-email-not-set-msg="Please enter a valid email address.">
                                                    <input name="email" type="text" placeholder="email">
                                                    <input type="submit" value="Send">
                                                
                                                    <div class="ajax-loader"></div>
                                                </form>
                                            </div>
                                            <div class="cube-slide cube-slide-3 tooltip-trigger"></div>
                                            
                                            <div class="return-msg tooltip-trigger"></div>
                                        </div><!-- cube -->
                                    </div><!-- form-email-container -->
                                </div><!-- slide-bottom -->
                            </div><!-- wrapper -->
                        </div><!-- slide-content -->
                    </div><!-- swiper-slide -->
                </div><!-- swiper-wrapper -->
            </div><!-- swiper -->
        </div><!-- content -->
        
    	<div id="counter">
        	<div class="counter-item days">
            	<div class="counter-item-name">days</div>
                <div class="counter-item-value">
                	<div class="days-val prev"></div>
                    <div class="days-val current"></div>
                    <div class="days-val next"></div>
                </div>
            </div><!-- counter-item -->
            <div class="counter-item hours">
            	<div class="counter-item-name">hours</div>
                <div class="counter-item-value">
                	<div class="hours-val prev"></div>
                    <div class="hours-val current"></div>
                    <div class="hours-val next"></div>
                </div>
            </div><!-- counter-item -->
            <div class="counter-item minutes">
            	<div class="counter-item-name">minutes</div>
                <div class="counter-item-value">
                	<div class="minutes-val prev"></div>
                    <div class="minutes-val current"></div>
                    <div class="minutes-val next"></div>
                </div>
            </div><!-- counter-item -->
            <div class="counter-item seconds">
            	<div class="counter-item-name">seconds</div>
                <div class="counter-item-value">
                	<div class="seconds-val prev"></div>
                    <div class="seconds-val current"></div>
                    <div class="seconds-val next"></div>
                </div>
            </div><!-- counter-item -->
        </div><!-- counter -->
        
        <div id="socials">
            <a href="https://facebook.com/soccerfanhub" target="_blank"><i class="icon-facebook"></i></a>
            <a href="https://twitter.com/soccerfanhub" target="_blank"><i class="icon-twitter"></i></a>
        </div><!-- socials -->
        <div id="footer">
        	<span id="copyright-sign">&copy; 2015 SoccerFanHub, All Rights Reserved<br /><br />
            	<!-- Site Meter -->
				<script type="text/javascript" src="http://s30.sitemeter.com/js/counter.js?site=s30sfhmeter">
                </script>
                <noscript>
                <a href="http://s30.sitemeter.com/stats.asp?site=s30sfhmeter" target="_top">
                <img src="http://s30.sitemeter.com/meter.asp?site=s30sfhmeter" alt="Site Meter" border="0"/></a>
                </noscript>
                <!-- Copyright (c)2009 Site Meter -->
            </span>
        </div><!-- footer -->
    </div><!-- main-content -->
    
	<script src="<?php echo base_url(); ?>coming/js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>coming/js/jquery.easing.1.3.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>coming/js/placeholder-fallback.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>coming/swiper/idangerous.swiper-2.1.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>coming/js/jquery.countdown.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>coming/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>coming/js/custom.js" type="text/javascript"></script>
</body>

</html>
