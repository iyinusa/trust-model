<?php include(APPPATH.'libraries/inc.php'); ?>
		<section class="layout">
            <!-- main content -->
            <section class="main-content">
                <!-- content wrapper -->
                <div class="content-wrap">
                    <!-- inner content wrapper -->
                    <div class="wrapper">
                    	<div class="row">
                            <div class="col-md-2">
                                <!-- profile information sidebar -->
                                <div class="panel overflow-hidden no-b profile p15">
                                    <div class="row mb25">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                    <img src="<?php echo base_url($club_pics); ?>" alt="" class="avatar avatar-lg img-circle avatar-bordered">
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                    <figure>
                                                        <h3><?php echo $club_name; ?></h3>
                                                        <small class="text-muted"><?php echo $club_slogan; ?></small>
                                                        <br />
                                                        <?php echo $club_league; ?><br />
                                                        <?php
															if($log_user == TRUE){
																if($log_user_club_id != $club_id){
																	echo '
																		<a class="btn btn-primary" href="'.base_url('club/'.$club_slug.'?join='.$club_id).'"><i class="ti-check-box"></i> Join Club</a>'.$club_msg.'
																	';
																} else {
																	echo '
																		<a class="btn btn-danger" href="'.base_url('club/'.$club_slug.'?leave='.$club_id).'"><i class="ti-close"></i> Leave Club</a>
																	';	
																}
															}
														?>
                                                    </figure>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 mt25 text-center bt">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <h2 class="mb0"><b><?php if($club_moot_count >= 100000){echo number_format(99999).'+';}else{echo number_format($club_moot_count);} ?></b></h2> 
                                                <small>Club Moots</small>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <h2 class="mb0"><b><?php if($club_moot_reply_count >= 100000){echo number_format(99999).'+';}else{echo number_format($club_moot_reply_count);} ?></b></h2> 
                                                <small>Club Trends</small>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <h2 class="mb0"><b><?php if($club_moot_all >= 100000){echo number_format(99999).'+';}else{echo number_format($club_moot_all);} ?></b></h2> 
                                                <small>Global Moots</small>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="row mb15">
                                        <div class="col-xs-12">
                                            <h5 class="heading-font"><b>About <?php echo $club_name; ?></b></h5>
                                            <p><?php echo $club_bio; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- /profile information sidebar -->
                            </div>
                            
                            <div class="col-md-6 mb25">
								<h2><i class="ti-book"></i> <?php echo $fact_year; ?> Facts</h2>
                                <p class="text-muted">
                                    <div class="addthis_sharing_toolbox"></div>
                                </p>
                                <?php echo $fact_details; ?>
                                <br /><br />
                                <div class="col-lg-12">
                                	<div class="fb-comments" data-href="<?php echo base_url('fact/'.$pg_link) ?>" data-numposts="5" data-colorscheme="light" width="100%"></div>
                                </div>
                                <hr />
                                <div class="col-lg-12">
                                    <h4><i class="ti-book"></i> More <?php echo $club_name; ?> Facts</h4>
                                    <?php
										$ino =& get_instance();
										$ino->load->model('m_facts');
										$more_fact_list = '';
										$more_fact = $ino->m_facts->query_fact_club_id($club_id);
										if(!empty($more_fact)){
											foreach($more_fact as $more){
												if($fact_id != $more->id){
													$more_fact_list .= '
														<a href="'.base_url('fact/'.$more->id).'" class="col-lg-12 panel">
															<div class="panel-body">
																<b>'. $more->fact_year.':</b>&nbsp;
																'.character_limiter($more->fact_details,100).'
															</div>
														</a>
													';
												}
											}
										}
									?>
                                    
                                    <?php
										if($more_fact_list == ''){
											echo '<h5 class="text-muted">No More Facts</h5>';	
										} else {
											echo $more_fact_list;
										}
									?>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">

                            