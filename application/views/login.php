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

      <div class="lock-container">
        <h1>Account Access</h1>
        <div class="panel panel-default text-center">
          <!--<a href="<?php echo base_url(); ?>hauth/login/Facebook" class="btn btn-social btn-sm btn-facebook mr5"><i class="fa fa-facebook"></i> Facebook</a>
          <br /><br />-->
          <div class="panel-body">
            <?php echo $err_msg; ?>
          
			<?php echo form_open('login') ?>
            <input class="form-control" type="text" name="username" placeholder="Enter Username" value="<?php echo set_value('email'); ?>" required>
            <input class="form-control" type="password" name="password" placeholder="Enter Password" required>

            <button class="btn btn-primary">Login <i class="fa fa-fw fa-unlock-alt"></i></button>
            <?php echo form_close(); ?>
            
            <!--<a href="javascript:;" class="forgot-password">Forgot password?</a>-->
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