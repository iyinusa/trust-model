<!DOCTYPE html style="width:100%; margin:auto;">
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" lang="en"> <![endif]-->
<html lang="en">
<!--<![endif]-->
<head>
  	<meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <style>
    	.e_header {
			border-bottom:1px solid #0CF; padding:10px;
			overflow:auto;
		}
		.e_sub_header {
			padding:10px; margin-bottom:10px; border-bottom:1px solid #0CF;
		}
		.e_body {
			padding:10px;	
		}
		.e_footer {
			border-top:1px solid #0CF; padding:10px; margin-top:10px;
		}
		.email_btn {
			text-decoration:none;
			padding:10px 35px;
			background-color:#06C;
			text-align:center;
			font-weight:bold;
			color:#fff;
		}
    </style>
    
</head>
<body>
	<div style="width:95%; background-color:#eee; margin:auto; padding:10px;">
        <div style="background-color:#fff; border:1px solid #999; margin:auto;">
            <div class="e_header">
                <a href="<?php base_url(); ?>"><img alt="SFH " src="<?php echo base_url(); ?>img/logo.png" style="float:left; margin-right:10px;" /> <br /><h1><?php echo app_name; ?></h1></a>
            </div>
            <div class="e_sub_header">
                <strong><?php echo $subhead; ?></strong>
            </div>
            <div class="e_body">
                <?php echo $message; ?>
            </div>
            <div class="e_footer">
                <strong><?php echo app_name; ?> Team</strong><br />
                <small>
                	<i><?php echo app_email; ?></i><br />
                    <i><?php echo app_website; ?></i><br />
                    <i><small>Product of Steve Aderibigbe</small></i><br />
                </small>
            </div>
        </div>
    </div>
</body>
</html>