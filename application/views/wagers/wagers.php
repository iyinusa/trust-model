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
                                    	<h2>
                                        	<i class="ti-pulse"></i> Wagers 
                                            <small class="text-muted">Bets Arena 
                                            	<?php
													if($log_user==TRUE){
														echo '<a href="'.base_url('wagers/add').'" class="btn btn-info btn-xs"><i class="ti-pulse"></i> Start Bet</a>';
													}
												?>
                                            </small>
                                        </h2>
                                    </div>
                                    
                                    <div class="col-xs-6 text-right">
                                        <div class="btn-group mr5 mt10">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><i class="ti-pulse"></i> Filter Bets
                                                <span class="ti-angle-down ml10"></span>
                                            </button>
                                            <ul class="dropdown-menu text-left filter" data-option-key="filter" role="menu">
                                                <li><a href="javascript:;" data-filter="*">All Wagers</a></li>
                                                <li><a href="javascript:;" data-filter=".One-To-One">One-To-One</a></li>
                                                <li><a href="javascript:;" data-filter=".One-To-Many">One-To-Many</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="col-lg-12 mb25" />
                                
                                <div class="switcher view-grid col-lg-12">
                                    <div class="row feed">
                                        <?php
											$ins_obj =& get_instance();
											$ins_obj->load->model('users');
											$ins_obj->load->model('m_wagers');
											$wager_list = '';
											$edit_btn = '';
											$del_btn = '';
											$join_btn = '';
											$wcount = 0;
											if(!empty($allwager)){
												foreach($allwager as $wager){
													$wager_id = $wager->id;
													$type = $wager->type;
													$content = $wager->content;
													$amt = $wager->amt;
													$starts = $wager->starts;
													$ends = $wager->ends;
													$remark = $wager->remark;
													$status = $wager->status;
													$privacy = $wager->privacy;
													$reg_date = $wager->reg_date;
													
													if($status==0){
														$w_status = 'Bet Close';
														$w_status_back = 'default';	
													} else {
														$w_status = 'Bet Open';
														$w_status_back = 'success';
													}
													
													//get wagerer details
													$c_wagerer_list = '';
													$wagerer_list = '';
													$join_btn = '';
													$creator_id = '';
													$gw = $this->m_wagers->query_all_wagerer($wager_id);
													$total_wagerer = count($gw);
													if($type=='One-To-One'){$wins_info='Winner gets';}else{$wins_info='Winners shares';}
													if(!empty($gw)){
														foreach($gw as $witem){
															$wagerer_id = $witem->id;
															$user_id = $witem->user_id;
															$w_privacy = $witem->privacy;
															$creator = $witem->creator;
															$win = $witem->win;
															$w_reg_date = $witem->reg_date;
															
															//get creator ID
															if($creator==1){$creator_id = $user_id;}
															
															//get user details
															$wfan_pics_small='';
															$wfan_username='';
															$wfan_display='';
															$gu = $this->users->query_single_user_id($user_id);
															if(!empty($gu)){
																foreach($gu as $wfan){
																	if($wfan->pics_small=='' || file_exists(FCPATH.$wfan->pics_small)==FALSE){$wfan_pics_small='img/avatar.jpg';} else {$wfan_pics_small=$wfan->pics_small;}
																	$wfan_username	= $wfan->user_nicename;
																	$wfan_display = $wfan->display_name;
																}
															}
															
															//check privacy and protect
															if($privacy==1 && ($creator==1)){
																$wfan_pics_small = 'img/avatar.jpg';
																$wfan_username = 'null';
																$wfan_display = '';	
															}
															
															if($w_privacy==1){
																$wfan_pics_small = 'img/avatar.jpg';
																$wfan_username = 'null';
																$wfan_display = '';	
															}
															
															if($creator==1){
																$c_wagerer_list .= '
																	<a href="'.base_url('fan/'.$wfan_username).'" class="show pull-left" data-toggle="tooltip" data-placement="bottom" title="'.$wfan_display.'">
																		<img src="'.base_url($wfan_pics_small).'" class="avatar avatar-md img-circle" alt="">
																	</a> 
																	<small>
																		<small class="text-muted">'.date('j M',strtotime($starts)).' - '.date('j M',strtotime($ends)).'</small><br/>
																		'.$remark.'
																	</small>
																';
															} else {
																$wagerer_list .= '
																	<a href="'.base_url('fan/'.$wfan_username).'" class="show col-xs-2">
																		<img src="'.base_url($wfan_pics_small).'" class="avatar avatar-md img-circle" alt="" data-toggle="tooltip" data-placement="top" title="'.$wfan_display.'">
																	</a>
																';
															}
														}
														
														if($log_user_role=='editor' || $log_user_role=='administrator'){
															$edit_btn = '<a href="'.base_url().'wagers/add?edit='.$wager_id.'" class="btn btn-xs btn-info"><i class="ti-pencil"></i></a>';
														}
														
														if($log_user_role=='editor' || $log_user_role=='administrator'){
															$del_btn = '<a href="'.base_url().'wagers/add?del='.$wager_id.'" class="btn btn-xs btn-danger"><i class="ti-trash"></i></a>';
														}
													}
													
													if($log_user==TRUE){
														//check if user already joined
														if($this->m_wagers->check_user_wagerer($wager_id, $log_user_id) > 0){
															//$join_btn = '<a href="'.base_url().'/wagers/leave='.$wager_id.'" class="btn btn-danger btn-xs"><i class="ti-hand-point-left"></i> Leave</a>';		
														} else {
															if($status==1){
																$join_btn = '
																	<a href="javascript:;" class="btn btn-success btn-xs" onclick="place'.$wcount.'();"><i class="ti-hand-point-right"></i> Bet It</a>
																	<input type="hidden" id="place_id'.$wcount.'" value="'.$wager_id.'" />
																	<input type="hidden" id="place_creator'.$wcount.'" value="'.$creator_id.'" />
																	<input type="hidden" id="place_type'.$wcount.'" value="'.$type.'" />
																	<input type="hidden" id="place_amt'.$wcount.'" value="'.$amt.'" />
																	<div id="place_reply'.$wcount.'"></div>
																	<script type="text/javascript">
																		function place'.$wcount.'(){
																			var hr = new XMLHttpRequest();
																			var place_id = document.getElementById("place_id'.$wcount.'").value;
																			var place_creator = document.getElementById("place_creator'.$wcount.'").value;
																			var place_type = document.getElementById("place_type'.$wcount.'").value;
																			var place_amt = document.getElementById("place_amt'.$wcount.'").value;
																			var c_vars = "place_id="+place_id+"&place_creator="+place_creator+"&place_type="+place_type+"&place_amt="+place_amt;
																			hr.open("POST", "'.base_url().'wagers/joinbet", true);
																			hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
																			hr.onreadystatechange = function() {
																				if(hr.readyState == 4 && hr.status == 200) {
																					var return_data = hr.responseText;
																					document.getElementById("place_reply'.$wcount.'").innerHTML = return_data;
																			   }
																			}
																			hr.send(c_vars);
																			document.getElementById("place_reply'.$wcount.'").innerHTML = "<i class=\"icon-spin4 animate-spin loader\"></i>";
																		}
																	</script>
																';
															}
														}
													} else {$join_btn = '<br/>&nbsp;<small><a href="'.base_url().'wagers/add">Sign In</a> to bet</small>';}
													if(!empty($wagerer_list)){
														$wagerer_list = '<p class="text-muted">'.$wins_info.' &#8358;'.number_format($total_wagerer*$amt).'</p>'.$wagerer_list;
													}
													
													$wager_list .= '
														<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 switch-item '.$type.'">
															<section class="panel">
																<div class="panel-body">
																	<div>
																		'.$content.'<br/><small class="text-muted">'.$type.'</small>
																		<span class="pull-right">
																			<span class="label label-'.$w_status_back.'"><i class="ti-pulse"></i> '.$w_status.'</span> 
																			'.$join_btn.'
																		</span>
																	</div>
																	<hr/>
																	<div>
																		<div class="media">
																			<span class="pull-right">
																				<span class="label label-default"><i class="ti-user"></i> Creator</span>
																				'.$edit_btn.'
																				'.$del_btn.'<br />
																				<h3 class="text-right">&#8358;'.number_format($amt).'</h3>
																			</span>
																			'.$c_wagerer_list.'
																		</div>
																		<hr />
																		<div>
																			<span class="label label-default pull-right"><i class="fa fa-users"></i> Wagerers</span>
																			'.$wagerer_list.'
																		</div>
																	</div>
																</div>
															</section>
														</div>
													';
													$wcount+=1;
												}
											}
										?>
                                        
                                        <?php echo $wager_list; ?>
                                   	</div>
                               	</div>
                                
                                
                            </div>
                            
                            <div class="col-md-4">