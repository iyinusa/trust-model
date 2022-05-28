<!DOCTYPE html>
<html class="hide-sidebar ls-bottom-footer" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php echo $title; ?></title>
  <link href="<?php echo base_url(); ?>css/vendor/all.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/app/app.css" rel="stylesheet">

</head>

<body class="login">

  <div id="content">
    <div class="container-fluid">

      <div class="lock-container" style="max-width:100%;">
        <h1>Join Network</h1>
        <div class="panel panel-default text-center">
          <!--<a href="<?php echo base_url(); ?>hauth/login/Facebook" class="btn btn-social btn-sm btn-facebook mr5"><i class="fa fa-facebook"></i> Facebook</a>
          <br /><br />-->
          <div class="panel-body">
            <?php echo $err_msg; ?>
            
            <?php
				if($form_access == FALSE){
					$btn = 'style="display:none;"';
				} else {
					$btn = '';
				}
				
				if(!empty($invitee)){
					$invited_by = 'INVITATION BY<hr /><h3 class="text-center text-muted text-primary">'.strtoupper($invitee).'</h3><hr />';
				} else {$invited_by = '';}
			?>
            
            <?php echo $invited_by; ?>
                                  
			<?php echo form_open('register') ?>
                <div class="col-md-6">
                    <div class="form-group mr5">
                        <input type="hidden" name="invitee_id" value="<?php echo $invitee_id; ?>" >
                        <input name="name" type="text" placeholder="Display Name" class="form-control" value="<?php echo set_value('name'); ?>">
                    </div>
                    <div class="form-group mr5">
                        <input name="username" type="text" placeholder="Username" class="form-control" value="<?php echo set_value('username'); ?>">
                    </div>
                    <div class="form-group mr5">
                        <input name="password" type="password" id="inputPassword" placeholder="Password" class="form-control" value="<?php echo set_value('password'); ?>">
                    </div>
                    <div class="form-group mr5">
                        <input name="confirm" type="password" id="inputPassword" placeholder="Confim Password" class="form-control" value="<?php echo set_value('confirm'); ?>">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mr5">
                        <input name="email" type="email" placeholder="yours@email.com" class="form-control" value="<?php echo $invite_email; ?>" readonly>
                    </div>
                    <div class="form-group mr5">
                        <input name="phone" type="text" placeholder="Phone" class="form-control" value="<?php echo set_value('phone'); ?>">
                    </div>
                    <div class="form-group mr5">
                        <select name="sex" class="form-control">
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                       	</select>
                    </div>
                    <div class="form-group mr5">
                        <?php
							$country_list = '';
							if(!empty($allcountry)){
								foreach($allcountry as $country){
									$country_list .= '<option value="'.$country->id.'">'.ucwords($country->name).'</option>';	
								}
							}
						?>
                        
                        <select name="country" class="form-control">
                          <?php echo $country_list; ?>
                        </select>
                    </div>
                    
                    <div class="form-group mr5">
                        <!--<div class="checkbox"> 
                            <label class="checkbox-custom"> 
                                <input type="checkbox" name="checkboxA" checked="checked"> Agree the <a data-toggle="modal" href="#model_tos">terms and policy</a>
                            </label> 
                        </div>-->
                        <!--<div>
                            <?php echo $recaptcha_html; ?>
                        </div>-->
                        <button type="submit" class="form-control btn btn-info btn-lg" <?php echo $btn; ?>><i class="fa fa-user"></i> Join Network <i class="ti-arrow-circle-right"></i></button>
                        <p class="text-muted text-right"><small>Already have an account?</small> <a href="<?php echo base_url(); ?>login" class="btn btn-default btn-sm"><i class="fa fa-key"></i> Sign In <i class="ti-angle-right"></i></a></p>
                        
                    </div>
                </div>
                
              <?php echo form_close() ?>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <strong><?php echo app_name; ?></strong> &copy; Copyright <?php echo date('Y'); ?> | By Steve Aderibigbe
  </footer>
  <!-- // Footer -->
  <script>
    var colors = {
      "danger-color": "#e74c3c",
      "success-color": "#81b53e",
      "warning-color": "#f0ad4e",
      "inverse-color": "#2c3e50",
      "info-color": "#2d7cb5",
      "default-color": "#6e7882",
      "default-light-color": "#cfd9db",
      "purple-color": "#9D8AC7",
      "mustard-color": "#d4d171",
      "lightred-color": "#e15258",
      "body-bg": "#f6f6f6"
    };
    var config = {
      theme: "social-2",
      skins: {
        "default": {
          "primary-color": "#16ae9f"
        },
        "orange": {
          "primary-color": "#e74c3c"
        },
        "blue": {
          "primary-color": "#4687ce"
        },
        "purple": {
          "primary-color": "#af86b9"
        },
        "brown": {
          "primary-color": "#c3a961"
        },
        "default-nav-inverse": {
          "color-block": "#242424"
        }
      }
    };
  </script>

  <script src="<?php echo base_url(); ?>js/vendor/all.js"></script>
  <script src="<?php echo base_url(); ?>js/app/app.js"></script>

</body>
</html>