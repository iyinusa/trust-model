<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->helper('cookie');
    }
	
	public function index()
	{
		$shf_id = $this->session->userdata('tm_id');
		
		$status_update = array('user_status'=>0);
		if($this->users->update_user($shf_id,$status_update) > 0){
			$newdata = array(
				'tm_id' => '',
				'tm_nicename' => '',
				'tm_user_email' => '',
				'tm_user_registered' => '',
				'tm_user_lastlog' => '',
				'tm_user_status' => '',
				'tm_display_name' => '',
				'tm_user_nicename' => '',
				'tm_user_pics' => '',
				'tm_user_pics_small' => '',
				'tm_user_country' => '',
				'tm_user_bio' => '',
				'tm_user_sex' => '',
				'tm_user_address' => '',
				'tm_user_city' => '',
				'tm_user_dob' => '',
				'tm_user_phone' => '',
				'tm_user_website' => '',
				'tm_user_facebook' => '',
				'tm_user_twitter' => '',
				'tm_user_linkedin' => '',
				'tm_user_role' => '',
				'tm_user_pro' => '',
				'logged_in' => FALSE,
			);
			$this->session->unset_userdata($newdata);
			//unset($this->session->userdata); 
			$this->session->sess_destroy();
			delete_cookie( config_item('sess_cookie_name') ); 
		}
		
		$data['title'] = 'Sign Out | '.app_name;
		$data['page_active'] = 'logout';
		
		$this->load->view('designs/header', $data);
		$this->load->view('logout', $data);
		$this->load->view('designs/footer', $data);
		
		//redirect(base_url().'hauth/logout', 'refresh');
		redirect('/', 'refresh');
	}
}