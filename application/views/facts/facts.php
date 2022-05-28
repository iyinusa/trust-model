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
                                    	<h2><i class="ti-book"></i> Club Facts</h2>
                                    </div>
                                    
                                    <div class="col-xs-6 text-right">
                                        <div class="btn-group mr5 mt10">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><i class="ti-cup"></i> Clubs
                                                <span class="ti-angle-down ml10"></span>
                                            </button>
                                            <?php
												$club_list = '';
												$count_fact_all = 0;
												$count_fact_item = 0;
												if(!empty($allclub)){
													foreach($allclub as $club){
														$inl =& get_instance();
														$inl->load->model('m_facts');
														$count_fact_all = count($inl->m_facts->query_all_fact());
														$count_fact_item = count($inl->m_facts->query_fact_club_id($club->id));
														$club_list .= '
															<li><a href="javascript:;" data-filter=".'.$club->slug.'">'.ucwords($club->name).' ('.$count_fact_item.')</a></li>
														';	
													}
												}
                                            ?>
                                            <ul class="dropdown-menu text-left filter" data-option-key="filter" role="menu" style="max-height:400px; overflow:auto;">
                                                <li><a href="javascript:;" data-filter="*">All Clubs (<?php echo $count_fact_all; ?>)</a>
                                                </li>
                                                <?php echo $club_list; ?>
                                            </ul>
                                        </div>
                                        
                                        <div class="btn-group view-options mt10" data-toggle="buttons">
                                            <label class="btn btn-primary btn-sm active" data-view="grid">
                                                <input type="radio" name="options" id="option1">
                                                <i class="ti-view-grid"></i>
                                            </label>
                                            <label class="btn btn-primary btn-sm" data-view="list">
                                                <input type="radio" name="options" id="option2">
                                                <i class="ti-view-list"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="col-lg-12 mb25" />
                                
                                <div class="switcher view-grid col-lg-12">
                                    <div class="row feed">
                                        <?php
											$ins_obj =& get_instance();
											$ins_obj->load->model('m_clubs');
											$fact_list = '';
											$club = '';
											$club_slug = '';
											$club_pics = 'img/avatar.jpg';
											if(!empty($allfact)){
												foreach($allfact as $fact){
													$club_id = $fact->club_id;
													
													//get club details
													$gc = $this->m_clubs->query_single_club_id($club_id);
													if(!empty($gc)){
														foreach($gc as $citem){
															$club = $citem->name;
															$club_slug = $citem->slug;
															if($citem->pics_small=='' || file_exists(FCPATH.$citem->pics_small)==FALSE){$club_pics='img/avatar.jpg';}else{$club_pics = $citem->pics_small;}
														}
													}
													
													$fact_list .= '
														<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 switch-item '.$club_slug.'">
															<section class="panel">
																<div class="thumb">
																	<img class="img-responsive" alt="" src="'.base_url($club_pics).'">
																</div>
																<div class="panel-body">
																	<div class="switcher-content">
																		<b>'.$fact->fact_year.'</b>
																		<p>'.character_limiter($fact->fact_details,80).'</p>
																		<a href="'.base_url('fact/'.$fact->id).'">read more...</a><br /><br />
																		<a href="'.base_url('club/'.$club_slug).'" class="show small"><b>'.ucwords($club).'</b></a>
																	</div>
																</div>
															</section>
														</div>
													';
												}
											}
										?>
                                        
                                        <?php echo $fact_list; ?>
                                   	</div>
                               	</div>
                                
                                
                            </div>
                            
                            <div class="col-md-4">