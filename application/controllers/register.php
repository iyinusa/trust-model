<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation'); //load form validate rules
		//$this->load->library('recaptcha'); //load reCAPTCHA library
		
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
		//check if already logged in
		If($this->session->userdata('logged_in')==TRUE){redirect(base_url('member/'.$this->session->userdata('tm_user_nicename')), 'refresh');}
		
		$data['err_msg'] = '';
		$data['recaptcha_html'] = '';
			
		//check invitation
		$get_from = $this->input->get('from');
		$get_to = $this->input->get('to');
		
		$data['form_access'] = FALSE;
		$data['invitee'] = '';
		$data['invitee_id'] = '';
		$data['invite_email'] = '';
		if($get_from == '' || $get_to == ''){
			$data['err_msg'] = '<div class="alert alert-danger"><h5><i class="fa fa-flash fa-2x"></i> You can only Join through Invitation</h5></div>';
		} else {
			if($this->users->check_invite($get_from, $get_to) <= 0){
				$data['err_msg'] = '<div class="alert alert-danger"><h5><i class="fa fa-flash fa-2x"></i> Invitation Not Valid!!!</h5></div>';
			} else {
				//get invitee name
				$getinv = $this->users->query_single_user_id($get_from);
				if(!empty($getinv)){
					foreach($getinv as $inv){
						$data['invitee_id'] = $inv->ID;
						$data['invitee'] = $inv->display_name;
						$data['form_access'] = TRUE;
					}
				}
				$data['invite_email'] = $get_to;
			}
		}
		
		//set form input rules 
		$this->form_validation->set_rules('name','Display name','required|xss_clean');
		$this->form_validation->set_rules('username','User name','trim|required|xss_clean');
		$this->form_validation->set_rules('email','Email Address','trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('password','Password','trim|required|xss_clean|md5');
		$this->form_validation->set_rules('confirm','Confirm Password','trim|required|matches[password]|xss_clean');
		$this->form_validation->set_rules('sex','Sex','required|xss_clean');
		$this->form_validation->set_rules('phone','Phone','required|xss_clean');
		$this->form_validation->set_rules('country','Country','required|xss_clean');
		
		$this->form_validation->set_error_delimiters('<div id="pass-info" class="alert alert-danger">', '</div>'); //error delimeter
		
		if ($this->form_validation->run() == FALSE)
		{
			
		}
		else
		{
			//check if ready for post
			if($_POST) {
				$invitee_id = $_POST['invitee_id'];
				$name = $_POST['name'];
				$username = $_POST['username'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				$sex = $_POST['sex'];
				$phone = $_POST['phone'];
				$country = $_POST['country'];
				$role = 'User';
				//===get nicename and convert to seo friendly====
				$nicename = strtolower($username);
				$nicename = preg_replace("/[^a-z0-9_\s-]/", "", $nicename);
				$nicename = preg_replace("/[\s-]+/", " ", $nicename);
				$nicename = preg_replace("/[\s_]/", "-", $nicename);
				//================================================
				
				//Call to recaptcha to get the data validation set within the class. 
                //$this->recaptcha->recaptcha_check_answer();
				
				if($this->users->check_by_email($email) > 0 || $this->users->check_by_username($username) > 0) {
					$data['err_msg'] = '<div class="alert alert-danger"><h5><i class="fa fa-flash fa-2x"></i> Member already exist with this username or email address</h5></div>';
				} else {
					$time = time();
					$now = date("Y-m-d H:i:s");
					$now_group = date("F Y");
					
					$reg_data = array(
						'display_name' => ucwords($name),
						'user_login' => $username,
						'user_nicename' => $nicename,
						'user_email' => $email,
						'user_pass' => $password,
						'role' => $role,
						'sex' => $sex,
						'phone' => $phone,
						'country' => $country,
						'user_registered' => $now,
						'regstamp' => $time,
						'activate' => 1,
						'user_status' => 0
					);
					
					$insert_id = $this->users->reg_insert($reg_data); //save records in database
					
					//update invite table status
					$upd_status = array('status' => 1);
					$this->users->update_invite($invitee_id, $email, $upd_status);
					
					//get recommeder details
					$rec_email = '';
					$rec_name = '';
					$getrec = $this->users->query_single_user_id($invitee_id);
					if(!empty($getrec)){
						foreach($getrec as $rec){
							$rec_email = $rec->user_email;	
							$rec_name = $rec->display_name;	
						}
					}
					
					//save collaboration
					$ins_collab = array(
						'sender_id' => $invitee_id,
						'receiver_id' => $insert_id,
						'status' => 1,
						'remark' => 'Collaboration via invitation'
					);
					
					$collab_id = $this->m_collab->reg_insert($ins_collab);
					
					//compute trust value
					$collab_pass = 0;
					$collab_total = 0;
					$calcol = $this->m_collab->query_all_collab($invitee_id);
					if(!empty($calcol)){
						foreach($calcol as $col){
							if($col->status == 1){
								$collab_pass += 1;  //count success collab
							}
							
							$collab_total += 1;
						}
					}
					
					//get invitee avarage point and trust new member with it
					if($collab_total == 0){
						$new_point = 5;
					} else {
						$new_point = ($collab_pass / $collab_total) * 5;
					}
					$reg_point = array(
						'user_id' => $insert_id,
						'point' => $new_point,
						'purpose' => 'Invitation point based on Recommender Average Trust',
						'reg_date' => $now
					);
					
					$this->users->reg_point($reg_point);
					
					//try register activity
					$content = $rec_name.' is now in collaboration with '.$name;
					$reg_activity = array(
						'type' => 'collaboration',
						'member_id' => $invitee_id,
						'p_id' => $collab_id,
						's_id' => $collab_id,
						'content' => $content,
						'reg_date' => $now
					);
					
					$this->users->reg_activity($reg_activity);
					
					//try register notification
					$notify = $name.' accepted your collaboration';
					$reg_notify = array(
						'type' => 'collaboration',
						'member_id' => $insert_id,
						'receive_id' => $invitee_id,
						'p_id' => $collab_id,
						's_id' => $collab_id,
						'content' => $notify,
						'reg_date' => $now,
						'date_group' => $now_group
					);
					
					$this->users->reg_notification($reg_notify);
					
					//email notification processing
					$this->email->clear(); //clear initial email variables
					$this->email->to($email);
					$this->email->from(app_email, app_name);
					$this->email->subject('Welcome to '.app_name);
					
					//compose html body of mail
					//$mail_stamp = $time;
					$mail_subhead = 'Welcome to '.app_name;
					$body_msg = '
						Thanks for registering on '.app_name.'.<br /><br />
						Start making collaboration and build your Trust Model strength.<br /><br />
						Thanks
					';
					
					$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
					$this->email->set_mailtype("html"); //use HTML format
					$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
 
					$this->email->message($mail_design);
					
					if($this->email->send()) {
						//send notification mail to admin
						$this->email->clear(); //clear initial email variables
						$this->email->to($rec_email);
						$this->email->from($email, app_name);
						$this->email->subject('New Collaboration Accepted [Invitee]');
						
						//compose html body of mail
						//$mail_stamp = $time;
						$mail_subhead = 'New Collaboration Accepted [Invitee]';
						$body_msg = '
							This is to notify you that your collaboration via invitation is successful.<br /><br />
							Check <a href="'.base_url().'member/'.$nicename.'">'.$name.'</a> Collaboration Profile<br /><br />Thanks
						';
						
						$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
						$this->email->set_mailtype("html"); //use HTML format
						$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
	 
						$this->email->message($mail_design);
						
						if($this->email->send()) {}						
					} else {
						$data['err_msg'] = '<div class="alert alert-danger">Problem sending email this time. You will need to try again with valid Email Address.</div>';
					}
					
					if($insert_id){
						//redirect to login page
						$data['err_msg'] = '<div class="alert alert-success"><h5><i class="fa fa-check fa-2x"></i> Successful!!! - <a href="'.base_url().'login/">LOGIN HERE</a></h5></div>';
					}
				}
			}
		}
        
		//Store the captcha HTML for correct MVC pattern use.
        //$data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
		
		$data['allcountry'] = $this->m_country->query_all_country();
		
		$data['title'] = 'Join Network | '.app_name;
		$data['page_active'] = 'register';

	  	//$this->load->view('designs/header', $data);
	  	$this->load->view('register', $data);
	  	//$this->load->view('designs/footer', $data);
	}
}