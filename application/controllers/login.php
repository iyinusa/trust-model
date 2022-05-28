<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
        parent::__construct();
		$this->load->library('form_validation'); //load form validate rules
		
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
		$redir = $this->session->userdata('tm_redirect');
		//check if already logged in
		If($this->session->userdata('logged_in')==TRUE){
			if($redir==''){$redir = 'member/'.$this->session->userdata('tm_user_nicename');}
			redirect(base_url($redir), 'refresh');
		}
		
		$this->form_validation->set_rules('username','Username','trim|required|xss_clean');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[4]|max_length[32]|xss_clean|md5');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>'); //error delimeter
		
		if ($this->form_validation->run() == FALSE) {
			$data['err_msg'] = '';
		} else {
			//check if ready for post
			if($_POST) {
				$username = $_POST['username'];
				$password = $_POST['password'];
				if(isset($_POST['remind'])){$remind='';}else{$remind='';}
				
				if($this->users->check_user($username, $password) <= 0) {
					$data['err_msg'] = '<div class="alert alert-danger">Invalid username or password.</div>';		
				} else {
					$query = $this->users->query_user($username, $password);
					if(!empty($query)) {
						foreach($query as $row) {
							//update status
							$first_log = $row->user_lastlog; //to check first time user
							$now = date("Y-m-d H:i:s");
							$status_update = array('user_status'=>1, 'user_lastlog'=>$now);
							$this->users->update_user($row->ID,$status_update);
							
							//get country name
							$get_country = $this->m_country->query_country_id($row->country);
							if(!empty($get_country)){
								foreach($get_country as $countr){
									$country = $countr->name;	
								}
							} else {$country = '';}
							
							//add data to session
							$s_data = array (
								'tm_id' => $row->ID,
								'tm_nicename' => $row->user_nicename,
								'tm_user_email' => $row->user_email,
								'tm_user_registered' => $row->user_registered,
								'tm_user_lastlog' => $row->user_lastlog,
								'tm_user_status' => $row->user_status,
								'tm_display_name' => $row->display_name,
								'tm_user_nicename' => $row->user_nicename,
								'tm_user_pics' => $row->pics,
								'tm_user_pics_small' => $row->pics_small,
								'tm_user_country_id' => $row->country,
								'tm_user_country' => $country,
								'tm_user_club_id' => $row->club_id,
								'tm_user_club_ban' => $row->club_ban,
								'tm_user_global_code' => $row->global_code,
								'tm_user_verified' => $row->verified,
								'tm_user_bio' => $row->bio,
								'tm_user_profession' => $row->profession,
								'tm_user_sex' => $row->sex,
								'tm_user_address' => $row->address,
								'tm_user_city' => $row->city,
								'tm_user_dob' => $row->dob,
								'tm_user_phone' => $row->phone,
								'tm_user_website' => $row->website,
								'tm_user_facebook' => $row->fb_page,
								'tm_user_twitter' => $row->twitter_page,
								'tm_user_linkedin' => $row->linkedin_page,
								'tm_user_role' => $row->role,
								'tm_user_pro' => $row->pro,
								'tm_redirect' => '', //clean up redirect if exist
								'logged_in' => TRUE
							);
						}
						
						$check = $this->session->set_userdata($s_data);
						
						//if first time logged, push to group page to select group(s)
						if($first_log==''){
							if($redir==''){$redir = 'members/';}
							redirect(base_url($redir), 'refresh');
						} else {
							if($redir==''){$redir = 'member/'.$this->session->userdata('tm_nicename');}
							redirect(base_url($redir), 'refresh');
						}
					}
				}
			}
		}

		$data['title'] = 'Login | '.app_name;
		$data['page_active'] = 'login';

	  	//$this->load->view('designs/header', $data);
	  	$this->load->view('login', $data);
	  	//$this->load->view('designs/footer', $data);
		
	}
	
	public function social() {
		$data['err_msg']='';
		if($this->session->userdata('social_log_in')==FALSE){ 
			redirect(base_url(), 'refresh');
		} else {
			//collect social login data from session
			$query = '';
			$social_user_identifier = $this->session->userdata('social_user_identifier');
			$social_display_name = $this->session->userdata('social_display_name');
			$social_first_name = $this->session->userdata('social_first_name');
			$social_last_name = $this->session->userdata('social_last_name');
			$social_user_pics = $this->session->userdata('social_user_pics');
			$social_user_url = $this->session->userdata('social_user_url');
			$social_user_about_me = $this->session->userdata('social_user_about_me');
			$social_user_sex = $this->session->userdata('social_user_sex');
			$social_user_email = $this->session->userdata('social_user_email');
			$social_user_country = $this->session->userdata('social_user_country');
			
			if(empty($social_user_country)){$social_user_country = 'Nigeria';}
			
			//extract username
			$social_user_name = explode('/', $social_user_url);
			$social_user_name = $social_user_name[4];
			
			//check if user with email already exist, then login, else register in database
			if($this->users->check_by_email($social_user_email) > 0 || $this->users->check_by_username($social_user_name) > 0) {
				$query = $this->users->query_user_by_email($social_user_email);
			} else {
				//first register records
				$time = time();
				$now = date("Y-m-d H:i:s");
				
				//===get nicename and convert to seo friendly====
				$nicename = strtolower($social_user_name);
				$nicename = preg_replace("/[^a-z0-9_\s-]/", "", $nicename);
				$nicename = preg_replace("/[\s-]+/", " ", $nicename);
				$nicename = preg_replace("/[\s_]/", "-", $nicename);
				//================================================
				
				$password = md5($social_user_name.$social_user_name);
				
				$reg_data = array(
					'display_name' => ucwords($social_display_name),
					'user_login' => $social_user_name,
					'user_nicename' => $nicename,
					'user_email' => $social_user_email,
					'user_pass' => $password,
					'role' => 'User',
					'sex' => ucwords($social_user_sex),
					'country' => $social_user_country,
					'bio' => $social_user_about_me,
					'fb_page' => $social_user_url,
					'user_registered' => $now,
					'regstamp' => $time,
					'activate' => 1,
					'user_status' => 1
				);
				
				//email notification processing
				$this->email->clear(); //clear initial email variables
				$this->email->to($social_user_email);
				$this->email->from('info@soccerfanhub.com','SoccerFanHub (SFH)');
				$this->email->subject('Welcome to SoccerFanHub');
				
				//compose html body of mail
				$mail_stamp = $time;
				$mail_subhead = 'Welcome to SoccerFanHub';
				$body_msg = '
					Thanks for join SoccerFanHub.<br /><br />
					World largest fans club network!!! - Start connecting and build soccer club interest.<br /><br />Thanks
				';
				
				$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
				$this->email->set_mailtype("html"); //use HTML format
				$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);

				$this->email->message($mail_design);
				
				if($this->email->send()) {
					$data['err_msg'] = '<div class="alert alert-danger">Please activate your Email Address to complete registration. Click on link sent to '.$social_user_email.' (NB: Check SPAM if not in INBOX)</div>';
											
					$insert_id = $this->users->reg_insert($reg_data); //save records in database
					
					//try give fan 20 point on registration
					$reg_point = array(
						'user_id' => $insert_id,
						'point' => 20,
						'purpose' => 'Registration bonus',
						'reg_date' => $now
					);
					
					$this->users->reg_point($reg_point);
					
					/////////////////////////////////////////////////////////////////////////////////////
					//send notification mail to admin
					$this->email->clear(); //clear initial email variables
					$this->email->to('info@soccerfanhub.com');
					$this->email->from($social_user_email,'SoccerFanHub (SFH)');
					$this->email->subject('New SFH Member');
					
					//compose html body of mail
					$mail_stamp = $time;
					$mail_subhead = 'New Account Creation';
					$body_msg = '
						This is to notify you that SoccerFanHub now has new member.<br /><br />
						Check <a href="'.base_url().'fan/'.$nicename.'">'.$social_display_name.'</a> Profile or Social page <a href="'.$social_user_url.'">'.$social_user_url.'</a><br /><br />Thanks
					';
					
					$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
					$this->email->set_mailtype("html"); //use HTML format
					$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
 
					$this->email->message($mail_design);
					
					if($this->email->send()) {}
				}
				
				//now query record
				$query = $this->users->query_user_by_email($social_user_email);
			}
			
			//query records
			///////////////////////////////////////////////////////////////////////////////////////
			$redir = $this->session->userdata('tm_redirect');
			if(!empty($query)) {
				foreach($query as $row) {
					//update status
					$first_log = $row->user_lastlog; //to check first time user
					$now = date("Y-m-d H:i:s");
					$status_update = array('user_status'=>1, 'user_lastlog'=>$now);
					$this->users->update_user($row->ID,$status_update);
					
					//add data to session
					$s_data = array (
						'tm_id' => $row->ID,
						'tm_nicename' => $row->user_nicename,
						'tm_user_email' => $row->user_email,
						'tm_user_registered' => $row->user_registered,
						'tm_user_lastlog' => $row->user_lastlog,
						'tm_user_status' => $row->user_status,
						'tm_display_name' => $row->display_name,
						'tm_user_nicename' => $row->user_nicename,
						'tm_user_pics' => $row->pics,
						'tm_user_pics_small' => $row->pics_small,
						'tm_user_country' => $row->country,
						'tm_user_club_id' => $row->club_id,
						'tm_user_club_ban' => $row->club_ban,
						'tm_user_global_code' => $row->global_code,
						'tm_user_verified' => $row->verified,
						'tm_user_bio' => $row->bio,
						'tm_user_sex' => $row->sex,
						'tm_user_address' => $row->address,
						'tm_user_city' => $row->city,
						'tm_user_dob' => $row->dob,
						'tm_user_phone' => $row->phone,
						'tm_user_website' => $row->website,
						'tm_user_facebook' => $row->fb_page,
						'tm_user_twitter' => $row->twitter_page,
						'tm_user_linkedin' => $row->linkedin_page,
						'tm_user_role' => $row->role,
						'tm_user_pro' => $row->pro,
						'logged_in' => TRUE,
					);
				}
				
				$check = $this->session->set_userdata($s_data);
			
				//if first time logged, push to group page to select group(s)
				if($first_log==''){
					if($redir==''){$redir = 'clubs/';}
					redirect(base_url($redir), 'refresh');
				} else {
					if($redir==''){$redir = 'fan/'.$this->session->userdata('tm_nicename');}
					redirect(base_url($redir), 'refresh');
				}
			} else {
				$data['err_msg'] = '<div class="alert alert-info">Issue with Facebook Login! - Please Use Registration Form. Thank you.</div>';	
			}
		}
		
		$data['title'] = 'Login | SoccerFanHub';
		$data['page_active'] = 'login';

	  	$this->load->view('designs/header', $data);
	  	$this->load->view('login', $data);
	  	$this->load->view('designs/footer', $data);
	}
}