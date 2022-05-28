<?php include(APPPATH.'libraries/inc.php'); ?>
<?php
	$ins_obj =& get_instance();
	$ins_obj->load->model('m_moots');
	$ins_obj->load->model('m_clubs');
	$ins_obj->load->model('users');
	$page_owner = '';
	$club_info = '';
	$moot_list = '';
	$moot_com_list = '';
	$fan_display_name = '';
	if(!empty($allmoots)){
		foreach($allmoots as $mt){
			$moot_id = $mt->id;
			$fan_id = $mt->fan_id;
			$club_id = $mt->club_id;
			$moot_detail = $mt->moot;
			$status = $mt->status;
			$privacy = $mt->privacy;
			$reg_date = $mt->reg_date;
			
			$reg_date_ago = timespan(strtotime($reg_date), time());
			$reg_date = date(('D, j M Y H:m'), strtotime($reg_date));
			
			//get post fan details
			$gf = $this->users->query_single_user_id($fan_id);
			foreach($gf as $f){
				$f_nicename = $f->user_nicename;
				$f_display_name = $f->display_name;
				$f_club_id = $f->club_id;
				$f_club_ban = $f->club_ban;
				$f_pics_small = $f->pics_small;
				if($f_pics_small=='' || file_exists(FCPATH.$f_pics_small)==FALSE){$f_pics_small='img/avatar.jpg';}		
			}
			
			//get post club details
			$gc = $this->m_clubs->query_single_club_id($club_id);
			if(!empty($gc)){
				foreach($gc as $c){
					$c_name = ucwords($c->name);
					//check if fan has decamped
					if($f_club_id!=$c->id){$club_info = '| Formally';}else{$club_info = '';}
				}
			} else {$c_name='No Club';$club_info='';}
			
			//get comment
			$moot_com_list = '';
			$club_r_info = '';
			$moot_com = $this->m_moots->query_moot_reply($moot_id);
			$com_count = count($moot_com);
			if($com_count<=1){$com_count=$com_count.' Comment';}else{$com_count=$com_count.' Comments';}
			if(!empty($moot_com)){
				foreach($moot_com as $com){
					$r_moot_id = $com->id;
					$r_fan_id = $com->fan_id;
					$r_club_id = $com->club_id;
					$r_reply = $com->reply;
					$r_status = $com->status;
					$r_reg_date = $com->reg_date;	
					
					$r_reg_date_ago = timespan(strtotime($r_reg_date), time());
					$r_reg_date = date(('D, j M Y H:m'), strtotime($r_reg_date));
					
					//get comment fan details
					$rgf = $this->users->query_single_user_id($r_fan_id);
					foreach($rgf as $rf){
						$r_f_nicename = $rf->user_nicename;
						$r_f_display_name = $rf->display_name;
						$r_f_club_id = $rf->club_id;
						$r_f_club_ban = $rf->club_ban;
						$r_f_pics_small = $rf->pics_small;
						if($r_f_pics_small=='' || file_exists(FCPATH.$r_f_pics_small)==FALSE){$r_f_pics_small='img/avatar.jpg';}		
					}
					
					//get post club details
					$rgc = $this->m_clubs->query_single_club_id($r_club_id);
					if(!empty($rgc)){
						foreach($rgc as $rc){
							$r_c_name = ucwords($rc->name);
							//check if comment fan has decamped
							if($r_f_club_id!=$rc->id){$club_r_info = '| Formally';}else{$club_r_info = '';}
						}
					} else {$r_c_name = 'No Club';}
					
					//prepare admin buttons for moot replies
					if($log_user == TRUE) {
						if($log_user_id==$r_fan_id || $log_user_role=='editor' || $log_user_role=='administrator'){
							$reply_del_btn = '
								<a href="javascript:;" class="text-muted mr10" onclick="delmootreply'.$r_moot_id.'();"><i class="ti-trash mr5"></i>Delete</a>
								<script type="text/javascript">
									function delmootreply'.$r_moot_id.'(){
										var hr = new XMLHttpRequest();
										var del_moot_reply_id = '.$r_moot_id.';
										var del_reply_fan_id = '.$r_fan_id.';
										var c_vars = "del_moot_reply_id="+del_moot_reply_id+"&del_reply_fan_id="+del_reply_fan_id;
										hr.open("POST", "'.base_url().'moots/delete_reply", true);
										hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
										hr.onreadystatechange = function() {
											if(hr.readyState == 4 && hr.status == 200) {
												var return_data = hr.responseText;
												document.getElementById("moot-reply-del-msg'.$r_moot_id.'").innerHTML = return_data;
										   }
										}
										hr.send(c_vars);
										document.getElementById("moot-reply-del-msg'.$r_moot_id.'").innerHTML = "<i class=\"icon-spin4 animate-spin loader\"></i>";
									}
								</script>
							';
						} else {$reply_del_btn='';}
					} else {$reply_del_btn='';}
					
					if($r_status==1){
						$moot_com_list .= '
							<hr />
							<div id="moot-reply-del-msg'.$r_moot_id.'" class="media">
								<a class="pull-left" href="'.base_url('fan/'.$r_f_nicename).'">
									<img class="media-object avatar avatar-sm" src="'.base_url($r_f_pics_small).'" alt="">
								</a>
								<div class="comment">
									<div class="comment-author h6 no-m">
										<a href="'.base_url('fan/'.$r_f_nicename).'"><b>'.$r_f_display_name.' <small class="text-muted">'.$r_c_name.' '.$club_r_info.'</small></b></a>
									</div>
									<div class="comment-meta small">'.$r_reg_date.' ('.$r_reg_date_ago.' ago)</div>
									<p>
										'.$r_reply.'
									</p>
									<p class="small">
										'.$reply_del_btn.'
									</p>
								</div>
							</div>
						';
					}
				}
			}
			
			//prepare comment form
			if($log_user == TRUE){
				$com_form = '
					<hr />
					<div id="moot-reply-msg'.$moot_id.'"></div>
					<div class="media">
						<a class="pull-left" href="'.base_url('fan/'.$log_user_nicename).'">
							<img class="media-object avatar avatar-sm" src="'.base_url($log_user_pics_small).'" alt="">
						</a>
						<div class="comment">
							<div class="form-group no-m">
								<div class="input-group">
									<input type="hidden" id="reply_moot_id'.$moot_id.'" name="reply_moot_id" value="'.$moot_id.'" />
									<input type="text" id="reply_moot'.$moot_id.'" name="reply_moot" class="form-control input-sm no-border" placeholder="Join the conversation">
									<span class="input-group-btn">
									<button id="submit-moot-reply'.$moot_id.'" class="btn btn-default btn-sm" type="button" onclick="postmootreply'.$moot_id.'();"><i class="ti-thought"></i> Moot It!</button>
								</span>
								</div>
							</div>
						</div>
					</div>
					<script type="text/javascript">
						function postmootreply'.$moot_id.'(){
							var hr = new XMLHttpRequest();
							var reply_moot_id = document.getElementById("reply_moot_id'.$moot_id.'").value;
							var reply_moot = document.getElementById("reply_moot'.$moot_id.'").value;
							var c_vars = "reply_moot_id="+reply_moot_id+"&reply_moot="+reply_moot;
							hr.open("POST", "'.base_url().'moots/reply", true);
							hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
							hr.onreadystatechange = function() {
								if(hr.readyState == 4 && hr.status == 200) {
									var return_data = hr.responseText;
									document.getElementById("moot-reply-msg'.$moot_id.'").innerHTML = return_data;
							   }
							}
							hr.send(c_vars);
							document.getElementById("moot-reply-msg'.$moot_id.'").innerHTML = "<i class=\"icon-spin4 animate-spin loader\"></i>";
							document.getElementById("reply_moot'.$moot_id.'").value = "";
						}
					</script>
				';
			} else {$com_form = '';}
			
			//prepare admin buttons for moots
			if($log_user == TRUE) {
				if($log_user_id==$fan_id || $log_user_role=='editor' || $log_user_role=='administrator'){
					$del_btn = '
						<a href="javascript:;" class="text-muted mr10" onclick="delmoot'.$moot_id.'();"><i class="ti-trash mr5"></i>Delete</a>
						<script type="text/javascript">
							function delmoot'.$moot_id.'(){
								var hr = new XMLHttpRequest();
								var del_moot_id = '.$moot_id.';
								var del_fan_id = '.$fan_id.';
								var c_vars = "del_moot_id="+del_moot_id+"&del_fan_id="+del_fan_id;
								hr.open("POST", "'.base_url().'moots/delete", true);
								hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
								hr.onreadystatechange = function() {
									if(hr.readyState == 4 && hr.status == 200) {
										var return_data = hr.responseText;
										document.getElementById("moot-del-msg'.$moot_id.'").innerHTML = return_data;
								   }
								}
								hr.send(c_vars);
								document.getElementById("moot-del-msg'.$moot_id.'").innerHTML = "<i class=\"icon-spin4 animate-spin loader\"></i>";
							}
						</script>
					';
				} else {$del_btn='';}
			} else {$del_btn='';}
			
			if($privacy==0 && $status==1){
				$moot_list .= '
					<div id="moot-del-msg'.$moot_id.'" class="media p15">
						<a class="pull-left" href="'.base_url('fan/'.$f_nicename).'">
							<img class="media-object avatar avatar-sm" src="'.base_url($f_pics_small).'" alt="">
						</a>
						<div class="comment">
							<div class="comment-author h6 no-m">
								<a href="'.base_url('fan/'.$f_nicename).'"><b>'.$f_display_name.'</b> <small class="text-muted">'.$c_name.' '.$club_info.'</small></a>
							</div>
							<div class="comment-meta small">'.$reg_date.' ('.$reg_date_ago.' ago)</div>
							<p>
								'.$moot_detail.'
							</p>
							<p class="small">
								<a href="'.base_url('moot/'.$moot_id).'" class="text-muted mr10"><i class="ti-comment mr5"></i>'.$com_count.'</a>
								<!--<a href="javascript:;" class="text-muted mr10"><i class="ti-share mr5"></i>Share</a>-->
								'.$del_btn.'
							</p>
							'.$moot_com_list.'
							'.$com_form.'
						</div>
					</div><hr />
				';	
			} $moot_id = ''; //clear moot id
		}
	} else {
		if($page_active=='club'){$page_owner = $club_name;}else{$page_owner = $fan_display_name;}
		$moot_list = '<h3 class="text-center text-muted">'.$page_owner.' has no Moot yet</h3>';
	}
?>