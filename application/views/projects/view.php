<?php include(APPPATH.'libraries/inc.php'); ?>
        <div class="container-fluid">
            <div id="filter">
              <h4><i class="fa fa-plus"></i> Project/Task Collaboration</h4></div>
            
            <?php
				if($project_member_id == $log_user_id){
					$collab_view = 'col-lg-6';	
					$collab_invite = 'col-lg-6';	
				} else {
					$collab_view = 'col-lg-12';	
					$collab_invite = 'hidden';
				}
			?>
			
            <div class="row">
            	<div class="<?php echo $collab_view; ?>">
                	<section class="panel panel-default">
                        <div class="panel-body">
                        	<h3><?php echo $project_title; ?></h3>
                            
                            <div class="text-muted" style="border-bottom:1px solid #eee; margin-bottom:10px; padding-bottom:10px;">
                                <img alt="" src="<?php echo base_url($project_pics_small); ?>" class="img-circle pull-left" height="25" style="margin-right:10px;" />
                                <span>
                                	<a href="<?php echo base_url('member/'.$project_nicename); ?>" style="text-decoration:none;"><?php echo $project_display_name; ?></a> <small><i class="fa fa-calendar"></i> <?php echo $project_reg_date; ?></small>
                                </span>
                            </div>
                                                       
                            <div class="col-lg-12">
                            	<?php echo $project_details; ?>
                            </div>
                        </div>
                  	</section>
                </div>
                
                <div class="<?php echo $collab_invite; ?>">
                	<?php
						$dir_list = '';
						$alluser = $this->users->query_all_user();
						if(!empty($alluser)){
							foreach($alluser as $user){
								$pics_small = $user->pics_small;
								if($pics_small=='' || file_exists(FCPATH.$pics_small)==FALSE){$pics_small='img/avatar.jpg';}
								
								//get professions
								$profession = '';
								$pcount = explode(':', $user->profession);
								for($i = 0; $i < count($pcount); $i++){
									if($i == count($pcount)-1){$delimeter = '';} else {$delimeter = ', ';}
									//query profession
									$prof_name = '';
									$gprof = $this->m_profession->query_profession_id($pcount[$i]);
									if(!empty($gprof)){
										foreach($gprof as $gf){
											$prof_name = $gf->name;	
										}
									}
									
									$profession .= $prof_name.$delimeter;
								}
								
								
								$dir_list .= '
									<tr>
										<td>
											<img alt="" src="'.base_url($pics_small).'" class="img-circle pull-left" height="25" style="margin-right:10px;" />
											<small>'.ucwords($user->display_name).'</small>
										</td>
										<td><small>'.$profession.'</small></td>
										<td align="center">
											<a href="#" class="btn btn-primary btn-xs">Invite <i class="fa fa-arrow-circle-o-right"></i></a>
										</td>
									</tr>
								';	
							}
						}
					?>
                    <section class="panel panel-default">
                        <header class="panel-heading">
                            <h5><i class="fa fa-share"></i> Invite To Project/Task Collaboration</h5>
                        </header>
                        <div class="panel-body">
                            <div class="table-responsive no-border">
                                <table id="dttable" class="table table-striped mg-t datatable">
                                    <thead>
                                        <tr>
                                            <th>Member</th>
                                            <th>Professions</th>
                                            <th align="center">Invite</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $dir_list; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
          	</div>
      	</div>   