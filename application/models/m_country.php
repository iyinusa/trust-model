<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class M_country extends CI_Model {
	 
		public function reg_insert($data) {
			$this->db->insert('tm_country', $data);
			return $this->db->insert_id();
		}
		
		public function query_single_country($data) {
			$query = $this->db->get_where('tm_country', array('slug' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_country_id($data) {
			$query = $this->db->get_where('tm_country', array('id' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_all_country() {
			$query = $this->db->order_by('name', 'asc');
			$query = $this->db->get('tm_country');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function check_by_name($data) {
			$query = $this->db->get_where('tm_country', array('name' => $data));
			return $query->num_rows();
		}
		
		public function update_country($id, $data) {
			$this->db->where('id', $id);
			$this->db->update('tm_country', $data);
			return $this->db->affected_rows();	
		}
		
		public function delete_country($id) {
			$this->db->where('id', $id);
			$this->db->delete('tm_country');
			return $this->db->affected_rows();
		}
	}