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
                                    	<h2><i class="ti-book"></i> Manage Club Facts</h2>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12"></div>
                                
                                <div class="col-lg-12">
                                	<?php echo $err_msg; ?>
                                  
									<?php echo form_open('facts/add') ?>
                                        <div class="form-inline">
                                            <div class="input-group mb15">
                                                <?php
                                                    $club_sel='';
													$select_club = '';
													if(!empty($allclub)){
                                                        foreach($allclub as $club){
															if(!empty($e_club_id)){
																if($e_club_id == $club->id){
																	$club_sel='selected="selected"';
																}
															}
															
															$select_club .= '<option value="'.$club->id.'" '.$club_sel.'>'.$club->name.'</option>';
															$club_sel = '';
														}
                                                    }
                                                ?>
                                                <input type="hidden" name="fact_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
                                                <select data-placeholder="Club" class="form-control chosen" name="club_id" required="required">
                                                    <option>Select Club</option>
                                                    <?php echo $select_club; ?>
                                                </select>
                                            </div>
                                            <div class="input-group mb15">
                                                <input name="date" type="text" class="form-control datepicker" placeholder="Fact Date" value="<?php if(!empty($e_fact_date)){echo $e_fact_date;} ?>" required="required">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Fact Details</label>
                                            <div>
                                                <textarea id="editor" name="details" data-provide="markdown" contenteditable="true" data-iconlibrary="fa" placeholder="Fact Details" required="required" style="padding:5px; background-color:#fff;" rows="10"><?php if(!empty($e_fact_details)){echo $e_fact_details;} ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-info btn-lg"><i class="ti-book"></i> Update Record</button><br /><br />
                                      <?php echo form_close() ?>
                                </div>
                                
                                <?php
									$ins =& get_instance();
									$ins->load->model('m_clubs');
									$dir_list = '';
									if(!empty($allfact)){
										foreach($allfact as $fact){
											//only admin can see delete
											if(strtolower($log_user_role) == 'administrator'){
												$del_btn = '<a href="'.base_url().'facts/add?del='.$fact->id.'" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> <b>Delete</b></a>';
											} else {$del_btn = '';}
											
											//get club name
											$gc = $ins->m_clubs->query_single_club_id($fact->club_id);
											if(!empty($gc)){
												foreach($gc as $c){
													$club_name = $c->name;	
												}
											} else {$club_name='';}
											
											$dir_list .= '
												<tr>
													<td>'.$fact->fact_year.'</td>
													<td>'.$club_name.'</td>
													<td>'.character_limiter($fact->fact_details,30).'</td>
													<td>
														<a href="'.base_url().'facts/add?edit='.$fact->id.'" class="btn btn-primary btn-xs"><i class="ti-pencil"></i> <b>Edit</b></a>
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
                                            <h5><i class="ti-book"></i> Club Facts</h5>
                                        </header>
                                        <div class="panel-body">
                                            <div class="table-responsive no-border">
                                                <table id="sfhtblist" class="table table-bordered table-striped mg-t datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>Fact Date</th>
                                                            <th>Club</th>
                                                            <th>Fact</th>
                                                            <th width="120">Manage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<?php echo $dir_list; ?>
                                                    </tbody>
                                                    <tfoot>
                                                    	<tr>
                                                            <th>Fact Date</th>
                                                            <th>Club</th>
                                                            <th>Fact</th>
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