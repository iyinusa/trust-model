<?php include(APPPATH.'libraries/inc.php'); ?>
        <div class="container-fluid">
            <div id="filter">
              <h4><i class="fa fa-cogs"></i> Update Profile</h4></div>
            
            <div class="row">
            	<div class="col-lg-12">
                    <div class="widget">
                        <div class="widget-body no-p">
                            <?php echo $err_msg; ?>
                  
                            <?php echo form_open('settings/account'); ?>
                                <div class="panel panel-default">
                  					<div class="panel-heading panel-heading-gray" style="text-transform:uppercase;">
                    					<i class="fa fa-fw fa-info-circle fa-2x"></i> <b>Profile Identity</b>
                  					</div>
                  					<div class="panel-body">
                                    	<div class="form-group">
                                            <label>Username/Display Name</label>
                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <input name="name" type="text" class="form-control" placeholder="Username" value="<?php if(!empty($log_user_nicename)){echo $log_user_nicename;} ?>" />
                                                </div>
                                                <div class="form-group">
                                                    <input name="displayname" type="text" class="form-control" placeholder="Display Name" required="required" value="<?php if(!empty($log_display_name)){echo $log_display_name;} ?>" />
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="form-group">
                                            <label>Gender/Date of Birth</label>
                                            <div class="form-inline">
                                                <div class="input-group mb15">
                                                    <?php
                                                        if(!empty($log_user_sex)){
                                                            if($log_user_sex == 'Male'){
                                                                $m_sel = 'selected="selected"';
                                                                $f_sel = '';
                                                            } else {
                                                                $m_sel = '';
                                                                $f_sel = 'selected="selected"';
                                                            }
                                                        } else {$m_sel = '';$f_sel = '';}
                                                    ?>
                                                    <select data-placeholder="Gender" class="form-control chosen" name="sex" required="required">
                                                        <option>Select Gender</option>
                                                        <option value="Male" <?php echo $m_sel; ?>>Male</option>
                                                        <option value="Female" <?php echo $f_sel; ?>>Female</option>
                                                    </select>
                                                </div>
                                                <div class="input-group mb15">
                                                    <input name="dob" type="text" class="form-control datepicker" placeholder="Date of Birth" value="<?php if(!empty($log_user_dob)){echo $log_user_dob;} ?>">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Bio</label>
                                            <div>
                                                <textarea name="bio" id="bio" class="form-control"><?php if(!empty($log_user_bio)){echo $log_user_bio;} ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="form-inline">
                                            <label>Specialization/Profession</label>
                                            <?php
												$spec_list = '';
												$all_spec_list = '';
												$selected = array(); //array to store selected
												if(!empty($allprofession)){
													foreach($allprofession as $profession){
														if(!empty($log_user_profession)){
															$pcount = explode(':', $log_user_profession);
															for($i = 0; $i < count($pcount); $i++){
																if($pcount[$i] == $profession->id){
																	$spec_list .= '<span class="col-lg-4 col-md-4 col-sm-6 col-xs-12"><input type="checkbox" name="profession[]" class="form-control" value="'.$profession->id.'" checked="checked"/> '.$profession->name.'</span>&nbsp;';
																	$selected[] = $profession->id;
																}
															}
														}
														
														//only display non-selected
														if(!in_array($profession->id, $selected)){
															$all_spec_list .= '<span class="col-lg-4 col-md-4 col-sm-6 col-xs-12"><input type="checkbox" name="profession[]" class="form-control" value="'.$profession->id.'" /> '.$profession->name.'</span>&nbsp;';
														}
													}
												}
											?>
                                            <div>
                                                <?php
                                                	if(!empty($spec_list)){
														echo '
															<div class="col-lg-12 text-muted bg-default">
																<div class="col-lg-12"><small>Selected Profession(s), Uncheck to remove.</small></div>
																<div class="col-lg-12">'.$spec_list.'</div>
															</div>
														';
													}
												?>
                                                <?php echo $all_spec_list; ?>
                                            </div>
                                        </div>
                                    </div>
                              	</div>
                                
                                <div class="panel panel-default">
                  					<div class="panel-heading panel-heading-gray" style="text-transform:uppercase;">
                    					<i class="fa fa-fw fa-info-circle fa-2x"></i> <b>Contact Information</b>
                  					</div>
                  					<div class="panel-body">
                                    	<div class="form-inline">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <div>
                                                    <input name="phone" type="text" class="form-control" placeholder="Phone Number" value="<?php if(!empty($log_user_phone)){echo $log_user_phone;} ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <div>
                                                    <input name="email" type="email" class="form-control" placeholder="Email Address" value="<?php if(!empty($log_user_email)){echo $log_user_email;} ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <div>
                                                <textarea name="address" id="address" class="form-control"><?php if(!empty($log_user_address)){echo $log_user_address;} ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <label>State</label>
                                                <div>
                                                    <input name="city" type="text" class="form-control" placeholder="State" value="<?php if(!empty($log_user_city)){echo $log_user_city;} ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Country</label>
                                                <div>
                                                    <?php
														$country_list = '';
														if(!empty($allcountry)){
															foreach($allcountry as $country){
																if(!empty($log_user_country_id)){
																	if($log_user_country_id == $country->id){
																		$c_sel = 'selected="selected"';
																	} else {$c_sel = '';}
																} else {$c_sel = '';}
																$country_list .= '<option value="'.$country->id.'" '.$c_sel.'>'.$country->name.'</option>';	
															}
														}
													?>
                                                    
                                                    <select data-placeholder="Country" class="form-control chosen" name="country" required="required">
                                                        <option>Select Country</option>
                                                        <?php echo $country_list; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              	</div>
                                
                                <div class="panel panel-default">
                  					<div class="panel-heading panel-heading-gray" style="text-transform:uppercase;">
                    					<i class="fa fa-fw fa-info-circle fa-2x"></i> <b>Social Information</b>
                  					</div>
                  					<div class="panel-body">
                                    	<div class="form-group">
                                            <label>Website <small class="text-muted">(eg http://your-site.com)</small></label>
                                            <div>
                                                <input name="website" type="text" class="form-control" placeholder="Website" value="<?php if(!empty($log_user_website)){echo $log_user_website;} ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Facebook <small class="text-muted">(eg http://fabebook.com/your-fb-page)</small></label>
                                            <div>
                                                <input name="fb_page" type="text" class="form-control" placeholder="Facebook Page" value="<?php if(!empty($log_user_facebook)){echo $log_user_facebook;} ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Twitter <small class="text-muted">(eg http://twitter.com/your-twitter-handle)</small></label>
                                            <div>
                                                <input name="twitter" type="text" class="form-control" placeholder="Twitter Page" value="<?php if(!empty($log_user_twitter)){echo $log_user_twitter;} ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>LinkedIn <small class="text-muted">(eg http://linkedin.com/in/your-linkedin-page)</small></label>
                                            <div>
                                                <input name="linkedin" type="text" class="form-control" placeholder="LinkedIn Page" value="<?php if(!empty($log_user_linkedin)){echo $log_user_linkedin;} ?>" />
                                            </div>
                                        </div>
                                    </div>
                              	</div>
    
                                <div class="panel-body">
                                	<button type="submit" class="btn btn-primary stepy-finish pull-right"><i class="fa fa-save mr5"></i> Update Record</button>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
      	</div>