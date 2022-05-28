<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coming extends CI_Controller {

	function __construct(){
        parent::__construct();
		$this->load->model('subscribe'); //load MODEL
		//$this->load->model('user'); //load MODEL
		//$this->load->library('form_validation'); //load form validate rules
		
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
		if($_POST){
			$sub_email = $_POST['email'];
			
			//check if already subscribed
			$check = $this->subscribe->check_subscriber($sub_email);
			if(!empty($check)){
				echo 'Thanks!!! We already have you listed';
			} else {
				//prepare to insert
				$now = date('l, j F, Y H:m');
				$reg_data = array(
					'email' => $sub_email,
					'name' => '',
					'reg_date' => $now
				);
				
				//save records in database
				$insert_id = $this->subscribe->reg_insert($reg_data);
				
				if($insert_id) {
					//get total subscriptions
					$total = count($this->subscribe->all_subscriber());
					
					//email notification processing
					$this->email->clear(); //clear initial email variables
					$this->email->to($sub_email);
					$this->email->from('info@soccerfanhub.com','SFH - SoccerFanHub');
					$this->email->subject('Subscribed SoccerFanHub Updates');
					
					//compose html body of mail
					$mail_subhead = 'Subscribed to Updates';
					$body_msg = '
						Thanks for subscribing to SoccerFanHub updates. We will always keep you posted as the development goes, mostly when we finally go live.
					';
					
					$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
					$this->email->set_mailtype("html"); //use HTML format
					$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
 
					$this->email->message($mail_design);
					
					if($this->email->send()) {
						echo 'Successful! You will be the first to know when we launch';
						
						//copy admin as well
						$this->email->clear(); //clear initial email variables
						$this->email->to('info@soccerfanhub.com');
						$this->email->from($sub_email,'SFH - SoccerFanHub');
						$this->email->subject('New Subscriber at SoccerFanHub');
						
						//compose html body of mail
						$mail_subhead = 'New Subscriber';
						$body_msg = '
							<h2>'.$total.' subscribers and growing...</h2>
							Congrats!!! - We now have new subscriber to SoccerFanHub platform with email address ('.$sub_email.').
						';
						
						$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
						$this->email->set_mailtype("html"); //use HTML format
						$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
	 
						$this->email->message($mail_design);
						
						if($this->email->send()) {} //mail sent to admin		
					} else {
						echo 'There is problem this time. Please try later';
					}
					
				} else {
					echo 'There is problem this time. Please try later';
				}
			}
			
			exit;
		}
		
		$data['title'] = 'SFH - SoccerFanHub';
		$data['page_active'] = 'welcome';

	  	//$this->load->view('designs/header', $data);
	  	$this->load->view('coming', $data);
	  	//$this->load->view('designs/footer', $data);
	}
}