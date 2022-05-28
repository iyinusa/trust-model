	<!-- SERVICES SECTION -->
	<div id="services">
    	<marquee behavior="scroll" direction="left" onmousemove="this.stop();" onmouseout="this.start();">
		<div class="container">
			<div class="row mt">
				<div class="col-lg-1 centered">
					<i class="fa fa-certificate"></i>
				</div>
				<div class="col-lg-3">
					<h3>Cloths</h3>
					<p>We are best in quality design of Shirts, Trousers, Male Blazers, Jalamias, Male Natives, Female Blazers, Female Natives, Polo.</p>
				</div>

				<div class="col-lg-1 centered">
					<i class="fa fa-question-circle"></i>
				</div>
				<div class="col-lg-3">
					<h3>Promotion</h3>
					<p>We specialize in relevant concept for your business profitability through world class creation of Logos, Office Correspondence, Marketing/Promotional Materials.</p>
				</div>
			
			
				<div class="col-lg-1 centered">
					<i class="fa fa-globe"></i>
				</div>
				<div class="col-lg-3">
					<h3>Global Services</h3>
					<p>We engage in several services such as IT Consultancy, Business/Career Seminar Presentation, Communinity Services.</p>
				</div>
			</div>
		</div>
        </marquee>
	</div>
        
        <!-- BLOG POSTS -->
        <?php
			$ins_obj =& get_instance();
			$ins_obj->load->model('blogs');
			$hm_recent = '';
			$h_category = '';
			$h_count = 1;
			if(!empty($h_allblog)){
				foreach($h_allblog as $hmb){
					$h_cat_id = $hmb->cat_id;
										
					$hgc = $this->blogs->query_blog_cat_id($h_cat_id);
					if(!empty($hgc)){
						foreach($hgc as $h_citem){
							$h_category = $h_citem->cat;	
						}
					}
					
					if($h_count <= 3){
						$hm_recent .= '
							<div class="col-lg-4">
								<img class="img-responsive" src="'.base_url($hmb->pics_small).'" alt="">
								<h3><a href="'.base_url('blog/'.$hmb->slug).'">'.character_limiter($hmb->title,45).'</a></h3>
								<p class="small"><i class="fa fa-calendar"></i> '.$hmb->post_date.' | <i class="fa fa-book"></i> '.$h_category.' | <i class="fa fa-eye"></i> '.$hmb->views.' Views</p>
								<p><a href="'.base_url('blog/'.$hmb->slug).'" target="_blank"><i class="fa fa-link"></i> Read More</a></p>
							</div>
						';
					}
					
					$h_count += 1;
				}
			}
		?>
        <div class="container">
            <div class="row mt">
                <div class="col-lg-12">
                    <h1>Recent Posts</h1>
                </div><!-- col-lg-12 -->
                <div class="col-lg-8">
                    <p>Our latests thoughts about things that only matters to us.</p>
                </div><!-- col-lg-8-->
                <div class="col-lg-4 goright">
                    <p><a href="#"><i class="fa fa-angle-right"></i> See All Posts</a></p>
                </div>
            </div><!-- row -->
            
            <div class="row mt">
                <?php echo $hm_recent; ?>		
            </div><!-- row -->
        </div><!-- container -->
        
        <div style="clear:both;"
        
        <!-- CLIENTS LOGOS -->
        <!--<div id="lg">
            <div class="container">
                <div class="row centered">
                    <div class="col-lg-2 col-lg-offset-1">
                        <img src="assets/img/clients/c01.gif" alt="">
                    </div>
                    <div class="col-lg-2">
                        <img src="assets/img/clients/c02.gif" alt="">
                    </div>
                    <div class="col-lg-2">
                        <img src="assets/img/clients/c03.gif" alt="">
                    </div>
                    <div class="col-lg-2">
                        <img src="assets/img/clients/c04.gif" alt="">
                    </div>
                    <div class="col-lg-2">
                        <img src="assets/img/clients/c05.gif" alt="">
                    </div>
                </div>
            </div>
        </div>--><!-- dg -->
        
        
        <!-- CALL TO ACTION -->
        <div id="call">
            <div class="container">
                <div class="row">
                    <h3>THIS IS A CALL TO ACTION</h3>
                    <div class="col-lg-8 col-lg-offset-2">
                        <p>You can request your design by clicking below.</p>
                        <p><a href="<?php echo base_url('request'); ?>" class="btn btn-green btn-lg">Request Design/Buy Now!</a></p>
                    </div>
                </div>
            </div>
        </div><!-- Call to action -->
        
        <div class="container">
            <div class="row mt">
                <div class="col-lg-12">
                    <h1>Stay Connected</h1>
                    <p>Join us on our social networks for all the latest updates, product/service announcements and more.</p>
                    <br>
                </div>
            </div>
        </div><!-- container -->
        
        
        <!-- SOCIAL FOOTER --->
        <section id="contact"></section>
        <div id="sf">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 dg">
                        <h4 class="ml">FACEBOOK</h4>
                        <p class="centered"><a href="https://www.facebook.com/Brandszevous" target="_blank"><i class="fa fa-facebook"></i></a></p>
                        <p class="ml">> Become A Friend</p>
                    </div>
                    <div class="col-lg-3 lg">
                        <h4 class="ml">TWITTER</h4>
                        <p class="centered"><a href="https://www.twitter.com/brandszevous" target="_blank"><i class="fa fa-twitter"></i></a></p>
                        <p class="ml">> Follow Us</p>
                    </div>
                    <div class="col-lg-3 dg">
                        <h4 class="ml">GOOGLE +</h4>
                        <p class="centered"><a href="https://plus.google.com/107174930720033583835/" target="_blank"><i class="fa fa-google-plus"></i></a></p>
                        <p class="ml">> Add Us To Your Circle</p>
                    </div>
                    <div class="col-lg-3 lg">
                        <h4 class="ml">INSTAGRAM</h4>
                        <p class="centered"><a href="http://instagram.com/brandszevous/" target="_blank"><i class="fa fa-instagram"></i></a></p>
                        <p class="ml">> Join Our World</p>
                    </div>
                </div><!-- row -->
            </div><!-- container -->
        </div><!-- Social Footer -->
        
        <!-- CONTACT FOOTER --->
        <div id="cf">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div id="mapwrap">
                            <iframe height="400" width="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.es/maps?t=m&amp;ie=UTF8&amp;ll=6.506143,3.377432&amp;spn=6.506143,3.377432&amp;z=6&amp;output=embed"></iframe>
                        </div>	
                    </div><!--col-lg-8-->
                    <div class="col-lg-4">
                        <h4>ADDRESS<br/>Lagos - Head Office</h4>
                        <br>
                        <p>
                            Sabo Yaba,<br/>
                            Lagos, Nigeria.
                        </p>
                        <p>
                            DL1: +234 806 897 7601<br/>
                            DL2: +234 803 487 3682<br/>
                            E: <a href="mailto:info@brandszevous.com">info@brandszevous.com</a>
                        </p>
                        <p>Feel free to contact us at your leisure time, we are always at your service</p>
                        <!-- Site Meter -->
						<script type="text/javascript" src="http://s30.sitemeter.com/js/counter.js?site=s30brandszevous">
                        </script>
                        <noscript>
                        	<a href="http://s30.sitemeter.com/stats.asp?site=s30brandszevous" target="_top">
                        		<img src="http://s30.sitemeter.com/meter.asp?site=s30brandszevous" alt="Site Meter" border="0"/>
                          	</a>
                        </noscript>
                        <!-- Copyright (c)2009 Site Meter -->
						<br />
                        <?php if($this->session->userdata('logged_in') == TRUE){ ?>
                        	<a href="<?php echo base_url('dashboard'); ?>">Dashboard</a>&nbsp;|&nbsp;
                        <?php } else { ?>
                        	<a href="<?php echo base_url('login'); ?>">Sign In</a>&nbsp;|&nbsp;
                        <?php } ?>
						<a href="<?php echo base_url('webmail'); ?>" target="_blank">WebMail</a>
                    </div><!--col-lg-4-->
                </div><!-- row -->
            </div><!-- container -->
        </div><!-- Contact Footer -->
        
    
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
       <!-- <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>-->
        <script src="<?php echo base_url(); ?>js/plugins/jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/plugins/jquery-ui/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/masonry.pkgd.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/imagesloaded.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/classie.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/AnimOnScroll.js"></script>

		<!-- Interface -->
        <script src="<?php echo base_url(); ?>js/plugins/pace/pace.min.js" type="text/javascript"></script>
		
		<!-- Forms -->
        <script src="<?php echo base_url(); ?>js/plugins/bootstrapValidator/bootstrapValidator.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
		
		<script type="text/javascript">
			function swap(one, two) {
				document.getElementById(one).style.display = 'block';
				document.getElementById(two).style.display = 'none';
			}
			
			new AnimOnScroll( document.getElementById( 'grid' ), {
                minDuration : 0.4,
                maxDuration : 0.7,
                viewportFactor : 0.2
            } );
			
			new AnimOnScroll( document.getElementById( 'grid2' ), {
                minDuration : 0.4,
                maxDuration : 0.7,
                viewportFactor : 0.2
            } );
			
			//iCheck
			$("input[type='checkbox'], input[type='radio']").iCheck({
				checkboxClass: 'icheckbox_minimal',
				radioClass: 'iradio_minimal'
			});
			
			$(document).ready(function() {
				$('#loginform').bootstrapValidator({
					message: 'This value is not valid',
					fields: {
						username: {
							message: 'The username is not valid',
							validators: {
								notEmpty: {
									message: 'The username is required and can\'t be empty'
								}
							}
						},
						password: {
							validators: {
								notEmpty: {
									message: 'The password is required and can\'t be empty'
								}
							}
						}
					}
				});
				
				$('#regform').bootstrapValidator({
					message: 'This value is not valid',
					fields: {
						username: {
							message: 'The username is not valid',
							validators: {
								notEmpty: {
									message: 'The username is required and can\'t be empty'
								}
							}
						},
						password: {
							validators: {
								notEmpty: {
									message: 'The password is required and can\'t be empty'
								}
							}
						}
					}
				});
			});
		</script>
    </body>
</html>