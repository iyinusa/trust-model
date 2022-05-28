<?php include(APPPATH.'libraries/inc.php'); ?>
          <div class="container-fluid">

            <!--<div id="filter">
              <form class="form-inline">
                <label>Filter:</label>
                <select name="users-filter" id="users-filter-select" class="selectpicker" data-style="btn-primary" data-width="auto">
                  <option value="all">All</option>
                  <option value="friends">By Collaboration</option>
                  <option value="name">By Name</option>
                </select>
                <div id="users-filter-trigger">
                  <div class="select-friends hidden">
                    <select name="users-filter-friends" class="selectpicker" data-style="btn-primary" data-live-search="true">
                      <option value="0">Select Friend</option>
                      <option value="1">Mary D.</option>
                      <option value="2">Michelle S.</option>
                      <option value="3">Tunde Johnson</option>
                    </select>
                  </div>
                  <div class="search-name hidden">
                    <input type="text" class="form-control" name="user-first" placeholder="First Last Name" id="name" />
                    <a href="#" class="btn btn-default hidden" id="user-search-name"><i class="fa fa-search"></i> Search</a>
                  </div>

                </div>
              </form>
            </div>-->
            <?php if(!empty($err_msg)){echo $err_msg;} ?>
            <?php
				$member_list = '';
				$collab_list = '';
				if(!empty($allmember)){
					foreach($allmember as $member){
						if($log_user_id != $member->ID){
							$m_user_nicename = $member->user_nicename;
							$m_display_name = $member->display_name;
							$m_pics_small = $member->pics_small;
							if($m_pics_small=='' || file_exists(FCPATH.$m_pics_small)==FALSE){$m_pics_small='img/avatar.jpg';}
							
							//check collaborations
							$chkcoll = mysql_query("SELECT * FROM tm_collab WHERE (sender_id='$log_user_id' AND receiver_id='$member->ID' AND status=1 AND project=0) OR (sender_id='$member->ID' AND receiver_id='$log_user_id' AND status=1 AND project=0)");
							if(mysql_num_rows($chkcoll) > 0){
								$btn = '<a href="javascript:;" class="btn btn-success btn-sm">Collaborated <i class="fa fa-paperclip"></i></a>';
							} else {
								$btn = '<a href="'.base_url('members?collab='.$member->ID).'" class="btn btn-default btn-sm">Request Collaboration <i class="fa fa-share"></i></a>';
							}
							
							//get collaboration status
							$col_pass = 0;
							$col_fail = 0;
							$col_total = 0;
							$coll_status = $this->m_collab->query_all_collab($member->ID);
							if(!empty($coll_status)){
								foreach($coll_status as $cstatus){
									//don't include projects
									if($cstatus->project == 0){
										if($cstatus->status == 1){$col_pass += 1;}
										if($cstatus->reject == 1 && $member->ID == $cstatus->sender_id){$col_fail += 1;}
									}
								}
							}
							$col_total = $col_pass + $col_fail;
							
							//compute trust scale
							$scale = ($col_pass / $col_total) * 5;
							$scale_perc = ($col_pass / $col_total) * 100;
							
							$get_trs = $this->m_trs->query_trs_degree(round($scale));
							if(!empty($get_trs)){
								foreach($get_trs as $trs){
									$scale_text = $trs->value.' Scale ('.$trs->name.')';	
								}
							} else {$scale_text = '';}
							
							$member_list .= '
								<div class="col-md-6 col-lg-4 item">
									<div class="panel panel-default">
									  <div class="panel-heading">
										<div class="media">
										  <div class="pull-left">
											<img src="'.base_url($m_pics_small).'" alt="" height="60" class="media-object img-circle" />
										  </div>
										  <div class="media-body">
											<h4 class="media-heading margin-v-5"><a href="'.base_url('member/'.$m_user_nicename).'">'.$m_display_name.'</a></h4>
											<div class="profile-icons">
											  <span data-toggle="tooltip" data-placement="bottom" title="Successful Collaborations"><i class="fa fa-check"></i> '.$col_pass.'</span>
											  <span data-toggle="tooltip" data-placement="bottom" title="Failed Collaborations"><i class="fa fa-close"></i> '.$col_fail.'</span>
											  <span data-toggle="tooltip" data-placement="bottom" title="Total Collaborations"><i class="fa fa-cubes"></i> '.$col_total.'</span>
											</div>
										  </div>
										</div>
									  </div>
									  <div class="panel-body">
										<p class="common-friends">Collaborations Trust Scale</p>
										<div class="user-friend-list">
										  <div class="progress">
											<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="'.$scale_perc.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$scale_perc.'%">
											  <small class="">'.$scale_text.'</small>
											</div>
										  </div>
										  
										  <!--<a href="#">
											<img src="images/people/50/guy-2.jpg" alt="people" class="img-circle" />
										  </a>-->
										</div>
									  </div>
									  <div class="panel-footer text-right">
										'.$btn.'
									  </div>
									</div>
								</div>
							';
						}
					}
				}
			?>

            <div class="row" data-toggle="isotope">
              <?php echo $member_list; ?>
            </div>

          </div>