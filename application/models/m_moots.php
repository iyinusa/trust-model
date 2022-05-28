<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class M_moots extends CI_Model {
	 
		public function reg_insert($data) {
			$this->db->insert('sfh_moot', $data);
			return $this->db->insert_id();
		}
		
		public function reg_moot_reply($data) {
			$this->db->insert('sfh_moot_reply', $data);
			return $this->db->insert_id();
		}
		
		public function query_moot_id($data) {
			$query = $this->db->get_where('sfh_moot', array('id' => $data, 'status' => 1));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_moot_reply($data) {
			$query = $this->db->get_where('sfh_moot_reply', array('moot_id' => $data, 'status' => 1));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_moot_reply_trend_id($moot_id) {
			$query = $this->db->where('moot_id', $moot_id);
			$query = $this->db->group_by('fan_id');
			$query = $this->db->get('sfh_moot_reply');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_all_moot() {
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->get('sfh_moot');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_all_moot_reply() {
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->get('sfh_moot_reply');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_moot_club($club_id) {
			$query = $this->db->where('club_id', $club_id);
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->get('sfh_moot');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_moot_fan($fan_id) {
			$query = $this->db->where('fan_id', $fan_id);
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->get('sfh_moot');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_moot_reply_club($club_id) {
			$query = $this->db->where('club_id', $club_id);
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->get('sfh_moot_reply');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_moot_reply_fan($fan_id) {
			$query = $this->db->where('fan_id', $fan_id);
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->get('sfh_moot_reply');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function check_moot($data) {
			$query = $this->db->get_where('sfh_moot', array('moot' => $data));
			return $query->num_rows();
		}
		
		public function check_moot_reply($data, $moot_id) {
			$query = $this->db->get_where('sfh_moot_reply', array('reply' => $data, 'moot_id' => $moot_id));
			return $query->num_rows();
		}
		
		public function update_moot($id, $data) {
			$this->db->where('id', $id);
			$this->db->update('sfh_moot', $data);
			return $this->db->affected_rows();	
		}
		
		public function delete_moot($id) {
			$this->db->where('id', $id);
			$this->db->delete('sfh_moot');
			return $this->db->affected_rows();
		}
		
		public function delete_moot_reply($id) {
			$this->db->where('id', $id);
			$this->db->delete('sfh_moot_reply');
			return $this->db->affected_rows();
		}
	}