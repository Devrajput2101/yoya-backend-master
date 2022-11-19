<?php defined('BASEPATH') OR exit('No direct script access allowed');
class ConversationsModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$this->db->set('room_create_at',date('Y-m-d H:i:s'));
			$this->db->set('room_update_at',date('Y-m-d H:i:s'));
			$return = $this->db->insert($this->db->dbprefix('conversation_rooms'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function save_message($data){
		try {
			$this->db->set('message_update_at',date('Y-m-d H:i:s'));
			$this->db->set('message_create_at',date('Y-m-d H:i:s'));
			$return = $this->db->insert($this->db->dbprefix('conversations'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function update($where,$data){
		try {
			$this->db->set('room_update_at',date('Y-m-d H:i:s'));
			return $this->db->where($where)->update($this->db->dbprefix('conversation_rooms'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function is_exist($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('conversation_rooms'));
			$this->db->where($where);
			$checkuser = $this->db->get()->num_rows();
			if($checkuser > 0){
				return true;
			}
			return false;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_room($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('conversation_rooms'));
			$this->db->where($where);
			$return = $this->db->get()->row();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_room_users($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('conversation_rooms'));
			$this->db->where($where);
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_message_by_rooms($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('conversations'));
			$this->db->where($where);
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}