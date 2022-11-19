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

	public function check_duplicate_mobile($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('users'));
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

	public function save($data){
		try {
			$this->db->set('user_update_at',date('Y-m-d H:i:s'));
			$this->db->set('user_create_at',date('Y-m-d H:i:s'));
			$return = $this->db->insert($this->db->dbprefix('users'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function update($where,$data){
		try {
			$this->db->set('user_update_at',date('Y-m-d H:i:s'));
			return $this->db->where($where)->update($this->db->dbprefix('users'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function check_otp_is_exist($otp_text){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('users'));
			$this->db->where('user_verification_code',$otp_text);
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
	

	public function fetch_user_data_by_otp($otp_text){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('users'));
			$this->db->where('user_verification_code',$otp_text);
			$checkuser = $this->db->get()->row();
			return $checkuser;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function fetch_user_data_by_id($user_id){
		try {
			$this->db->select('user_id,user_name,user_image,user_referral,user_email,user_phone,user_country_code,user_username,user_phone_verified,user_job_status,user_socket_id');
			$this->db->from($this->db->dbprefix('users'));
			$this->db->where('user_id',$user_id);
			$checkuser = $this->db->get()->row();
			if(!empty($checkuser)){
				$checkuser->user_image = api_url($checkuser->user_image);
			}
			return $checkuser;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function fetch_single_user($where){
		try {
			$this->db->select('user_id,user_name,user_image,user_referral,user_email,user_phone,user_country_code,user_username,user_phone_verified,user_password,user_job_status,user_socket_id');
			$this->db->from($this->db->dbprefix('users'));
			$this->db->where($where);
			$checkuser = $this->db->get()->row();

			if(!empty($checkuser)){
				$checkuser->user_image = api_url($checkuser->user_image);
			}
			return $checkuser;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}	

	public function fetch_user_data_for_request_by_id($user_id){
		try {
			$this->db->select('user_id,user_name,user_image,user_referral,user_email,user_phone,user_country_code,user_username');
			$this->db->from($this->db->dbprefix('users'));
			$this->db->where('user_id',$user_id);
			$user = $this->db->get()->row();
			if(!empty($user)){
			    $user->user_rating = '';
				$user->user_image  = api_url($user->user_image);
			}
			return $user;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
} 