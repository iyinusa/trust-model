<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('url');
    }
	
	public function index() 
	{
		if($this->session->userdata('logged_in') == TRUE){
			$log_role = $this->session->userdata('tm_user_role');
			if(strtolower($log_role) != 'administrator'){
				redirect(base_url('fan/'.$this->session->userdata('tm_nicename')), 'refresh');
			}
		} else {
			//register redirect page
			$s_data = array ('tm_redirect' => uri_string());
			$this->session->set_userdata($s_data);
			redirect(base_url('login'), 'refresh');
		}
		
		$data['err_msg'] = '';
		
		//check for update
		$get_id = $this->input->get('edit');
		if($get_id != ''){
			$gq = $this->users->query_single_user_id($get_id);
			foreach($gq as $item){
				$data['e_id'] = $item->ID;
				$data['e_display_name'] = $item->display_name;
				$data['e_role'] = $item->role;
				
				//query fan quota
				$cal_quota = 0;
				$user_quota = $this->users->query_user_quota($item->ID);
				if(empty($user_quota)){
					$cal_quota = 0;	
				} else {
					foreach($user_quota as $quota){
						$cal_quota += $quota->point;
					}
				}
				
				$data['e_points'] = $cal_quota;
			}
		}
		
		//check record delete
		$del_id = $this->input->get('del');
		if($del_id != ''){
			$data['rec_del'] = $del_id;
		}
		
		//check record update
		if($_POST){
			$user_id = $_POST['user_id'];
			$role = $_POST['role'];
			
			if($user_id && $role){
				$upd_data = array(
					'role' => $role
				);
				
				if($this->users->update_user($user_id, $upd_data) > 0){
					$data['err_msg'] = '<div class="alert alert-success"><h5><i class="fa fa-check fa-2x"></i> Role Changed</h5></div>';
				} else {
					$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-flash fa-2x"></i> No Changes Made To Role</h5></div>';
				}
			}	
		}
		
		//query uploads
		$data['alluser'] = $this->users->query_all_user();
		
		$data['title'] = 'Manage Accounts | '.app_name;
		$data['page_active'] = 'accounts';

	  	$this->load->view('designs/header', $data);
	  	$this->load->view('admin/user/accounts', $data);
	  	$this->load->view('designs/footer', $data);
	}
	
	public function delete(){
		if($this->session->userdata('logged_in') == TRUE){
			$log_role = $this->session->userdata('tm_user_role');
			if(strtolower($log_role) != 'administrator'){
				redirect(base_url('member/'.$this->session->userdata('tm_nicename')), 'refresh');
			}
		} else {
			//register redirect page
			$s_data = array ('tm_redirect' => uri_string());
			$this->session->set_userdata($s_data);
			redirect(base_url('login'), 'refresh');
		}
		
		if(isset($_POST['cancel'])){
			redirect(base_url('admin/user/accounts'), 'refresh');
		} else {
			$del_id = $_POST['del_id'];
			
			if($del_id != ''){
				if($this->users->delete_user($del_id) > 0){
					redirect(base_url('admin/user/accountsd'), 'refresh');
				} else {
					$data['err_msg'] = '<div class="alert alert-info"><h5>There is problem this time. Try later</h5></div>';
				}
			}
		}
	}
}