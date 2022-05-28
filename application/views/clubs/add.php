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
                                    	<h2><i class="fa fa-trophy"></i> Manage Clubs</h2>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                	<div class="widget">
                                        <div class="widget-body no-p">
                                            <?php echo $err_msg; ?>
                                  
											<?php echo form_open_multipart('clubs/add', array('id'=>'stepy', 'class'=>'stepy')) ?>
            									<fieldset title="Club">
                                                    <legend>Club Identity</legend>
                                                    <input type="hidden" name="club_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
                                                    <input type="hidden" name="pics" value="<?php if(!empty($e_pics)){echo $e_pics;} ?>" />
                                                    <input type="hidden" name="pics_small" value="<?php if(!empty($e_pics_small)){echo $e_pics_small;} ?>" />
                                                    <input type="hidden" name="pics_square" value="<?php if(!empty($e_pics_square)){echo $e_pics_square;} ?>" />
            
                                                    <div class="form-group">
                                                        <label>League/Club Name</label>
                                                        <div class="form-inline">
                                                        	<div class="form-group">
                                                                <?php
																	$league_list = '';
																	if(!empty($allleague)){
																		foreach($allleague as $league){
																			if(!empty($e_league_id)){
																				if($league->id == $e_league_id){
																					$l_sel='selected="selected"';
																				} else {
																					$l_sel='';
																				}
																			} else {
																				$l_sel='';	
																			}
																			
																			$league_list .= '
																				<option value="'.$league->id.'" '.$l_sel.'>'.$league->name.'</option>
																			';	
																		}
																	}
																?>
                                                                
                                                                <select data-placeholder="League" class="form-control chosen" name="league">
                                                                    <option>Select League</option>
                                                                    <?php echo $league_list; ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <input name="name" type="text" class="form-control" placeholder="Club Name" required="required" value="<?php if(!empty($e_name)){echo $e_name;} ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
            
                                                    <div class="form-group">
                                                        <label>Slogan</label>
                                                        <div>
                                                            <input name="slogan" type="text" class="form-control" placeholder="Club Slogan (if any)" value="<?php if(!empty($e_slogan)){echo $e_slogan;} ?>" />
                                                        </div>
                                                    </div>
            
                                                    <div class="form-group">
                                                        <label>Background/Fore Colour</label>
                                                        <div class="form-inline">
                                                            <div class="input-group mb15">
                                                                <input name="bcolour" type="text" class="form-control" id="selected-color1" placeholder="Background" value="<?php if(!empty($e_colour)){echo $e_colour;} ?>">
                                                                <div class="input-group-btn">
                                                                    <button type="button" class="btn btn-default btn-outline dropdown-toggle" data-toggle="dropdown">Color
                                                                        <span class="caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu pull-right">
                                                                        <li>
                                                                            <div id="colorpalette1"></div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="input-group mb15">
                                                                <input name="fcolour" type="text" class="form-control" id="selected-color2" placeholder="Fore/Text" value="<?php if(!empty($e_fore_colour)){echo $e_fore_colour;} ?>">
                                                                <div class="input-group-btn">
                                                                    <button type="button" class="btn btn-default btn-outline dropdown-toggle" data-toggle="dropdown">Color
                                                                        <span class="caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu pull-right">
                                                                        <li>
                                                                            <div id="colorpalette2"></div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
            
                                                <fieldset title="Club">
                                                    <legend>Biography</legend>
            										<div class="form-group">
                                                        <label>Bio</label>
                                                        <div>
                                                            <textarea name="bio" id="bio" class="form-control"><?php if(!empty($e_desc)){echo $e_desc;} ?></textarea>
                                                        </div>
                                                    </div>
                                                </fieldset>
            
                                                <fieldset title="Club">
                                                    <legend>Logo</legend>
                                                    <div class="form-group">
                                                       	<?php
															if(!empty($e_pics_square)){
																echo '<img alt="" src="'.base_url($e_pics_square).'" /><br /><br />';	
															}
														?>
                                                        
                                                        <input name="up_file" type="file" class="btn btn-default file-inputs btn-lg mr5" placeholder="Upload Logo">
                                                    </div>
                                                </fieldset>
            
                                                <button type="submit" class="btn btn-primary stepy-finish pull-right"><i class="ti-share mr5"></i> Update Record</button>
            									<div class="col-lg-12"></div>
                                            <?php echo form_close() ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php
									$ins_obj =& get_instance();
									$ins_obj->load->model('m_clubs');
									$ins_obj->load->model('m_leagues');
									$dir_list = '';
									$league = '';
									$fans = '';
									if(!empty($allclub)){
										foreach($allclub as $club){
											$league_id = $club->league_id;
											
											//get league
											$gl = $this->m_leagues->query_league_id($league_id);
											if(!empty($gl)){
												foreach($gl as $litem){
													$league = $litem->name;	
												}
											}
											
											//get fans
											$fans = count($this->m_clubs->query_club_fans($club->id));
											
											//only admin can see delete
											if(strtolower($log_user_role) == 'administrator'){
												$del_btn = '<a href="'.base_url().'clubs/add?del='.$club->id.'" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> <b>Delete</b></a>';
											} else {$del_btn = '';}
											
											$dir_list .= '
												<tr>
													<td>'.$league.'</td>
													<td>'.$club->name.'</td>
													<td>'.$club->slogan.'</td>
													<td align="center"><img alt="" src="'.base_url($club->pics_square).'" width="50" /></td>
													<td align="center">'.$fans.'</td>
													<td>
														<a href="'.base_url().'clubs/add?edit='.$club->id.'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> <b>Edit</b></a>
														'.$del_btn.'
													</td>
												</tr>
											';	
										}
									}
								?>
                                
                                <div class="col-lg-12">
                                	<section class="panel panel-default">
                                        <header class="panel-heading">
                                            <h5><i class="fa fa-trophy"></i> Clubs</h5>
                                        </header>
                                        <div class="panel-body">
                                            <div class="table-responsive no-border">
                                                <table id="sfhtblist" class="table table-bordered table-striped mg-t datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>League</th>
                                                            <th>Club</th>
                                                            <th>Slogan</th>
                                                            <th width="60px">Logo</th>
                                                            <th width="40px">Fans</th>
                                                            <th width="100px">Manage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php echo $dir_list; ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>League</th>
                                                            <th>Club</th>
                                                            <th>Slogan</th>
                                                            <th>Logo</th>
                                                            <th>Fans</th>
                                                            <th>Manage</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            
                            <div class="col-md-4">