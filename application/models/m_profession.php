<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class M_profession extends CI_Model {
	 
		public function reg_insert($data) {
			$this->db->insert('tm_profession', $data);
			return $this->db->insert_id();
		}
		
		public function query_single_profession($data) {
			$query = $this->db->get_where('tm_profession', array('slug' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_profession_id($data) {
			$query = $this->db->get_where('tm_profession', array('id' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_all_profession() {
			$query = $this->db->order_by('name', 'asc');
			$query = $this->db->get('tm_profession');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function check_by_name($data) {
			$query = $this->db->get_where('tm_profession', array('name' => $data));
			return $query->num_rows();
		}
		
		public function update_profession($id, $data) {
			$this->db->where('id', $id);
			$this->db->update('tm_profession', $data);
			return $this->db->affected_rows();	
		}
		
		public function delete_profession($id) {
			$this->db->where('id', $id);
			$this->db->delete('tm_profession');
			return $this->db->affected_rows();
		}
	}