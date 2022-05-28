<?php include(APPPATH.'libraries/inc.php'); ?>
		<div class="container-fluid">

            <!--<div class="tabbable">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab"><i class="fa fa-fw fa-picture-o"></i> Photos</a></li>
                <li class=""><a href="#profile" data-toggle="tab"><i class="fa fa-fw fa-folder"></i> Albums</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade active in" id="home">
                  <img src="images/place1.jpg" alt="image" />
                  <img src="images/place2.jpg" alt="image" />
                  <img src="images/food1.jpg" alt="image" />
                </div>
                <div class="tab-pane fade" id="profile">
                  <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth
                    letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown.
                    Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
                </div>
                <div class="tab-pane fade" id="dropdown1">
                  <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy
                    salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably
                    haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
                </div>
                <div class="tab-pane fade" id="dropdown2">
                  <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo
                    park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial
                    keffiyeh echo park vegan.</p>
                </div>
              </div>
            </div>-->
            
            <div>
            	<?php
					$collab_list = '';
					$collab_pass = 0;
					$collab_fail = 0;
					$collab_total = 0;
					if(!empty($allcollab)){
						foreach($allcollab as $collab){
							if($member_id == $collab->sender_id){
								$coll_id = $collab->receiver_id;	
							} else {
								$coll_id = $collab->sender_id;
							}
							
							//calculate successful and failed collaboration
							if($collab->status == 1){$collab_pass += 1;}
							if($collab->reject == 1 && $member_id == $collab->sender_id){$collab_fail += 1;}
							
							$getuser = $this->users->query_single_user_id($coll_id);
							if(!empty($getuser)){
								foreach($getuser as $user){
									$user_nicename = $user->user_nicename;
									$display_name = $user->display_name;
									$pics_small = $user->pics_small;
									if($pics_small=='' || file_exists(FCPATH.$pics_small)==FALSE){$pics_small='img/avatar.jpg';}
									$collab_list .= '
										<li data-toggle="tooltip" data-placement="bottom" title="'.$display_name.'">
											<a href="'.base_url('member/'.$user_nicename).'">
												<img src="'.base_url($pics_small).'" alt="image" />
											</a>
										</li>
									';	
								}
							}
						}
					}
					
					$collab_total = $collab_pass + $collab_fail;
					
					//compute trust scale
					$scale = ($collab_pass / $collab_total) * 5;
					$scale_perc = ($collab_pass / $collab_total) * 100;
					
					$get_trs = $this->m_trs->query_trs_degree(round($scale));
					if(!empty($get_trs)){
						foreach($get_trs as $trs){
							$scale_text = $trs->value.' Scale ('.$trs->name.')';	
						}
					} else {$scale_text = '';}
					
					//check collab request status
					$btn_request = '';
					if($log_user_id != $member_id){
						$req_collab = $this->m_collab->query_receive_collab($log_user_id, $member_id);
						if(!empty($req_collab)){
							foreach($req_collab as $rcollab){
								if($rcollab->reject == 0 && $rcollab->status == 0){
									$btn_request = '<a href="'.base_url('members?collab_accept='.$rcollab->id.'&from='.$rcollab->sender_id).'" class="btn btn-success"><i class="fa fa-check"></i> Accept</a> <a href="'.base_url('members?collab_reject='.$rcollab->id.'&from='.$rcollab->sender_id).'" class="btn btn-warning"><i class="fa fa-close"></i> Reject</a>';	
								}
							}
						}
					}
				?>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading panel-heading-gray">
                    <?php if($log_user_id == $member_id){ ?>
                    <a href="<?php echo base_url('settings/account'); ?>" class="btn btn-white btn-xs pull-right"><i class="fa fa-pencil"></i> Update Profile</a>
                    <?php } ?>
                    <i class="fa fa-fw fa-info-circle"></i> About
                  </div>
                  <div class="panel-body">
                    <?php
						if($member_id != $log_user_id){
							echo '
								<div class="pull-right">'.$btn_request.'</div>
								<div>
									<img alt="" src="'.base_url($member_pics).'" style="max-width:50%;" />
								</div>
							';	
						}
					?>
                    <ul class="list-unstyled profile-about margin-none">
                      <li class="padding-v-5">
                        <div class="row">
                          <div class="col-sm-4"><span class="text-muted">Full Name</span></div>
                          <div class="col-sm-8"><?php echo $member_display_name != '' ? $member_display_name : 'Nil'; ?></div>
                        </div>
                      </li>
                      <li class="padding-v-5">
                        <div class="row">
                          <div class="col-sm-4"><span class="text-muted">Bio</span></div>
                          <div class="col-sm-8"><?php echo $member_bio != '' ? $member_bio : 'Nil'; ?></div>
                        </div>
                      </li>
                      <li class="padding-v-5">
                        <div class="row">
                          <div class="col-sm-4"><span class="text-muted">Phone</span></div>
                          <div class="col-sm-8"><?php echo $member_phone != '' ? $member_phone : 'Nil'; ?></div>
                        </div>
                      </li>
                      <li class="padding-v-5">
                        <div class="row">
                          <div class="col-sm-4"><span class="text-muted">Email</span></div>
                          <div class="col-sm-8"><?php echo $member_email != '' ? $member_email : 'Nil'; ?></div>
                        </div>
                      </li>
                      <li class="padding-v-5">
                        <div class="row">
                          <div class="col-sm-4"><span class="text-muted">Date of Birth</span></div>
                          <div class="col-sm-8"><?php echo $member_dob != '' ? date('jS F',strtotime($member_dob)) : 'Nil'; ?></div>
                        </div>
                      </li>
                      <li class="padding-v-5">
                        <div class="row">
                          <div class="col-sm-4"><span class="text-muted">Specilization</span></div>
                          <div class="col-sm-8"><?php echo $member_profession != '' ? $member_profession : 'Nil'; ?></div>
                        </div>
                      </li>
                      <li class="padding-v-5">
                        <div class="row">
                          <div class="col-sm-4"><span class="text-muted">Gender</span></div>
                          <div class="col-sm-8"><?php echo $member_sex != '' ? $member_sex : 'Nil'; ?></div>
                        </div>
                      </li>
                      <li class="padding-v-5">
                        <div class="row">
                          <div class="col-sm-4"><span class="text-muted">Address</span></div>
                          <div class="col-sm-8"><?php echo $member_address != '' ? $member_address : 'Nil'; ?></div>
                        </div>
                      </li>
                      <li class="padding-v-5">
                        <div class="row">
                          <div class="col-sm-4"><span class="text-muted">Location</span></div>
                          <div class="col-sm-8">
                          	<?php echo $member_location != '' ? $member_location : 'Nil'; ?>
                          </div>
                        </div>
                      </li>
                      <li class="padding-v-5">
                        <div class="row">
                          <div class="col-sm-4"><span class="text-muted">Trust Rating</span></div>
                          <div class="col-sm-8">
                          	<div class="progress">
                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo $scale_perc; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $scale_perc; ?>%">
                                  <span class=""><?php echo $scale_text; ?></span>
                                </div>
                              </div>
                          </div>
                        </div>
                      </li>
                      <hr/>
                      <li class="padding-v-5">
                        <div class="row">
                          <div class="col-sm-4"><span class="text-muted">Website</span></div>
                          <div class="col-sm-8"><i class="fa fa-globe"></i> <?php echo $member_website != '' ? '<a href="'.$member_website.'" target="_blank">'.$member_website.'</a>' : 'Nil'; ?></div>
                        </div>
                      </li>
                      <li class="padding-v-5">
                        <div class="row">
                          <div class="col-sm-4"><span class="text-muted">Facebook</span></div>
                          <div class="col-sm-8"><i class="fa fa-facebook"></i> <?php echo $member_fb_page != '' ? '<a href="'.$member_fb_page.'" target="_blank">'.$member_fb_page.'</a>' : 'Nil'; ?></div>
                        </div>
                      </li>
                      <li class="padding-v-5">
                        <div class="row">
                          <div class="col-sm-4"><span class="text-muted">Twitter</span></div>
                          <div class="col-sm-8"><i class="fa fa-twitter"></i> <?php echo $member_twitter_page != '' ? '<a href="'.$member_twitter_page.'" target="_blank">'.$member_twitter_page.'</a>' : 'Nil'; ?></div>
                        </div>
                      </li>
                      <li class="padding-v-5">
                        <div class="row">
                          <div class="col-sm-4"><span class="text-muted">LinkedIn</span></div>
                          <div class="col-sm-8"><i class="fa fa-linkedin"></i> <?php echo $member_linkedin_page != '' ? '<a href="'.$member_linkedin_page.'" target="_blank">'.$member_linkedin_page.'</a>' : 'Nil'; ?></div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading panel-heading-gray">
                    <div class="pull-right">
                      <a href="<?php echo base_url('members'); ?>" class="btn btn-primary btn-xs">Add <i class="fa fa-plus"></i></a>
                    </div>
                    <i class="icon-user-1"></i> Collaborations
                  </div>
                  <div class="panel-body">
                    <ul class="img-grid">
                      <p>
                        <div class="col-sm-4 btn btn-primary btn-icon-stacked"><i class="fa fa-2x fa-check"></i> 
                        	<h3 class="text-center"><?php echo $collab_pass; ?><br><small style="color:#fff;">Successful</small></h3>
                        </div>
                        <div class="col-sm-4 btn btn-inverse btn-icon-stacked"><i class="fa fa-2x fa-close"></i> 
                        	<h3 class="text-center"><?php echo $collab_fail; ?><br><small style="color:#fff;">Failed</small></h3>
                        </div>
                        <div class="col-sm-4 btn btn-success btn-icon-stacked"><i class="fa fa-2x fa-cubes"></i> 
                        	<h3 class="text-center"><?php echo $collab_total; ?><br><small style="color:#fff;">Total Collaboration</small></h3>
                        </div>
                      </p>
					  <?php echo $collab_list; ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            
          </div>