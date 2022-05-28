<?php include(APPPATH.'libraries/inc.php'); ?>
<?php
    //get notification count in title
	if($log_user == TRUE){
		$top_obj =& get_instance();
		$top_obj->load->model('users');
		$gen_note_count = count($top_obj->users->query_notify_fan_unread($log_user_id));
		if($gen_note_count > 0){
			$gen_note='('.$gen_note_count.') ';
		} else {
			$gen_note='';
		}
	} else {$gen_note='';}
?>
<!DOCTYPE html>
<html class="no-js" lang="">
	
<head>
	<meta charset="UTF-8">
    <meta name="description" content="<?php echo app_meta_desc; ?>">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    
    <link rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.png">
    
    <title><?php echo $gen_note.$title; ?></title>
    
    <!-- stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
    <!-- /page level plugin styles -->
    
    <!-- core styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/animate.min.css">
    <!-- /core styles -->
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datepicker/datepicker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/timepicker/jquery.timepicker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/colorpicker/css/colorpicker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/bootstrap-colorpalette/bootstrap-colorpalette.css">
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/stepy/jquery.stepy.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/chosen/chosen.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.css">

    <!-- template styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/skins/palette.css" id="skin">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/fonts/font.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css">
    <!-- template styles -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- load modernizer -->
    <script src="<?php echo base_url(); ?>plugins/modernizr.js"></script>
    
</head>

