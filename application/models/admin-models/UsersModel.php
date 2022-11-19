<?php defined('BASEPATH') OR exit('No direct script access allowed');
class UsersModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function fetch_user_by_id($user_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('users'));
			$this->db->where('user_id',$user_id);
			$checkuser = $this->db->get()->row();
			return $checkuser;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_user_by_session_id(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('users'));
			$this->db->where('user_id',$this->session->userdata('user_id'));
			$checkuser = $this->db->get()->row();
			return $checkuser;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('users'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function check_duplicate_mobile($mobile){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('users'));
			$this->db->where('user_phone',$mobile);
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

	public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('users'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
} 