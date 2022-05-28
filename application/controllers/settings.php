<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->helper('text'); //for content limiter
		$this->load->library('form_validation'); //load form validate rule
		$this->load->library('image_lib'); //load image library
		
		$this->load->library('email'); //load email library
		
		//$config['image_library'] = 'gd2';
//		$config['source_image']	= '/path/to/image/mypic.jpg';
//		$config['create_thumb'] = TRUE;
//		$config['maintain_ratio'] = TRUE;
//		$config['width']	= 320;
//		$config['height']	= 320;
		//$this->image_lib->initialize($config); //load image library
    }
	
	public function index()
	{
		if($this->session->userdata('logged_in')==FALSE){redirect(base_url().'login','refresh');}
		
		$this->account();
	}
	
	public function photo(){
		if($this->session->userdata('logged_in')==FALSE){redirect(base_url().'login','refresh');}
		$log_user_id = $this->session->userdata('tm_id');
		$data['err_msg'] = '';
		
		if($log_user_id != ''){
			$gq = $this->users->query_single_user_id($log_user_id);
			foreach($gq as $item){
				$data['e_id'] = $item->ID;
				$data['e_pics'] = $item->pics;
				$data['e_pics_small'] = $item->pics_small;
				$data['e_pics_square'] = $item->pics_small;	
			}
		}
		
		//check if ready for post
		if($_POST){
			$pics = $_POST['pics'];
			$pics_small = $_POST['pics_small'];
			$pics_square = $_POST['pics_square'];
			$stamp = time();
			$save_path = '';
			$save_path400 = '';
			$save_path100 = '';
			
			if(isset($_FILES['up_file']['name'])){
				$path = 'img/members/'.$log_user_id;
				 
				if (!is_dir($path))
					mkdir($path, 0755);
  
				$pathMain = './img/members/'.$log_user_id;
				if (!is_dir($pathMain))
					mkdir($pathMain, 0755);
  
				$result = $this->do_upload("up_file", $pathMain);
  
				if (!$result['status']){
					$data['err_msg'] ='<div class="alert alert-info"><h5>Can not upload Photo, try another</h5></div>';
				} else {
					$save_path = $path . '/' . $result['upload_data']['file_name'];
					
					//if size not up to 400px above
					if($result['image_width'] >= 400){
						if($result['image_width'] >= 400 || $result['image_height'] >= 400) {
							if($this->resize_image($pathMain . '/' . $result['upload_data']['file_name'], $stamp .'-400.gif','400','400', $result['image_width'], $result['image_height'])){
								$save_path400 = $path . '/' . $stamp .'-400.gif';
							}
						}
							
						if($result['image_width'] >= 200 || $result['image_height'] >= 200){
							if($this->resize_image($pathMain . '/' . $result['upload_data']['file_name'], $stamp .'-150.gif','200','200', $result['image_width'], $result['image_height'])){
								$resize100 = $pathMain . '/' . $stamp.'-150.gif';
								$resize100_dest = $resize100;	
								
								if($this->crop_image($resize100, $resize100_dest,'150','150')){
									$save_path100 = $path . '/' . $stamp .'-150.gif';
								}
							}
						}
						
					} else {
						$data['err_msg'] = '<div class="alert alert-info"><h5>Must be at least 400px in Width</h5></div>';
					}
				}
			}
			
			//prepare insert record
			if($save_path=='' && $save_path400=='' && $save_path100==''){
				$data['err_msg'] = '<div class="alert alert-info"><h5>No changes</h5></div>';
			} else {
				//check for update
				$upd_data = array(
					'pics' => $save_path400,
					'pics_small' => $save_path100
				);
				
				if($this->users->update_user($log_user_id, $upd_data) > 0){
					//add data to session
					$s_data = array (
						'tm_user_pics' => $save_path400,
						'tm_user_pics_small' => $save_path100
					);
						
					$check = $this->session->set_userdata($s_data);
					
					$data['err_msg'] = '<div class="alert alert-success"><h5><i class="fa fa-check fa-2x"></i> Successfully</h5></div>';
				} else {
					$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-flash fa-2x"></i> No Changes Made</h5></div>';
				}
			}
		}
		
		$data['title'] = 'Profile Photo | '.app_name;
		$data['page_active'] = 'setting';
		
		$this->load->view('designs/header', $data);
		$this->load->view('settings/photo', $data);
		$this->load->view('designs/footer', $data);
	}
	
	public function account(){
		if($this->session->userdata('logged_in')==FALSE){redirect(base_url().'login','refresh');}
		
		//account setting page
		$log_user_id = $this->session->userdata('tm_id');
		$log_user_email = $this->session->userdata('tm_user_email');
		
		//set form input rules 
		$this->form_validation->set_rules('name','Username','trim|required|xss_clean');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('displayname','Display Name','required|xss_clean');
		$this->form_validation->set_rules('sex','Sex','required|xss_clean');
		$this->form_validation->set_rules('country','Country','required|xss_clean');
		
		//error delimeter
		$this->form_validation->set_error_delimiters('<h5 id="pass-info" class="alert alert-info">', '</h5>');
		
		if ($this->form_validation->run() == FALSE){
			$data['err_msg'] = '';
		} else {
			//check if ready for post
			if($_POST) {
				$name = $_POST['name'];
				$email = $_POST['email'];
				$displayname = $_POST['displayname'];
				$bio = $_POST['bio'];
				$dob = $_POST['dob'];
				$sex = $_POST['sex'];
				$city = $_POST['city'];
				$country = $_POST['country'];
				$phone = $_POST['phone'];
				$address = $_POST['address'];
				$website = $_POST['website'];
				$fb = $_POST['fb_page'];
				$twitter = $_POST['twitter'];
				$linkedin = $_POST['linkedin'];
				
				//check professions
				$profession = '';
				if(isset($_POST['profession'])){
					$profcount = $_POST['profession'];
					for($i = 0; $i < count($profcount); $i++){
						if($i == count($profcount)-1){$delimenter = '';} else {$delimenter = ':';}
						$profession	.= $profcount[$i].$delimenter;
					}
				}
				
				//===get nicename and convert to seo friendly====
				$nicename = strtolower($name);
				$nicename = preg_replace("/[^a-z0-9_\s-]/", "", $nicename);
				$nicename = preg_replace("/[\s-]+/", " ", $nicename);
				$nicename = preg_replace("/[\s_]/", "-", $nicename);
				//================================================
				
				if($log_user_email != $email) {
					if(($this->users->check_by_email($email) > 0) || ($this->users->check_by_username($nicename) > 0)) {
						$data['err_msg'] = '<h5 class="alert alert-info"><i class="fa fa-flash fa-2x"></i> Username or Email address already registered, try another</h5>';
					}
				} else {
					$update_data = array(
						'user_login' => $nicename,
						'user_nicename' => $nicename,
						'display_name' => $displayname,
						'user_email' => $email,
						'bio' => $bio,
						'profession' => $profession,
						'dob' => $dob,
						'sex' => $sex,
						'city' => $city,
						'country' => $country,
						'phone' => $phone,
						'address' => $address,
						'website' => $website,
						'fb_page' => $fb,
						'twitter_page' => $twitter,
						'linkedin_page' => $linkedin
					);
					
					if($this->users->update_user($log_user_id, $update_data) > 0){
						$data['err_msg'] = '<h5 class="alert alert-success"><i class="fa fa-check fa-2x"></i> Account update successful</h5>';
						
						//update session records
						$session_data = array (
							'tm_user_nicename' => $nicename,
							'tm_user_email' => $email,
							'tm_display_name' => $displayname,
							'tm_user_bio' => $bio,
							'tm_user_profession' => $profession,
							'tm_user_dob' => $dob,
							'tm_user_sex' => $sex,
							'tm_user_city' => $city,
							'tm_user_phone' => $phone,
							'tm_user_address' => $address,
							'tm_user_website' => $website,
							'tm_user_facebook' => $fb,
							'tm_user_twitter' => $twitter,
							'tm_user_linkedin' => $linkedin
						);
						$this->session->set_userdata($session_data);
					} else {
						$data['err_msg'] = '<h5 class="alert alert-info">No changes made</h5>';	
					}
				}
			}
		}
		
		$data['allcountry'] = $this->m_country->query_all_country();
		$data['allprofession'] = $this->m_profession->query_all_profession();
		
		$data['title'] = 'Update Profile | '.app_name;
		$data['page_active'] = 'setting';
		
		$this->load->view('designs/header', $data);
		$this->load->view('settings/account', $data);
		$this->load->view('designs/footer', $data);
	}
	
	public function password(){
		if($this->session->userdata('logged_in')==FALSE){redirect(base_url().'login','refresh');}
		$log_user_id = $this->session->userdata('tm_id');
		$log_user_nicename = $this->session->userdata('tm_user_nicename');
		
		//set form input rules 
		$this->form_validation->set_rules('old','Old password','trim|required|min_length[4]|max_length[32]|xss_clean|md5');
		$this->form_validation->set_rules('new','New password','trim|required|min_length[4]|max_length[32]|xss_clean|md5');
		$this->form_validation->set_rules('confirm','Confirm password','trim|required|matches[new]|xss_clean');
		
		//error delimeter
		$this->form_validation->set_error_delimiters('<h5 id="pass-info" class="alert alert-info">', '</h5>');
		
		if ($this->form_validation->run() == FALSE){
			$data['err_msg'] = '';
		} else {
			//check if ready for post
			if($_POST) {
				$old = $_POST['old'];
				$new = $_POST['new'];
				$confirm = $_POST['confirm'];
				
				if($this->users->check_user($log_user_nicename, $old) <= 0) {
					$data['err_msg'] = '<h5 class="alert alert-danger"><i class="fa fa-flash fa-2x"></i> Password not associated to your account</h5>';		
				} else {
					$update_data = array(
						'user_pass' => $new
					);
					
					if($this->users->update_user($log_user_id, $update_data) > 0){
						$data['err_msg'] = '<h5 class="alert alert-success"><i class="fa fa-check fa-2x"></i> Password changed successfully</h5>';
					} else {
						$data['err_msg'] = '<h5 class="alert alert-info"><i class="fa fa-flash fa-2x"></i> No changes made</h5>';
					}
				}
			}
		}
		
		$data['title'] = 'Change Password | '.app_name;
		$data['page_active'] = 'setting';
		
		$this->load->view('designs/header', $data);
		$this->load->view('settings/password', $data);
		$this->load->view('designs/footer', $data);
	}
	
	public function privacy($page='privacy'){
		if($this->session->userdata('logged_in')==FALSE){redirect(base_url().'login','location');}
		
		//privacy setting page
		$data['title'] = 'Privacy Settings | SoccerFanHub';
		$data['page_title'] = 'Account Settings';
		
		$data['err_msg'] = '';
		
		$this->load->view('designs/header', $data);
		$this->load->view('settings/'.$page, $data);
		$this->load->view('designs/footer', $data);
	}
	
	public function submit_code(){
		if($_POST){
			$codevalue = $_POST['codevalue'];
			$log_user_id = $this->session->userdata('tm_id');
			$log_user_club_id = $this->session->userdata('tm_user_club_id');
			$log_user_nicename = $this->session->userdata('tm_user_nicename');
			$log_user_email = $this->session->userdata('tm_user_email');
			
			//get club name
			$gclub = $this->m_clubs->query_single_club_id($log_user_club_id);
			if(!empty($gclub)){
				foreach($gclub as $cl){
					$clubname = $cl->name;
				}
			}
			
			if(!$codevalue){
				echo '<h5 class="alert alert-info">Code can not be empty</h5>';
			} else {
				//check verified
				if($this->users->check_by_verify() > 0){
					echo '<h5 class="alert alert-info">Already a Verified Fan</h5>';
				} else {
					$update_data = array(
						'global_code' => $codevalue,
						'verified' => 0
					);
					
					if($this->users->update_user($log_user_id, $update_data) > 0){
						//send notification mail to Chelsea Nigeria
						$this->email->clear(); //clear initial email variables
						$this->email->to('database@chelseanigeria.com');
						$this->email->from($log_user_email,'SoccerFanHub');
						$this->email->subject('Verification Request');
						
						//compose html body of mail
						$mail_subhead = 'Verification Request';
						$body_msg = '
							Please look into this Verification Request.<br /><br />
							<b>Fan:</b> <a href="'.base_url().'fan/'.$log_user_nicename.'">'.base_url().'fan/'.$log_user_nicename.'</a><br /><br /><b>Code</b> '.$codevalue.'<br /><br />Thanks
						';
						
						$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
						$this->email->set_mailtype("html"); //use HTML format
						$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
	 
						$this->email->message($mail_design);
						
						if($this->email->send()) {}
						
						//send notification mail to admin
						$this->email->clear(); //clear initial email variables
						$this->email->to('info@soccerfanhub.com');
						$this->email->from($log_user_email,'SoccerFanHub');
						$this->email->subject('Verification Request');
						
						//compose html body of mail
						$mail_subhead = 'Verification Request';
						$body_msg = '
							Please look into this Verification Request.<br /><br />
							<b>Fan:</b> <a href="'.base_url().'fan/'.$log_user_nicename.'">'.base_url().'fan/'.$log_user_nicename.'</a><br /><br /><b>Code</b> '.$codevalue.'<br /><br />Thanks
						';
						
						$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
						$this->email->set_mailtype("html"); //use HTML format
						$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
	 
						$this->email->message($mail_design);
						
						if($this->email->send()) {
							echo '<h5 class="alert alert-success">Submitted!!! - Your Code will be reviewed. Thanks</h5>';	
						} else {
							echo '<h5 class="alert alert-warning">Please try later.</h5>';
						}
					} else {
						echo '<h5 class="alert alert-warning">Please try later</h5>';
					}
				}
			}exit;
		}
	}
	
	function do_upload($htmlFieldName, $path)
    {
        $config['file_name'] = time();
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png|tif';
        $config['max_size'] = '10000';
        $config['max_width'] = '6000';
        $config['max_height'] = '6000';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        unset($config);
        if (!$this->upload->do_upload($htmlFieldName))
        {
            return array('error' => $this->upload->display_errors(), 'status' => 0);
        } else
        {
            $up_data = $this->upload->data();
			return array('status' => 1, 'upload_data' => $this->upload->data(), 'image_width' => $up_data['image_width'], 'image_height' => $up_data['image_height']);
        }
    }
	
	function resize_image($sourcePath, $desPath, $width = '500', $height = '500', $real_width, $real_height)
    {
        $this->image_lib->clear();
		$config['image_library'] = 'gd2';
        $config['source_image'] = $sourcePath;
        $config['new_image'] = $desPath;
        $config['quality'] = '100%';
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['thumb_marker'] = '';
		$config['width'] = $width;
        $config['height'] = $height;
		
		$dim = (intval($real_width) / intval($real_height)) - ($config['width'] / $config['height']);
		$config['master_dim'] = ($dim > 0)? "height" : "width";
		
		$this->image_lib->initialize($config);
 
        if ($this->image_lib->resize())
            return true;
        return false;
    }
	
	function crop_image($sourcePath, $desPath, $width = '320', $height = '320')
    {
        $this->image_lib->clear();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $sourcePath;
        $config['new_image'] = $desPath;
        $config['quality'] = '100%';
        $config['maintain_ratio'] = FALSE;
        $config['width'] = $width;
        $config['height'] = $height;
		$config['x_axis'] = '20';
		$config['y_axis'] = '20';
        
		$this->image_lib->initialize($config);
 
        if ($this->image_lib->crop())
            return true;
        return false;
    }
}