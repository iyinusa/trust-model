<?php include(APPPATH.'libraries/inc.php'); ?>
        <div class="container-fluid">
            <div id="filter">
              <h4><i class="fa fa-share"></i> Invite To Network</h4></div>
            
            <div class="row">
            	<div class="col-sm-6">
                	<?php echo $err_msg; ?>
					<?php echo form_open_multipart('members/invite') ?>
                        <div class="form-group">
                            <h6>Insert Email Address to Invite user to Join Network</h6>
                           	<input name="invite" type="text" class="form-control" placeholder="Enter Email Address"><br />
                            <b>Invitation Message (optional)</b>
                            <textarea name="msg" class="form-control" placeholder="Invitation Message (optional)"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary stepy-finish pull-left"><i class="fa fa-save"></i> Send Invitation</button>
                    <?php echo form_close() ?>
                </div>
                
                <div class="col-sm-6">
                	<?php
						$dir_list = '';
						if(!empty($allinvite)){
							foreach($allinvite as $invite){
								if($invite->status == 0){$status = '<span class="label label-primary">Pending</span>';} else {$status = '<span class="label label-success">Joined</span>';}
								
								$dir_list .= '
									<tr>
										<td>'.$invite->email.'</td>
										<td>'.$status.'</td>
										<td align="center">
											<a href="'.base_url().'members/invite?resend='.$invite->id.'" class="btn btn-primary btn-xs">Send <i class="fa fa-arrow-circle-o-right"></i></a>
										</td>
									</tr>
								';	
							}
						}
					?>
                    <section class="panel panel-default">
                        <header class="panel-heading">
                            <h5><i class="fa fa-share"></i> Invitations</h5>
                        </header>
                        <div class="panel-body">
                            <div class="table-responsive no-border">
                                <table id="dttable" class="table table-striped mg-t datatable">
                                    <thead>
                                        <tr>
                                            <th>Email Address</th>
                                            <th>Status</th>
                                            <th align="center">Re-send</th>
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