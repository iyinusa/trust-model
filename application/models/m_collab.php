<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class M_collab extends CI_Model {
	 
		public function reg_insert($data) {
			$this->db->insert('tm_collab', $data);
			return $this->db->insert_id();
		}
		
		public function query_collab_id($data) {
			$query = $this->db->get_where('tm_collab', array('id' => $data));
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_all_collab($data) {
			$query = $this->db->where('sender_id', $data);
			$query = $this->db->or_where('receiver_id', $data);
			$query = $this->db->get('tm_collab');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_send_collab($send, $rec) {
			$query = $this->db->where('sender_id', $send);
			$query = $this->db->where('receiver_id', $rec);
			$query = $this->db->get('tm_collab');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function query_receive_collab($send, $rec) {
			$query = $this->db->where('sender_id', $rec);
			$query = $this->db->where('receiver_id', $send);
			$query = $this->db->get('tm_collab');
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		public function check_collab($id) {
			$query = $this->db->where('sender_id', $id);
			$query = $this->db->or_where('receiver_id', $id);
			$query = $this->db->get('tm_collab');
			return $query->num_rows();
		}
		
		public function check_send_collab($send, $rec) {
			$query = $this->db->where('sender_id', $send);
			$query = $this->db->where('receiver_id', $rec);
			$query = $this->db->get('tm_collab');
			return $query->num_rows();
		}
		
		public function check_receive_collab($send, $rec) {
			$query = $this->db->where('sender_id', $rec);
			$query = $this->db->where('receiver_id', $send);
			$query = $this->db->get('tm_collab');
			return $query->num_rows();
		}
		
		public function update_collab($id, $data) {
			$this->db->where('id', $id);
			$this->db->update('tm_collab', $data);
			return $this->db->affected_rows();	
		}
		
		public function delete_collab($id) {
			$this->db->where('id', $id);
			$this->db->delete('tm_collab');
			return $this->db->affected_rows();
		}
	}