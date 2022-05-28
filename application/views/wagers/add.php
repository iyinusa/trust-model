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
                                    	<h2><i class="ti-pulse"></i> Start Wager <small class="text-muted">Start A Bet</small></h2>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12"></div>
                                
                                <div class="col-lg-12">
                                	<hr />
									<?php echo $err_msg; ?>
                                  
									<?php echo form_open('wagers/add'); ?>
                                        <div class="form-inline">
                                        	<h3><?php if(!empty($e_content)){echo $e_content.'<hr />';} ?></h3>
											<?php
												$ins_obj =& get_instance();
												$ins_obj->load->model('m_clubs');
												$wclub = $ins_obj->m_clubs->query_all_club();
												$a_wclub_list = '';
												$b_wclub_list = '';
												$ca_act='';
												$cb_act='';
												if(!empty($wclub)){
													foreach($wclub as $witem){
														if(!empty($e_content)){
															$a_content = explode(' VS ', $e_content);
															if($witem->name == $a_content[0]){$ca_act='selected="selected"';}else{$ca_act='';}
															if($witem->name == $a_content[1]){$cb_act='selected="selected"';}else{$cb_act='';}
														}	
														$a_wclub_list .= '<option value="'.$witem->name.'" '.$ca_act.'>'.$witem->name.'</option>';
														$b_wclub_list .= '<option value="'.$witem->name.'" '.$cb_act.'>'.$witem->name.'</option>';	
													}
												}
											?>
                                            <div class="input-group">
                                                <label>Club A:</label>
                                                <select data-placeholder="Select Club A" class="chosen" name="clubA" style="width:100px;" required="required">
                                                    <option>Select Club A</option>
                                                    <?php echo $a_wclub_list; ?>
                                                </select>
                                            </div>&nbsp;VS&nbsp;
                                            <div class="input-group">
                                                <label>Club B:</label>
                                                <select data-placeholder="Select Club B" class="chosen form-control" name="clubB" required="required">
                                                    <option>Select Club B</option>
                                                    <?php echo $b_wclub_list; ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <hr />
                                        
                                        <div class="form-inline">
                                            <div class="input-group mb15">
                                               	<input type="hidden" name="wager_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
                                                <?php
													if(!empty($e_type)){
														if($e_type=='One-To-One'){$t1='selected="selected"';}else{$t1='';}
														if($e_type=='One-To-Many'){$t2='selected="selected"';}else{$t2='';}
													} else {$t1='';$t2='';}
												?>
                                                <select data-placeholder="Wager Type" class="chosen" name="type" required="required" style="width:100px;" required="required">
                                                    <option>Select Wager Type</option>
                                                    <option value="One-To-One" <?php echo $t1; ?>>One-To-One</option>
                                                    <?php if($log_user_pro==1 || $log_user_role=='administrator'){ ?>
                                                    	<option value="One-To-Many" <?php echo $t2; ?>>One-To-Many</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="input-group mb15">
                                                <input name="starts" type="text" class="form-control datepicker" placeholder="Start Date" value="<?php if(!empty($e_starts)){echo $e_starts;} ?>" required="required">
                                            </div>
                                            <?php if($log_user_role=='editor' || $log_user_role=='administrator'){ ?>
                                                <div class="input-group mb15">
                                                    <input name="ends" type="text" class="form-control datepicker" placeholder="End Date" value="<?php if(!empty($e_ends)){echo $e_ends;} ?>">
                                                </div>
                                            <?php } ?>
                                            <div class="input-group mb15">
                                                <input name="amt" type="text" class="form-control" placeholder="&#8358; Amount" value="<?php if(!empty($e_amt)){echo $e_amt;} ?>" required="required" <?php if(!empty($e_amt)){echo 'readonly="readonly"';} ?>>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Comment/Remark <i>(optional)</i></label>
                                            <div>
                                                <textarea class="form-control" name="remark" placeholder="Your bet comment/remark e.g. Chelsea will win Arsenal" rows="3"><?php if(!empty($e_remark)){echo $e_remark;} ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="form-inline">
                                        	<?php if($log_user_role=='editor' || $log_user_role=='administrator'){ ?>
                                                <?php
													if(!empty($e_status)){
														if($e_status==0){$s1='selected="selected"';}else{$s1='';}
														if($e_status==1){$s2='selected="selected"';}else{$s2='';}	
													} else {$s1='';$s2='';}
												?>
                                                <div class="input-group">
                                                    <label>Status</label>
                                                    <select data-placeholder="Select Status" class="chosen" name="status" style="width:100px;">
                                                    	<option value="0" <?php echo $s1; ?>>Close</option>
                                                        <option value="1" <?php echo $s2; ?>>Open</option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                            <?php if($log_user_pro==1 || $log_user_role=='administrator'){ ?>
                                                <?php
													if(!empty($e_privacy)){
														if($e_privacy==0){$p1='selected="selected"';}else{$p1='';}
														if($e_privacy==1){$p2='selected="selected"';}else{$p2='';}	
													} else {$p1='';$p2='';}
												?>
                                                <div class="input-group">
                                                    <label>Set Privacy</label>
                                                    <select data-placeholder="Select Privacy" class="chosen" name="privacy" style="width:100px;">
                                                    	<option value="0" <?php echo $p1; ?>>Show Identity</option>
                                                        <option value="1" <?php echo $p1; ?>>Hide Identity</option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        
                                        <hr />
                                        
                                        <button type="submit" class="btn btn-info btn-lg"><i class="ti-pulse"></i> Update Wager</button><br /><br />
                             		<?php echo form_close(); ?>
                                </div>
                                
                            </div>
                            
                            <div class="col-md-4">