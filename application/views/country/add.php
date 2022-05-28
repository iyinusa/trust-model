<?php include(APPPATH.'libraries/inc.php'); ?>
		<div class="container-fluid">
            <div id="filter">
              <h4><i class="fa fa-pencil"></i> Manage Country</h4>
            </div>
            
            <div class="row">
            	<div class="col-lg-12">
					<?php echo $err_msg; ?>
                  
                    <?php echo form_open('country/add') ?>
                        <div class="form-group mr5">
                            <input name="country_id" type="hidden" value="<?php if(!empty($e_id)){echo $e_id;} ?>">
                            <input name="name" type="text" placeholder="Country Name" class="form-control" value="<?php if(!empty($e_name)){echo $e_name;} ?>" required="required">
                        </div>
                        
                        <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Update Record</button><br /><br />
                      <?php echo form_close() ?>
                </div>
                                
				<?php
                    $dir_list = '';
                    if(!empty($allcountry)){
                        foreach($allcountry as $country){
                            //only admin can see delete
                            if(strtolower($log_user_role) == 'administrator'){
                                $del_btn = '<a href="'.base_url().'country/add?del='.$country->id.'" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> <b>Delete</b></a>';
                            } else {$del_btn = '';}
                            
                            $dir_list .= '
                                <tr>
                                    <td>'.ucwords($country->name).'</td>
                                    <td align="center">
                                        <a href="'.base_url().'country/add?edit='.$country->id.'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> <b>Edit</b></a>
                                        '.$del_btn.'
                                    </td>
                                </tr>
                            ';	
                        }
                    }
                ?>
                
                <?php if(!empty($rec_del)){ ?>
					<?php if($rec_del!=''){ ?>
                        <?php echo form_open_multipart('country/delete'); ?>
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
                            <h5><i class="fa fa-briefcase"></i> Country</h5>
                        </header>
                        <div class="panel-body">
                            <div class="table-responsive no-border">
                                <table id="dttable" class="table table-striped mg-t datatable">
                                    <thead>
                                        <tr>
                                            <th>Country</th>
                                            <th width="150" align="center">Manage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $dir_list; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Country</th>
                                            <th align="center">Manage</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
       	</div>