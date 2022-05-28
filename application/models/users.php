<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Users extends CI_Model {
	 
		public function reg_insert($data) {
			$this->db->insert('tm_users', $data);
			return $this->db->insert_id();
		}
		
		public function reg_point($data) {
			$this->db->insert('tm_quota', $data);
			return $this->db->insert_id();
		}
		
		public function reg_activity($data) {
			$this->db->insert('tm_activity', $data);
			return $this->db->insert_id();
		}
		
		public function reg_notification($data) {
			$this->db->insert('tm_notification', $data);
			return $this->db->insert_id();
		}
		
		public function reg_invite($data) {
			$this->db->insert('tm_invite', $data);
			return $this->db->insert_id();
		}
		
		public function query_user_quota($data) {
			$query = $this->db->get_where('tm_quota', array('user_id' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function check_user_quota($id, $purpose) {
			$query = $this->db->get_where('tm_quota', array('user_id' => $id, 'purpose' => $purpose));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_all_user_quota() {
			$query = $this->db->get('tm_quota');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_user($user, $pass) {
			$query = $this->db->get_where('tm_users', array('user_nicename' => $user, 'user_pass' => $pass));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_user_by_email($email) {
			$query = $this->db->get_where('tm_users', array('user_email' => $email));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_invite($data) {
			$query = $this->db->get_where('tm_invite', array('sender_id' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_by_invite($data, $email) {
			$query = $this->db->get_where('tm_invite', array('sender_id' => $data, 'email' => $email));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_invite_id($data) {
			$query = $this->db->get_where('tm_invite', array('id' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_single_user($user) {
			$query = $this->db->get_where('tm_users', array('user_nicename' => $user));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_single_user_id($data) {
			$query = $this->db->get_where('tm_users', array('ID' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_all_user() {
			$query = $this->db->order_by('display_name', 'asc');
			$query = $this->db->get('tm_users');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_country_user() {
			$query = $this->db->group_by('country');
			$query = $this->db->order_by('country', 'asc');
			$query = $this->db->get('tm_users');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_user_by_country($data) {
			$query = $this->db->get_where('tm_users', array('country' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_activity() {
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->get('tm_activity');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_notify_member($id) {
			$query = $this->db->where('receive_id', $id);
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->get('tm_notification');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_notify_member_unread($id) {
			$query = $this->db->where('receive_id', $id);
			$query = $this->db->where('status', 0);
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->get('tm_notification');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_notify_by_date($id, $date) {
			$query = $this->db->where('receive_id', $id);
			$query = $this->db->where('date_group', $date);
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->get('tm_notification');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_notify_group_date($id) {
			$query = $this->db->where('receive_id', $id);
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->group_by('date_group');
			$query = $this->db->get('tm_notification');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function check_by_email($email) {
			$query = $this->db->get_where('tm_users', array('user_email' => $email));
			return $query->num_rows();
		}
		
		public function check_by_username($user) {
			$query = $this->db->get_where('tm_users', array('user_login' => $user));
			return $query->num_rows();
		}
		
		public function check_by_code($code) {
			$query = $this->db->get_where('tm_users', array('glocal_code' => $code));
			return $query->num_rows();
		}
		
		public function check_by_verify() {
			$query = $this->db->get_where('tm_users', array('verified' => 1));
			return $query->num_rows();
		}
		
		public function check_user($username, $pass) {
			$query = $this->db->get_where('tm_users', array('user_nicename' => $username, 'user_pass' => $pass));
			return $query->num_rows();
		}
		
		public function check_invite($sender, $email) {
			$query = $this->db->get_where('tm_invite', array('sender_id' => $sender, 'email' => $email));
			return $query->num_rows();
		}
		
		public function check_activation($stamp, $email) {
			$query = $this->db->get_where('tm_users', array('regstamp' => $stamp, 'user_email' => $email, 'activate' => 0));
			return $query->num_rows();	
		}
		
		public function check_reset($stamp, $email) {
			$query = $this->db->get_where('tm_users', array('reset_stamp' => $stamp, 'user_email' => $email, 'reset' => 1));
			return $query->num_rows();	
		}
		
		public function activate($email, $data) {
			$this->db->where('user_email', $email);
			$this->db->update('tm_users', $data);
			return $this->db->affected_rows();	
		}
		
		public function update_user($id, $data) {
			$this->db->where('ID', $id);
			$this->db->update('tm_users', $data);
			return $this->db->affected_rows();	
		}
		
		public function update_notification($id, $data) {
			$this->db->where('id', $id);
			$this->db->update('tm_notification', $data);
			return $this->db->affected_rows();	
		}
		
		public function update_invite($sender, $email, $data) {
			$this->db->where('sender_id', $sender);
			$this->db->where('email', $email);
			$this->db->update('tm_invite', $data);
			return $this->db->affected_rows();	
		}
		
		public function delete_user($id) {
			$this->db->where('ID', $id);
			$this->db->delete('tm_users');
			return $this->db->affected_rows();
		}
		
		public function delete_notification($id, $user) {
			$this->db->where('id', $id);
			$this->db->where('receive_id', $user);
			$this->db->delete('tm_notification');
			return $this->db->affected_rows();
		}
		
		public function delete_invite($id, $user) {
			$this->db->where('id', $id);
			$this->db->where('sender_id', $user);
			$this->db->delete('tm_invite');
			return $this->db->affected_rows();
		}
	}