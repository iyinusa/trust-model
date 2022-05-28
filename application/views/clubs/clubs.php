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
                                	<div class="col-xs-6">
                                    	<h2><i class="fa fa-trophy"></i> Clubs</h2>
                                    </div>
                                    
                                    <div class="col-xs-6 text-right">
                                        <div class="btn-group mr5 mt10">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><i class="ti-pencil"></i> Leagues
                                                <span class="ti-angle-down ml10"></span>
                                            </button>
                                            <?php
												$league_list = '';
												$count_club_all = 0;
												$count_club_item = 0;
												if(!empty($allleague)){
													foreach($allleague as $league){
														$inl =& get_instance();
														$inl->load->model('m_clubs');
														$count_club_all = count($inl->m_clubs->query_all_club());
														$count_club_item = count($inl->m_clubs->query_club_league_id($league->id));
														$league_list .= '
															<li><a href="javascript:;" data-filter=".'.$league->slug.'">'.ucwords($league->name).' ('.$count_club_item.')</a></li>
														';	
													}
												}
                                            ?>
                                            <ul class="dropdown-menu text-left filter" data-option-key="filter" role="menu" style="max-height:400px; overflow:auto;">
                                                <li><a href="javascript:;" data-filter="*">All Clubs (<?php echo $count_club_all; ?>)</a>
                                                </li>
                                                <?php echo $league_list; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="col-lg-12 mb25" />
                                
                                <div class="switcher view-grid col-lg-12">
                                    <div class="row feed">
                                        <?php
											$ins_obj =& get_instance();
											$ins_obj->load->model('m_clubs');
											$ins_obj->load->model('m_leagues');
											$ins_obj->load->model('m_moots');
											$club_list = '';
											$league = '';
											$league_slug = '';
											$fans = 0;
											$moots = 0;
											if(!empty($allclub)){
												foreach($allclub as $club){
													$league_id = $club->league_id;
													
													//get league
													$gl = $this->m_leagues->query_league_id($league_id);
													if(!empty($gl)){
														foreach($gl as $litem){
															$league = $litem->name;
															$league_slug = $litem->slug;;	
														}
													}
													
													//get fans
													$fans = count($this->m_clubs->query_club_fans($club->id));
													
													//get moots
													$moots = count($this->m_moots->query_moot_club($club->id));
													
													//get club colour code
													$sty_b = 'background-color:'.$club->colour;
													$sty_f = 'color:'.$club->fore_colour;
													$colour_b = 'style="'.$sty_b.'"';
													$colour_f = 'style="'.$sty_f.'"';
													
													$club_list .= '
														<div class="col-xs-12 col-sm-6 col-lg-4 switch-item '.$league_slug.'">
															<section class="panel no-b">
																<div class="panel-body">
																	<a href="'.base_url('club/'.$club->slug).'" class="show text-center">
																		<img width="128px" height="128px" src="'.base_url($club->pics_square).'" class="avatar avatar-lg img-circle" alt="">
																	</a>
							
																	<div class="show mt15 mb15 text-center">
																		<div class="h5"><b>'.$club->name.'</b>
																		</div>
																		<p class="show text-muted">
																			<small><i>'.$club->slogan.'</i><br /></small>
																			<b>'.$league.'</b>
																		</p>
																	</div>
							
																</div>
																<div class="panel-footer no-p no-b">
																	<div class="row no-m">
																		<div class="col-xs-4 bg-primary p10 text-center brbl">
																			<a href="'.base_url('club/'.$club->slug).'">
																				<b><span class="fa fa-users show mb5"></span>
																				'.$fans.'</b>
																			</a>
																		</div>
																		<div class="col-xs-4 p10 text-center" '.$colour_b.'>
																			<a href="'.base_url('club/'.$club->slug).'" '.$colour_f.'>
																				<b><span class="ti-thought show mb5"></span>
																				'.$moots.'</b>
																			</a>
																		</div>
																		<div class="col-xs-4 bg-primary p10 text-center brbr">
																			<a href="'.base_url('club/'.$club->slug).'">
																				<b><span class="ti-heart show mb5"></span>
																				Check</b>
																			</a>
																		</div>
																	</div>
																</div>
															</section>
														</div>
													';
												}
											}
										?>
                                        
                                        <?php echo $club_list; ?>
                                   	</div>
                               	</div>
                                
                                
                            </div>
                            
                            <div class="col-md-4">