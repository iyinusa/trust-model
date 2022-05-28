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
                                	<h2><i class="ti-thought"></i> Moot <small class="text-muted"><?php echo $club.': '.character_limiter($moot,25); ?></small></h2>
                                </div>
                                
                                <div class="col-lg-12 mb25">
                                    <section class="panel bordered  post-comments">
                                    	<div class="media p15">
                                            <a class="pull-left" href="<?php echo base_url('fan/'.$fan_nicename); ?>">
                                                <img class="media-object avatar avatar-sm" src="<?php echo base_url($fan_pics_small); ?>" alt="">
                                            </a>
                                            <div class="comment">
                                                <div class="comment-author h6 no-m">
                                                    <a href="<?php echo base_url('fan/'.$fan_nicename); ?>"><b><?php echo $fan_display_name; ?></b> <small class="text-muted"><?php echo $club; ?></small></a>
                                                </div>
                                                <div class="comment-meta small"><?php echo $reg_date. ' ('.$reg_date_ago.')'; ?></div>
                                                <p>
                                                    <?php echo $moot; ?>
                                                </p>
                                                <p class="small">
                                                    <a href="javascript:;" class="text-muted mr10"><i class="ti-comment mr5"></i><?php echo $com_count; ?></a>
                                                    <!--<a href="javascript:;" class="text-muted mr10"><i class="ti-share mr5"></i>Share</a>-->
                                                </p>
                                                <p class="text-muted">
                                                	<div class="addthis_sharing_toolbox"></div>
                                                </p>
                                            </div>
                                        </div>
                                    </section>
                                    
                                    <section>
                                    	<div class="fb-comments" data-href="<?php echo base_url('moot/'.$pg_link) ?>" data-numposts="5" data-colorscheme="light" width="100%"></div>
                                    </section>
                                    
                                    <section class="panel bordered  post-comments">
                                    	<h5 class="text-muted p15"><i class="ti-thought"></i> Moot Trends (<?php echo $com_count; ?>)</h5>
										<div class="p15"><?php echo $moot_com_list; ?></div>
                                        <div id="mootit" class="p15"><?php echo $com_form; ?></div>
                                    </section>
                               	</div>
                                
                            </div>
                            
                            <div class="col-md-4">