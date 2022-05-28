<?php include(APPPATH.'libraries/inc.php'); ?>
        <div class="container-fluid">
            <div id="filter">
              <h4><i class="fa fa-key"></i> Change Password</h4></div>
            
            <div class="row">
            	<div class="col-lg-6">
                	<div class="panel panel-default">
                  		<div class="panel-body">
							<?php echo $err_msg; ?>
                            <?php echo form_open('settings/password') ?>
                                <div class="form-group">
                                    <?php echo form_error('old'); ?>
                                    <input type="password" name="old" placeholder="Old password" class="input-lg form-control">
                                </div>
                                <div class="form-group">
                                    <?php echo form_error('new'); ?>
                                    <input type="password" name="new" placeholder="New password" class="input-lg form-control">
                                </div>
                                <div class="form-group">
                                    <?php echo form_error('confirm'); ?>
                                    <input type="password" name="confirm" placeholder="Confirm password" class="input-lg form-control">
                                </div>
                                
                                <button type="submit" class="btn btn-primary stepy-finish pull-left"><i class="fa fa-save"></i> Update Password</button>
                            <?php echo form_close() ?>
                       	</div>
                    </div>
                </div>
          	</div>      
        </div>