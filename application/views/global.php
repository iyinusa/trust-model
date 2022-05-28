<?php include(APPPATH.'libraries/inc.php'); ?>
		<section class="layout">
            <!-- main content -->
            <section class="main-content">
                <!-- content wrapper -->
                <div class="content-wrap">
                    <!-- inner content wrapper -->
                    <div class="wrapper">
                    	<div class="row">
                            <div class="col-lg-12">
                            	<?php if($global_log == TRUE){ ?>
									<?php if($log_user_club != $clubname && $log_user_club != 'No Club'){ ?>
                                    	<h2 class="text-center">SoccerFanHub <b><?php echo $log_user_club; ?></b> Fan not permitted to register as <b><?php echo $clubname; ?></b> Global Fan.</h2>
                                    <?php } else { ?>
										<?php if($clubname == 'Chelsea FC'){ ?>
                                            <h2 class="text-center" style="text-align:center;">Please fill the Form below and click on the Verify Account button to Insert your Chelsea Membership Number. <a data-toggle="modal" href="#model_verify" class="btn btn-info"><i class="fa fa-check"></i> Verify Account</a> Below</h2>
                							<style>
												
											</style>                            
                                            <iframe src="<?php echo $global_link; ?>" width="100%" frameborder="0" height="580px"></iframe>
                                        <?php } else { ?>
                                            <h2 class="text-center">Coming Soon!!!</h2>
                                        <?php } ?>
                                  	<?php } ?>
                                <?php } else { ?>
                                    <h1 class="text-center" style="text-transform:uppercase;">REGISTER WITH <?php echo $clubname; ?> Global Club</h1>
                                    <hr />
                                    <h2 class="text-center">
                                    	Join Network Using <i class="ti-angle-right"></i> <a href="<?php echo base_url(); ?>hauth/login/Facebook" class="btn btn-social btn-facebook"><i class="fa fa-facebook"></i> Facebook</a><br /><br />
                                        OR<br /><br />
                                        <a href="<?php echo base_url('login') ;?>">Login</a> | <a href="<?php echo base_url('register') ;?>">Register</a>
                                    </h2>
                                <?php } ?>
                            </div>                    	
                        </div>
                    </div>
                    </div>
                    
                </div>
                <!-- /inner content wrapper -->
            </div>
            <!-- /content wrapper -->
            <a class="exit-offscreen"></a>
        </section>
        <!-- /main content -->
    </section>
    
    <div id="model_verify" class="modal fade" style="text-align:center;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
              <h4 class="modal-title" id="myModalLabel"><i class="fa fa-check"></i> Verify <?php if(!empty($clubname)){echo $clubname;} ?> Membership</h4>
            </div>
            <div class="modal-body">
           		To make your account Verified and let other Fans knows you are a Verified Fan of your Club, you must Insert Membership Code Received after your registration with <?php if(!empty($clubname)){echo $clubname;} ?> Club.<br /><br />
                <b>PLEASE NOTE:</b> You must have registered with <?php if(!empty($clubname)){echo $clubname;} ?> before this process. Thanks
                <h4><?php if(!empty($clubname)){echo $clubname;} ?> Membership Code:</h4>
                <input type="text" class="form-control" id="codevalue" />
                <div id="send_code_reply"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-sm btn-success" onclick="send_code();"><i class="fa fa-check"></i> Submit</button>
              
              <script type="text/javascript">
				  function send_code(){
					  var hr = new XMLHttpRequest();
					  var codevalue = document.getElementById('codevalue').value;
					  var c_vars = "codevalue="+codevalue;
					  hr.open("POST", "<?php echo base_url('settings/submit_code'); ?>", true);
					  hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					  hr.onreadystatechange = function() {
						  if(hr.readyState == 4 && hr.status == 200) {
							  var return_data = hr.responseText;
							  document.getElementById("send_code_reply").innerHTML = return_data;
						 }
					  }
					  hr.send(c_vars);
					  document.getElementById("send_code_reply").innerHTML = "<i class=\"icon-spin4 animate-spin loader\"></i>";
				  }
			  </script>
            </div>
          </div>
        </div>
    </div>
    
    <!-- core scripts -->
    <script src="<?php echo base_url(); ?>plugins/jquery-1.11.1.min.js"></script>
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>plugins/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/jquery.easing.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/appear/jquery.appear.js"></script>
    <script src="<?php echo base_url(); ?>plugins/jquery.placeholder.js"></script>
    <script src="<?php echo base_url(); ?>plugins/fastclick.js"></script>
    <!-- /core scripts -->

    <!-- page level scripts -->
    <script src="<?php echo base_url(); ?>plugins/jquery.blockUI.js"></script>
    <script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?php echo base_url(); ?>plugins/jquery.sparkline.js"></script>
    <script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.js"></script>
    <script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?php echo base_url(); ?>plugins/count-to/jquery.countTo.js"></script>
    <!-- /page level scripts -->
    
    <!-- page level scripts -->
    <script src="<?php echo base_url(); ?>plugins/isotope/isotope.pkgd.min.js"></script>
    <!-- /page level scripts -->

    <!-- page script -->
    <!--<script src="<?php echo base_url(); ?>js/dashboard.js"></script>-->
    <!-- /page script -->
    
    <!-- page level scripts -->
    <script src="<?php echo base_url(); ?>plugins/chosen/chosen.jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.js"></script>
    <!-- /page level scripts -->
    
    <!-- page level scripts -->
    <script src="<?php echo base_url(); ?>plugins/wysiwyg/bootstrap-wysiwyg.js"></script>
    <script src="<?php echo base_url(); ?>plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
    <!-- /page level scripts -->
    
    <!-- page script -->
	<script src="<?php echo base_url(); ?>js/bootstrap-datatables.js"></script>
    <script src="<?php echo base_url(); ?>js/datatables.js"></script>
    <!-- /page script -->
    
    <!-- page script -->
	<script src="<?php echo base_url(); ?>plugins/stepy/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/stepy/jquery.stepy.js"></script>
    <script src="<?php echo base_url(); ?>plugins/fuelux/wizard.js"></script>
	<script src="<?php echo base_url(); ?>js/form-wizard.js"></script>
    <!-- /page script -->
    
    <!-- page script -->
    <script src="<?php echo base_url(); ?>plugins/daterangepicker/moment.js"></script>
    <script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>plugins/timepicker/jquery.timepicker.min.js"></script>
	<script src="<?php echo base_url(); ?>plugins/colorpicker/js/bootstrap-colorpicker.js"></script>
    <script src="<?php echo base_url(); ?>plugins/bootstrap-colorpalette/bootstrap-colorpalette.js"></script>
	<script src="<?php echo base_url(); ?>js/pickers.js"></script>
    <script src="<?php echo base_url(); ?>js/validate.js"></script>
    
    <?php if($page_active=='wallet'){ ?>
    <script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.js"></script>
    <script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.categories.js"></script>
    <script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.stack.js"></script>
    <script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.time.js"></script>
    <script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.orderBars.js"></script>
    <script src="<?php echo base_url(); ?>plugins/flot/jquery.flot.pie.js"></script>
    <script src="<?php echo base_url(); ?>plugins/jquery.sparkline.js"></script>
    <script src="<?php echo base_url(); ?>plugins/jquery.easing.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/easy-pie-chart/jquery.easypiechart.js"></script>
    <script src="<?php echo base_url(); ?>plugins/raphael.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/morris/morris.js"></script>
    <script src="<?php echo base_url(); ?>plugins/chartjs/Chart.min.js"></script>
    <?php } ?>
    
    <script src="<?php echo base_url(); ?>js/general.js"></script>
    
    <!-- page script -->
    <script src="<?php echo base_url(); ?>js/catalog.js"></script>
    
    <!-- template scripts -->
    <script src="<?php echo base_url(); ?>js/offscreen.js"></script>
    <script src="<?php echo base_url(); ?>js/main.js"></script>
    <!-- /template scripts -->
    
    <?php if($page_active=='wallet'){ ?>
    <script src="<?php echo base_url(); ?>js/chart.js"></script>
    <?php } ?>
    
    <!-- scripts -->
	<script type="text/javascript">
        $(document).ready(function() {
			$('#sfhtblist').dataTable();
		} );
    </script>
    
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54f059895825b165" async="async"></script>
</body>
<!-- /body -->
</html>

                            