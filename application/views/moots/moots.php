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
                                	<h2><i class="ti-thought"></i> Moots <small class="text-muted">Clubs Debates</small></h2>
                                </div>
                                
                                <hr class="col-lg-12 mb25" />
                                
                                <div class="col-lg-12 mb25">
                                    <?php if($log_user!=FALSE || $log_user_club_id!=0 || $log_user_club_ban!=0){ ?>
                                        <section class="panel bordered">
                                            <form method="post" action="<?php echo base_url(); ?>moots/" id="postmoot">
                                                <textarea id="moot" name="moot" placeholder="What's your moot?" rows="2" class="form-control no-b"></textarea>
                                                <div class="panel-footer clearfix no-b">
                                                    <!--<div class="pull-left">
                                                        <button class="btn bg-none btn-sm" type="button">
                                                            <i class="ti-camera"></i>
                                                        </button>
                                                        <button class="btn bg-none btn-sm" type="button">
                                                            <i class="ti-video-camera"></i>
                                                        </button>
                                                        <button class="btn bg-none btn-sm" type="button">
                                                            <i class="ti-time"></i>
                                                        </button>
                                                    </div>-->
                                                    <div class="pull-right">
                                                        <button type="submit" id="submit-moot" class="btn btn-primary btn-sm">&nbsp;&nbsp;&nbsp;<i class="ti-thought"></i> Moot Now&nbsp;&nbsp;&nbsp;</button>
                                                    </div>
                                                </div>
                                            </form>
                                		</section>
                            		<?php } ?>
                                    
                                    <section id="sfhscroll" class="panel bordered  post-comments">
    
                                        <?php include(APPPATH.'views/logics/moot_list.php'); ?>
                                        
                                        <div id="moot-msg"></div>
                                        
                                        <?php echo $moot_list; ?>
                                        
                                    </section>
                               	</div>
                                
                            </div>
                            
                            <div class="col-md-4">