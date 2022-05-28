<?php include(APPPATH.'libraries/inc.php'); ?>
		<div class="container-fluid">
            <div id="filter">
              <h4><i class="fa fa-star-o"></i> Manage Trust Rating Scale</h4></div>
            
            <div class="row">
            	<div class="col-lg-12">
					<?php echo $err_msg; ?>
                  
                    <?php echo form_open('admin/trs/add') ?>
                        <div class="form-group mr5">
                            <input name="trs_id" type="hidden" value="<?php if(!empty($e_id)){echo $e_id;} ?>">
                            <input name="name" type="text" placeholder="Rating" class="form-control" value="<?php if(!empty($e_name)){echo $e_name;} ?>" required="required">
                        </div>
                        <div class="form-inline mr5">
                        	<input name="degree" type="text" placeholder="Degree e.g. 0" class="form-control" value="<?php if(!empty($e_degree)){echo $e_degree;} ?>" required="required">
                            <input name="value" type="text" placeholder="Value e.g. 0.0" class="form-control" value="<?php if(!empty($e_value)){echo $e_value;} ?>" required="required">
                        </div>
                        
                        <hr />
                        
                        <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Update Record</button><br /><br />
                	<?php echo form_close() ?>
                </div>
                
                <div class="col-lg-12">
                	<?php
						$dir_list = '';
						if(!empty($alltrs)){
							foreach($alltrs as $trs){
								//only admin can see delete
								if(strtolower($log_user_role) == 'administrator'){
									$del_btn = '<a href="'.base_url().'admin/trs/add?del='.$trs->id.'" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> <b>Delete</b></a>';
								} else {$del_btn = '';}
								
								//compute rating star
								if($trs->degree == 5){
									$rate_star = '<span class="text-warning"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>';
								} else if($trs->degree == 4){
									$rate_star = '<span class="text-warning"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i></span>';
								} else if($trs->degree == 3){
									$rate_star = '<span class="text-warning"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></span>';
								} else if($trs->degree == 2){
									$rate_star = '<span class="text-warning"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></span>';
								} else if($trs->degree == 1){
									$rate_star = '<span class="text-warning"><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></span>';
								} else if($trs->degree == 0) {
									$rate_star = '<span class="text-warning"><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></span>';
								} else {
									$rate_star = '<span class="text-warning"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>';	
								}
								
								$dir_list .= '
									<tr>
										<td>'.$trs->name.'</a></td>
										<td>'.$trs->degree.'</td>
										<td>'.$trs->value.' '.$rate_star.'</td>
										<td align="center">
											<a href="'.base_url().'admin/trs/add/?edit='.$trs->id.'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> <b>Edit</b></a>
											'.$del_btn.'
										</td>
									</tr>
								';	
							}
						}
					?>
                    
                    <?php if(!empty($rec_del)){ ?>
						<?php if($rec_del!=''){ ?>
                            <?php echo form_open_multipart('admin/trs/delete'); ?>
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
                                <h5><i class="fa fa-star-o"></i> Rating Degree and Value Reputation</h5>
                            </header>
                            <div class="panel-body">
                                <div class="table-responsive no-border">
                                    <table id="sfhtblist" class="table table-striped mg-t">
                                        <thead>
                                            <tr>
                                                <th>Rating</th>
                                                <th>Degree</th>
                                                <th>Value</th>
                                                <th width="150">Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $dir_list; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Rating</th>
                                                <th>Degree</th>
                                                <th>Value</th>
                                                <th width="150">Manage</th>
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