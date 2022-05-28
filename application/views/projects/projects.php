<?php include(APPPATH.'libraries/inc.php'); ?>
          <div class="container-fluid">

            <div id="filter">
              <a href="<?php echo base_url('projects/add'); ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Create New Project/Task</a>
              <!--<form class="form-inline">
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
              </form>-->
            </div>
            <?php if(!empty($err_msg)){echo $err_msg;} ?>
            <?php
				$project_list = '';
				$collab_list = '';
				
				//get collaboration status
				$col_pass = 0;
				$col_fail = 0;
				$col_total = 0;
				$all_project = $this->m_project->query_all_project($log_user_id);
				if(!empty($all_project)){
					foreach($all_project as $aproject){
						//get collaboration
						$getcollab = $this->m_collab->query_all_collab($log_user_id);
						if(!empty($getcollab)){
								foreach($getcollab as $collab){
									if($collab->project != 0){
										if($collab->status == 1){$col_pass += 1;}
										if($collab->reject == 1 && $log_user_id == $collab->sender_id){$col_fail += 1;}
										
										$col_total = $col_pass + $col_fail;
									}
								}
						}
						
						//pull user details
						$user_display_name = '';
						$user_pics_small = '';
						$user_nicename = '';
						$getuser = $this->users->query_single_user_id($aproject->member_id);
						if(!empty($getuser)){
							foreach($getuser as $row){
								$user_display_name = $row->display_name;
								$user_nicename = $row->user_nicename;
								$user_pics_small = $row->pics_small;
								if($user_pics_small=='' || file_exists(FCPATH.$user_pics_small)==FALSE){$user_pics_small='img/avatar.jpg';}
							}
						}
					
						$project_list .= '
							<div class="col-md-6 col-lg-4 item">
								<div class="panel panel-default">
								  <div class="panel-heading">
									<div class="media">
									  <div class="media-body">
										<h4 class="media-heading margin-v-5"><a href="'.base_url('project/'.$aproject->slug).'">'.character_limiter($aproject->title, 20).'</a></h4>
										<div class="profile-icons">
										  <span data-toggle="tooltip" data-placement="bottom" title="Successful Collaborations"><i class="fa fa-check"></i> '.$col_pass.'</span>
										  <span data-toggle="tooltip" data-placement="bottom" title="Failed Collaborations"><i class="fa fa-close"></i> '.$col_fail.'</span>
										  <span data-toggle="tooltip" data-placement="bottom" title="Total Collaborations"><i class="fa fa-cubes"></i> '.$col_total.'</span>
										</div>
										<div>
											<img alt="" src="'.base_url($user_pics_small).'" class="img-circle pull-left" height="20" /> 
											&nbsp;<a href="'.base_url('member/'.$user_nicename).'" style="text-decoration:none;">'.$user_display_name.'</a>
										</div>
									  </div>
									</div>
								  </div>
								  <div class="panel-footer text-right">
									<span class="pull-left text-muted">
										<i class="fa fa-calendar"></i> 
										'.date('d M Y', strtotime($aproject->reg_date)).'
									</span>
									<a href="'.base_url('project/'.$aproject->slug).'" class="btn btn-default btn-sm"><i class="fa fa-search"></i> View Project</a>
								  </div>
								</div>
							</div>
						';
					}
				}
			?>

            <div class="row" data-toggle="isotope">
			  <?php echo $project_list; ?>
            </div>

          </div>