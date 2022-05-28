<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class M_trs extends CI_Model {
	 
		public function reg_insert($data) {
			$this->db->insert('tm_trs', $data);
			return $this->db->insert_id();
		}
		
		public function query_single_trs($data) {
			$query = $this->db->get_where('tm_trs', array('slug' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_trs_id($data) {
			$query = $this->db->get_where('tm_trs', array('id' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_trs_degree($data) {
			$query = $this->db->get_where('tm_trs', array('degree' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_all_trs() {
			$query = $this->db->order_by('id', 'asc');
			$query = $this->db->get('tm_trs');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function check_by_name($data) {
			$query = $this->db->get_where('tm_trs', array('name' => $data));
			return $query->num_rows();
		}
		
		public function update_trs($id, $data) {
			$this->db->where('id', $id);
			$this->db->update('tm_trs', $data);
			return $this->db->affected_rows();	
		}
		
		public function delete_trs($id) {
			$this->db->where('id', $id);
			$this->db->delete('tm_trs');
			return $this->db->affected_rows();
		}
	}