<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$m_obj =& get_instance();
	$m_obj->load->model('users');
	$m_obj->load->model('m_profession');
	$m_obj->load->model('m_country');
	$m_obj->load->model('m_trs');
	$m_obj->load->model('m_collab');
	$m_obj->load->model('m_project');
	
	$tm_member_page = base_url().'member/';
	$tm_club_page = base_url().'club/';
	$tm_setting_page = base_url().'settings/';
	$tm_notification_page = base_url().'notifications/';
	
	$log_user = $this->session->userdata('logged_in');
	
	$tm_view_nicename = $this->session->userdata('tm_view_nicename');
	$tm_view_id = $this->session->userdata('tm_view_id');
	
	$tm_nairatodollar = 199;
	
	if($log_user == FALSE) {
		$user_menu ='
			<li style="padding:10px;">
				<a class="btn btn-inverse" data-toggle="modal" href="#model_login">Sign In</a>
			</li>
		';
		$user_notification = '<button type="button" class="btn btn-link pull-left nav-toggle visible-xs" data-toggle="class:slide-nav slide-nav-left" data-target="body"> <i class="fa fa-bars fa-lg text-default"></i> </button>';
		$add = '';
		$follow = '';
		$post_forum = '';
		$post_article = '';
		
		$log_user_nicename = '';
		$log_user_id = '';
		$log_display_name = '';
		$log_user_email = '';
		$log_user_pics = '';
		$log_user_pics_small = '';
		$log_user_country = '';
		$log_user_club_id = '';
		$log_user_club_ban = '';
		$log_user_global_code = '';
		$log_user_verified = '';
		$log_user_sex = '';
		$log_user_dob = '';
		$log_user_address = '';
		$log_user_bio = '';
		$log_user_profession = '';
		$log_user_city = '';
		$log_user_phone = '';
		$log_user_website = '';
		$log_user_facebook = '';
		$log_user_twitter = '';
		$log_user_linkedin = '';
		$log_user_role = '';
		$log_user_pro = '';
	} else {
		$log_user_id = $this->session->userdata('tm_id');
		$log_display_name = ucwords($this->session->userdata('tm_display_name'));
		$log_user_nicename = $this->session->userdata('tm_user_nicename');
		$log_user_email = $this->session->userdata('tm_user_email');
		$log_user_pics = $this->session->userdata('tm_user_pics');
		$log_user_pics_small = $this->session->userdata('tm_user_pics_small');
		$log_user_country_id = $this->session->userdata('tm_user_country_id');
		$log_user_country = $this->session->userdata('tm_user_country');
		$log_user_club_id = $this->session->userdata('tm_user_club_id');
		$log_user_club_ban = $this->session->userdata('tm_user_club_ban');
		$log_user_global_code = $this->session->userdata('tm_user_global_code');
		$log_user_verified = $this->session->userdata('tm_user_verified');
		$log_user_sex = $this->session->userdata('tm_user_sex');
		$log_user_dob = $this->session->userdata('tm_user_dob');
		$log_user_address = $this->session->userdata('tm_user_address');
		$log_user_bio = $this->session->userdata('tm_user_bio');
		$log_user_profession = $this->session->userdata('tm_user_profession');
		$log_user_city = $this->session->userdata('tm_user_city');
		$log_user_phone = $this->session->userdata('tm_user_phone');
		$log_user_website = $this->session->userdata('tm_user_website');
		$log_user_facebook = $this->session->userdata('tm_user_facebook');
		$log_user_twitter = $this->session->userdata('tm_user_twitter');
		$log_user_linkedin = $this->session->userdata('tm_user_linkedin');
		$log_user_role = strtolower($this->session->userdata('tm_user_role'));
		$log_user_pro = $this->session->userdata('tm_user_pro');
		
		if($log_user_pics=='' || file_exists(FCPATH.$log_user_pics)==FALSE){$log_user_pics='img/avatar.jpg';}
		if($log_user_pics_small=='' || file_exists(FCPATH.$log_user_pics_small)==FALSE){$log_user_pics_small='img/avatar.jpg';}
		
		//get activities
		$activity_left = '';
		$activity_all = '';
		
		$count = 0;
		$getnote = $this->users->query_activity();
		if(!empty($getnote)){
			foreach($getnote as $note){
				if($count < 5){
					$activity_left .= '
						<li class="media">
						  <div class="media-left">
							<span class="media-object">
								<i class="fa fa-fw fa-bell"></i>
							</span>
						  </div>
						  <div class="media-body">
							'.$note->content.'
							<span class="time">'.$note->reg_date.'</span>
						  </div>
						  <div class="media-right">
							<span class="news-item-success"><i class="fa fa-circle"></i></span>
						  </div>
						</li>
					';
				}
				
				$count += 1;
			}
		}
		
		//get notifications
		$notify_all = '';
		$n_count = 1;
		$getnotify = $this->users->query_notify_member($log_user_id);
		if(!empty($getnotify)){
			foreach($getnotify as $notify){
				//get sender details
				$n_pics_small = '';
				$n_user_nicename = '';
				$ngetuser = $this->users->query_single_user_id($notify->member_id);
				if(!empty($ngetuser)){
					foreach($ngetuser as $nuser){
						$n_user_nicename = $nuser->user_nicename;
						$n_pics_small = $nuser->pics_small;
						if($n_pics_small=='' || file_exists(FCPATH.$n_pics_small)==FALSE){$n_pics_small='img/avatar.jpg';}	
					}
				}
				
				if($notify->status == 0){$n_status = '<span class="status"></span>';} else {$n_status = '';}
				
				$notify_all .= '
					<li class="online" data-user-id="'.$n_count.'">
					  <a href="'.base_url('notifications?n='.$notify->id.'&t='.$notify->type.'&l='.$n_user_nicename).'">
						<div class="media">
						  '.$n_status.'
						  <div class="pull-left">
							<img src="'.base_url($n_pics_small).'" width="40" class="img-circle" />
						  </div>
						  <div class="media-body">
							<div>'.$notify->content.'</div>
						  </div>
						</div>
					  </a>
                	</li>
				';
				$n_count += 1;
			}
		}
	}