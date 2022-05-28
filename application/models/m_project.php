<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class M_project extends CI_Model {
	 
		public function reg_insert($data) {
			$this->db->insert('tm_project', $data);
			return $this->db->insert_id();
		}
		
		public function query_single_project($data) {
			$query = $this->db->get_where('tm_project', array('slug' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_project_id($data) {
			$query = $this->db->get_where('tm_project', array('id' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_project_degree($data) {
			$query = $this->db->get_where('tm_project', array('degree' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_all_project() {
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->get('tm_project');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_user_project($data) {
			$query = $this->db->where('member_id', $data);
			$query = $this->db->order_by('id', 'desc');
			$query = $this->db->get('tm_project');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function check_by_name($data, $user) {
			$query = $this->db->get_where('tm_project', array('title' => $data, 'member_id' => $user));
			return $query->num_rows();
		}
		
		public function update_project($id, $data) {
			$this->db->where('id', $id);
			$this->db->update('tm_project', $data);
			return $this->db->affected_rows();	
		}
		
		public function delete_project($id) {
			$this->db->where('id', $id);
			$this->db->delete('tm_project');
			return $this->db->affected_rows();
		}
	}