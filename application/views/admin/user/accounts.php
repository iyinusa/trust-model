<?php include(APPPATH.'libraries/inc.php'); ?>
		<div class="container-fluid">
            <div id="filter">
              <h4><i class="fa fa-users"></i> Manage Users</h4>
            </div>
            
            <div class="row">
            	<div class="col-lg-12">
					<?php echo $err_msg; ?>
                  
                    <?php if(!empty($e_id)){ ?>
                        <?php echo form_open('admin/accounts') ?>
                            <div class="form-group mr5">
                                <input name="user_id" type="hidden" value="<?php if(!empty($e_id)){echo $e_id;} ?>">
                                <?php if(!empty($e_name)){echo $e_name;} ?>
                            </div>
                            <div class="form-group mr5">
                                <?php if(!empty($e_display_name)){echo $e_display_name;} ?>
                            </div>
                            <div class="form-group mr5">
                                <select data-placeholder="Role" class="form-control chosen" name="role">
                                    <option value="<?php if(!empty($e_role)){echo $e_role;} ?>">Select Role</option>
                                    <option value="User">User</option>
                                    <option value="Social Manager">Social Manager</option>
                                    <option value="Administrator">Administrator</option>
                                </select>
                            </div>
                            <hr />
                            
                            <button type="submit" class="btn btn-info btn-lg"><i class="fa fa-pencil"></i> Update Record</button><br /><br />
                        <?php echo form_close() ?>
                    <?php } ?>
                </div>
                
                <div class="col-lg-12">
                	<?php
						$dir_list = '';
						if(!empty($alluser)){
							foreach($alluser as $user){
								//only admin can see delete
								if(strtolower($log_user_role) == 'administrator'){
									$del_btn = '<a href="'.base_url().'admin/accounts?del='.$user->ID.'" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> <b>Delete</b></a>';
								} else {$del_btn = '';}
								
								if($user->pics_small=='' || file_exists(FCPATH.$user->pics_small)==FALSE){$user_pics='img/avatar.jpg';}else{$user_pics = $user->pics_small;}
								
								//get country name
								$get_country = $this->m_country->query_country_id($user->country);
								if(!empty($get_country)){
									foreach($get_country as $countr){
										$country = $countr->name;	
									}
								} else {$country = '';}
								
								$dir_list .= '
									<tr>
										<td><img alt="" src="'.base_url($user_pics).'" class="avatar img-circle" width="50" /></td>
										<td><a href="'.base_url('member/'.$user->user_nicename).'">'.ucwords($user->display_name).'</a></td>
										<td>'.$user->sex.'</td>
										<td>'.$country.'</td>
										<td>'.$user->role.'</td>
										<td>
											<a href="'.base_url().'admin/accounts?edit='.$user->ID.'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> <b>Edit</b></a>
											'.$del_btn.'
										</td>
									</tr>
								';	
							}
						}
					?>
                    
                    <?php if(!empty($rec_del)){ ?>
						<?php if($rec_del!=''){ ?>
                            <?php echo form_open_multipart('admin/accounts/delete'); ?>
                                <div class="col-lg-12 bg-info">
                                    <h3>Are you sure? - Record will be totally remove from the database</h3>
                                    <input type="hidden" name="del_id" value="<?php echo $rec_del; ?>" />
                                    <button type="submit" name="cancel" class="btn btn-sm btn-default"><i class="fa fa-close"></i> Cancel</button>
                                    <button type="submit" name="delete" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i> Remove</button><br /><br />
                                </div>
                            <?php echo form_close(); ?>
                        <?php } ?>
                    <?php } ?>
                    
                    <div class="col-lg-12">
                        <section class="panel panel-default">
                            <header class="panel-heading">
                                <h5><i class="fa fa-users"></i> Users Account</h5>
                            </header>
                            <div class="panel-body">
                                <div class="table-responsive no-border">
                                    <table id="sfhtblist" class="table table-striped mg-t datatable">
                                        <thead>
                                            <tr>
                                                <th width="50">Photo</th>
                                                <th>Name</th>
                                                <th>Sex</th>
                                                <th>Country</th>
                                                <th>Role</th>
                                                <th width="120">Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $dir_list; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Sex</th>
                                                <th>Country</th>
                                                <th>Role</th>
                                                <th width="120">Manage</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
         	</div>
     	</div>