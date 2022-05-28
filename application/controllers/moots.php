<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Moots extends CI_Controller {

	function __construct(){
        parent::__construct();
		$this->load->model('users'); //load MODEL
		$this->load->model('m_clubs'); //load MODEL
		$this->load->model('m_moots'); //load MODEL
		$this->load->helper('text'); //for content limiter
		$this->load->library('form_validation'); //load form validate rules
		$this->load->helper('url');
		
		//mail config settings
		$this->load->library('email'); //load email library
		//$config['protocol'] = 'sendmail';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		//$config['charset'] = 'iso-8859-1';
		//$config['wordwrap'] = TRUE;
		
		//$this->email->initialize($config);
    }
	
	public function index()
	{
		$all_club = $this->m_clubs->query_all_club();
		if(!empty($all_club)) {
			$data['allclub'] = $all_club;
		}
		
		if($_POST){
			$moot = $_POST['moot'];
			
			if($moot == ''){exit;}
			
			if($this->m_moots->check_moot($moot) <= 0){
				$now = date("Y-m-d H:i:s");
				$now_group = date("F Y");
				$fan_id = $this->session->userdata('sfh_id');
				$club_id = $this->session->userdata('sfh_user_club_id');
				$fan_display_name = ucwords($this->session->userdata('sfh_display_name'));
				$log_user_nicename = $this->session->userdata('sfh_user_nicename');
				
				$log_user_pics_small = $this->session->userdata('sfh_user_pics_small');
				if($log_user_pics_small=='' || file_exists(FCPATH.$log_user_pics_small)==FALSE){$log_user_pics_small='img/avatar.jpg';}
				
				//get club name
				$gcn = $this->m_clubs->query_single_club_id($club_id );
				if(!empty($gcn)){
					foreach($gcn as $cn){
						$club_name = $cn->name;	
					}
				} else {$club_name = 'No Club';}
				
				$reg_data = array(
					'fan_id' => $fan_id,
					'club_id' => $club_id,
					'moot' => $moot,
					'privacy' => 0,
					'status' => 1,
					'reg_date' => $now
				);
				
				$insert_id = $this->m_moots->reg_insert($reg_data);
				if($insert_id){
					//try give fan 5 point
					$reg_point = array(
						'user_id' => $fan_id,
						'point' => 5,
						'purpose' => 'Moot bonus',
						'reg_date' => $now
					);
					
					$this->users->reg_point($reg_point);
					
					//try register activity
					$reg_activity = array(
						'type' => 'moot',
						'fan_id' => $fan_id,
						'p_id' => $insert_id,
						's_id' => $insert_id,
						'content' => $moot,
						'reg_date' => $now
					);
					
					$this->users->reg_activity($reg_activity);
					
					//try send mail to all fans
					$gall = $this->users->query_all_user();
					foreach($gall as $all){
						if($fan_id != $all->ID){
							//try register notification
							$reg_notify = array(
								'type' => 'moot',
								'fan_id' => $fan_id,
								'receive_id' => $all->ID,
								'p_id' => $insert_id,
								's_id' => $insert_id,
								'content' => $moot,
								'reg_date' => $now,
								'date_group' => $now_group
							);
							
							$this->users->reg_notification($reg_notify);
							
							/////////////////////////////////////////////////////////////////////////////////////
							//send notification mail to all fans
							$this->email->clear(); //clear initial email variables
							$this->email->to($all->user_email);
							$this->email->from('info@soccerfanhub.com','SoccerFanHub');
							$this->email->subject('Moot from '.$fan_display_name.' ('.$club_name.')');
							
							//compose html body of mail
							$mail_subhead = 'Moot from '.$fan_display_name.' ('.$club_name.')';
							$body_msg = '
								<div style="overflow:auto;">
								<img alt="" src="'.base_url($log_user_pics_small).'" width="50px" style="float:left; margin-right:10px;" />
								'.$fan_display_name.' ('.$club_name.') started a new Moot:<br /><br />'.$moot.'<br /><br /></div>
								<a href="'.base_url('moot/'.$insert_id).'" class="email_btn">View Now</a>
							';
							
							$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
							$this->email->set_mailtype("html"); //use HTML format
							$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
		 
							$this->email->message($mail_design);
							
							if($this->email->send()) {}
						}
					}
					
					if($moot != ''){
						echo '
							<div class="media p15">
								<a class="pull-left" href="'.base_url('fan/'.$log_user_nicename).'">
									<img class="media-object avatar avatar-sm" src="'.base_url($log_user_pics_small).'" alt="">
								</a>
								<div class="comment">
									<div class="comment-author h6 no-m">
										<a href="'.base_url('fan/'.$log_user_nicename).'"><b>'.$fan_display_name.'</b></a>
									</div>
									<div class="comment-meta small">'.date(('D, j M Y H:m'), strtotime($now)).' (now)</div>
									<p>
										'.$moot.'
									</p>
									<!--<p class="small">
										<a href="javascript:;" class="text-muted mr10"><i class="ti-comment mr5"></i>Comment</a>
										<a href="javascript:;" class="text-muted mr10"><i class="ti-share mr5"></i>Share</a>
										<a href="javascript:;" class="mr10 text-danger"><i class="ti-heart mr5"></i>Like</a>
										<a href="javascript:;" class="text-muted mr10"><i class="ti-more mr5"></i>More</a>
										<i class="ti-bookmark text-warning" data-toggle="tooltip" data-original-title="View tags"></i>
									</p>-->
								</div><hr />
							</div>
						';
					}
				}
			} exit;
		}
		
		$data['allmoots'] = $this->m_moots->query_all_moot();
		
		$data['title'] = 'Moots | SoccerFanHub';
		$data['page_active'] = 'moot';

	  	$this->load->view('designs/header', $data);
	  	$this->load->view('moots/moots', $data);
	  	$this->load->view('designs/footer', $data);
	}
	
	public function view($moot){
		$log_user = $this->session->userdata('logged_in');
		$fan_display_name = ucwords($this->session->userdata('sfh_display_name'));
		$log_user_nicename = $this->session->userdata('sfh_user_nicename');
		$log_user_pics_small = $this->session->userdata('sfh_user_pics_small');
		if($log_user_pics_small=='' || file_exists(FCPATH.$log_user_pics_small)==FALSE){$log_user_pics_small='img/avatar.jpg';}
				
		$single_moot = $this->m_moots->query_moot_id($moot);
		$moot_id = '';
		$data['title'] = '';
		$data['pg_link'] = '';
		if(!empty($single_moot)) {
			foreach($single_moot as $row) {
				$moot_id = $row->id;
				$data['title'] = $row->moot.' | SoccerFanHub';
				$data['pg_link'] = $moot;
				$data['fan_id'] = $row->fan_id;
				$data['club_id'] = $row->club_id;
				$data['moot'] = $row->moot;
				$data['status'] = $row->status;
				$data['privacy'] = $row->privacy;
				
				$reg_date_ago = timespan(strtotime($row->reg_date), time());
				$reg_date = date(('D, j M Y H:m'), strtotime($row->reg_date));
													
				$data['reg_date_ago'] = $reg_date_ago.' ago';
				$data['reg_date'] = $reg_date;
				
				//get club details
				$gc = $this->m_clubs->query_single_club_id($row->club_id);
				if(!empty($gc)){
					foreach($gc as $citem){
						$data['club'] = $citem->name;
					}
				} else {$data['club'] = 'No Club';}
				
				//get user details
				$gf = $this->users->query_single_user_id($row->fan_id);
				foreach($gf as $f){
					$data['fan_nicename'] = $f->user_nicename;
					$data['fan_display_name'] = $f->display_name;
					$data['fan_pics_small'] = $f->pics_small;
					if($f->pics_small=='' || file_exists(FCPATH.$f->pics_small)==FALSE){$data['fan_pics_small']='img/avatar.jpg';}		
				}
				
				//get comments
				$data['moot_com_list'] = 'What\'s your Moot on this? <a href="#mootit">Moot It!</a>';
				$moot_com = $this->m_moots->query_moot_reply($row->id);
				$com_count = count($moot_com);
				if($com_count<=1){$data['com_count']=$com_count.' Comment';}else{$data['com_count']=$com_count.' Comments';}
				if(!empty($moot_com)){
					foreach($moot_com as $com){
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
							$r_f_pics_small = $rf->pics_small;
							if($r_f_pics_small=='' || file_exists(FCPATH.$r_f_pics_small)==FALSE){$r_f_pics_small='img/avatar.jpg';}		
						}
						
						//get post club details
						$rgc = $this->m_clubs->query_single_club_id($r_club_id);
						if(!empty($rgc)){
							foreach($rgc as $rc){
								$r_c_name = ucwords($rc->name);
							}
						} else {$r_c_name = 'No Club';}
						
						if($r_status==1){
							$data['moot_com_list'] .= '
								<hr />
								<div id="'.$com->id.'" class="media">
									<a class="pull-left" href="'.base_url('fan/'.$r_f_nicename).'">
										<img class="media-object avatar avatar-sm" src="'.base_url($r_f_pics_small).'" alt="">
									</a>
									<div class="comment">
										<div class="comment-author h6 no-m">
											<a href="'.base_url('fan/'.$r_f_nicename).'"><b>'.$r_f_display_name.' <small class="text-muted">'.$r_c_name.'</small></b></a>
										</div>
										<div class="comment-meta small">'.$r_reg_date.' ('.$r_reg_date_ago.' ago)</div>
										<p>
											'.$r_reply.'
										</p>
										<!--<p class="small">
											<a href="javascript:;" class="text-muted mr10"><i class="ti-comment mr5"></i>Comment</a>
										</p>-->
									</div>
								</div>
							';
						}
					}
				}
				
				//prepare comment form
				if($log_user == TRUE){
					$data['com_form'] = '
						<hr />
						<div id="moot-reply-msg"></div>
						<div class="media">
							<a class="pull-left" href="'.base_url('fan/'.$log_user_nicename).'">
								<img class="media-object avatar avatar-sm" src="'.base_url($log_user_pics_small).'" alt="">
							</a>
							<div class="comment">
								<div class="form-group no-m">
									<div class="input-group">
										<input type="hidden" id="reply_moot_id" name="reply_moot_id" value="'.$moot_id.'" />
										<input type="text" id="reply_moot" name="reply_moot" class="form-control input-sm no-border" placeholder="Join the conversation">
										<span class="input-group-btn">
										<button id="submit-moot-reply" class="btn btn-default btn-sm" type="button" onclick="postmootreply();"><i class="ti-thought"></i> Moot It!</button>
									</span>
									</div>
								</div>
							</div>
						</div>
						<script type="text/javascript">
							function postmootreply(){
								var hr = new XMLHttpRequest();
								var reply_moot_id = document.getElementById("reply_moot_id").value;
								var reply_moot = document.getElementById("reply_moot").value;
								var c_vars = "reply_moot_id="+reply_moot_id+"&reply_moot="+reply_moot;
								hr.open("POST", "'.base_url().'moots/reply", true);
								hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
								hr.onreadystatechange = function() {
									if(hr.readyState == 4 && hr.status == 200) {
										var return_data = hr.responseText;
										document.getElementById("moot-reply-msg").innerHTML = return_data;
								   }
								}
								hr.send(c_vars);
								document.getElementById("moot-reply-msg").innerHTML = "<i class=\"icon-spin4 animate-spin loader\"></i>";
								document.getElementById("reply_moot").value = "";
							}
						</script>
					';
				} else {$data['com_form'] = '';}
				
			}
		} else {redirect(base_url().'moots/', 'refresh');}
		
		$data['page_active'] = 'moot';

	  	$this->load->view('designs/header', $data);
	  	$this->load->view('moots/view', $data);
	  	$this->load->view('designs/footer', $data);
	}
	
	public function reply(){
		if($_POST){
			$moot_id = $_POST['reply_moot_id'];
			$reply = $_POST['reply_moot'];
			$post_id = ''; //to get the post fan id	
			
			if($moot_id=='' || $reply==''){exit;}
			
			if($this->m_moots->check_moot_reply($reply, $moot_id) <= 0){
				$now = date("Y-m-d H:i:s");
				$now_group = date("F Y");
				$fan_id = $this->session->userdata('sfh_id');
				$club_id = $this->session->userdata('sfh_user_club_id');
				$fan_display_name = ucwords($this->session->userdata('sfh_display_name'));
				$log_user_nicename = $this->session->userdata('sfh_user_nicename');
				
				$log_user_pics_small = $this->session->userdata('sfh_user_pics_small');
				if($log_user_pics_small=='' || file_exists(FCPATH.$log_user_pics_small)==FALSE){$log_user_pics_small='img/avatar.jpg';}
				
				//get club name
				$gcn = $this->m_clubs->query_single_club_id($club_id );
				if(!empty($gcn)){
					foreach($gcn as $cn){
						$club_name = $cn->name;	
					}
				} else {$club_name = 'No Club';}
				
				$reg_data = array(
					'moot_id' => $moot_id,
					'fan_id' => $fan_id,
					'club_id' => $club_id,
					'reply' => $reply,
					'status' => 1,
					'reg_date' => $now
				);
				
				$insert_id = $this->m_moots->reg_moot_reply($reg_data);
				if($insert_id){
					//try give fan 2 point
					$reg_point = array(
						'user_id' => $fan_id,
						'point' => 2,
						'purpose' => 'Moot reply bonus',
						'reg_date' => $now
					);
					
					$this->users->reg_point($reg_point);
					
					//try register activity
					$reg_activity = array(
						'type' => 'moot reply',
						'fan_id' => $fan_id,
						'p_id' => $moot_id,
						's_id' => $insert_id,
						'content' => $reply,
						'reg_date' => $now
					);
					
					$this->users->reg_activity($reg_activity);
					
					//sent mail to post fan
					$pf = $this->m_moots->query_moot_id($moot_id);
					foreach($pf as $postfan){
						$post_id = $postfan->fan_id;
						if($post_id != $fan_id){
							//try register notification for post fan
							$reg_notify_fan = array(
								'type' => 'moot reply',
								'fan_id' => $fan_id,
								'receive_id' => $postfan->fan_id,
								'p_id' => $moot_id,
								's_id' => $insert_id,
								'content' => 'Replied one of your Moots: '.$reply,
								'reg_date' => $now,
								'date_group' => $now_group
							);
							
							$this->users->reg_notification($reg_notify_fan);
							
							//get the email
							$ge = $this->users->query_single_user_id($postfan->fan_id);
							foreach($ge as $f_email){$fan_email = $f_email->user_email;}
							
							/////////////////////////////////////////////////////////////////////////////////////
							//send notification mail to fan
							$this->email->clear(); //clear initial email variables
							$this->email->to($fan_email);
							$this->email->from('info@soccerfanhub.com','SoccerFanHub');
							$this->email->subject($fan_display_name.' ('.$club_name.') replied one of your Moots');
							
							//compose html body of mail
							$mail_subhead = 'Moot reply from '.$fan_display_name.' ('.$club_name.')';
							$body_msg = '
								<div style="overflow:auto;">
								<img alt="" src="'.base_url($log_user_pics_small).'" width="50px" style="float:left; margin-right:10px;" />
								'.$fan_display_name.' ('.$club_name.') replied a Moot:<br /><br />'.$reply.'<br /><br /></div>
								<a href="'.base_url('moot/'.$moot_id.'#'.$insert_id).'" class="email_btn">View Now</a>
							';
							
							$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
							$this->email->set_mailtype("html"); //use HTML format
							$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
		 
							$this->email->message($mail_design);
							
							if($this->email->send()) {}
						}
					}
					
					//try send mail to contributing fans
					$cf = $this->m_moots->query_moot_reply_trend_id($moot_id);
					if(!empty($cf)){
						foreach($cf as $item){
							$gall = $this->users->query_single_user_id($item->fan_id);
							foreach($gall as $g){
								if($fan_id != $g->ID && $post_id != $g->ID){
									//try register notification
									$reg_notify = array(
										'type' => 'moot reply',
										'fan_id' => $fan_id,
										'receive_id' => $g->ID,
										'p_id' => $moot_id,
										's_id' => $insert_id,
										'content' => $reply,
										'reg_date' => $now,
										'date_group' => $now_group
									);
									
									$this->users->reg_notification($reg_notify);
									
									/////////////////////////////////////////////////////////////////////////////////////
									//send notification mail to fan
									$this->email->clear(); //clear initial email variables
									$this->email->to($g->user_email);
									$this->email->from('info@soccerfanhub.com','SoccerFanHub');
									$this->email->subject($fan_display_name.' ('.$club_name.') replied a moot');
									
									//compose html body of mail
									$mail_subhead = 'Moot reply from '.$fan_display_name.' ('.$club_name.')';
									$body_msg = '
										<div style="overflow:auto;">
										<img alt="" src="'.base_url($log_user_pics_small).'" width="50px" style="float:left; margin-right:10px;" />
										'.$fan_display_name.' ('.$club_name.') replied a Moot:<br /><br />'.$reply.'<br /><br /></div>
										<a href="'.base_url('moot/'.$moot_id.'#'.$insert_id).'" class="email_btn">View Now</a>
									';
									
									$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
									$this->email->set_mailtype("html"); //use HTML format
									$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
				 
									$this->email->message($mail_design);
									
									if($this->email->send()) {}
								}
							}
						}
					}
					
					echo '
						<div class="media">
							<a class="pull-left" href="'.base_url('fan/'.$log_user_nicename).'">
								<img class="media-object avatar avatar-sm" src="'.base_url($log_user_pics_small).'" alt="">
							</a>
							<div class="comment">
								<div class="comment-author h6 no-m">
									<a href="'.base_url('fan/'.$log_user_nicename).'"><b>'.$fan_display_name.'</b></a>
								</div>
								<div class="comment-meta small">'.date(('D, j M Y H:m'), strtotime($now)).' (now)</div>
								<p>
									'.$reply.'
								</p>
								<!--<p class="small">
									<a href="javascript:;" class="text-muted mr10"><i class="ti-comment mr5"></i>Comment</a>
								</p>-->
							</div>
						</div>
					';
				}
			} exit;
		}
	}
	
	public function delete(){
		$log_user_id = $this->session->userdata('sfh_id');
		
		if($_POST){
			$del = $this->m_moots->delete_moot($_POST['del_moot_id']);
			$del_fan_id = $_POST['del_fan_id'];
			if($del){
				//try remove 5 points
				mysql_query("DELETE FROM sfh_quota WHERE user_id='$del_fan_id' AND purpose='Moot bonus' LIMIT 1");
				echo '<div class="text-center">Moot Removed</div>';
			}
		} exit;
	}
	
	public function delete_reply(){
		$log_user_id = $this->session->userdata('sfh_id');
		
		if($_POST){
			$del_reply = $this->m_moots->delete_moot_reply($_POST['del_moot_reply_id']);
			$del_reply_fan_id = $_POST['del_reply_fan_id'];
			if($del_reply){
				//try remove 2 points
				mysql_query("DELETE FROM sfh_quota WHERE user_id='$del_reply_fan_id' AND purpose='Moot reply bonus' LIMIT 1");
				echo '<div class="text-center">Moot Replied Removed</div>';
			}
		} exit;
	}
}