<body>
    <div id="fb-root"></div>
	<script>
		//facebook
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=335966623275742&version=v2.0";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		
		//Google
		(function(i,s,o,g,r,a,m){
			i['GoogleAnalyticsObject']=r;
			i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)
			},i[r].l=1*new Date();
			a=s.createElement(o),m=s.getElementsByTagName(o)[0];
			a.async=1;
			a.src=g;
			m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	  
		ga('create', 'UA-59892347-1', 'auto');
		ga('send', 'pageview');
	</script>
    <div class="app horizontal-layout">
        <!-- top header -->
        <header class="header header-fixed navbar">

            <div class="brand">
                <!-- toggle offscreen menu -->
                <a href="javascript:;" class="ti-menu navbar-toggle off-left visible-xs" data-toggle="collapse" data-target="#hor-menu"></a>
                <!-- /toggle offscreen menu -->

                <!-- logo -->
                <a href="<?php echo base_url(); ?>" class="navbar-brand">
                    <img src="<?php echo base_url('img/logo.png'); ?>" alt="SFH">
                    <span class="heading-font">
                        SoccerFanHub
                    </span>
                </a>
                <!-- /logo -->
            </div>

            <div class="collapse navbar-collapse pull-left" id="hor-menu">
                <ul class="nav navbar-nav">
                    <li>
                    	<a href="<?php echo base_url('moots'); ?>">
                            <span><i class="ti-thought"></i> Moots</span>
                        </a>
                    </li>
                    
                    <li class="dropdown">
                        <a href="javascript:;" data-toggle="dropdown">
                            <span><i class="ti-cup"></i> Clubs</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo base_url('clubs'); ?>">
                                    <span><i class="ti-cup"></i> All Clubs</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('facts'); ?>">
                                    <span><i class="ti-book"></i> Facts</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('fans'); ?>">
                                    <span><i class="fa fa-users"></i> Fans</span>
                                </a>
                            </li>
                       	</ul>
                 	</li>
                    
                    <li>
                    	<a href="<?php echo base_url('wagers'); ?>">
                            <span><i class="ti-pulse"></i> Wagers</span>
                        </a>
                    </li>
                    
                    <?php
						if(($log_user == TRUE) && ($log_user_role == 'editor' || $log_user_role == 'administrator')){
							echo '
								<li class="dropdown">
									<a href="javascript:;" data-toggle="dropdown">
										<span><i class="ti-pencil"></i> Moderator</span>
										<b class="caret"></b>
									</a>
									<ul class="dropdown-menu">
										<li>
											<a href="'.base_url().'leagues/add">
												<span><i class="ti-pencil"></i> Manage Leagues</span>
											</a>
										</li>
										<li>
											<a href="'.base_url().'clubs/add">
												<span><i class="fa fa-trophy"></i> Manage Clubs</span>
											</a>
										</li>
										<li>
											<a href="'.base_url().'facts/add">
												<span><i class="ti-book"></i> Manage Club Facts</span>
											</a>
										</li>
									</ul>
								</li>
							';
						}
					?>
                    
                    <?php
						if(($log_user == TRUE) && ($log_user_role == 'administrator')){
							echo '
								<li class="dropdown">
									<a href="javascript:;" data-toggle="dropdown">
										<span><i class="ti-settings"></i> Admin</span>
										<b class="caret"></b>
									</a>
									<ul class="dropdown-menu">
										<li>
											<a href="'.base_url().'admin/accounts">
												<span><i class="ti-user"></i> Manage Users</span>
											</a>
										</li>
									</ul>
								</li>
							';
						}
					?>
                </ul>
            </div>

            <!--<ul class="nav navbar-nav">
                <li class="header-search">
                    <a href="javascript:;" class="toggle-search">
                        <i class="ti-search"></i>
                    </a>
                    
                    <div class="search-container">
                        <form role="search">
                            <input type="text" class="form-control search" placeholder="type and press enter">
                        </form>
                    </div>
                </li>
            </ul>-->

            <ul class="nav navbar-nav navbar-right">
				<?php if($log_user==TRUE){ ?> 
                    <?php include(APPPATH.'views/logics/user_notify.php'); ?>
                    <li class="hidden-xs notifications dropdown">
                        <a href="javascript:;" data-toggle="dropdown">
                            <i class="ti-bell"></i>
                            <div class="badge badge-top bg-danger animated flash">
                                <span><?php echo $rnew_count; ?></span>
                            </div>
                        </a>
                        <div class="dropdown-menu animated fadeInLeft">
                            <div class="panel panel-default no-m">
                                <div class="panel-heading small"><b><i class="ti-bell"></i> Notifications</b>
                                </div>
                                <ul class="list-group" style="max-height:300px; overflow:auto;">
                                    <?php echo $rn_list; ?>
                                </ul>
    
                                <div class="panel-footer">
                                    <a href="<?php echo base_url('notifications'); ?>">See all notifications</a>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php } ?>

                <li class="off-right">
                    <?php
						if($log_user == TRUE){
							echo '
								<a href="javascript:;" data-toggle="dropdown">
									<img src="'.base_url($log_user_pics_small).'" class="header-avatar img-circle" alt="user" title="user">
									<span class="hidden-xs ml10">'.$log_display_name.'</span>
									<i class="ti-angle-down ti-caret hidden-xs"></i>
									<div class="hidden-lg hidden-md hidden-sm badge badge-top bg-danger animated flash">
										<span>'.$rnew_count.'</span>
									</div>
								</a>
								<ul class="dropdown-menu animated fadeInDown">
									<li>
										<a href="'.base_url().'fan/'.$log_user_nicename.'"><i class="ti-user"></i>&nbsp; Profile</a>
									</li>
									<li>
										<a href="'.base_url().'notifications"><i class="ti-bell"></i>&nbsp;
											Notifications&nbsp;
											<div class="badge badge-right bg-danger animated flash">
												<span>'.$rnew_count.'</span>
											</div>
										</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="'.base_url().'upgrade"><i class="ti-shield"></i>&nbsp; Upgrade Pro</a>
									</li>
									<li>
										<a href="'.base_url().'wallet"><i class="ti-wallet"></i>&nbsp; Fund Wallet</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="'.base_url().'settings/photo"><i class="ti-camera"></i>&nbsp; Profile Photo</a>
									</li>
									<li>
										<a href="'.base_url().'settings/account"><i class="ti-settings"></i>&nbsp; Account</a>
									</li>
									<li>
										<a href="'.base_url().'settings/password"><i class="ti-key"></i>&nbsp; Change Password</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="'.base_url().'logout"><i class="ti-power-off"></i>&nbsp; Sign Out</a>
									</li>
								</ul>
							';	
						} else {
							echo '
								<a href="'.base_url().'register" class="pull-left heading-font hidden-xs">
									<i class="ti-user"> Join</i>
								</a>
								<a href="'.base_url().'login" class="pull-left heading-font">
									<i class="ti-key"> SignIn</i>
								</a>
							';
						}
					?>
                </li>
            </ul>
        </header>
        <!-- /top header -->
		