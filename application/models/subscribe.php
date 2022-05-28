<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Subscribe extends CI_Model {
	 
		public function reg_insert($data) {
			$this->db->insert('subscriber', $data);
			return $this->db->insert_id();
		}
		
		public function check_subscriber($email) {
			$query = $this->db->get_where('subscriber', array('email' => $email));
			return $query->num_rows();
		}
		
		public function all_subscriber() {
			$query = $this->db->get('subscriber');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
	}