<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Country extends CI_Controller {

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
				redirect(base_url('member/'.$this->session->userdata('tm_nicename')), 'refresh');
			}
		} else {
			//register redirect page
			$s_data = array ('tm_redirect' => uri_string());
			$this->session->set_userdata($s_data);
			redirect(base_url('login'), 'refresh');
		}
		
		$data['err_msg'] = '';
		
		//query uploads
		$data['allcountry'] = $this->m_country->query_all_country();
		
		$data['title'] = 'Manage Country | '.app_name;
		$data['page_active'] = 'country';

	  	$this->load->view('designs/header', $data);
	  	$this->load->view('country/add', $data);
	  	$this->load->view('designs/footer', $data);
	}
	
	public function add(){
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
		
		$data['err_msg'] = '';
		
		//check for update
		$get_id = $this->input->get('edit');
		if($get_id != ''){
			$gq = $this->m_country->query_country_id($get_id);
			foreach($gq as $item){
				$data['e_id'] = $item->id;
				$data['e_name'] = $item->name;
				$data['e_slug'] = $item->slug;	
			}
		}
		
		//check record delete
		$del_id = $this->input->get('del');
		if($del_id != ''){
			$data['rec_del'] = $del_id;
		}
		
		//set form input rules 
		$this->form_validation->set_rules('name','Country','trim|required|xss_clean');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-warning no-radius no-margin padding-sm"><i class="fa fa-info-circle"></i>', '</div>'); //error delimeter
	  
	  	if ($this->form_validation->run() == FALSE)
		{
			$data['err_msg'] = '';
		}
		else
		{
			//check if ready for post
			if($_POST){
				$country_id = $_POST['country_id'];
				$name = $_POST['name'];
				
				//===get nicename and convert to seo friendly====
				$slug = strtolower($name);
				$slug = preg_replace("/[^a-z0-9_\s-]/", "", $slug);
				$slug = preg_replace("/[\s-]+/", " ", $slug);
				$slug = preg_replace("/[\s_]/", "-", $slug);
				//================================================
				
				//check for existence
				if(($this->m_country->check_by_name($name) > 0) && $country_id == ''){
					$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-flash fa-2x"></i> Country already in database</h5></div>';
				} else {
					//check for update
					if($country_id != ''){
						$upd_data = array(
							'name' => $name,
							'slug' => $slug
						);
						
						if($this->m_country->update_country($country_id, $upd_data) > 0){
							$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-check fa-2x"></i> Successful</h5></div>';
						} else {
							$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-flash fa-2x"></i> No Changes Made</h5></div>';
						}
					} else {
						$reg_data = array(
							'name' => $name,
							'slug' => $slug
						);
						
						if($this->m_country->reg_insert($reg_data) > 0){
							$data['err_msg'] = '<div class="alert alert-info"><h5><i class="fa fa-mark"></i> Successful</h5></div>';
						} else {
							$data['err_msg'] = '<div class="alert alert-danger"><h5><i class="fa fa-flash fa-2x"></i> There is problem this time. Try later</h5></div>';
						}
					}
				}
			}
		}
		
		//query uploads
		$data['allcountry'] = $this->m_country->query_all_country();
		
		$data['title'] = 'Manage Country | '.app_name;
		$data['page_active'] = 'country';

	  	$this->load->view('designs/header', $data);
	  	$this->load->view('country/add', $data);
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
			redirect(base_url('country/add'), 'refresh');
		} else {
			$del_id = $_POST['del_id'];
			
			if($del_id != ''){
				if($this->m_country->delete_country($del_id) > 0){
					redirect(base_url('country/add'), 'refresh');
				} else {
					$data['err_msg'] = '<div class="alert alert-info"><h5>There is problem this time. Try later</h5></div>';
				}
			}
		}
	}
}