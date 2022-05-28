		<section class="layout">
            <!-- main content -->
            <section class="main-content">
                <!-- content wrapper -->
                <div class="content-wrap">
                    <!-- inner content wrapper -->
                    <div class="wrapper">
                    	<div class="row">
                            <div class="col-md-8">
                                <div class="timeline">
                                    <div class="timeline-heading">
                                        <h4><i class="ti-clipboard"></i>&nbsp;Activity Timeline</h4>
                                    </div>
        
                                    <?php
										$ra_obj =& get_instance();
										$ra_obj->load->model('users');
										
										$ra_item = '';
										$ra_content = '';
										$r_act = $ra_obj->users->query_activity();
										if(!empty($r_act)){
											foreach($r_act as $ract){
												$ra_type = $ract->type;
												$ra_fan_id = $ract->fan_id;
												$ra_p_id = $ract->p_id;
												$ra_s_id = $ract->s_id;
												$ra_content = $ract->content;
												$ra_reg_date = $ract->reg_date;
												
												$ra_reg_date_ago = timespan(strtotime($ra_reg_date), time());
												//$ra_reg_date_ago = explode(', ',$ra_reg_date_ago);
												//$ra_reg_date_ago = $ra_reg_date_ago[0];
												
												//get fan details
												$r_gf = $ra_obj->users->query_single_user_id($ra_fan_id);
												foreach($r_gf as $rf){
													$ra_fan_nicename = $rf->user_nicename;
													$ra_fan_display_name = $rf->display_name;
													$ra_fan_pics_small = $rf->pics_small;
													if($ra_fan_pics_small=='' || file_exists(FCPATH.$ra_fan_pics_small)==FALSE){$ra_fan_pics_small='img/avatar.jpg';}		
												}
												
												//check type
												if($ra_type=='moot' || $ra_type=='moot reply'){
													if($ra_type=='moot'){
														$ra_content = '<a href="'.base_url('moot/'.$ra_p_id).'">Started new moot: '.character_limiter($ra_content,50).'</a>';
													} else {
														$ra_content = '<a href="'.base_url('moot/'.$ra_p_id.'#'.$ra_s_id).'">Replied a moot: '.character_limiter($ra_content,50).'</a>';
													}
												} else if($ra_type=='join club'){
													$ra_content = '<a href="'.base_url('moot/'.$ra_p_id).'">New Fan: '.character_limiter($ra_content,50).'</a>';
												} else if($ra_type=='leave club'){
													$ra_content = '<a href="'.base_url('moot/'.$ra_p_id).'">Decamped: '.character_limiter($ra_content,50).'</a>';
												}
												
												//layout recent activity
												$ra_item .= '
													<div class="timeline-panel">
														<section class="panel">
															<div class="timeline-date">'.$ra_reg_date_ago.' ago</div>
															<div class="panel-body">
																<a href="javascript:;" class="pull-left mr15" style="width:15%;">
																	<img class="img-circle avatar avatar-md" src="'.base_url($ra_fan_pics_small).'" alt="">
																</a>
																<div class="overflow-hidden">
																	<b><a href="'.base_url('fan/'.$ra_fan_nicename).'">'.$ra_fan_display_name.'</a></b>
																	<p>'.$ra_content.'</p>
																</div>
															</div>
														</section>
													</div>
												';
											}
										}
									?>
                                    
                                    <?php echo $ra_item; ?>
                                </div>
                         	</div>
                            
                            <div class="col-md-4">

                            