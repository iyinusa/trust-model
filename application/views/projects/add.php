<?php include(APPPATH.'libraries/inc.php'); ?>
        <div class="container-fluid">
            <div id="filter">
              <h4><i class="fa fa-plus"></i> Create New Project/Task</h4></div>
            
              <div class="row">
            	<div class="col-lg-6">
					<?php echo $err_msg; ?>
                  
                    <?php echo form_open('projects/add') ?>
                        <div class="form-group mr5">
                            <input name="project_id" type="hidden" value="<?php if(!empty($e_id)){echo $e_id;} ?>">
                            <input name="title" type="text" placeholder="Title" class="form-control" value="<?php if(!empty($e_title)){echo $e_title;} ?>" required="required">
                        </div>
                        <div class="form-group mr5">
                        	<textarea name="details" placeholder="Details" rows="8" class="summernote"><?php if(!empty($e_details)){echo $e_details;} ?></textarea>
                        </div>
                        
                        <hr />
                        
                        <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save Project</button><br /><br />
                	<?php echo form_close() ?>
                </div>
                
                <div class="col-lg-6">
                	<?php
						$dir_list = '';
						if(!empty($allprojects)){
							foreach($allprojects as $projects){
								$dir_list .= '
									<tr>
										<td><small>'.date('d M Y', strtotime($projects->reg_date)).'</small></td>
										<td>'.$projects->title.'</td>
										<td align="center">
											<a href="'.base_url().'projects/add/?edit='.$projects->id.'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
											<a href="'.base_url().'projects/add?del='.$projects->id.'" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></a>
										</td>
									</tr>
								';	
							}
						}
					?>
                    
                    <?php if(!empty($rec_del)){ ?>
						<?php if($rec_del!=''){ ?>
                            <?php echo form_open_multipart('projects/delete'); ?>
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
                                <h5><i class="fa fa-briefcase"></i> My Projects/Tasks</h5>
                            </header>
                            <div class="panel-body">
                                <div class="table-responsive no-border">
                                    <table id="dttable" class="table table-striped mg-t datatable">
                                        <thead>
                                            <tr>
                                                <th width="100">Date</th>
                                                <th>Title</th>
                                                <th width="50">Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $dir_list; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th width="100">Date</th>
                                                <th>Title</th>
                                                <th width="50">Manage</th>
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