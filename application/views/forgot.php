<?php include(APPPATH.'libraries/inc.php'); ?>
        <section class="layout">
            <!-- main content -->
            <section class="main-content">
                <!-- content wrapper -->
                <div class="content-wrap">
                    <!-- inner content wrapper -->
                    <div class="wrapper">
                    	<div class="row">
                            <div class="col-md-8">
                            	<div class="col-lg-12">
                                	<h2><i class="ti-key"></i> Reset Password</h2>
                                </div>
                                
                                <div class="col-lg-12 mb25">
                                	<?php echo $err_msg; ?>
                                    
                                    <?php if(isset($_GET['stamp']) && isset($_GET['email'])){ ?>
										<?php $post_page = 'forgot?stamp='.$_GET['stamp'].'&email='.$_GET['email']; ?>
                                        <?php echo form_open($post_page) ?>
                                          <div class="form-group">
                                            <?php echo form_error('new'); ?>
                                            <label class="control-label"><h4>New password</h4></label><br />
                                            <input name="new" type="password" placeholder="Choose new password" class="form-control input-lg">
                                          </div>
                                          <div class="form-group">
                                            <?php echo form_error('confirm'); ?>
                                            <label class="control-label"><h4>Confirm new password</h4></label><br />
                                            <input name="confirm" type="password" placeholder="Confirm new password" class="form-control input-lg"> 
                                          </div>
                                          <button name="change" type="submit" class="btn btn-primary stepy-finish pull-left"><i class="ti-share mr5"></i> Reset Password</button>
                                        <?php echo form_close() ?>
                                    <?php } else { ?>
										<?php echo form_open('forgot') ?>
                                            <div class="form-group">
                                                <?php echo form_error('email'); ?>
                                                <label><h4>Your Email Address:</h4></label><br />
                                                <input name="email" type="email" placeholder="Your Email Address" class="form-control input-lg">
                                            </div>
                                            
                                            <button name="send" type="submit" class="btn btn-primary stepy-finish pull-left"><i class="ti-share mr5"></i> Reset Password</button>
                                        <?php echo form_close() ?>
                                  	<?php } ?>
                               	</div>
                                
                            </div>
                            
                            <div class="col-md-4">