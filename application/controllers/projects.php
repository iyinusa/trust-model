<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->helper('text'); //for content limiter
		$this->load->library('form_validation');
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
		if($this->session->userdata('logged_in') == TRUE){
			
		} else {
			//register redirect page
			$s_data = array ('tm_redirect' => uri_string());
			$this->session->set_userdata($s_data);
			redirect(base_url('login'), 'refresh');
		}
		
		$log_user_id = $this->session->userdata('tm_id');
		$log_display_name = ucwords($this->session->userdata('tm_display_name'));
		$log_user_nicename = $this->session->userdata('tm_user_nicename');
		
		///////// SEND REQUEST ////////
		$get_collab = $this->input->get('collab');
		$get_invite = $this->input->get('invite');
		if($get_collab && $get_invite){
			$now = date("Y-m-d H:i:s");
			$now_group = date("F Y");
			
			//check if request already sent
			if($this->m_collab->check_send_collab($log_user_id, $get_collab) > 0 || $this->m_collab->check_receive_collab($log_user_id, $get_collab) > 0){
				$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-flash fa-2x"></i> Invitation already sent</h5></div>';
			} else {
				//save collaboration
				$ins_collab = array(
					'sender_id' => $log_user_id,
					'receiver_id' => $get_invite,
					'status' => 0,
					'project' => $get_collab,
					'remark' => 'Collaboration via project request'
				);
				
				$collab_id = $this->m_collab->reg_insert($ins_collab);
				
				//try register notification
				$notify = $log_display_name.' sent you collaboration request';
				$reg_notify = array(
					'type' => 'request collaboration',
					'member_id' => $log_user_id,
					'receive_id' => $get_invite,
					'p_id' => $collab_id,
					's_id' => $collab_id,
					'content' => $notify,
					'reg_date' => $now,
					'date_group' => $now_group
				);
				
				$this->users->reg_notification($reg_notify);
				
				$data['err_msg'] = '<div class="alert alert-success"><h5><i class="fa fa-check fa-2x"></i> Invitation sent. Member will either Accept or Reject</h5></div>';
			}
		}
		///////// END SEND REQUEST ////////
		
		///////// ACCEPT REQUEST ////////
		$collab_accept = $this->input->get('collab_accept');
		$from = $this->input->get('from');
		if($collab_accept && $from){
			$now = date("Y-m-d H:i:s");
			$now_group = date("F Y");
			
			//update collaboration
			$ins_collab = array(
				'status' => 1
			);
			
			$collab_id = $this->m_collab->update_collab($collab_accept, $ins_collab);
			
			//try register notification
			$notify = $log_display_name.' accepted your collaboration request';
			$reg_notify = array(
				'type' => 'accept collaboration',
				'member_id' => $log_user_id,
				'receive_id' => $from,
				'p_id' => $collab_id,
				's_id' => $collab_id,
				'content' => $notify,
				'reg_date' => $now,
				'date_group' => $now_group
			);
			
			$this->users->reg_notification($reg_notify);
			
			$data['err_msg'] = '<div class="alert alert-success"><h5><i class="fa fa-check fa-2x"></i> You now have new collaboration</h5></div>';
		}
		///////// END ACCEPT REQUEST ////////
		
		///////// REJECT REQUEST ////////
		$collab_reject = $this->input->get('collab_reject');
		$from = $this->input->get('from');
		if($collab_reject && $from){
			$now = date("Y-m-d H:i:s");
			$now_group = date("F Y");
			
			//update collaboration
			$ins_collab = array(
				'status' => 0,
				'reject' => 1
			);
			
			$collab_id = $this->m_collab->update_collab($collab_reject, $ins_collab);
			
			$data['err_msg'] = '<div class="alert alert-success"><h5><i class="fa fa-check fa-2x"></i> You have rejected the collaboration</h5></div>';
		}
		///////// END REJECT REQUEST ////////
		
		$data['title'] = 'Projects | '.app_name;
		$data['page_active'] = 'projects';
		
		$this->load->view('designs/header', $data);
		$this->load->view('projects/projects', $data);
		$this->load->view('designs/footer', $data);
	}
	
	public function add() {
		$data['err_msg'] = '';
		
		$log_user_id = $this->session->userdata('tm_id');
		
		//check for update
		$get_id = $this->input->get('edit');
		if($get_id != ''){
			$gq = $this->m_project->query_project_id($get_id);
			foreach($gq as $item){
				$data['e_id'] = $item->id;
				$data['e_title'] = $item->title;
				$data['e_details'] = $item->details;
			}
		}
		
		//check record delete
		$del_id = $this->input->get('del');
		if($del_id != ''){
			$data['rec_del'] = $del_id;
		}
		
		//set form input rules 
		$this->form_validation->set_rules('title','Title','trim|required|xss_clean');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-warning no-radius no-margin padding-sm"><i class="fa fa-info-circle"></i>', '</div>'); //error delimeter
	  
	  	if ($this->form_validation->run() == FALSE)
		{
			$data['err_msg'] = '';
		}
		else
		{
			//check if ready for post
			if($_POST){
				$project_id = $_POST['project_id'];
				$title = $_POST['title'];
				$details = $_POST['details'];
				
				$now = date("Y-m-d H:i:s");
				
				//===get nicename and convert to seo friendly====
				$slug = strtolower($title);
				$slug = preg_replace("/[^a-z0-9_\s-]/", "", $slug);
				$slug = preg_replace("/[\s-]+/", " ", $slug);
				$slug = preg_replace("/[\s_]/", "-", $slug);
				//================================================
				
				//check for existence
				if(($this->m_project->check_by_name($title, $log_user_id) > 0) && $project_id == ''){
					$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-flash fa-2x"></i> Project already in database</h5></div>';
				} else {
					//check for update
					if($project_id != ''){
						$upd_data = array(
							'title' => $title,
							'slug' => $slug.'-'.time(),
							'details' => $details
						);
						
						if($this->m_project->update_project($project_id, $upd_data) > 0){
							$data['err_msg'] = '<div class="alert alert-success"><h5><i class="fa fa-check fa-2x"></i> Successful</h5></div>';
						} else {
							$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-flash fa-2x"></i> No Changes Made</h5></div>';
						}
					} else {
						$reg_data = array(
							'member_id' => $log_user_id,
							'title' => $title,
							'slug' => $slug.'-'.time(),
							'details' => $details,
							'reg_date' => $now
						);
						
						if($this->m_project->reg_insert($reg_data) > 0){
							$data['err_msg'] = '<div class="alert alert-success"><h5><i class="fa fa-mark"></i> Successful</h5></div>';
						} else {
							$data['err_msg'] = '<div class="alert alert-danger"><h5><i class="fa fa-flash fa-2x"></i> There is problem this time. Try later</h5></div>';
						}
					}
				}
			}
		}
		
		//query uploads
		$data['allprojects'] = $this->m_project->query_user_project($log_user_id);
		
		$data['title'] = 'Add Project | '.app_name;
		$data['page_active'] = 'project';

	  	$this->load->view('designs/header', $data);
	  	$this->load->view('projects/add', $data);
	  	$this->load->view('designs/footer', $data);	
	}
	
	public function view($project)
	{
		$single_project = $this->m_project->query_single_project($project);
		if(!empty($single_project)) {
			foreach($single_project as $row) {
				$data['project_id'] = $row->id;
				$data['project_member_id'] = $row->member_id;
				$data['project_title'] = $row->title;
				$data['project_details'] = $row->details;
				$data['project_reg_date'] = date('d M Y', strtotime($row->reg_date));
				
				
				//get user details
				$user_display_name = '';
				$user_pics_small = '';
				$user_nicename = '';
				$getuser = $this->users->query_single_user_id($row->member_id);
				if(!empty($getuser)){
					foreach($getuser as $user){
						$user_display_name = $user->display_name;
						$user_nicename = $user->user_nicename;
						$user_pics_small = $user->pics_small;
						if($user_pics_small=='' || file_exists(FCPATH.$user_pics_small)==FALSE){$user_pics_small='img/avatar.jpg';}
					}
				}
				
				$data['title'] = ucwords($row->title).' | '.app_name;
				$data['project_display_name'] = ucwords($user_display_name);
				$data['project_nicename'] = $user_nicename;
				$data['project_pics_small'] = $user_pics_small;
				
				//get collaboration status
				$col_pass = 0;
				$col_fail = 0;
				$col_total = 0;
				$getcollab = $this->m_collab->query_all_collab($row->member_id);
				if(!empty($getcollab)){
					foreach($getcollab as $collab){
						if($collab->project != 0){
							if($collab->status == 1){$col_pass += 1;}
							if($collab->reject == 1 && $log_user_id == $collab->sender_id){$col_fail += 1;}
							
							$col_total = $col_pass + $col_fail;
						}
					}
				}
				
				$data['project_collab_pass'] = $col_pass;
				$data['project_collab_fail'] = $col_fail;
				$data['project_collab_total'] = $col_total;
			}
		} else {redirect(base_url().'projects/', 'refresh');}
		
		$data['page_active'] = 'project';
		
		$this->load->view('designs/header', $data);
		$this->load->view('projects/view', $data);
		$this->load->view('designs/footer', $data);
	}
	
	public function invite() {
		if($this->session->userdata('logged_in') == TRUE){
			
		} else {
			//register redirect page
			$s_data = array ('tm_redirect' => uri_string());
			$this->session->set_userdata($s_data);
			redirect(base_url('login'), 'refresh');
		}
		
		$log_user_id = $this->session->userdata('tm_id');
		$log_display_name = ucwords($this->session->userdata('tm_display_name'));
		$log_user_nicename = $this->session->userdata('tm_user_nicename');
		$log_user_pics_small = $this->session->userdata('tm_user_pics_small');
		if($log_user_pics_small=='' || file_exists(FCPATH.$log_user_pics_small)==FALSE){$log_user_pics_small='img/avatar.jpg';}
		
		$data['err_msg'] = '';
		
		//resend code
		$get_id = $this->input->get('resend');
		if($get_id){
			$getitem = $this->users->query_invite_id($get_id);
			if(!empty($getitem)){
				foreach($getitem as $item){
					if($log_user_id != $item->sender_id){
						$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-flash fa-2x"></i> Invitation can\'t be traced</h5></div>';
					} else {
						//send invitation again
						if($item->status == 1){
							$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-flash fa-2x"></i> You can\'t send invitation to registered account</h5></div>';
						} else {
							//now send email notification
							$this->email->clear(); //clear initial email variables
							$this->email->to($item->email);
							$this->email->from(app_email, app_name);
							$this->email->subject($log_display_name.' invites you to '.app_name);
							
							//compose html body of mail
							$mail_subhead = 'Invitation To Network';
							$msg = $item->msg;
							if($msg != ''){$msg = $msg.'<br /><br />';}
							$body_msg = '
								<img alt="'.$log_display_name.'" src="'.base_url().$log_user_pics_small.'" style="float:left; margin-right:10px;" />
								<a href="'.base_url().'project/'.$log_user_nicename.'">'.$log_display_name.'</a> invites you to join '.app_name.'<br /><br />
								'.$msg.'
								<b><a href="'.base_url().'register?from='.$log_user_id.'&to='.$item->email.'">REGISTER ON NETWORK</a></b>
							';
							
							$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
							$this->email->set_mailtype("html"); //use HTML format
							$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
		 
							$this->email->message($mail_design);
							
							if($this->email->send()) {
								$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-check"></i> Successful</h5></div>';
							} else {
								$data['err_msg'] = '<div class="alert alert-danger"><h5><i class="fa fa-flash fa-2x"></i> Invitation registered, but Email not sent this time</h5></div>';
							}
						}
					}
				}
			}
		}
		
		if($_POST){
			$invite = $_POST['invite'];
			$msg = $_POST['msg'];
			
			//check if memeber already exist in network
			if($this->users->check_by_email($invite) > 0){
				$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-flash fa-2x"></i> Already in Network</h5></div>';
			} else {
				//check if invitation already sent
				if($this->users->check_invite($log_user_id, $invite) > 0){
					$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-flash fa-2x"></i> Invitation already sent</h5></div>';
				} else {
					//now send invitation
					$reg_data = array(
						'sender_id' => $log_user_id,
						'email' => $invite,
						'msg' => $msg,
						'status' => 0,
					);
					
					if($this->users->reg_invite($reg_data) > 0){
						//now send email notification
						$this->email->clear(); //clear initial email variables
						$this->email->to($invite);
						$this->email->from(app_email, app_name);
						$this->email->subject($log_display_name.' invites you to '.app_name);
						
						//compose html body of mail
						$mail_subhead = 'Invitation To Network';
						if($msg != ''){$msg = $msg.'<br /><br />';}
						$body_msg = '
							<img alt="'.$log_display_name.'" src="'.base_url().$log_user_pics_small.'" style="float:left; margin-right:10px;" />
							<a href="'.base_url().'project/'.$log_user_nicename.'">'.$log_display_name.'</a> invites you to join '.app_name.'<br /><br />
							'.$msg.'
							<b><a href="'.base_url().'register?from='.$log_user_id.'&to='.$invite.'">REGISTER ON NETWORK</a></b>
						';
						
						$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
						$this->email->set_mailtype("html"); //use HTML format
						$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
	 
						$this->email->message($mail_design);
						
						if($this->email->send()) {
							$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-check"></i> Successful</h5></div>';
						} else {
							$data['err_msg'] = '<div class="alert alert-danger"><h5><i class="fa fa-flash fa-2x"></i> Invitation registered, but Email not sent this time</h5></div>';
						}
					} else {
						$data['err_msg'] = '<div class="alert alert-danger"><h5><i class="fa fa-flash fa-2x"></i> There is problem this time. Try later</h5></div>';
					}
				}
			}
		}
		
		$data['allinvite'] = $this->users->query_invite($log_user_id);
		
		$data['title'] = 'Send Invitation | '.app_name;
		$data['page_active'] = 'projects';

	  	$this->load->view('designs/header', $data);
	  	$this->load->view('projects/invite', $data);
	  	$this->load->view('designs/footer', $data);
	}
	
	public function delete(){
		if(isset($_POST['cancel'])){
			redirect(base_url('projects/add'), 'refresh');
		} else {
			$del_id = $_POST['del_id'];
			
			if($del_id != ''){
				if($this->m_project->delete_project($del_id) > 0){
					redirect(base_url('projects/add'), 'refresh');
				} else {
					$data['err_msg'] = '<div class="alert alert-info"><h5>There is problem this time. Try later</h5></div>';
				}
			}
		}
	}
	
	function activity_comment() {
		if($_POST) {
			$component = $_POST['component'];
			$item_id = $_POST['item_id'];
			$second_item_id = $_POST['second_item_id'];
			$com = $_POST['com'];
			
			$now = date("Y-m-d H:i:s");
			$primary_link = '';
			$type = '';
			$action = '';
			
			$itc_project_page = base_url().'geek/';
			$itc_group_page = base_url().'group/';
			$itc_article_page = base_url().'article/';
			$itc_forum_page = base_url().'forum/';
			$itc_setting_page = base_url().'setting/';
			
			$log_display_name = $this->session->userdata('itc_display_name');
			$log_user_nicename = $this->session->userdata('itc_user_nicename');
			
			if($com != '') {
				//post to comment of either forum or article
				if($component=='groups' || $component=='forums'){
					$get_forum = $this->forum->query_forum_id($item_id);
					if(!empty($get_forum)){
						foreach($get_forum as $f_item){
							$f_title = $f_item->post_title;	
							$f_slug = $f_item->slug;
						}
					}
					
					$type = 'new_forum_comment';
					$action = '
						<a href="'.$itc_project_page.$log_user_nicename.'">'.$log_display_name.'</a> replied to forum 
						<a href="'.$itc_forum_page.$f_slug.'">'.$f_title.'</a>
					';
					$primary_link = $itc_forum_page.$f_slug;
					
					$reg_data = array(
						'user_id' => $this->session->userdata('itc_id'),
						'comment_post_ID' => $item_id,
						'comment_date' => $now,
						'comment_date_gmt' => $now,
						'comment_content' => $com,
						'comment_approved' => 1,
						'comment_parent' => 0
					);
					
					//add record
					if($this->forum->reg_forum_comment($reg_data)) {
						//echo '<div class="alert alert-info">Comment successful</div>';
					} else {
						echo '<div class="alert alert-danger">There is problem this time. Please try later</div>';
					}
				} else if($component=='blogs' || $component=='articles') {
					$get_article = $this->article->query_article_id($item_id);
					if(!empty($get_article)){
						foreach($get_article as $a_item){
							$a_title = $a_item->post_title;	
							$a_slug = $a_item->slug;
						}
					}
					
					$type = 'new_article_comment';
					$action = '
						<a href="'.$itc_project_page.$log_user_nicename.'">'.$log_display_name.'</a> replied to article  
						<a href="'.$itc_article_page.$a_slug.'">'.$a_title.'</a>
					';
					$primary_link = $itc_article_page.$a_slug;
					
					$reg_data = array(
						'user_id' => $this->session->userdata('itc_id'),
						'comment_post_ID' => $item_id,
						'comment_date' => $now,
						'comment_date_gmt' => $now,
						'comment_content' => $com,
						'comment_approved' => 1,
						'comment_parent' => 0
					);
					
					//add record
					if($this->article->reg_article_comment($reg_data)) {
						//echo '<div class="alert alert-info">Comment successful</div>';
					} else {
						echo '<div class="alert alert-danger">There is problem this time. Please try later</div>';
					}
				}
				
				//now post comment to activity
				if($type==''){$type = 'activity_comment';}
				if($primary_link==''){$primary_link = $itc_project_page.$log_user_nicename;}
				if($action==''){
					$action = '<a href="'.$itc_project_page.$log_user_nicename.'">'.$log_display_name.'</a> posted a new activity comment';
				}
				
				$act_data = array(
					'user_id' => $this->session->userdata('itc_id'),
					'component' => $component,
					'type' => $type,
					'action' => $action,
					'content' => $com,
					'primary_link' => $primary_link,
					'item_id' => $item_id,
					'secondary_item_id' => $second_item_id,
					'date_recorded' => $now,
					'hide_sitewide' => 0,
					'mptt_left' => 0,
					'mptt_right' => 0,
					'is_spam' => 0,
				);
				
				//add record
				if($this->user->reg_activity($act_data)) {
					echo '<div class="alert alert-info">Successful</div>';
				} else {
					echo '<div class="alert alert-danger">There is problem this time. Please try later</div>';
				}
			}
		}
	}
	
	function activity_delete() {
		if($_POST) {
			$activity_id = $_POST['activity_id'];
			
			if($activity_id!='') {
				//remove record
				if($this->user->delete_activity($activity_id)) {
					echo 'Removed';
				} else {
					echo '<div class="alert alert-danger">There is problem this time. Please try later</div>';
				}	
			}
		}
	}
	
	public function verify_fan(){
		if($_POST){
			if(strtolower($this->session->userdata('tm_user_role'))){
				$fanemail = $_POST['fanemail'];
				$fanid = $_POST['fanid'];
				
				$update_data = array(
					'verified' => 1
				);
				
				if($this->users->update_user($fanid, $update_data) > 0){
					//send notification mail to admin
					$this->email->clear(); //clear initial email variables
					$this->email->to($fanemail);
					$this->email->from('info@soccerfanhub.com','SoccerFanHub');
					$this->email->subject('Congratulations!!! Fan Profile Verified');
					
					//compose html body of mail
					$mail_subhead = 'Fan Profile Verified';
					$body_msg = '
						Congratulations, your Fan Profile page now Verified as a Global Fan.<br /><br />Thanks
					';
					
					$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
					$this->email->set_mailtype("html"); //use HTML format
					$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
	
					$this->email->message($mail_design);
					
					if($this->email->send()) {
						echo '<h5 class="alert alert-success">Verified</h5>';	
					} else {
						echo '<h5 class="alert alert-warning">Please try later.</h5>';
					}
				} else {
					echo '<h5 class="alert alert-warning">Please try later</h5>';
				}
			}
		}exit;
	}
	
	function add_friend() {
		if($_POST) {
			$friend_id = $_POST['friend_id'];
			$send_id = $this->session->userdata('itc_id');
			$now = date("Y-m-d H:i:s");
			
			if($friend_id!=''){
				//check request already sent
				$check_req = mysql_query("SELECT * FROM nc_bp_friends WHERE (initiator_user_id='$friend_id' AND friend_user_id='$send_id') OR (initiator_user_id='$send_id' AND friend_user_id='$friend_id') AND is_confirmed=0 LIMIT 1");
				if(mysql_num_rows($check_req) > 0){
					echo 'Awaiting approval';
				} else {
					$reg_data = array(
						'initiator_user_id' => $send_id,
						'friend_user_id' => $friend_id,
						'is_confirmed' => 0,
						'is_limited' => 0,
						'date_created' => $now
					);
					
					$reg_id = $this->user->reg_friend($reg_data); //last saved id
					
					//get sender details
					$log_display_name = ucwords($this->session->userdata('itc_display_name'));
					$log_user_nicename = $this->session->userdata('itc_user_nicename');
					$log_user_email = $this->session->userdata('itc_user_email');
					$log_user_pics_small = $this->session->userdata('itc_user_pics_small');
					
					//get receiver details
					$receiver = $this->user->query_single_user_id($friend_id);
					if(!empty($receiver)){
						if($reg_id > 0) {
							foreach($receiver as $receive) {
								$receiver_email = $receive->user_email;
								$receiver_display_name = $receive->display_name;
								$receiver_nicename = $receive->user_nicename;	
							}
							
							//save notification
							$notify_data = array(
								'user_id' => $friend_id,
								'item_id' => $send_id,
								'component_name' => 'friends',
								'component_action' => 'friendship_request',
								'date_notified' => $now,
								'date_group' => date("F Y",strtotime($now)),
								'is_new' => 1
							);
							
							//add notify record
							if($this->user->reg_notify($notify_data)) {}
							
							//send notification mail
							$this->email->clear(); //clear initial email variables
							$this->email->to($receiver_email);
							$this->email->from('info@itcerebral.com','ITCerebral');
							$this->email->subject($log_display_name.' wants to be your friend on ITCerebral');
							
							//compose html body of mail
							$mail_subhead = 'Friend Request';
							$body_msg = '
								<img alt="'.$log_display_name.'" src="'.base_url().$log_user_pics_small.'" style="float:left; margin-right:10px;" />
								<a href="'.base_url().'geek/'.$log_user_nicename.'">'.$log_display_name.'</a> wants to be your friend on ITCerebral<br /><br />
								<b><a href="'.base_url().'notifications/friend?request='.$friend_id.'&sent='.$send_id.'">Confirm Request</a></b>
							';
							
							$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
							$this->email->set_mailtype("html"); //use HTML format
							$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
		 
							$this->email->message($mail_design);
							
							if($this->email->send()) {
								echo 'Request sent';
							} else {
								//echo 'Request sent with mail';
							}
						}
					} else {
						echo 'Try later';
					}
				}
			}
		}
	}
	
	function remove_friend() {
		if($_POST) {
			$friend_id = $_POST['friend_id'];
			
			if($friend_id!=''){
				if($this->user->delete_friend($friend_id)) {
					echo 'Unfriend';
				} else {
					echo 'Try later';
				}
			}
		}
	}
	
	function add_follow() {
		if($_POST) {
			$follow_id = $_POST['follow_id'];
			$now = date("Y-m-d H:i:s");
			
			if($follow_id!=''){
				$reg_data = array(
					'follower_id' => $this->session->userdata('itc_id'),
					'leader_id' => $follow_id
				);
				
				if($this->user->reg_follow($reg_data)) {
					//get sender details
					$log_display_name = ucwords($this->session->userdata('itc_display_name'));
					$log_user_nicename = $this->session->userdata('itc_user_nicename');
					$log_user_email = $this->session->userdata('itc_user_email');
					$log_user_pics_small = $this->session->userdata('itc_user_pics_small');
					
					//get receiver details
					$receiver = $this->user->query_single_user_id($follow_id);
					if(!empty($receiver)){
						foreach($receiver as $receive) {
							$receiver_email = $receive->user_email;
							$receiver_display_name = $receive->display_name;
							$receiver_nicename = $receive->user_nicename;	
						}
						
						//save notification
						$date_group = date("F Y",strtotime($now));
						$n_data = array(
							'user_id' => $follow_id,
							'item_id' => $this->session->userdata('itc_id'),
							'component_name' => 'follow',
							'component_action' => 'new_follow',
							'date_notified' => $now,
							'date_group' => $date_group,
							'is_new' => 1
						);
						
						//add notify record
						$this->user->reg_notify($n_data);
						
						//send notification mail
						$this->email->clear(); //clear initial email variables
						$this->email->to($receiver_email);
						$this->email->from('info@itcerebral.com','ITCerebral');
						$this->email->subject($log_display_name.' now following you on ITCerebral');
						
						//compose html body of mail
						$mail_subhead = 'New Follower';
						$body_msg = '
							<img alt="'.$log_display_name.'" src="'.base_url().$log_user_pics_small.'" style="float:left; margin-right:10px;" />
							<a href="'.base_url().'geek/'.$log_user_nicename.'">'.$log_display_name.'</a> is now following your activities on ITCerebral.</b>
						';
						
						$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
						$this->email->set_mailtype("html"); //use HTML format
						$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
	 
						$this->email->message($mail_design);
						
						if($this->email->send()) {
							echo 'Following';
						} else {
							echo 'Following.';
						}
					} else {
						echo 'Try later';
					}
				} else {
					echo 'Try later';
				}
			}
		}
	}
	
	function remove_follow() {
		if($_POST) {
			$follow_id = $_POST['follow_id'];
			
			if($follow_id!=''){
				if($this->user->delete_follow($follow_id)) {
					echo 'Unfollowed';
				} else {
					echo 'Try later';
				}
			}
		}
	}
}